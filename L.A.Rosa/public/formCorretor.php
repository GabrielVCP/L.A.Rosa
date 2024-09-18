<!DOCTYPE html>
    <head>
        <meta charset="UTF-8" />
        <title>CADASTRO DE CORRETOR</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <link rel="stylesheet" href="CSS/stylesCadastro.css">
    </head>
    <body>
        <!--FORMULÁRIO DE CADASTRO-->
        <form action='cadastrarCorretor.php' method='POST' name='formCad' id='formCad'>
            <h1>Cadastro de Corretor</h1> 

            <label for='email'>Email</label>
            <input type='email' name='email' placeholder='Email' minlength='6' maxlength='35' required>
            
            <label for='senha'>Senha</label>
            <input type='password' name='senha' placeholder='Senha' minlength='8' required>
            
            <p> 
                <input type="submit" value="Cadastrar"/> 
            </p>
            
        </form>
    </body>
</html>