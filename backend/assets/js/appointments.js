


$(document).on('ready pjax:beforeSend', function(){
    $('#dynagrid-schedule-appointment').showLoading();
});
$(document).on('ready pjax:complete', function(){
    $('#dynagrid-schedule-appointment').hideLoading();
});
