<?php 
    require_once "session.php"; 
    require_once "apufunktiot.php";
    
    if (isset($_GET["id"])) {
        $kalenterin_id = $_GET["id"];
    }
    else {
        $kalenterin_id = $id;
    }

?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Collapsing sidebar drawer menu</title>
    <meta name="generator" content="Bootply" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="libs/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">

    <!-- Kalenterin CSS -->
    <link rel='stylesheet' href='libs/fullcalender/fullcalendar.css' />
</head>
<body>
<div class="page-container">

    <!-- top navbar -->
    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="offcanvas" data-target=".sidebar-nav">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Vaasan yliopisto</a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row row-offcanvas row-offcanvas-left">

            <!-- sidebar -->
            <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">
                <ul class="nav">
                    <li> <a id="omaKalenteriLinkki" href="index.php?id=<?php echo $id ?>">Oma kalenteri <span class="sr-only">(current)</span></a></li>
                    <li></li>
                    <li>
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon" id="sizing-addon3"></span>
                            <input id="kalenterinHakuKentta" onkeyup="naytaTulokset(this.value, 'hakutulokset')" type="text" class="form-control" placeholder="Hae kalenteria" aria-describedby="sizing-addon3">
                        </div>
                    </li>
                    <li>
                        <span id="hakutulokset"></span>
                    </li>

                </ul>
            </div>

            <!-- main area -->
            <div class="col-xs-12 col-sm-9">
                <h3 id="kalenterinOmistajaTeksti" class="text-primary">
                    <?php echo anna_kalenterin_omistaja($id, $kalenterin_id); ?>
                </h3>
                <div id="calendar"></div>
            </div><!-- /.col-xs-12 main -->
        </div><!--/.row-->
    </div><!--/.container-->

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Ajanvaraus</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-2">
                            Alkamisaika:
                        </div>
                        <div id="alkamisaika" class="col-md-2">

                        </div>
                        <div class="col-md-2">
                            Loppumisaika:
                        </div>
                        <div id="loppumisaika" class="col-md-2">

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="kuvaus">Syy tapaamiselle:</label>
                        <input type="text" class="form-control" id="kuvaus" required="true">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="muokkausTallenna" onclick="lisaysPopupTallenna()" class="btn btn-primary">Varaa aika!</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Peruuta</button>
                </div>
            </div>
        </div>
    </div><!--/.page-container-->

    <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel2">Tiedot</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
			<input type="hidden" name="eventID" id="eventID" value="">
                        <div class="col-md-2">
                            Alkamisaika:
                        </div>
                        <div id="alkamisaika2" class="col-md-2">

                        </div>
                        <div class="col-md-2">
                            Loppumisaika:
                        </div>
                        <div id="loppumisaika2" class="col-md-2">

                        </div>
                        <div class="col-md-2">
                            Tapaamisen syy:
                        </div>
                        <div id="syy" class="col-md-2">

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="kuvaus2">Muuta tapaamisen syy:</label>
                        <input type="text" class="form-control" id="kuvaus2" required="true">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="muuta" onclick="tietoPopupMuutaSyy()" class="btn btn-primary">Muuta syy</button>
                    <button type="button" id="poista" onclick="tietoPopupPoista()" class="btn btn-danger">Poista varaus</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Takaisin</button>
                </div>
            </div>
        </div>
    </div>






    <!-- script references -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
    <script src="libs/bootstrap/js/bootstrap.min.js"></script>
    <script src="js/scripts.js"></script>

    <!-- Sisällytä JQuery, Bootstrap ja FullCalendar JavaScript -->
    <script src='libs/fullcalender/lib/jquery.min.js'></script>

    <script src="libs/bootstrap/js/bootstrap.js"></script>

    <script src='libs/fullcalender/lib/moment.min.js'></script>
    <script src='libs/fullcalender/fullcalendar.js'></script>
    <script src="libs/fullcalender/lang/fi.js"></script>

    <!-- Omat Javascript funktiot -->
    <script src="js/funktiot.js"></script>

    <script type='text/javascript'>
        var CONFIG = {
            userID: <?php echo $id; ?>,
            kalenterinID: <?php echo $kalenterin_id; ?>,
            nimi: <?php echo '"' . $nimi . '"'; ?>,
            taso: <?php echo '"' . $taso . '"'; ?>
        }
        

        luoKalenteri("#calendar",  <?php echo $kalenterin_id; ?>);
    </script>

</body>
</html>
