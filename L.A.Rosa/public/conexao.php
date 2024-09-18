77% de armazenamento usado … Se você atingir o limite, não será possível criar, editar ou fazer upload de arquivos. Aproveite 100 GB de armazenamento por R$ 7,99 R$ 0 durante um mês.
<?php
try
{
	$con = new PDO("mysql:host=localhost:3306;dbname=db_larosa",
					"root",
					"");
					
	$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
	echo 'ERROR: ' . $e->getMessage();
}
?>