
jQuery(document).ready(function($){
    
    $('#modal').removeAttr('tabindex');
});
var calendarEventClick = function( event, jsEvent, view ) {
    var url = appointmentUrl + '/update?ajax=1&id='+event.id;
    if(!$('#modal').data('bs.modal').isShown)
        $('#modal').modal('show');
    
    $('#modal').find('#modalContent').load(url);
    
    document.getElementById('modalHeaderTitle').innerHTML = '<h4>' + event.title + '</h4>';
};