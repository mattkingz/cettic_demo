<?php

require_once(dirname(__FILE__)."/../model/model.php");

if(isset($_POST["username"]) && isset($_POST["password1"]) && isset($_POST["password2"]))
{
	if($_POST["password1"] == $_POST["password2"])
	{
		$model = new Model();
		echo $model->SignUp($_POST["username"], $_POST["password1"]);
	}
	else
	{
		echo "error";
	}

}
else
{
	echo "error";
}

?>