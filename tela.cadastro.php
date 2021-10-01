<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>App Lista Tarefas</title>

		<link rel="stylesheet" href="css/estilo.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
		<style>
			.form-group {
				margin-bottom: 0rem;
			}
		</style>
	</head>

	<body>
		<nav class="navbar navbar-light bg-light">
			<div class="container">
				<a class="navbar-brand" href="#">
					<img src="img/logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
					App Lista Tarefas
				</a>
			</div>
		</nav>
		<div class="container" style="margin-top: 100px;">
			<div class="row justify-content-center">
				<div class="col-md-4">
					<div class="card">
						<div class="card-header">
							<span style="font-size: 20px;">Cadastrar</span>
						</div>
						<div class="card-body">
							<form action="cadastrar.php" class="form-group" method="POST">
								<input type="email" name="email" id="" class="form-control mt-2" placeholder="E-mail">
								<input type="password" name="senha" id="" class="form-control mt-2"  placeholder="Senha" required>
								<input type="submit" value="Cadastrar" class="btn btn-block btn-outline-info mt-2">
							</form>
							<?php
								if( isset($_GET['cadastro']) && $_GET['cadastro'] == 'sucesso' ) { ?>
									<div class="text-success pt-3 mb-0">
										<p>Cadastro realizado com sucesso!</p>
										<a href="tela.login.php">Faça o login aqui</a>
									</div>
							<?php } else if( isset($_GET['cadastro']) && $_GET['cadastro'] == 'falha' ) { ?>
									<div class="text-danger pt-3 mb-0">
										<p>Email já cadastrado</p>
									</div>
							<?php } ?>
						</div>
						<div class="card-footer text-center">
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>