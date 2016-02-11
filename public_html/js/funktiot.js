/**
 * Created by jkankaanpaa on 2/11/16.
 */

function muutaTapahtumaa(event) {
    var muokkaavaraustaurl = "muokkaavarausta.php?id" + event.id + "&start=" + event.start.format() + "&stop=" + event.end.format()

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
        contentHeight: "auto",
        minTime: "08:00:00",
        maxTime: "16:00:00",
        defaultDate: moment(),
        defaultView: 'agendaWeek',
        eventColor: '#e67e22',
        allDaySlot: false,
        editable: true,
        eventOverlap: function(event) {
            return event.rendering === 'background';
        },
        selectable: true,
        selectHelper: true,
        selectConstraint: "availableForMeeting",
        selectOverlap: function(event) {
            return event.rendering === 'background';
        },
        select: function(start, end) {
            var title = prompt('Event Title:');
            var eventData;
            if (title) {
                eventData = {
                    title: title,
                    start: start,
                    end: end,
                    constraint: "availableForMeeting"
                };
                $(kohdeElementti).fullCalendar('renderEvent', eventData, true); // stick? = true
            }
            $(kohdeElementti).fullCalendar('unselect');
        },
        events: "haevaraukset.php?id=" + kayttajaId,
        eventResize: muutaTapahtumaa,
        eventDrop: muutaTapahtumaa
    });
}