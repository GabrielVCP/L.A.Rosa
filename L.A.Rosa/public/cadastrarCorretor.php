<?php
	
	/* se a variavel NÃO estiver vazia faça */
	if (!empty($_POST)){
		
		include_once('conexao.php');

		$email =  $_POST['email'];
		$senha =   $_POST['senha'];
				
		/* verifica se há erro no comando e executa */
		try
		{
			/* cadastrar o email, a senha e o CÓDIGO do bairro */
			$stmt = $con->prepare("INSERT INTO tb_corretor(nm_email, 
														  cd_senha) 
								   VALUES(?, ?)");
			$stmt->bindParam(1,$email);
			$stmt->bindParam(2,$senha);
			$stmt->execute();
		}
		/* se existir erro retorna menssagem */
		catch(Exception $e)
		{
			echo "deu ruim mano".$e->getMessage();
		}
	}
	else{
		echo "Por favor, preencha todos os campos!";
	}

?>