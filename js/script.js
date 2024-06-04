$(function(){
    var note = $('#note');
    // Imposta la data desiderata: 17 agosto 2024
    var ts = new Date(2024, 7, 17, 15, 0, 0);
    
    /*if((new Date()) > ts){
        // La data e l'ora specificate sono già passate, aggiorno il ts per mostrare un altro countdown
        // Ad esempio, aggiornato di 10 giorni
        ts.setDate(ts.getDate() + 10);
    }*/
        
    $('#countdown').countdown({
        timestamp: ts,
        callback: function(months, days, hours){
            var message = "";
            
            message += months + " month" + (days == 1 ? '' : 's') + ", ";
            message += days + " day" + (days == 1 ? '' : 's') + " and ";
            message += hours + " hour" + (hours == 1 ? '' : 's') + "<br /> ";
            
            // Aggiungi il messaggio al div con l'id "note"
            note.html(message);
        }
    });
});