<?php

require_once(dirname(__FILE__)."/../model/model.php");

$model = new Model();
echo $model->GetPlayerStats(6);

?>