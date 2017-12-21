<?php

require_once(dirname(__FILE__)."/../model/model.php");

if(isset($_POST["username"]) && isset($_POST["password"]))
{
	$model = new Model();
	echo $model->CheckLogin($_POST["username"], $_POST["password"]);
}
else
{
	echo "error";
}

?>