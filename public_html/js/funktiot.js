/**
 * Created by jkankaanpaa on 2/11/16.
 */

function muutaTapahtumaa(start, stop, title) {
    var muokkaavaraustaurl = "muokkaavarausta.php?start=" + start + "&stop=" + stop + "&title=" + title

    $.ajax({
        url: muokkaavaraustaurl
    })
}

function naytaTulokset(str, kohdeElementti) {
    if (str.length == 0) {
        document.getElementById(kohdeElementti).innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById(kohdeElementti).innerHTML = xmlhttp.responseText;
            }
        };
        xmlhttp.open("GET", "haeKayttajaa.php?nimi=" + str, true);
        xmlhttp.send();
    }
}

function luoKalenteri(kohdeElementti, kayttajaId) {
    $(kohdeElementti).fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        slotDuration: '00:15:00',
        contentHeight: "auto",
        minTime: "08:00:00",
        maxTime: "16:00:00",
        defaultDate: moment(),
        defaultView: 'agendaWeek',
        eventColor: '#e67e22',
        allDaySlot: false,
        editable: true,
        selectable: true,
        selectHelper: true,
        select: luoLisaysPopup,
        events: "haevaraukset.php?id=" + kayttajaId,
        eventClick: luoTietoPopup,
        eventDrop: function(event, delta, revertFunc) {
            var title = event.title;
            var start = event.start.format();
            var stop = (event.end == null) ? start : event.end.format();
            muutaTapahtumaa(start, stop, title);

        },
        eventDrop: function(event, delta, revertFunc) {
            var title = event.title;
            var start = event.start.format();
            var end = (event.end == null) ? start : event.end.format();
            $.ajax({
                url: 'process.php',
                data: 'type=resetdate&title='+title+'&start='+start+'&end='+end+'&eventid='+event.id,
                type: 'POST',
                dataType: 'json',
                success: function(response){
                    if(response.status != 'success')
                        revertFunc();
                },
                error: function(e){
                    revertFunc();
                    alert('Error processing your request: '+e.responseText);
                }
            });
        },
        eventResize: function(event, delta, revertFunc) {
            console.log(event);
            var title = event.title;
            var end = event.end.format();
            var start = event.start.format();
            $.ajax({
                url: 'process.php',
                data: 'type=resetdate&title='+title+'&start='+start+'&end='+end+'&eventid='+event.id,
                type: 'POST',
                dataType: 'json',
                success: function(response){
                    if(response.status != 'success')
                        revertFunc();
                },
                error: function(e){
                    revertFunc();
                    alert('Error processing your request: '+e.responseText);
                }
            });
        },

    });
}

function lisaysPopupTallenna() {
    var title = $('#kuvaus').val();
    var start = $('#alkamisaika').text();
    var end = $('#loppumisaika').text();

    var eventData;
    if(title) {
        /*
        eventData = {
            title: title,
            start: start,
            end: end
        }
        */
        $.ajax({
            url: 'process.php',
            data: 'type=new&title=' + title + '&startdate=' + start + '&enddate=' + end,
            type: 'POST',
            dataType: 'json',

        });

        //$('#calendar').fullCalendar('renderEvent', eventData);
    };

    //$('#calendar').fullCalendar('unselect');

    $("#calendar").fullCalendar('refetchEvents');

    $('#myModal').modal('hide')
    //alert(title+start+end);
}

function luoLisaysPopup(start, end) {
    $('#alkamisaika').text(start.format())
    $('#loppumisaika').text(end.format())

    $('#kuvaus').val("")

    $('#myModal').modal()
}

function luoTietoPopup(event, jsEvent, view) {
    $('#alkamisaika2').text(event.start)
    $('#loppumisaika2').text(event.end)

    $('#eventID').val(event.id)

    $('#syy').text(event.title)
    $('#kuvaus2').val("")

    $('#myModal2').modal()
}

function tietoPopupPoista() {
    var id = $('#eventID').val();
    var con = confirm('Haluatko varmasti poistaa varauksen?');
    if(con == true) {
        $.ajax({
            url: 'process.php',
            data: 'type=remove&eventid='+id,
            type: 'POST',
            dataType: 'json',
            success: function(response){
                console.log(response);
                if(response.status == 'success'){
                    $("#calendar").fullCalendar('refetchEvents');
                    //$('#calendar').fullCalendar('removeEvents');
                    //getFreshEvents();
                }
            },
            error: function(e){
                alert('Error processing your request: '+e.responseText);
            }
        });
    }

    $("#calendar").fullCalendar('refetchEvents');

    $('#myModal2').modal('hide')

}

function tietoPopupMuutaSyy(){

    var id = $('#eventID').val();
    var title = $('#kuvaus2').val();

    console.log('type=changetitle&title='+title+'&eventid='+id);
    $.ajax({
        url: 'process.php',
        data: 'type=changetitle&title='+title+'&eventid='+id,
        type: 'POST',
        dataType: 'json',

        success: function(response){
            if(response.status == 'success')
                $("#calendar").fullCalendar('refetchEvents');
                //$('#calendar').fullCalendar('updateEvent',event);
            //getFreshEvents();
        },
        error: function(e){
            alert('Error processing your request: '+e.responseText);
        }

    });

    //$("#calendar").fullCalendar('refetchEvents');

    $('#myModal2').modal('hide')

}
