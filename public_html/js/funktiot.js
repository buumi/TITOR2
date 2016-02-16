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
        //select: luoLisaysPopup,
        events: "haevaraukset.php?id=" + kayttajaId,
    });
}

function lisaysPopupTallenna() {
    var kuvaus = $('#kuvaus').val();
    var start = $('#alkamisaika').text();
    var stop = $('#loppumisaika').text();

    muutaTapahtumaa(start, stop, kuvaus);

    $("#calendar").fullCalendar('refetchEvents');

    $('#myModal').modal('hide')
}

function luoLisaysPopup(start, end) {
    $('#alkamisaika').text(start.format())
    $('#loppumisaika').text(end.format())

    $('#kuvaus').val("")

    $('#myModal').modal()
}
