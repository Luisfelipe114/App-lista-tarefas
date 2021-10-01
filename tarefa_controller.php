<?php

	session_start();

	require "tarefa.model.php";
	require "tarefa.service.php";
	require "conexao.php";

	$acao = isset($_GET['acao']) ? $_GET['acao'] : $acao;

	//RECUPERANDO ID DO USUÁRIO
	$conexao2 = new Conexao();
	$conexao_id = $conexao2->conectar();
	$query = '
		select 
			id_usuario
		from 
			tb_usuarios
		where 
			email = (:email)
	';
	$stmt = $conexao_id->prepare($query);
	$stmt->bindValue(':email', $_SESSION['email']);
	$stmt->execute();
	$teste = $stmt->fetchAll();


	if($acao == 'inserir' ) {
		$tarefa = new Tarefa();
		$tarefa->__set('tarefa', $_POST['tarefa']);

		$conexao = new Conexao();

		$tarefaService = new TarefaService($conexao, $tarefa, $teste[0]['id_usuario']);
		if($tarefaService->inserir() == 1) {
			header('Location: nova_tarefa.php?inclusao=1');
		}
	
	} else if($acao == 'recuperar') {
		
		$tarefa = new Tarefa();
		$conexao = new Conexao();

		$tarefaService = new TarefaService($conexao, $tarefa, $teste[0]['id_usuario']);
		$tarefas = $tarefaService->recuperar();
	
	} else if($acao == 'atualizar') {

		$tarefa = new Tarefa();
		$tarefa->__set('id', $_POST['id'])
			->__set('tarefa', $_POST['tarefa']);

		$conexao = new Conexao();

		$tarefaService = new TarefaService($conexao, $tarefa, $teste[0]['id_usuario']);
		if($tarefaService->atualizar()) {
			
			if( isset($_GET['pag']) && $_GET['pag'] == 'pendentes') {
				header('location: tarefas.pendentes.php');	
			} else {
				header('location: todas_tarefas.php');
			}
		}


	} else if($acao == 'remover') {

		$tarefa = new Tarefa();
		$tarefa->__set('id', $_GET['id']);

		$conexao = new Conexao();

		$tarefaService = new TarefaService($conexao, $tarefa, $teste[0]['id_usuario']);
		$tarefaService->remover();

		if( isset($_GET['pag']) && $_GET['pag'] == 'pendentes') {
			header('location: tarefas,pendentes.php');	
		} else {
			header('location: todas_tarefas.php');
		}
	
	} else if($acao == 'marcarRealizada') {

		$tarefa = new Tarefa();
		$tarefa->__set('id', $_GET['id'])->__set('id_status', 2);

		$conexao = new Conexao();

		$tarefaService = new TarefaService($conexao, $tarefa, $teste[0]['id_usuario']);
		$tarefaService->marcarRealizada();

		if( isset($_GET['pag']) && $_GET['pag'] == 'pendentes') {
			header('location: tarefas,pendentes.php');	
		} else {
			header('location: todas_tarefas.php');
		}
	
	} else if($acao == 'recuperarTarefasPendentes') {
		$tarefa = new Tarefa();
		$tarefa->__set('id_status', 1);
		
		$conexao = new Conexao();

		$tarefaService = new TarefaService($conexao, $tarefa, $teste[0]['id_usuario']);
		$tarefas = $tarefaService->recuperarTarefasPendentes();
	}


?>