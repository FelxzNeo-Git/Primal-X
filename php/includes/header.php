<?php
/**
 * Cabeçalho comum das páginas de elemento / modalidade / admin.
 * Variáveis esperadas: $titulo (string), $tema (chave de ELEMENTOS ou null), $css (array de css extras)
 */
$tema = $tema ?? null;
$css  = $css ?? [];
$qtd  = carrinho_qtd();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($titulo) ?> | Primal X</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500&family=Oswald:wght@500;600;700&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" type="image/png" href="../img/primalxlogo.png">
    <link rel="stylesheet" href="../css/elemento.css">
    <?php foreach ($css as $arquivo): ?>
    <link rel="stylesheet" href="../css/<?= e($arquivo) ?>">
    <?php endforeach; ?>
</head>
<body class="<?= $tema ? 't-' . e($tema) : '' ?>">
<div class="progresso" id="progresso"></div>

<header class="topo">
    <a class="logo" href="../index.php">PRIMAL<span>X</span></a>

    <nav class="topo-nav" aria-label="Elementos">
        <?php foreach (ELEMENTOS as $chave => $item): ?>
            <a class="t-<?= $chave ?><?= $tema === $chave ? ' ativo' : '' ?>" href="elemento.php?e=<?= $chave ?>">
                <i class="<?= e($item['icone']) ?>"></i> <?= e($item['nome']) ?>
            </a>
        <?php endforeach; ?>
    </nav>

    <div class="topo-direita">
        <?php if (admin()): ?><a class="topo-admin" href="admin.php">Admin</a><?php endif; ?>
        <span class="carrinho">Carrinho <b><?= str_pad((string) $qtd, 2, '0', STR_PAD_LEFT) ?></b></span>
    </div>
</header>
