<?php 
    session_start();

    require "conexao.php";  

    $login = new Login($_POST['email'], $_POST['senha']);

    class Login {
        private $email;
        private $senha;
        private $conexao;
        public $confirma_login;

        public function __construct($email, $senha) {
            $this->email = $email;
            $this->senha = $senha;
        }

        public function vereficaDados() {
            $conexao2 = new Conexao();
            $this->conexao = $conexao2->conectar();
            $query = '
                select 
                    email, senha
                from 
                    tb_usuarios
            ';
            $stmt = $this->conexao->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function recuperarId() {
            $conexao2 = new Conexao();
            $this->conexao = $conexao2->conectar();
            $query = '
                select 
                    id_usuario
                from 
                    tb_usuarios
                where 
                    email = (:email)
            ';
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(':email', $this->email);
            $stmt->execute();
            $teste = $stmt->fetchAll();
            return $teste[0]['id_usuario'];
        }
    }

    $dados = $login->vereficaDados();
    //verificar se já o email informado existe e se a senha está correta
    foreach($dados as $key => $dado) {
        if($_POST['email'] == $dado->email && $_POST['senha'] == $dado->senha) {
            $login->confirma_login = 1;
        } 
    }

    //fazer o login se os dados estiverem ok
    if(isset($_POST['email']) && isset($_POST['senha'])) {
        if ($login->confirma_login == 1) {
            $_SESSION['email'] = $_POST['email'];
            header('location: session.php?sessao=sim');
        } else if ($login->confirma_login == 0) {
            header('location: tela.login.php?login=falha');
        }
    }

?>