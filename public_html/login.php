<!DOCTYPE html>
<html lang="fi">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Ajanvaraus kirjautuminen</title>

    <!-- Bootstrap core CSS -->
    <link href="libs/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/signin.css" rel="stylesheet">

  </head>

  <body>

    <div class="container">

      <form action="index.php" class="form-signin" method="POST">
        <h2 class="form-signin-heading">Kirjaudu sisään</h2>
        <input type="text" name="tunnus" class="form-control" placeholder="Käyttäjätunnus" required autofocus>
        <input type="password" name="salasana" class="form-control" placeholder="Salasana" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Kirjaudu</button>
      </form>

    </div> <!-- /container -->

  </body>
</html>
