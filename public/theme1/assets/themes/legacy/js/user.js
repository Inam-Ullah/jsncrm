// $(document).ready(function () {

//     /** ******  Activation  *********************** **/
//     $(document).on('click', 'a.user-activation-btn', function () {

//         var userid = $(this).attr('data-userid');
//         var url = baseurl + 'activation/activation/ajaxfetch/';

//         //change value when click on user-activation-btn
//         $('.activation_modal .addExtraCharge').val('');

//         $('div.cost1Div').hide();
//         $('div.cost2Div').hide();
//         $('div.cost3Div').hide();
//         $('div.cost4Div').hide();
//         $('div.cost5Div').hide();

//         $('.cost1').val('');
//         $('.cost2').val('');
//         $('.cost3').val('');
//         $('.cost4').val('');
//         $('.cost5').val('');

//         $('.cost1level').val('');
//         $('.cost2level').val('');
//         $('.cost3level').val('');
//         $('.cost4level').val('');
//         $('.cost5level').val('');

//         jQuery.ajax({
//             type: "POST",
//             url: url,
//             dataType: 'json',
//             data: { "userid": userid },
//             async: true,
//             beforeSend: function () {
//                 $("div#loading").delay(100).fadeIn();
//                 $('.selectPPPoEProfile').hide();
//                 $('#pppoeprofile').children('option').remove();
//                 $('.selectHotspotProfile').hide();
//                 $('#hotspotprofile').children('option').remove();
//                 $('.selectHotspotServer').hide();
//                 $('#hotspotserver').children('option').remove();
//                 $('.selectInterface').hide();
//                 $('#interface').children('option').remove();
//             },
//             success: function (data) {

//                 $("div#loading").delay(100).fadeOut("slow");
//                 $('.activation_modal input[name="userID"]').val(userid);
//                 $('.activation_modal input#username').val(data.username);
//                 $('.activation_modal input#userstatus').val(data.userstatus);
//                 $('.activation_modal input#statusname').val(data.statusname);

//                 console.log(JSON.stringify(data, null /*replacer function */, 4 /* space */))

//                 $("div#loading").delay(100).fadeOut("slow");
//                 // $('.activation_modal input[name="userID"]').val(userid);
//                 // $('.activation_modal input#username').val(data.username);
//                 $('.activation_modal input[name="expirytime"]').val(data.fixedExpireTime);

//                 // table data list
//                 $('.activation_modal table tbody tr td span.username').text(data.username);
//                 $('.activation_modal table tbody tr td span.id').text(data.userid);
//                 $('.activation_modal table tbody tr td.status').text(data.statusName);
//                 $('.activation_modal table tbody tr td.current_package').text(data.currentPackageName);

//                 $('.activation_modal table tbody tr td.current_expiration').text(data.expiration.currentExpiration);
//                 $('.activation_modal table tbody tr td.new_expiration').text(data.expiration.newExpiration);
//                 $('.activation_modal table tbody tr td span.package_duration').text(data.packageData.duration);
//                 $('.activation_modal table tbody tr td span.package_duration_type').text(data.packageData.durationType.charAt(0).toUpperCase() + data.packageData.durationType.slice(1));
//                 $('.activation_modal table tbody tr td.fixed_expiry_day').text(data.fixedExpireDay);
//                 $('.activation_modal table tbody tr td.package_price').text(data.packageAccounting.packagePrice);
//                 $('.activation_modal table tbody tr td.package_extra_fee').text(data.packageAccounting.extraServiceFee);
//                 $('.activation_modal table tbody tr td.package_other_fee').text(data.packageAccounting.packageOtherFee);
//                 $('.activation_modal table tbody tr td.package_vat_fee').text(data.packageAccounting.packageVat);
//                 $('.activation_modal table tbody tr td.added_hours').text(data.addedHours);
//                 $('.activation_modal table tbody tr td.reduced_hours').text(data.reducedHours);
//                 $('.activation_modal table tbody tr td.total_days').text(data.totalDiffDays);
//                 $('.activation_modal table tbody tr td.total_hours').text(data.totalHours);
//                 $('.activation_modal table tbody tr td.per_hour_price').text(data.packageAccounting.perHourPackageTotal);
//                 $('.activation_modal table tbody tr td.total_price').text(data.packageAccounting.packageTotal);

//                 var balanceStatus = data.balanceStatus;
//                 var expiryStatus = data.expiryStatus;

