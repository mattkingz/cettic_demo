<?php

require_once(dirname(__FILE__)."/../model/model.php");

if(isset($_POST["user_id"]) && isset($_POST["score"]))
{
	$model = new Model();
	echo $model->PostScore($_POST["user_id"], $_POST["score"]);
}
else
{
	echo "error";
}

?>