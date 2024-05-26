$(function(){
    var note = $('#note');
    // Imposta la data e l'ora desiderate: 29 maggio 2024 alle ore 21:00
    var ts = new Date(2024, 4, 29, 21, 0, 0);
    
    if((new Date()) > ts){
        // La data e l'ora specificate sono già passate, puoi aggiornare ts per mostrare un altro countdown
        // Ad esempio, aggiorniamo ts di 10 giorni
        ts.setDate(ts.getDate() + 10);
    }
        
    $('#countdown').countdown({
        timestamp: ts,
        callback: function(days, hours, minutes, seconds){
            var message = "";
            
            message += days + " day" + (days == 1 ? '' : 's') + ", ";
            message += hours + " hour" + (hours == 1 ? '' : 's') + ", ";
            message += minutes + " minute" + (minutes == 1 ? '' : 's') + " and ";
            message += seconds + " second" + (seconds == 1 ? '' : 's') + "<br />";
            
            // Aggiungi il messaggio al div con l'id "note"
            note.html(message);
        }
    });
});