//                 if (balanceStatus <= 0) {
//                     $.confirm({
//                         title: 'Alert! Insufficient Balance',
//                         content: "Insufficient User Balance. Do You Want To Proceed ?",
//                         type: 'orange',
//                         typeAnimated: true,
//                         buttons: {
//                             Cancel: function () { },
//                             Ok: function () { }
//                         }
//                     });
//                 }

//                 if (expiryStatus === true) {
//                     $.confirm({
//                         title: 'Alert! Renewing Active User',
//                         content: "Renewing Active User. Do You Want To Proceed ?",
//                         type: 'orange',
//                         typeAnimated: true,
//                         buttons: {
//                             Cancel: function () { },
//                             Ok: function () { }
//                         }
//                     });
//                 }

//                 if (data.hasOwnProperty('error') && data.error.length != 0) { //if any error message                      
//                     $("div#loading").delay(100).fadeOut("slow");
//                     $('.activation_modal').modal('hide');
//                     showAlert('red', 'Alert', data.error);
//                 } else {
//                     if (data.hasOwnProperty('userStatus') && data.userStatus == 1) {
//                         $('.activation_modal span#buttontext').html('Active');
//                         $('.activation_modal select#package').children('option').remove();
//                         $('.activation_modal select#package').prepend(data.currentPackageList);
//                     } else {
//                         $('.activation_modal select#package').children('option').remove();
//                         $('.activation_modal select#package').prepend(data.currentPackageList);
//                         $('.activation_modal span#buttontext').html('Update');
//                     }
//                 }

//                 if (data.pppoeProfileList.length != 0) {
//                     $('.selectPPPoEProfile').show();
//                     $('#pppoeprofile').prepend(data.pppoeProfileList);
//                     $('#pppoeprofile').attr("required", true);
//                 }
//                 if (data.hotspotProfileList.length != 0) {
//                     $('.selectHotspotProfile').show();
//                     $('#hotspotprofile').prepend(data.hotspotProfileList);
//                     $('#hotspotprofile').attr("required", true);
//                 }
//                 if (data.hotspotServerList.length != 0) {
//                     $('.selectHotspotServer').show();
//                     $('#hotspotserver').prepend(data.hotspotServerList);
//                     $('#hotspotserver').attr("required", true);
//                 }
//                 if (data.interfaceList.length != 0) {
//                     $('.selectInterface').show();
//                     $('#interface').prepend(data.interfaceList);
//                     $('#interface').attr("required", true);
//                 }
//             }
//         });
//     });

//     /** ******  Extra Charge Cost in All Users  *********************** **/
//     $('.activation_modal .addExtraCharge').on('change', function () {
//         var addExtraCharge = $(this).val();
//         if (addExtraCharge == 1) {
//             $('div.cost1Div').show();
//         } else {
//             $('div.cost1Div').hide();
//             $('div.cost2Div').hide();
//             $('div.cost3Div').hide();
//             $('div.cost4Div').hide();
//             $('div.cost5Div').hide();

//             $('.cost1').val('');
//             $('.cost2').val('');
//             $('.cost3').val('');
//             $('.cost4').val('');
//             $('.cost5').val('');

//             $('.cost1level').val('');
//             $('.cost2level').val('');
//             $('.cost3level').val('');
//             $('.cost4level').val('');
//             $('.cost5level').val('');

//         }
//     });


//     $('.activation_modal .cost1').on('change', function () {
//         var cost1level = $(this).val();
//         var cost1 = $('.cost1').val();
//         if (cost1level && cost1) {
//             $('div.cost2Div').show();
//         } else {
//             $('div.cost2Div').hide();
//             $('div.cost3Div').hide();
//             $('div.cost4Div').hide();
//             $('div.cost5Div').hide();
//         }
//     });

//     $('.activation_modal .cost2').on('change', function () {
//         var cost2level = $(this).val();
//         var cost2 = $('.cost2').val();
//         if (cost2level && cost2) {
//             $('div.cost3Div').show();
//         } else {
//             $('div.cost3Div').hide();
//             $('div.cost4Div').hide();
//             $('div.cost5Div').hide();
//         }
//     });

//     $('.activation_modal .cost3').on('change', function () {
//         var cost3level = $(this).val();
//         var cost3 = $('.cost3').val();
//         if (cost3level && cost3) {
//             $('div.cost4Div').show();
//         } else {
//             $('div.cost4Div').hide();
//             $('div.cost5Div').hide();
//         }
//     });

//     $('.activation_modal .cost4').on('change', function () {
//         var cost4level = $(this).val();
//         var cost4 = $('.cost4').val();
//         if (cost4level && cost4) {
//             $('div.cost5Div').show();
//         } else {
//             $('div.cost5Div').hide();
//         }
//     });


// });