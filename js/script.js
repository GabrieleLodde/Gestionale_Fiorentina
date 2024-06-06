$(function(){
    var note = $('#note');
    // Imposta la data desiderata: 17 agosto 2024
    var ts = new Date(2024, 7, 17, 15);
        
    $('#countdown').countdown({
        timestamp: ts,
        callback: function(months, days, hours){
            var message = "";
            
            message += months + " month" + (days == 1 ? '' : 's') + ", ";
            message += days + " day" + (days == 1 ? '' : 's') + " and ";
            message += hours + " hour" + (hours == 1 ? '' : 's') + "<br /> ";
            
            // Aggiungi il messaggio al div
            note.html(message);
        }
    });
});