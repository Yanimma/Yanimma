<?php
// YANIMMA E ISABELLA - EI32
// Inclui o arquivo de conexão com o banco de dados
include("conexao.php");

// Verifica se o formulário foi enviado com o método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extrai as variáveis enviadas pelo formulário ($_POST)
    extract($_POST);

    // Verifica se o botão "cadastrar" foi acionado
    if (isset($cadastrar)) {
        // Verifica se os campos obrigatórios foram preenchidos
        if ($usuario != "" && $senha != "" && $email != "") {
            // Cria um hash MD5 da senha combinada com o nome de usuário
            $senha_md5 = md5($senha . $usuario);

            // Monta o comando SQL para inserir o usuário no banco de dados
            $sql = "INSERT INTO usuarios (usuario, senha, email) VALUES ('$usuario', '$senha_md5', '$email')";

            // Executa a consulta no banco de dados
            if (mysqli_query($con, $sql)) {
                // Redireciona para a página de login e indica sucesso no cadastro
                header("Location: login.php?cadastro=ok");
                exit;
            } else {
                // Define mensagem de erro caso a execução da consulta falhe
                $erro = "Erro ao cadastrar!";
            }
        } else {
            // Define mensagem de erro caso algum campo esteja vazio
            $erro = "Preencha todos os campos.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Cadastro - Loja Abelhinhas</title>
<!-- Importa o arquivo CSS externo -->
<link rel="stylesheet" href="css/style.css">
<style>
    /* ======   CSS para o cadastro ====== */
body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(180deg, #fff9d8 0%, #ffe67c 100%);
    margin: 0;
    padding: 0;
    color: #444;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

/* ====== CABEÇALHO ====== */
.navbar {
    background-color: #ffcc00;
    text-align: center;
    padding: 1rem 0;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
.logo {
    font-size: 1.8rem;
    font-weight: bold;
}

/* ====== CONTAINER ====== */
.container {
    max-width: 400px;
    margin: 8vh auto;
    background: #fff;
    padding: 2rem;
    border-radius: 20px;
    box-shadow: 0 8px 18px rgba(0,0,0,0.1);
    text-align: center;
    animation: fadeIn 0.7s ease-out;
}

/* ====== ANIMAÇÃO ====== */
@keyframes fadeIn {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}

/* ====== TÍTULO ====== */
.section-title {
    font-size: 1.9rem;
    color: #333;
    margin-bottom: 1.2rem;
}

/* ====== CAMPOS DO FORM ====== */
form input[type="text"],
form input[type="password"],
form input[type="email"] {
    width: 85%;
    padding: 10px;
    margin: 8px 0;
    border: 2px solid #ffcc00;
    border-radius: 10px;
    outline: none;
    transition: all 0.3s ease;
    font-size: 1rem;
}
form input:focus {
    border-color: #ffaa00;
    box-shadow: 0 0 8px rgba(255,170,0,0.4);
}

/* ====== BOTÃO ====== */
.btn {
    background: linear-gradient(135deg, #ffcc00, #ffaa00);
    border: none;
    color: white;
    padding: 10px 25px;
    border-radius: 50px;
    font-size: 1rem;
    cursor: pointer;
    transition: 0.3s;
    margin-top: 10px;
    box-shadow: 0 4px 10px rgba(255,200,0,0.4);
}
.btn:hover {
    transform: scale(1.05);
    background: linear-gradient(135deg, #ffdd33, #ff9900);
    box-shadow: 0 0 12px rgba(255,170,0,0.5);
}

/* ====== LINK PARA LOGIN ====== */
a {
    text-decoration: none;
    color: #cc8a00;
    font-weight: 500;
    transition: color 0.3s;
}
a:hover {
    color: #ff9900;
}

/* ====== MENSAGEM DE ERRO ====== */
p[style*="color:red"] {
    margin-top: 10px;
    font-weight: bold;
}

/* ====== RESPONSIVIDADE ====== */
@media (max-width: 480px) {
    .container {
        width: 85%;
        padding: 1.5rem;
    }
    .section-title {
        font-size: 1.6rem;
    }
}

</style>
</head>
<body>
<!-- Cabeçalho com logotipo -->
<header class="navbar"><div class="logo">🐝 Loja Abelhinhas</div></header>

<!-- Seção principal com o formulário de cadastro -->
<section class="container" style="text-align:center;">
<h2 class="section-title">Cadastro</h2>

<!-- Formulário de cadastro que envia dados via POST -->
<form method="post" action="">
    <input type="text" name="usuario" placeholder="Usuário"><br><br>
    <input type="password" name="senha" placeholder="Senha"><br><br>
    <input type="email" name="email" placeholder="Email"><br><br>
    <input type="submit" name="cadastrar" value="Cadastrar" class="btn">
</form>

<!-- Exibe mensagem de erro, se existir -->
<p style="color:red;"><?php if(isset($erro)) echo $erro; ?></p>

<!-- Link para a página de login -->
<p><a href="login.php">Já tem conta? Faça login</a></p>
</section>
</body>
</html>
