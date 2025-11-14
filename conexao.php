<?php
// YANIMMA E ISABELLA - EI32

// Define o nome do servidor de banco de dados (neste caso, o servidor local)
$servidor = "localhost";

// Define o nome de usuário para acesso ao banco de dados
$usuario = "root";

// Define a senha do usuário do banco (vazia por padrão no XAMPP)
$senha = "";

// Define o nome do banco de dados que será utilizado
$banco = "Loja";

// Cria a conexão com o banco de dados usando a função mysqli_connect()
// A função recebe: servidor, usuário, senha e nome do banco
$con = mysqli_connect($servidor, $usuario, $senha, $banco);

// Verifica se a conexão falhou
if (!$con) {
    // Encerra a execução do script e exibe uma mensagem de erro
    // mysqli_connect_error() retorna a descrição do erro ocorrido na conexão
    die("Erro na conexão: " . mysqli_connect_error());
}
?>

