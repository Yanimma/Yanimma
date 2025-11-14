<?php
// ==========================================================
// YANIMMA E ISABELLA - EI32
// Script de login de usuário com verificação no banco de dados
// ==========================================================

// Inclui o arquivo de conexão com o banco de dados.
// O arquivo "conexao.php" deve conter as informações de conexão ($con).
include("conexao.php");

// Verifica se o formulário foi enviado via método POST.
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Extrai as variáveis enviadas pelo formulário ($_POST)
    // Exemplo: $_POST['usuario'] vira $usuario.
    extract($_POST);

    // Verifica se o botão "entrar" foi clicado.
    if (isset($entrar)) {

        // Cria um hash MD5 combinando a senha digitada e o nome de usuário.
        // Essa técnica adiciona uma leve camada de segurança ao hash.
        $senha_md5 = md5($senha . $usuario);

        // Monta a consulta SQL que busca o usuário com o nome e senha correspondentes.
        $sql = "SELECT * FROM usuarios WHERE usuario='$usuario' AND senha='$senha_md5'";

        // Executa a consulta no banco de dados.
        $res = mysqli_query($con, $sql);

        // Verifica se foi encontrado pelo menos um registro correspondente.
        if (mysqli_num_rows($res) > 0) {
            // Se encontrou, redireciona o usuário para "index.php" com o parâmetro ?login=ok.
            header("Location: index.php?login=ok");
            exit; // Encerra o script após o redirecionamento.
        } else {
            // Caso nenhum usuário corresponda, define uma mensagem de erro.
            $erro = "Usuário ou senha incorretos.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Login - Loja Abelhinhas</title>
<link rel="stylesheet" href="css/style.css">
<style>
    /* ====== ESTILO GERAL DA PÁGINA DE LOGIN ====== */
body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(180deg, #fff8dc 0%, #fff1a8 100%);
    margin: 0;
    padding: 0;
    color: #333;
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

/* ====== CONTEÚDO ====== */
.container {
    max-width: 400px;
    margin: 6vh auto;
    background: #fff;
    padding: 2.5rem;
    border-radius: 20px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.1);
    text-align: center;
}
.section-title {
    font-size: 2rem;
    margin-bottom: 1.5rem;
    color: #444;
}

/* ====== CAMPOS DE ENTRADA ====== */
input[type="text"],
input[type="password"] {
    width: 90%;
    padding: 0.9rem;
    margin: 0.6rem 0;
    border: 2px solid #ffcc00;
    border-radius: 50px;
    outline: none;
    font-size: 1rem;
    transition: 0.3s;
}
input[type="text"]:focus,
input[type="password"]:focus {
    border-color: #ffaa00;
    box-shadow: 0 0 10px rgba(255,187,0,0.5);
}

/* ====== BOTÃO ====== */
.btn {
    width: 100%;
    background: linear-gradient(135deg, #ffcc00, #ffaa00);
    border: none;
    color: #fff;
    padding: 0.9rem;
    border-radius: 50px;
    font-size: 1rem;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
    margin-top: 0.8rem;
}
.btn:hover {
    transform: scale(1.05);
    background: linear-gradient(135deg, #ffdd33, #ff9900);
    box-shadow: 0 0 10px rgba(255,170,0,0.4);
}

/* ====== LINKS ====== */
a {
    color: #8b5e00;
    text-decoration: none;
    font-weight: bold;
    transition: 0.3s;
}
a:hover {
    color: #cc8400;
}

/* ====== MENSAGEM DE ERRO ====== */
p[style*="color:red"] {
    background: rgba(255, 204, 0, 0.15);
    padding: 0.6rem;
    border-radius: 10px;
    margin: 1rem auto;
    width: 80%;
    font-weight: bold;
}

/* ====== RESPONSIVIDADE ====== */
@media (max-width: 480px) {
    .container {
        width: 85%;
        padding: 2rem 1.2rem;
    }
    input[type="text"],
    input[type="password"] {
        width: 100%;
    }
}

</style>
</head>
<body>
<header class="navbar"><div class="logo">🐝 Loja Abelhinhas</div></header>
<section class="container" style="text-align:center;">
<h2 class="section-title">Login</h2>
<form method="post" action="">
    <input type="text" name="usuario" placeholder="Usuário"><br><br>
    <input type="password" name="senha" placeholder="Senha"><br><br>
    <input type="submit" name="entrar" value="Entrar" class="btn">
</form>
<!-- Exibe mensagem de erro em vermelho se existir -->
<p style="color:red;"><?php if(isset($erro)) echo $erro; ?></p>
<p><a href="cadastro.php">Não tem conta? Cadastre-se</a></p>
</section>
</body>
</html>
