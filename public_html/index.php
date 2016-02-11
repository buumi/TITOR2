<!DOCTYPE html>
<html lang="fi">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <meta name="description" content="Ajanvaraus järjestelmä Vaasan yliopistolle. Harjoitustyö">
  <meta name="author" content="Ryhmä 2">

  <title>Ajanvaraus</title>

  <!-- Bootstrapin CSS -->
  <link href="libs/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Kalenterin CSS -->
  <link rel='stylesheet' href='libs/fullcalender/fullcalendar.css' />
  <!-- Kustomoinnit, esim oranssi väri -->
  <link href="css/dashboard.css" rel="stylesheet">
</head>

<body>

  <nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">Vaasan yliopisto</a>
      </div>
    </div>
  </nav>

  <div class="container-fluid">
    <div class="row">

      <div class="col-sm-3 col-md-2 sidebar">
        <ul class="nav nav-sidebar">
          <li> <a href="#">Oma kalenteri <span class="sr-only">(current)</span></a></li>
          <li></li>
          <li>
            <div class="input-group input-group-sm">
              <span class="input-group-addon" id="sizing-addon3"></span>
              <input onkeyup="naytaTulokset(this.value, 'hakutulokset')" type="text" class="form-control" placeholder="Hae kalenteria" aria-describedby="sizing-addon3">
            </div>
          </li>
          <li>
            <span id="hakutulokset"></span>
          </li>
        </ul>
      </div>

      <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <div id='calendar'></div>
      </div>

    </div>
  </div>


  <!-- Sisällytä JQuery, Bootstrap ja FullCalendar JavaScript -->
  <script src='libs/fullcalender/lib/jquery.min.js'></script>

  <script src="libs/bootstrap/js/bootstrap.js"></script>

  <script src='libs/fullcalender/lib/moment.min.js'></script>
  <script src='libs/fullcalender/fullcalendar.js'></script>
  <script src="libs/fullcalender/lang/fi.js"></script>

  <!-- Omat Javascript funktiot -->
  <script src="js/funktiot.js"></script>

  <script type='text/javascript'>
    luoKalenteri("#calendar", <?php echo $_GET["id"]; ?>);
  </script>

</body>
</html>
