<!DOCTYPE html>
<html lang="en">

<?php

require_once(dirname(__FILE__)."/model/model.php");
$model = new Model();

$stats = $model->GetAverageStats();

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
          <a href="#">Estadísticas Generales</a>
        </li>
      </ol>

      <!-- Chart promedio general -->
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-area-chart"></i> Promedio de resultados de los jugadores</div>
        <div class="card-body">
          <canvas id="chart1" width="100%" height="30"></canvas>
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
    
    //Parse de valores y generar labels del grafico
    var stats = <?php echo $stats; ?>;
    var arr_stats = [];
    var arr_labels = [];

    for(var i = 0; i < stats.length; i++)
    {
      arr_stats.push(parseInt(stats[i]["AVG(score)"]));
      arr_labels.push(i+1);
    }

    //Grafico chart.js
    Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#292b2c';

    var ctx = document.getElementById("chart1");
    var myLineChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: arr_labels,
        datasets: [{
          label: "Promedio General",
          lineTension: 0.3,
          backgroundColor: "rgba(255,0,0,0.2)",
          borderColor: "rgba(255,0,0,1)",
          data: arr_stats,
        },
        ],
      }
    });

    </script>

  </div>
</body>

</html>
