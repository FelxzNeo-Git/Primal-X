<?php
require_once __DIR__ . '/includes/bootstrap.php';
exigir_admin();

$cat  = catalogo();
$mods = [];
foreach ($cat['modalidades'] as $m) {
    $mods[$m['elemento']][] = $m;
}

$titulo = 'Painel';
$tema   = null;
$css    = ['admin.css'];
require __DIR__ . '/includes/header.php';
?>
<main class="admin-main admin-largo">
    <h1 class="admin-titulo">Painel <em>admin</em></h1>
    <p class="admin-acoes">
        <a class="btn" href="nova_modalidade.php">+ Nova modalidade</a>
        <a class="btn" href="criar_produto.php">+ Novo produto</a>
    </p>

    <?php foreach (ELEMENTOS as $chave => $el): ?>
        <section class="admin-bloco t-<?= $chave ?>">
            <h2><i class="<?= e($el['icone']) ?>"></i> <?= e($el['nome']) ?></h2>
            <?php if (empty($mods[$chave])): ?>
                <p class="vazio-min">Nenhuma modalidade. <a href="nova_modalidade.php?e=<?= $chave ?>">Criar</a></p>
            <?php endif; ?>

            <?php foreach ($mods[$chave] ?? [] as $m): ?>
                <div class="admin-mod">
                    <div class="admin-linha">
                        <a href="modalidade.php?m=<?= e($m['slug']) ?>"><strong><?= e($m['nome']) ?></strong></a>
                        <span class="adm-acoes">
                            <a href="criar_produto.php?m=<?= e($m['slug']) ?>">+ produto</a>
                            <form method="post" action="excluir.php" onsubmit="return confirm('Excluir a modalidade e todos os seus produtos?')">
                                <?= csrf_campo() ?><input type="hidden" name="tipo" value="modalidade"><input type="hidden" name="id" value="<?= e($m['id']) ?>">
                                <button class="del">excluir</button>
                            </form>
                        </span>
                    </div>
                    <?php foreach (produtos_da_modalidade($m['id']) as $p): ?>
                        <div class="admin-linha admin-prod">
                            <span><?= e($p['nome']) ?> · <?= preco($p['valor']) ?></span>
                            <form method="post" action="excluir.php" onsubmit="return confirm('Excluir este produto?')">
                                <?= csrf_campo() ?><input type="hidden" name="tipo" value="produto"><input type="hidden" name="id" value="<?= e($p['id']) ?>">
                                <button class="del">excluir</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </section>
    <?php endforeach; ?>
</main>
</body>
</html>
