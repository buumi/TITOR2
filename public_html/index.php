<!DOCTYPE html>
<html lang="en">
<head>
    <link rel='stylesheet' href='libs/fullcalender/fullcalendar.css' />
    <script src='libs/fullcalender/lib/jquery.min.js'></script>
    <script src='libs/fullcalender/lib/moment.min.js'></script>
    <script src='libs/fullcalender/fullcalendar.js'></script>
    <script src="libs/fullcalender/lang/fi.js"></script>
    <script type='text/javascript'>

        $(document).ready(function() {

            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                lang: "fi",
                defaultDate: '2014-06-12',
                defaultView: 'agendaWeek',
                allDaySlot: false,
                editable: true,
                minTime: "08:00:00",
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
                        $('#calendar').fullCalendar('renderEvent', eventData, true); // stick? = true
                    }
                    $('#calendar').fullCalendar('unselect');
                },

                maxTime: "16:00:00",
                events: [
                    // areas where "Meeting" must be dropped
                    {
                        id: 'availableForMeeting',
                        start: '2014-06-11T10:00:00',
                        end: '2014-06-11T16:00:00',
                        rendering: 'background'
                    }
                ]
            });

        });

    </script>
    <style type='text/css'>

        body {
            margin-top: 40px;
            text-align: center;
            font-size: 14px;
            font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
        }

        #calendar {
            width: 900px;
            margin: 0 auto;
        }

    </style>
</head>
<body>
<div id='calendar'></div>
</body>
</html>
