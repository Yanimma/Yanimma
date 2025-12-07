<?php
session_start();

// opcional: exigir login
if (isset($_GET['login']) && $_GET['login'] == 'ok') {
    $_SESSION['login'] = 'ok';
}

// limpa carrinho
if (isset($_SESSION['carrinho'])) {
    unset($_SESSION['carrinho']);
}

// redireciona de volta para o carrinho (com login=ok para manter fluxo)
header("Location: carrinho.php?login=ok");
exit;
