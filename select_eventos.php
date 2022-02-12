<?php
	declare(strict_types=1);

	//requisita conexão com Mysql PDO
	require_once "connect_pdo.php";

	//define array($eventos) inicialmente vazio
	$eventos = array();

	//define query SELECT selecionando eventos
	$query = "SELECT * FROM events ORDER BY title ASC";
	$query = $pdo->query($query);

	//verfiica se houve retorno da requisição e atribui ao array($eventos)
	if($query->rowCount() > 0) {

		$eventos = $query->fetchAll(PDO::FETCH_ASSOC);

	}

	//retorna array($eventos) com dados em formato de json object
	echo json_encode($eventos);
	exit();
?>