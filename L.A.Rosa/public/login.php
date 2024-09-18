77% de armazenamento usado … Se você atingir o limite, não será possível criar, editar ou fazer upload de arquivos. Aproveite 100 GB de armazenamento por R$ 7,99 R$ 0 durante um mês.
<?php

	session_start();
	
	if(isset($_POST['login']) && ($_POST['senha']))
	{
		include_once('conexao.php');
		
		$login = $_POST['login'];
		$senha = $_POST['senha'];
		
		$rs = $con->query("SELECT * FROM tb_usuario WHERE nm_email = '".$login."'");
		
		if($rs->rowCount() == 0)
		{
			echo "Email: ".$login."não encontrado!";
		}
		else
		{
			while($row = $rs->fetch(PDO::FETCH_OBJ))
			{
				$codigo = $row->cd_usuario;
				$email = $row->nm_email;
				$password = $row->cd_senha;
			}
			if($senha == $password)
			{
				header('location:menu.php');
			}
			else
			{
				echo "Senha incorreta!!!";
			}
		}
	}

?>