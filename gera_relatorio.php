<?php
	declare(strict_types=1);

	//habilita diretiva(php.ini) setando tamanho limite de memória para execução
	set_time_limit(100);
	ini_set("memory_limit", "-1");

	//requisita conexão com Mysql PDO
	require_once "connect_pdo.php";

	//requisita autolod(composer)
	require_once "vendor/autoload.php";

	//recebe dados da requisição form como POST
	$forma_acesso = trim(filter_input(INPUT_POST, "forma_acesso", FILTER_SANITIZE_STRING));
	$fonte = trim(filter_input(INPUT_POST, "fonte", FILTER_SANITIZE_STRING));
	$folha = trim(filter_input(INPUT_POST, "folha", FILTER_SANITIZE_STRING));
	$estilo = trim(filter_input(INPUT_POST, "estilo", FILTER_SANITIZE_STRING));

	//realiza validação diante variaveis
	if(empty($forma_acesso) or empty($fonte) or empty($folha) or empty($estilo)) {

		header("Location: index.php");
		exit();

	}

	//define query SELECT listando eventos
	$query = "SELECT * FROM events ORDER BY start DESC";
	$query = $pdo->query($query);

	//verifica se houve retorno diante requisição e cria estrutura html para pdf
	if($query->rowCount() > 0) {

		$events = $query->fetchAll(PDO::FETCH_ASSOC);
		$total = $query->rowCount();
		
		$html = "<style type='text/css'>span {font-size:9px;} table {font-size:9px;border-collapse:collapse;} h4{margin-bottom:5px;}</style>";
		$html .= "<meta charset='utf-8'/>";
		$html .= "<title>Relatório de Eventos.</title>";
		$html .= "<img src='https://www.google.com.br/google.jpg' width='150' alt='Google Events'/>";
		$html .= "<h4>Relatório de Eventos.</h4>";
		$html .= "<span>Total de eventos: ".$total."</span>";
		$html .= "<table border='1' width='100%' cellpadding='3' cellspacing='3'>";
		$html .= "<thead>";
		$html .= "<tr>";
		$html .= "<th>Id</th>";
		$html .= "<th>Título</th>";
		$html .= "<th>Cor</th>";
		$html .= "<th>Data Início</th>";
		$html .= "<th>Data Fim</th>";
		$html .= "</tr>";
		$html .= "</thead>";
		$html .= "<tbody>";
		foreach ($events as $event) {
			$html .= "<tr>";
			$html .= "<td>".$event["id"]."</td>";
			$html .= "<td>".$event["title"]."</td>";
			$html .= "<td style='background-color:".$event["color"]."'>".$event["color"]."</td>";
			$html .= "<td>".date("d/m/Y H:i:s", strtotime($event["start"]))."</td>";
			$html .= "<td>".date("d/m/Y H:i:s", strtotime($event["end"]))."</td>";
			$html .= "</tr>";
		}
		$html .= "</tbody>";
		$html .= "</table>";

	}else {

		echo "<script>window.alert('Não foram encontrados nenhum registro')</script>";
		echo "<script>window.history.back()</script>";
		exit();

	}

	//referencia namespaces(dirs) das classes Dompdf e Options
	use Dompdf\Dompdf;
	use Dompdf\Options;

	//instancia(objeto) da class Options setando funcionalidades
	$options = new Options();

	$options->setDefaultFont($fonte);
	$options->setChroot(__DIR__);
	$options->setIsRemoteEnabled(TRUE);
	$options->setFontHeightRatio(1);
	$options->setIsHtml5ParserEnabled(TRUE);
	$options->setDefaultPaperSize($folha);

	//instancia(objeto) da class Dompdf agregando objeto $options injeção de dependencia
	$dompdf = new Dompdf($options);
	$dompdf->loadHtml($html);
	$dompdf->setPaper($folha, $estilo);
	$dompdf->render();

	if($forma_acesso == "pdf-navegador") {

		header("Content-Type: application/pdf");
		echo $dompdf->output();
		exit();

	}elseif($forma_acesso == "pdf-download") {

		$dompdf->stream("relatorio_events.pdf", array("attachment" => false));
		exit();

	}
?>