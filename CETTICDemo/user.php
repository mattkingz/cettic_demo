<!DOCTYPE html>
<html lang="en">

<?php

require_once(dirname(__FILE__)."/model/model.php");
$model = new Model();

//Se obtiene el usuario actual
$user_id = $_GET["id"];
$users = json_decode($model->GetUsers(), true);
$current_user;
for($i=0; $i<count($users);$i++)
{
  if($user_id == $users[$i]["id"])
  {
    $current_user = $users[$i];
    break;
  }
}

//Se obtienen los datos para poblar los graficos
$stats_user = $model->GetPlayerStats($user_id);
$stats_global = $model->GetAverageStats();

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
  
<?php require(dirname(__FILE__)."/modules/side_menu.php"); ?>

  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#"><?php echo $current_user["username"]; ?></a>
        </li>
      </ol>

      <!-- Chart 1: estadisticas del usuario-->
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-area-chart"></i> Resultados del usuario</div>
        <div class="card-body">
          <canvas id="chart1" width="100%" height="30"></canvas>
        </div>
      </div>

      <!-- Chart 2: estadisticas del usuario vs globales -->
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-area-chart"></i> Comparación usuario con el resto de los jugadores</div>
        <div class="card-body">
          <canvas id="chart2" width="100%" height="30"></canvas>
        </div>
      </div>
    
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

    <script>
    
    //parse de datos
    var stats_global = <?php echo $stats_global; ?>;
    var stats_user = <?php echo $stats_user; ?>;
    var arr_stats_global = [];
    var arr_stats_user = [];
    var arr_labels = [];

    //se rellena con valor cero en caso de que una de las estadisticas tenga menos datos (ej: el jugador ha jugado menos partidas)
    var count = stats_global.length > stats_user.length ? stats_global.length : stats_user.length;

    for(var i = 0; i < count; i++)
    {
      arr_stats_global.push(i < stats_global.length ? parseInt(stats_global[i]["AVG(score)"]) : 0);
      arr_stats_user.push(i < stats_user.length ? parseInt(stats_user[i]) : 0);
      arr_labels.push(i+1);
    }

    //creación de gráficos chart.js
    //TODO: una clase para generar y poblar los datos
    Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#292b2c';

    var ctx = document.getElementById("chart1");
    var myLineChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: arr_labels,
        datasets: [
        {
          label: "Puntaje Jugador",
          lineTension: 0.3,
          backgroundColor: "rgba(0,0,255,0.2)",
          borderColor: "rgba(0,0,255,1)",
          data: arr_stats_user,
        },
        ],
      }
    });

    var ctx = document.getElementById("chart2");
    var myLineChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: arr_labels,
        datasets: [
        {
          label: "Promedio General",
          lineTension: 0.3,
          backgroundColor: "rgba(255,0,0,0.2)",
          borderColor: "rgba(255,0,0,1)",
          data: arr_stats_global,
        },
        {
          label: "Puntaje Jugador",
          lineTension: 0.3,
          backgroundColor: "rgba(0,0,255,0.2)",
          borderColor: "rgba(0,0,255,1)",
          data: arr_stats_user,
        },
        ],
      }
    });

    </script>

  </div>
</body>

</html>
