<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta charset="UTF-8">
</head>
<body>


<div class="container">
  <!--<form action="/action_page.php">-->
    <div class="row">
      <h2 style="text-align:center">SISTEMA L.A.Rosa - AUTENTICAÇÃO</h2>
      <div class="vl">
        <span class="vl-innertext">ou</span>
      </div>
      <!--
      <div class="col">
        <a href="#" class="fb btn">
          <i class="fa fa-facebook fa-fw"></i> Login com Facebook
         </a>
        <a href="#" class="twitter btn">
          <i class="fa fa-twitter fa-fw"></i> Login com Twitter
        </a>
        <a href="#" class="google btn"><i class="fa fa-google fa-fw">
          </i> Login com Google+
        </a>
      </div>
-->
      <div class="col">
        <div class="hide-md-lg">
          <p>Insira seu login</p>
        </div>
		<form action="login.php" method="POST">
        <input type="text" name="login" placeholder="Nome de usuário" required>
        <input type="password" name="senha" placeholder="Senha" required>
        <input type="submit" value="Login">
		</form>
      </div>
      
    </div>
  <!--</form>-->
</div>

<div class="bottom-container">
  <div class="row">
    <div class="col">
      <a href="#" style="color:white" class="btn">Cadastrar-se</a>
    </div>
    <div class="col">
      <a href="#" style="color:white" class="btn">Esqueceu a senha?</a>
    </div>
  </div>
</div>

</body>
</html>