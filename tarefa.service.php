<?php


//CRUD
class TarefaService {

	private $conexao;
	private $tarefa;
	private $id_usuario;

	public function __construct(Conexao $conexao, Tarefa $tarefa, $id_usuario) {
		$this->conexao = $conexao->conectar();
		$this->tarefa = $tarefa;
		$this->id_usuario = $id_usuario;
	}

	public function inserir() { //create
		$query = 'insert into tb_tarefas(tarefa, id_usuario)values(:tarefa, :id_usuario)';
		$stmt = $this->conexao->prepare($query);
		$stmt->bindValue(':tarefa', $this->tarefa->__get('tarefa'));
		$stmt->bindValue(':id_usuario', $this->id_usuario);
		$stmt->execute();
		return 1;
	}

	public function recuperar() { //read
		$query = '
			select 
				t.id, s.status, t.tarefa 
			from 
				tb_tarefas as t
				left join tb_status as s on (t.id_status = s.id)
			where
				id_usuario = (:id_usuario)
		';
		$stmt = $this->conexao->prepare($query);
		$stmt->bindValue(':id_usuario', $this->id_usuario);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_OBJ);
	}

	public function atualizar() { //update

		$query = "update tb_tarefas set tarefa = ? where id = ?";
		$stmt = $this->conexao->prepare($query);
		$stmt->bindValue(1, $this->tarefa->__get('tarefa'));
		$stmt->bindValue(2, $this->tarefa->__get('id'));
		return $stmt->execute(); 
	}

	public function remover() { //delete

		$query = 'delete from tb_tarefas where id = :id';
		$stmt = $this->conexao->prepare($query);
		$stmt->bindValue(':id', $this->tarefa->__get('id'));
		$stmt->execute();
	}

	public function marcarRealizada() { //update

		$query = "update tb_tarefas set id_status = ? where id = ?";
		$stmt = $this->conexao->prepare($query);
		$stmt->bindValue(1, $this->tarefa->__get('id_status'));
		$stmt->bindValue(2, $this->tarefa->__get('id'));
		return $stmt->execute(); 
	}

	public function recuperarTarefasPendentes() {
		$query = '
			select 
				t.id, s.status, t.tarefa 
			from 
				tb_tarefas as t
				left join tb_status as s on (t.id_status = s.id)
			where
				id_usuario = (:id_usuario) and t.id_status = :id_status 
		';
		$stmt = $this->conexao->prepare($query);
		$stmt->bindValue(':id_usuario', $this->id_usuario);
		$stmt->bindValue(':id_status', $this->tarefa->__get('id_status'));
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_OBJ);
	}
}

?>