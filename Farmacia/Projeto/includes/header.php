<?php
$paginaAtual = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmácia VAV</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header>
    <div class="container header-inner">
        <a href="index.php" class="logo">
            <img src="img\AmanzingFarmaLogo.png" alt="Logo Farmácia VAV">
            <span>The Amazing Farmácia</span>
        </a>
        <nav>
            <a href="index.php" class="<?= $paginaAtual === 'index.php' ? 'ativo' : '' ?>">Estoque</a>
            <a href="cadastro.php" class="btn-novo <?= $paginaAtual === 'cadastro.php' ? 'ativo' : '' ?>">+ Novo Produto</a>
        </nav>
    </div>
</header>

<main class="container">
