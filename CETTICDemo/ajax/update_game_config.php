<?php

require_once(dirname(__FILE__)."/../model/model.php");

if(isset($_POST["speed"]) && isset($_POST["time"]) && isset($_POST["score"]))
{
	$model = new Model();
	echo $model->SetGameConfig($_POST["time"], $_POST["score"], $_POST["speed"]);
}
else
{
	echo "error";
}

?>