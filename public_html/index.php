<!DOCTYPE html>
<html lang="en">
<head>
    <link rel='stylesheet' href='libs/fullcalender/fullcalendar.css' />
    <script src='libs/fullcalender/lib/jquery.min.js'></script>
    <script src='libs/fullcalender/lib/moment.min.js'></script>
    <script src='libs/fullcalender/fullcalendar.js'></script>
    <script type='text/javascript'>

        $(document).ready(function() {

            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                defaultDate: '2014-06-12',
                defaultView: 'basicWeek',
                editable: true,
                events: [
                    {
                        title: 'All Day Event',
                        start: '2014-06-01'
                    },
                    {
                        title: 'Long Event',
                        start: '2014-06-07',
                        end: '2014-06-10'
                    },
                    {
                        id: 999,
                        title: 'Repeating Event',
                        start: '2014-06-09T16:00:00'
                    },
                    {
                        id: 999,
                        title: 'Repeating Event',
                        start: '2014-06-16T16:00:00'
                    },
                    {
                        title: 'Meeting',
                        start: '2014-06-12T10:30:00',
                        end: '2014-06-12T12:30:00'
                    },
                    {
                        title: 'Lunch',
                        start: '2014-06-12T12:00:00'
                    },
                    {
                        title: 'Birthday Party',
                        start: '2014-06-13T07:00:00'
                    },
                    {
                        title: 'Click for Google',
                        url: 'http://google.com/',
                        start: '2014-06-28'
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