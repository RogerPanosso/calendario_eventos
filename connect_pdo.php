<?php
	/*
	* Conexão com servidor de banco de dados Mysql utilizando biblioteca
	* PDO Object
	* Author <rogerninopa@gmail.com>
	*/
	define("DBDRIVER", "mysql");
	define("DBNAME", "full_calendar");
	define("DBHOST", "localhost");
	define("DBUSER", "root");
	define("DBPASS", "");

	try {
	
		$pdo = new PDO(DBDRIVER.":dbname=".DBNAME.";host=".DBHOST, DBUSER, DBPASS);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$pdo->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);

	} catch (PDOException $erro) {
		
		echo "Erro de conexão: ".$erro->getMessage()."<br>".PHP_EOL;
		echo "Arquivo: ".$erro->getFile()."<br>".PHP_EOL;
		echo "Linha: ".$erro->getLine()."<br>".PHP_EOL;
		echo "Código: ".$erro->getCode()."<br>".PHP_EOL;
		exit();

	}
?>