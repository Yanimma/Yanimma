<?php
// YANIMMA E ISABELLA - EI32

$sessao = "";

if (isset($_GET['login']) && $_GET['login'] == 'ok') {
    $sessao = "ok";
}

if ($sessao != "ok") {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Loja Abelhinhas</title>
<link rel="stylesheet" href="css/style.css">
<style>
/* Barra de pesquisa */
/* ====== ESTILO GERAL ====== */
body {
    font-family: 'Poppins', sans-serif;
    margin: 0;
    padding: 0;
    background: #fffaf0;
    color: #333;
}

/* ====== CABEÇALHO ====== */
.navbar {
    background-color: #ffcc00;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 2rem;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
.logo {
    font-size: 1.5rem;
    font-weight: bold;
}
.nav-links {
    list-style: none;
    display: flex;
    gap: 1rem;
}
.nav-links a {
    text-decoration: none;
    color: #333;
    font-weight: 600;
    transition: 0.3s;
}
.nav-links a:hover {
    color: #8b5e00;
}

/* ====== CONTEÚDO ====== */
.container {
    padding: 2rem;
    text-align: center;
}
.section-title {
    font-size: 2rem;
    margin-bottom: 1.2rem;
    color: #444;
}
p {
    font-size: 1.1rem;
    color: #666;
}

/* ====== BARRA DE PESQUISA ====== */
.search-bar {
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 2rem auto 3rem;
    gap: 0.6rem;
}
.search-bar input {
    padding: 0.8rem 1rem;
    width: 350px;
    border: 2px solid #ffcc00;
    border-radius: 50px;
    outline: none;
    transition: 0.3s;
    font-size: 1rem;
}
.search-bar input:focus {
    border-color: #ffaa00;
    box-shadow: 0 0 10px rgba(255, 187, 0, 0.5);
}
.search-bar .btn {
    padding: 0.8rem 1.5rem;
    border: none;
    background: linear-gradient(135deg, #ffcc00, #ffaa00);
    color: #fff;
    font-weight: bold;
    border-radius: 50px;
    cursor: pointer;
    transition: 0.3s;
}
.search-bar .btn:hover {
    transform: scale(1.05);
    box-shadow: 0 0 10px rgba(255,170,0,0.4);
}

/* ====== PRODUTOS ====== */
.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
    gap: 2rem;
    justify-items: center;
}
.product-card {
    background-color: #fff;
    border-radius: 15px;
    padding: 1.5rem;
    width: 220px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    transition: 0.3s;
}
.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 15px rgba(0,0,0,0.15);
}
.product-image {
    width: 100%;
    border-radius: 10px;
    margin-bottom: 0.8rem;
}
.product-price {
    color: #8b5e00;
    font-weight: bold;
    margin-bottom: 0.8rem;
}
.btn {
    background: linear-gradient(135deg, #ffcc00, #ffaa00);
    color: white;
    border: none;
    padding: 0.45rem 0.9rem;   /* tamanho menor */
    font-size: 0.85rem;        /* texto menor e proporcional */
    border-radius: 25px;       /* arredondamento menor combina mais com o novo tamanho */
    cursor: pointer;
    transition: 0.3s;
    margin: 0.2rem;
    width: 150px;              /* todos ficam do MESMO tamanho */
    text-align: center;
}

.btn:hover {
    background: linear-gradient(135deg, #ffaa00, #ff9900);
    transform: scale(1.05);
}

/* ====== RODAPÉ ====== */
footer {
    background-color: #ffcc00;
    color: #333;
    text-align: center;
    padding: 1rem 0;
    font-weight: bold;
    box-shadow: 0 -4px 8px rgba(0,0,0,0.05);
}

.product-actions { display:flex; justify-content:center; gap:8px; align-items:center; flex-wrap:wrap; }

</style>
</head>
<body>
<header>
    <nav class="navbar">
        <div class="logo">🐝 Loja Abelhinhas</div>
        <input type="checkbox" id="menu-toggle">
        <label for="menu-toggle" class="menu-icon">☰</label>
        <ul class="nav-links">
            <li><a href="logout.php">Sair</a></li>
            <!-- link para ver carrinho mantendo login -->
            <li><a href="carrinho.php?login=ok">Carrinho</a></li>
        </ul>
    </nav>
</header>

<section class="container" style="text-align:center;">
    <h1 class="section-title">Bem-vindo à Loja Abelhinhas!</h1>
    <p>Aqui você encontra as melhores roupas infantis com amor e conforto.</p>
</section>

<section class="container">
    <h2 class="section-title">Nossos Produtos</h2>

    <!-- 🔍 Barra de Pesquisa -->
    <div class="search-bar">
        <input type="text" id="searchInput" placeholder="Pesquisar produtos...">
        <button class="btn" onclick="filtrarProdutos()">Buscar</button>
    </div>

    <div class="products-grid" id="listaProdutos">

        <div class="product-card">
            <img src="img/roupa1.jpg" class="product-image" alt="">
            <h3>Vestido Abelhinha</h3>
            <p class="product-price">R$ 89,90</p>
            <div class="product-actions">
                <!-- botão Comprar original -->
                <a href="pagamento.php"><button class="btn">Comprar</button></a>
                <!-- botão Adicionar ao carrinho (envia nome e preço por GET e mantém login) -->
                <a href="carrinho.php?produto=Vestido%20Abelhinha&preco=89.90&login=ok"><button class="btn">Adicionar ao Carrinho</button></a>
            </div>
        </div>

        <div class="product-card">
            <img src="img/roupa2.jpg" class="product-image" alt="">
            <h3>Conjunto Floral</h3>
            <p class="product-price">R$ 119,90</p>
            <div class="product-actions">
                <a href="pagamento.php"><button class="btn">Comprar</button></a>
                <a href="carrinho.php?produto=Conjunto%20Floral&preco=119.90&login=ok"><button class="btn">Adicionar ao Carrinho</button></a>
            </div>
        </div>

        <div class="product-card">
            <img src="img/roupa3.jpg" class="product-image" alt="">
            <h3>Camiseta Colmeia</h3>
            <p class="product-price">R$ 49,90</p>
            <div class="product-actions">
                <a href="pagamento.php"><button class="btn">Comprar</button></a>
                <a href="carrinho.php?produto=Camiseta%20Colmeia&preco=49.90&login=ok"><button class="btn">Adicionar ao Carrinho</button></a>
            </div>
        </div>

        <div class="product-card">
            <img src="img/roupa4.jpg" class="product-image" alt="">
            <h3>Conjunto Infantil</h3>
            <p class="product-price">R$ 89,90</p>
            <div class="product-actions">
                <a href="pagamento.php"><button class="btn">Comprar</button></a>
                <a href="carrinho.php?produto=Conjunto%20Infantil&preco=89.90&login=ok"><button class="btn">Adicionar ao Carrinho</button></a>
            </div>
        </div>

        <div class="product-card">
            <img src="img/roupa5.jpg" class="product-image" alt="">
            <h3>Vestido Infantil</h3>
            <p class="product-price">R$ 79,90</p>
            <div class="product-actions">
                <a href="pagamento.php"><button class="btn">Comprar</button></a>
                <a href="carrinho.php?produto=Vestido%20Infantil&preco=79.90&login=ok"><button class="btn">Adicionar ao Carrinho</button></a>
            </div>
        </div>

        <div class="product-card">
            <img src="img/roupa6.jpg" class="product-image" alt="">
            <h3>Chapéu Infantil</h3>
            <p class="product-price">R$ 39,90</p>
            <div class="product-actions">
                <a href="pagamento.php"><button class="btn">Comprar</button></a>
                <a href="carrinho.php?produto=Chapeu%20Infantil&preco=39.90&login=ok"><button class="btn">Adicionar ao Carrinho</button></a>
            </div>
        </div>

        <div class="product-card">
            <img src="img/roupa7.jpg" class="product-image" alt="">
            <h3>Jardineira Infantil</h3>
            <p class="product-price">R$ 59,90</p>
            <div class="product-actions">
                <a href="pagamento.php"><button class="btn">Comprar</button></a>
                <a href="carrinho.php?produto=Jardineira%20Infantil&preco=59.90&login=ok"><button class="btn">Adicionar ao Carrinho</button></a>
            </div>
        </div>

        <div class="product-card">
            <img src="img/roupa8.jpg" class="product-image" alt="">
            <h3>Pijama Infantil</h3>
            <p class="product-price">R$ 149,90</p>
            <div class="product-actions">
                <a href="pagamento.php"><button class="btn">Comprar</button></a>
                <a href="carrinho.php?produto=Pijama%20Infantil&preco=149.90&login=ok"><button class="btn">Adicionar ao Carrinho</button></a>
            </div>
        </div>

    </div>
</section>

<footer>
    <p>&copy; 2025 Loja Abelhinhas - Todos os direitos reservados a Loja Abelhinhas 🐝</p>
</footer>
<script>
function filtrarProdutos() {
    var input = document.getElementById("searchInput").value.toLowerCase();
    var produtos = document.querySelectorAll(".product-card");
    var encontrou = false;

    produtos.forEach(function(produto) {
        var nome = produto.querySelector("h3").textContent.toLowerCase();

        if (nome.includes(input)) {
            produto.style.display = "block";
            encontrou = true;
        } else {
            produto.style.display = "none";
        }
    });

    if (!encontrou) {
        alert("Nenhum produto encontrado!");
    }
}
</script>

</body>
</html>
