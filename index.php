<?php
// YANIMMA E ISABELLA - EI32

// Cria uma variável chamada $sessao e a inicializa como string vazia
$sessao = "";

// Verifica se o parâmetro "login" foi enviado pela URL (via método GET)
// e se o valor dele é igual a "ok"
if (isset($_GET['login']) && $_GET['login'] == 'ok') {
    // Se a condição for verdadeira, define o valor da variável $sessao como "ok"
    $sessao = "ok";
}

// Verifica se a variável $sessao é diferente de "ok"
// Isso indica que o usuário não está autenticado
if ($sessao != "ok") {
    // Redireciona o usuário para a página de login
    header("Location: login.php");
    // Encerra a execução do script imediatamente
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
    padding: 0.7rem 1.2rem;
    border-radius: 30px;
    cursor: pointer;
    transition: 0.3s;
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
            <img src="img/roupa1.jpg" class="product-image">
            <h3>Vestido Abelhinha</h3>
            <p class="product-price">R$ 89,90</p>
            <a href="pagamento.php"><button class="btn">Comprar</button></a>
        </div>

        <div class="product-card">
            <img src="img/roupa2.jpg" class="product-image">
            <h3>Conjunto Floral</h3>
            <p class="product-price">R$ 119,90</p>
            <a href="pagamento.php"><button class="btn">Comprar</button></a>
        </div>

        <div class="product-card">
            <img src="img/roupa3.jpg" class="product-image">
            <h3>Camiseta Colmeia</h3>
            <p class="product-price">R$ 49,90</p>
            <a href="pagamento.php"><button class="btn">Comprar</button></a>
        </div>

        <div class="product-card">
            <img src="img/roupa4.jpg" class="product-image">
            <h3>Conjunto Infantil</h3>
            <p class="product-price">R$ 89,90</p>
            <a href="pagamento.php"><button class="btn">Comprar</button></a>
        </div>

        <div class="product-card">
            <img src="img/roupa5.jpg" class="product-image">
            <h3>Vestido Infantil</h3>
            <p class="product-price">R$ 79,90</p>
            <a href="pagamento.php"><button class="btn">Comprar</button></a>
        </div>

        <div class="product-card">
            <img src="img/roupa6.jpg" class="product-image">
            <h3>Chapéu Infantil</h3>
            <p class="product-price">R$ 39,90</p>
            <a href="pagamento.php"><button class="btn">Comprar</button></a>
        </div>

        <div class="product-card">
            <img src="img/roupa7.jpg" class="product-image">
            <h3>Jardineira Infantil</h3>
            <p class="product-price">R$ 59,90</p>
            <a href="pagamento.php"><button class="btn">Comprar</button></a>
        </div>

        <div class="product-card">
            <img src="img/roupa8.jpg" class="product-image">
            <h3>Pijama Infantil</h3>
            <p class="product-price">R$ 149,90</p>
            <a href="pagamento.php"><button class="btn">Comprar</button></a>
           
        </div>

    </div>
</section>

<footer>
    <p>&copy; 2025 Loja Abelhinhas - Todos os direitos reservados a Loja Abelhinhas 🐝</p>
</footer>
<script>

// Professor, usei esta função que é usada para filtrar os produtos exibidos na página
// com base no texto digitado pelo usuário em um campo de pesquisa (input).
// 🐝 Basicamente o que deixa a barra de pesquisa funcional, optei por usar javascript para deixar funcional.

function filtrarProdutos() {

    // Obtém o valor digitado no campo de pesquisa com id "searchInput"
    // e converte tudo para letras minúsculas para padronizar a comparação.
    var input = document.getElementById("searchInput").value.toLowerCase();

    // Seleciona todos os elementos com a classe "product-card",
    // que representam os produtos exibidos na página.
    var produtos = document.querySelectorAll(".product-card");

    // Cria uma variável booleana que servirá para verificar
    // se algum produto foi encontrado com base na busca.
    var encontrou = false;

    // Percorre cada elemento do NodeList "produtos" usando o método forEach.
    produtos.forEach(function(produto) {

        // Dentro de cada "product-card", busca o conteúdo do elemento <h3>,
        // que normalmente contém o nome do produto.
        // O texto também é convertido para minúsculas para comparação.
        var nome = produto.querySelector("h3").textContent.toLowerCase();

        // Verifica se o nome do produto inclui o texto digitado pelo usuário.
        if (nome.includes(input)) {
            // Se o nome do produto contém o texto buscado,
            // o produto é exibido (display: "block").
            produto.style.display = "block";

            // Marca que pelo menos um produto foi encontrado.
            encontrou = true;
        } else {
            // Caso contrário, o produto é ocultado da tela (display: "none").
            produto.style.display = "none";
        }
    });

    // Após verificar todos os produtos, se nenhum foi encontrado (encontrou = false),
    // é exibido um alerta informando que não há resultados correspondentes.
    if (!encontrou) {
        alert("Nenhum produto encontrado!");
    }
}
</script>

</body>
</html>
