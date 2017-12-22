<!DOCTYPE html>
<html lang="en">

<?php

require_once(dirname(__FILE__)."/model/model.php");
$model = new Model();

$game_config = json_decode($model->GetGameConfig(), true);

?>

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>CETTIC DEMO</title>
  <!-- Bootstrap core CSS-->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">

<!-- Side menu -->
<?php require(dirname(__FILE__)."/modules/side_menu.php"); ?>

  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Configuración</a>
        </li>
      </ol>

    <!-- Panel de edición de parametros -->
    <div class="card card-register mx-auto mt-5">
      <div class="card-header">Parámetros</div>
      <div class="card-body">
        <form>

          <div class="form-group">
            <label for="exampleInputEmail1">Tiempo de la partida</label>
            <input class="form-control" id="txtTime" value=<?php echo $game_config["time_limit"];?> >
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Velocidad del jugador</label>
            <input class="form-control" id="txtSpeed" value=<?php echo $game_config["player_speed"];?> >
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Puntaje por item</label>
            <input class="form-control" id="txtScore" value=<?php echo $game_config["score_per_item"];?> >
          </div>
          
          <input type="button" class="btn btn-primary btn-block" id="btnModifcar" value="Modificar" onclick="Modify()">
        </form>
      </div>
    </div>

    <script>

    //llamada ajax que modifica los valores en la BD
    function Modify()
    {
      var score = $("#txtScore").val();
      var time = $("#txtTime").val();
      var speed = $("#txtSpeed").val();

      $.ajax({
        type: "POST",
        url: "ajax/update_game_config.php",
        data: {score: score, time: time, speed: speed},
        success: function(data){
          //alert(data);
        },
        error: function(error, e2, e3)
        {
          alert(e3);
        }
      });
      //TODO: feedback de error o modificación correcta

    }
    
    </script>

    
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <footer class="sticky-footer">
      <div class="container">
        <div class="text-center">
          <small>Copyright © Your Website 2017</small>
        </div>
      </div>
    </footer>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Page level plugin JavaScript-->
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="vendor/datatables/jquery.dataTables.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin.min.js"></script>
    <!-- Custom scripts for this page-->
    <script src="js/sb-admin-datatables.min.js"></script>
    <script src="js/sb-admin-charts.min.js"></script>
  </div>
</body>

</html>
