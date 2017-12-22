<?php

class Model
{

	var $conn;

	//Conexion a BD
	function Model()
	{
		$this->conn = new mysqli(
			"127.0.0.1", //ip
			"root", //user
			"", //password
			"cettic_demo" //databse
		);
	}

	/*
	Registro de usuario
	TODO: detectar colisión
	*/
	function SignUp($username, $password)
	{
		$ret = $this->conn->query("INSERT INTO usuarios (username, password) VALUES ('$username', '$password');");
		return !$ret ? "error" : $this->conn->insert_id;
	}

	/*
	Return el id del usuario en caso de acceso correcto
	*/
	function CheckLogin($username, $password)
	{
		$ret = $this->conn->query("SELECT * FROM usuarios WHERE username = '$username' AND password = '$password';");
		if($ret->num_rows > 0)
		{
			return $ret->fetch_assoc()["id"];
		}
		else
		{
			return "error";
		}
	}

	//Obtencion de los parametros del juego
	function GetGameConfig()
	{
		$ret = $this->conn->query("SELECT * FROM game_config;");
		$ret = $ret->fetch_assoc();
		return json_encode($ret);
	}

	//Edicion de los parametros del juego
	function SetGameConfig($time_limit, $score_per_item, $player_speed)
	{
		$ret = $this->conn->query("UPDATE game_config SET time_limit = '$time_limit', score_per_item = '$score_per_item', player_speed = '$player_speed';");
		return !$ret ? "error" : "success";
	}

	//Se ingresa el puntaje del usuario a la BD indicando el numero de partida (segun el numero de registros del usuario)
	function PostScore($user_id, $score)
	{

		$ret = $this->conn->query("SELECT COUNT(*) FROM user_score WHERE id_user = '$user_id';");
		$entry = $ret->fetch_assoc()["COUNT(*)"];
		
		$ret = $this->conn->query("INSERT INTO user_score (id_user, score, entry) VALUES ('$user_id', '$score', '$entry');");
		return !$ret ? "error" : "success";
	}

	//Return: arreglo en orden de ingreso de los registros de puntaje
	function GetPlayerStats($user_id)
	{
		$ret = $this->conn->query("SELECT * FROM user_score WHERE id_user = '$user_id';");

		$arr = array();
		$row;
		while($row = $ret->fetch_assoc())
		{
			array_push($arr, $row["score"]);
		}

		return !$ret ? "error" : json_encode($arr);
	}

	//Return: promedio de todos los usuarios por cada partida
	function GetAverageStats()
	{
		$re = $this->conn->query("SELECT AVG(score) FROM user_score GROUP BY entry ASC");
		$arr = array();
		while($row = $re->fetch_assoc()){
			//echo json_encode($row);	
			array_push($arr, $row);
		}
		return !$re ? "error" : json_encode($arr);
		
	}

	//Lista de usuarios
	function GetUsers()
	{
		$re = $this->conn->query("SELECT * FROM usuarios");
		$arr = array();
		while($row = $re->fetch_assoc()){
			array_push($arr, $row);
		}
		return !$re ? "error" : json_encode($arr);
	}

}

?>