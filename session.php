<?php 
    session_start();
    if(isset($_GET['sessao']) && $_GET['sessao'] == 'sim') {
        $_SESSION['autenticado'] = 'SIM';
        header('location: tarefas.pendentes.php');
    }
?>