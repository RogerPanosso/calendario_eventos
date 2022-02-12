<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<meta name="description" content="Gerando Calendario de eventos com biblioteca FullCalendar"/>
	<meta name="author" content="Roger Panosso"/>
	<title>Calendario FullCalendar</title>
	<link rel="stylesheet" type="text/css" href="Bootstrap/css/bootstrap.min.css"/>
	<link rel="stylesheet" type="text/css" href="Bootstrap/css/bootstrap-reboot.min.css"/>
	<link rel="stylesheet" type="text/css" href="FullCalendar/css/core/main.min.css"/>
	<link rel="stylesheet" type="text/css" href="FullCalendar/css/daygrid/main.min.css"/>
	<link rel="stylesheet" type="text/css" href="Assets/css/style.css"/>
</head>
<body>

	<div class="container">
		<div class="row">
			<div class="col-md-12 my-5">
				<div class="page-header">
					<h3>Calendário</h3>
				</div>
				<hr class="bg-secondary">
                                <div id="result_delete">
                                    <!-- html result -->
                                </div>
				<div class="card shadow-sm">
					<div class="card-header text-muted d-flex justify-content-between">
						<span class="align-self-center">Calendário de Eventos</span>
						<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#Relatorio">Obter Relatório</button>
					</div>
					<div class="card-body row">
						<div id="calendar">
							<!-- html result -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script src="jQuery/jquery.min.js"></script>
	<script src="jQuery/jquery.form.min.js"></script>
	<script src="Bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="FullCalendar/js/core/main.min.js"></script>
	<script src="FullCalendar/js/core/locales/pt-br.js"></script>
	<script src="FullCalendar/js/daygrid/main.min.js"></script>
	<script src="FullCalendar/js/interaction/main.min.js"></script>
	<script src="Assets/js/script.js"></script>

	<!-- modal visualizar evento -->
	<div class="modal fade" id="visualizarEvento" tabindex="-1" role="dialog" aria-labelledby="MyModal">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Detalhes do Evento</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
                                        <div class="visualizacaoEvento">
                                            <dl class="row">
                                                    <dt class="col-md-3">Id do Evento:</dt>
                                                    <dd class="col-md-9" id="id"><!-- retorno salvo em #id --></dd>

                                                    <dt class="col-md-3">Título do Evento:</dt>
                                                    <dd class="col-md-9" id="title"><!-- retorno salvo em #title --></dd>

                                                    <dt class="col-md-3">Início do Evento:</dt>
                                                    <dd class="col-md-9" id="start"><!-- retorno salvo em #start --></dd>

                                                    <dt class="col-md-3">Fim do Evento:</dt>
                                                    <dd class="col-md-9" id="end"><!-- retorno salvo em #id --></dd>
                                            </dl>
                                            <!-- edit -->
                                            <button type="button" class="btn btn-warning ocultVisualizacao">Editar Evento</button>
                                            <a href="#" id="deleteEvento" class="btn btn-danger">Excluir Evento</a>
                                        </div>
                                        <div class="editarEvento">
                                            <div id="result_edit" class="my-1">
                                                <!-- html result -->
                                            </div>
                                            <form id="form_edit" name="form_edit" method="POST" enctype="multipart/form-data">
                                                <input type="hidden" name="id" class="form-control" id="id"/>
                                                <div class="mb-3">
                                                    <label for="title" class="form-label">Título do Evento</label>
                                                    <input type="text" name="title" class="form-control" placeholder="Título do Evento" id="title"/>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="color" class="form-label">Cor de Representação</label>
                                                    <input type="text" name="color" class="form-control" id="color"/>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="start" class="form-label">Início do Evento</label>
                                                    <input type="text" name="start" class="form-control" id="start"/>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="end" class="form-label">Fim do Evento</label>
                                                    <input type="text" name="end" class="form-control" id="end"/>
                                                </div>
                                                <div class="mb-3">
                                                    <button type="submit" class="btn btn-success">Editar</button>
                                                    <button type="button" class="btn btn-primary cancelarEdicao">Cancelar</button>
                                                </div>
                                            </form>
                                        </div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
				</div>
			</div>
		</div>
	</div>

	<!-- modal cadastrar evento -->
	<div class="modal fade" id="cadastrarEvento" tabindex="-1" role="dialog" aria-labelledby="MyModal" aria-expanded="false">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Cadastrar Evento</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div id="result_cad" class="my-1">
						<!-- html result -->
					</div>
					<form id="form_cad" name="form_cad" method="POST" enctype="multipart/form-data">
						<div class="mb-3">
							<label for="title" class="form-label">Título do Evento</label>
							<input type="text" name="title" class="form-control" autocomplete="off" autofocus="on" placeholder="Título do Evento" id="title"/>
						</div>
						<div class="mb-3">
							<label for="color" class="form-label">Cor de Represetação</label>
							<input type="color" name="color" class="form-control" autocomplete="off" id="color"/>
						</div>
						<div class="mb-3">
							<label for="start" class="form-label">Início do Evento</label>
							<input type="text" name="start" class="form-control" autocomplete="off" id="start"/>
						</div>
						<div class="mb-3">
							<label for="end" class="form-label">Fim do Evento</label>
							<input type="text" name="end" class="form-control" autocomplete="off" id="end"/>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-success gap-2">Cadastrar</button>
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- modal relatório -->
	<div class="modal fade" id="Relatorio" tabindex="-1" role="dialog" aria-labelledby="MyModal" aria-expanded="false">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Obter Relatório</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="card">
						<div class="card-header">
							<span>Formulário de geração de relatório</span>
						</div>
						<div class="card-body">
							<form target="_blank" method="POST" action="gera_relatorio.php">
								<span class="form-text">Preencha os campos abaixo corretamente diante o formulário para geração do relatório de eventos.</span>
								<div class="mb-3">
									<label for="forma_acesso" class="form-label">Forma de Acesso</label>
									<select name="forma_acesso" class="form-control" id="forma_acesso" required>
										<option value="" selected="selected">SELECIONE</option>
										<option value="pdf-navegador">PDF no navegador</option>
										<option value="pdf-download">PDF em download</option>
									</select>
								</div>
								<div class="mb-3">
									<label for="fonte" class="form-label">Fonte</label>
									<select name="fonte" class="form-control" id="fonte" required>
										<option value="" selected="selected">SELECIONE</option>
										<option value="Arial">Arial</option>
										<option value="Sans-Serif">Sans-Serif</option>
										<option value="Serif">Serif</option>
										<option value="Tahoma">Tahoma</option>
										<option value="Georgia">Georgia</option>
										<option value="Courier">Courier</option>
										<option value="Verdana">Verdana</option>
									</select>
								</div>
								<div class="mb-3">
									<label for="folha" class="folha">Folha</label>
									<select name="folha" class="form-control" id="folha" required>
										<option value="" selected="selected">SELECIONE</option>
										<option value="A4">A4</option>
										<option value="A5">A5</option>
										<option value="A6">A6</option>
										<option value="A7">A7</option>
										<option value="A8">A8</option>
										<option value="A9">A9</option>
										<option value="A10">A10</option>
									</select>
								</div>
								<div class="mb-3">
									<label for="estilo" class="form-label">Estilo</label>
									<select name="estilo" class="form-control" id="estilo" required>
										<option value="" selected="selected">SELECIONE</option>
										<option value="portrat">Portrat</option>
										<option value="landscape">Landscape</option>
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary">Gerar</button>
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
					</div>
				</form>
			</div>
		</div>
	</div>

</body>
</html>