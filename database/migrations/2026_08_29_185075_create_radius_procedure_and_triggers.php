<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS radacct_insert_triggers');
        DB::unprepared('DROP TRIGGER IF EXISTS radacct_update_triggers');
        DB::unprepared('DROP PROCEDURE IF EXISTS fr_new_data_usage_period');

        DB::unprepared(<<<'SQL'
CREATE TRIGGER radacct_insert_triggers
AFTER INSERT ON radacct
FOR EACH ROW
BEGIN
    DECLARE v_mac_lock_status TINYINT DEFAULT 0;
    DECLARE v_current_mac_address VARCHAR(50) DEFAULT NULL;

    UPDATE customers
    SET last_login_time = NEW.acctstarttime,
        last_interim_update = NEW.acctupdatetime
    WHERE username = NEW.username;

    SELECT COALESCE(MAX(mac_lock), 0), MAX(mac_address)
    INTO v_mac_lock_status, v_current_mac_address
    FROM customers
    WHERE username = NEW.username;

    IF v_mac_lock_status = 1
        AND (v_current_mac_address IS NULL OR v_current_mac_address = '')
        AND NEW.callingstationid IS NOT NULL
        AND NEW.callingstationid != '' THEN
        UPDATE customers
        SET mac_address = NEW.callingstationid,
            mac_lock = 1
        WHERE username = NEW.username;
    END IF;
END
SQL);

        DB::unprepared(<<<'SQL'
CREATE TRIGGER radacct_update_triggers
AFTER UPDATE ON radacct
FOR EACH ROW
BEGIN
    DECLARE v_data_usage_out BIGINT DEFAULT 0;
    DECLARE v_data_usage_in BIGINT DEFAULT 0;
    DECLARE v_session_time BIGINT DEFAULT 0;
    DECLARE v_usage_graph_enabled TINYINT DEFAULT 0;

    UPDATE customers
    SET last_interim_update = NEW.acctupdatetime,
        last_logout_time = CASE
            WHEN NEW.acctstoptime IS NOT NULL THEN NEW.acctstoptime
            ELSE last_logout_time
        END
    WHERE username = NEW.username;

    IF COALESCE(NEW.acctoutputoctets, 0) != COALESCE(OLD.acctoutputoctets, 0)
        OR COALESCE(NEW.acctinputoctets, 0) != COALESCE(OLD.acctinputoctets, 0) THEN

        SET v_data_usage_out = GREATEST(
            0,
            COALESCE(NEW.acctoutputoctets, 0) - COALESCE(OLD.acctoutputoctets, 0)
        );
        SET v_data_usage_in = GREATEST(
            0,
            COALESCE(NEW.acctinputoctets, 0) - COALESCE(OLD.acctinputoctets, 0)
        );

        SELECT COALESCE(MAX(s.usage_graph_enabled), 0)
        INTO v_usage_graph_enabled
        FROM customers c
        INNER JOIN users u ON u.id = c.user_id
        LEFT JOIN settings s ON s.user_id = COALESCE(u.admin_id, u.id)
        WHERE c.username = NEW.username;

        IF v_usage_graph_enabled = 1 THEN
            INSERT INTO live_graphs (
                username,
                download_bytes,
                upload_bytes,
                last_updated_at,
                created_at,
                updated_at
            ) VALUES (
                NEW.username,
                COALESCE(NEW.acctinputoctets, 0),
                COALESCE(NEW.acctoutputoctets, 0),
                COALESCE(NEW.acctupdatetime, NOW()),
                NOW(),
                NOW()
            );
        END IF;

        UPDATE customers
        SET quota_used = quota_used + v_data_usage_out + v_data_usage_in
        WHERE username = NEW.username;

        UPDATE access_tokens
        SET status = 0,
            usage_status = 1,
            used_data_bytes = used_data_bytes + v_data_usage_out + v_data_usage_in,
            updated_at = NOW()
        WHERE username = NEW.username;
    END IF;

    IF COALESCE(NEW.acctsessiontime, 0) != COALESCE(OLD.acctsessiontime, 0) THEN
        SET v_session_time = GREATEST(
            0,
            COALESCE(NEW.acctsessiontime, 0) - COALESCE(OLD.acctsessiontime, 0)
        );

        UPDATE customers
        SET quota_session = quota_session + (v_session_time / 60)
        WHERE username = NEW.username;

        UPDATE access_tokens
        SET status = 0,
            usage_status = 1,
            used_session_seconds = used_session_seconds + v_session_time,
            updated_at = NOW()
        WHERE username = NEW.username;
    END IF;
END
SQL);

        DB::unprepared(<<<'PROCEDURE_SQL'
CREATE PROCEDURE fr_new_data_usage_period()
SQL SECURITY INVOKER
BEGIN
    DECLARE v_start DATETIME;
    DECLARE v_end DATETIME;

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        RESIGNAL;
    END;

    SELECT IFNULL(
        DATE_ADD(MAX(period_end), INTERVAL 1 SECOND),
        FROM_UNIXTIME(0)
    )
    INTO v_start
    FROM data_usage_by_period;

    SET v_end = NOW();

    START TRANSACTION;

    INSERT INTO data_usage_by_period (
        username,
        period_start,
        period_end,
        acctinputoctets,
        acctoutputoctets
    )
    SELECT
        username,
        v_start,
        v_end,
        SUM(COALESCE(acctinputoctets, 0)),
        SUM(COALESCE(acctoutputoctets, 0))
    FROM radacct
    WHERE acctstoptime > v_start
        OR acctstoptime IS NULL
    GROUP BY username
    ON DUPLICATE KEY UPDATE
        acctinputoctets = data_usage_by_period.acctinputoctets + VALUES(acctinputoctets),
        acctoutputoctets = data_usage_by_period.acctoutputoctets + VALUES(acctoutputoctets),
        period_end = v_end;

    INSERT INTO data_usage_by_period (
        username,
        period_start,
        period_end,
        acctinputoctets,
        acctoutputoctets
    )
    SELECT
        username,
        DATE_ADD(v_end, INTERVAL 1 SECOND),
        NULL,
        0 - SUM(COALESCE(acctinputoctets, 0)),
        0 - SUM(COALESCE(acctoutputoctets, 0))
    FROM radacct
    WHERE acctstoptime IS NULL
    GROUP BY username;

    COMMIT;
END
PROCEDURE_SQL);
    }

    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS radacct_insert_triggers');
        DB::unprepared('DROP TRIGGER IF EXISTS radacct_update_triggers');
        DB::unprepared('DROP PROCEDURE IF EXISTS fr_new_data_usage_period');
    }
};
