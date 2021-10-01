<?php 

    require "conexao.php";  

    $cadastro = new Cadastro($_POST['email'], $_POST['senha']);

    class Cadastro {
        private $email;
        private $senha;
        private $conexao;
        public $confirma_cadastro = 1;

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

        public function cadastrar() {
            $conexao2 = new Conexao();
            $this->conexao = $conexao2->conectar();
            $query = 'insert into tb_usuarios(email, senha)values(:email, :senha)';
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(':email', $this->email);
            $stmt->bindValue(':senha', $this->senha);
            $stmt->execute();
        }
    }

    $dados = $cadastro->vereficaDados();
    //verificar se já o email informado já existe
    foreach($dados as $key => $dado) {
        if($_POST['email'] == $dado->email) {
            $cadastro->confirma_cadastro = 0;
        } 
    }

    //fazer o cadastro se os dados estiverem ok
    if ($cadastro->confirma_cadastro == 1) {
        $cadastro->cadastrar();
        header('location: tela.cadastro.php?cadastro=sucesso');
    } else if ($cadastro->confirma_cadastro == 0) {
        header('location: tela.cadastro.php?cadastro=falha');
    }

    

?>