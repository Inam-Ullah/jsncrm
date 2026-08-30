<footer>
    <div class="pull-right">
        {{ $setting->name ?? 'JSN ISP CRM' }}
        @if($setting->slogan)
            | {{ $setting->slogan }}
        @endif
        @if($setting->copyright)
            | {{ $setting->copyright }}
        @endif
        @if($setting->jsntext == 1)
            | ISP CRM by JSN
        @endif
    </div>
    <div class="clearfix"></div>
</footer>
