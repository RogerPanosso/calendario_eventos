<?php
	declare(strict_types=1);

	//requisita conexão com Mysql PDO
	require_once "connect_pdo.php";

	//recebe dados da requisição interna como POST
	$title = trim(filter_input(INPUT_POST, "title", FILTER_SANITIZE_STRING));
	$color = trim(filter_input(INPUT_POST, "color", FILTER_SANITIZE_STRING));
	$start = trim(filter_input(INPUT_POST, "start", FILTER_SANITIZE_STRING));
	$end = trim(filter_input(INPUT_POST, "end", FILTER_SANITIZE_STRING));

	//procura por caractere em strings de data de inicio e fim
	$start = str_replace("/", "-", $start);
	$end = str_replace("/", "-", $end);

	//converte data de inicio e fim do evento para padrão Y-m-d H:i:s(MySQL)
	$start_padrao = date("Y-m-d H:i:s", strtotime($start));
	$end_padrao = date("Y-m-d H:i:s", strtotime($end));

	//realiza validação diante variaveis
	if(empty($title) or empty($color) or empty($start_padrao) or empty($end_padrao)) {

		echo "<script>window.history.back()</script>";
		exit();

	}

	//define variavel $array inicialmente null
	$array = array();

	//define query SELECT verificando se evento cadastrado possui title unico
	$query = "SELECT * FROM events WHERE title = :title";
	$query = $pdo->prepare($query);
	$query->bindValue(":title", $title);
	$query->execute();

	if($query->rowCount() === 0) {

		$query = "INSERT INTO events (title,color,start,end) VALUES (:title,:color,:start,:end)";
		$query = $pdo->prepare($query);
		$query->bindValue(":title", $title);
		$query->bindValue(":color", $color);
		$query->bindValue(":start", $start_padrao);
		$query->bindValue(":end", $end_padrao);
		$query->execute();
		
		if($query->rowCount() > 0) {

			$idEvento = $pdo->LastInsertId();
			$array["return"] = "success";
			$array["idEvento"] = $idEvento;

		}else {

			$array["return"] = "error";

		}

	}else {

		$array["return"] = "exist";

	}

	//retorna array com dados em formato json(object)
	header("Location: application/json");
	echo json_encode($array);
	exit();
?>