<?php
// carrinho.php - grava/mostra carrinho usando SESSION e adiciona itens via GET
// parâmetros esperados para adicionar itens: ?produto=...&preco=...
// mantém o fluxo de login por ?login=ok

session_start(); // inicia a sessão para poder usar $_SESSION

// variável que armazena se o usuário está logado
$sessao = "";

// verifica se o login veio pela URL (?login=ok)
if (isset($_GET['login']) && $_GET['login'] == 'ok') {
    $sessao = "ok";

    // também grava na sessão que está logado
    // isso evita perder login ao navegar
    $_SESSION['login'] = 'ok';

// se não veio por GET, mas já está logado na SESSION, mantém acesso
} elseif (isset($_SESSION['login']) && $_SESSION['login'] == 'ok') {
    $sessao = "ok";
}

// se não está logado, redireciona para login.php
if ($sessao != "ok") {
    header("Location: login.php");
    exit;
}

// ADICIONAR ITEM AO CARRINHO (via GET)
if (isset($_GET['produto']) && isset($_GET['preco'])) {

    // pega nome e preço do GET
    $nome = trim($_GET['produto']);
    $preco = floatval($_GET['preco']);

    // se o carrinho ainda não existe, cria um array vazio
    if (!isset($_SESSION['carrinho']) || !is_array($_SESSION['carrinho'])) {
        $_SESSION['carrinho'] = [];
    }

    // procura se o produto já existe no carrinho
    $found = false;
    foreach ($_SESSION['carrinho'] as &$it) {
        if ($it['nome'] === $nome) {

            // se já existe, apenas soma mais 1 na quantidade
            $it['qtd'] += 1;
            $found = true;
            break;
        }
    }
    unset($it); // boa prática ao usar foreach por referência

    // se o item não existia, adiciona um novo
    if (!$found) {
        $_SESSION['carrinho'][] = [
            'nome' => $nome,
            'preco' => $preco,
            'qtd' => 1
        ];
    }

    // evita adicionar item novamente ao atualizar a página
    header("Location: carrinho.php?login=ok");
    exit;
}

// REMOVER ITEM DO CARRINHO (opcional)
if (isset($_GET['remover'])) {

    // índice do item no array do carrinho
    $idx = intval($_GET['remover']);

    // se existe, remove apenas aquele item
    if (isset($_SESSION['carrinho'][$idx])) {
        array_splice($_SESSION['carrinho'], $idx, 1);
    }

    // redireciona para evitar remoção repetida ao atualizar página
    header("Location: carrinho.php?login=ok");
    exit;
}

// obtém o carrinho atual ou cria um vazio caso não exista
$carrinho = isset($_SESSION['carrinho']) ? $_SESSION['carrinho'] : [];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Carrinho - Loja Abelhinhas</title>
<link rel="stylesheet" href="css/style.css">

<style>
/* Estilo visual da página do carrinho */
body { font-family: 'Poppins', sans-serif; background:#fffaf0; color:#333; padding:2rem; }
.container { max-width:720px; margin:0 auto; background:#fff; padding:1.5rem; border-radius:12px; box-shadow:0 6px 18px rgba(0,0,0,0.08); }
.item { display:flex; justify-content:space-between; padding:0.6rem 0; border-bottom:1px solid #f1f1f1; }
.item strong { display:block; }
.actions { display:flex; gap:0.6rem; align-items:center; }
.btn { background:linear-gradient(135deg,#ffcc00,#ffaa00); padding:0.5rem 1rem; border-radius:8px; border:none; cursor:pointer; color:#222; font-weight:700; text-decoration:none; }
.btn-danger { background:#ff6b6b; color:#fff; border-radius:8px; padding:0.4rem 0.8rem; text-decoration:none; }
.total { font-size:1.2rem; font-weight:700; margin-top:1rem; text-align:right; }
.link-small { font-size:0.9rem; color:#333; text-decoration:none; margin-left:0.6rem; }
</style>
</head>

<body>

<div class="container">
    <h2>Seu Carrinho</h2>

    <!-- Se o carrinho estiver vazio -->
    <?php if (count($carrinho) === 0): ?>
        <p>O carrinho está vazio.</p>

        <!-- botão para voltar à loja -->
        <p><a class="btn" href="index.php?login=ok">Voltar à loja</a></p>

    <?php else: ?>

        <!-- inicia soma total -->
        <?php $total = 0; ?>

        <!-- percorre cada item do carrinho -->
        <?php foreach ($carrinho as $i => $item): ?>

            <!-- calcula subtotal -->
            <?php $sub = $item['preco'] * $item['qtd']; $total += $sub; ?>

            <div class="item">
                <div>
                    <!-- nome do produto com proteção a XSS -->
                    <strong><?php echo htmlspecialchars($item['nome'], ENT_QUOTES); ?></strong>

                    <!-- informações do produto -->
                    <div>Preço unitário: R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?></div>
                    <div>Quantidade: <?php echo intval($item['qtd']); ?></div>
                </div>

                <div class="actions">
                    <div>Subtotal: R$ <?php echo number_format($sub, 2, ',', '.'); ?></div>

                    <!-- botão remover item do carrinho -->
                    <a class="btn-danger" href="carrinho.php?remover=<?php echo $i; ?>&login=ok"
                       onclick="return confirm('Remover este item?')">Remover</a>
                </div>
            </div>
        <?php endforeach; ?>

        <!-- total geral -->
        <div class="total">Total: R$ <?php echo number_format($total, 2, ',', '.'); ?></div>

        <div style="margin-top:1rem; display:flex; gap:1rem; justify-content:flex-end;">

            <!-- limpar tudo -->
            <a class="btn" href="limpar_carrinho.php?login=ok" onclick="return confirm('Deseja limpar o carrinho?')">Limpar carrinho</a>

            <?php
                // monta string com produtos e quantidades
                // exemplo: "Vestido x2; Short x1"
                $produtos_lista = [];
                foreach ($carrinho as $it) {
                    $produtos_lista[] = $it['nome'] . ' x' . intval($it['qtd']);
                }

                // transforma array em string
                $produtos_str = rawurlencode(implode('; ', $produtos_lista));

                // total formatado para enviar via GET
                $total_val = number_format($total, 2, '.', '');
            ?>

            <!-- botão FINALIZAR COMPRA enviando produto e valor via GET -->
            <a class="btn"
               href="pagamento.php?produto=<?php echo $produtos_str; ?>&valor=<?php echo $total_val; ?>&login=ok">
               Finalizar compra
            </a>
        </div>

        <!-- voltar para loja -->
        <p style="margin-top:1rem;">
            <a class="link-small" href="index.php?login=ok">Continuar comprando</a>
        </p>

    <?php endif; ?>
</div>

</body>
</html>
