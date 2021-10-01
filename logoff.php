<?php
    session_start();

    print_r($_SESSION);
    //remover índices do array de sessão
    //unset()
    //unset($_SESSION['autenticado']);

    //destruir a variável de sessão
    //session_destroy()
    session_destroy(); 
    header('Location: tela.login.php')
?>