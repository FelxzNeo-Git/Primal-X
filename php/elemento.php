<?php
require_once __DIR__ . '/includes/bootstrap.php';
exigir_login();

$tema = (string) ($_GET['e'] ?? '');
if (!isset(ELEMENTOS[$tema])) {
    ir('../index.php');
}

$el          = ELEMENTOS[$tema];
$modalidades = modalidades_do_elemento($tema);
$totalItens  = contar_produtos_do_elemento($tema);
$pad         = fn(int $n) => str_pad((string) $n, 2, '0', STR_PAD_LEFT);

$titulo = $el['nome'];
$css    = [];
require __DIR__ . '/includes/header.php';
?>

<main>
    <a class="voltar" href="../index.php"><i class="fa-solid fa-arrow-left"></i> Voltar às arenas</a>

    <section class="hero hero-elemento" style="--hero-img:url('../img/<?= e($el['imagem']) ?>')">
        <p class="eyebrow">// Elemento <?= e($el['nome']) ?> · Primal X</p>
        <h1 class="hero-titulo"><?= e($el['titulo'][0]) ?><br><em><?= e($el['titulo'][1]) ?></em></h1>
        <p class="hero-texto"><?= e($el['texto']) ?></p>

        <ul class="stats">
            <li><b><?= $pad(count($modalidades)) ?></b><span>Modalidades</span></li>
            <li><b><?= $pad($totalItens) ?></b><span>Itens selecionados</span></li>
            <li><b>100%</b><span>Testado em campo</span></li>
        </ul>

        <div class="losango" aria-hidden="true"><i class="<?= e($el['icone']) ?>"></i></div>
    </section>

    <section class="secao">
        <div class="secao-topo">
            <div>
                <p class="eyebrow">// Escolha sua modalidade</p>
                <h2 class="secao-titulo">Qual é o seu <em>próximo limite?</em></h2>
            </div>
            <p class="secao-nota">Acesse uma modalidade para ver apenas os equipamentos preparados para ela.</p>
        </div>

        <?php if ($modalidades): ?>
            <div class="grade-modalidades">
                <?php foreach ($modalidades as $i => $m): ?>
                    <a class="card-mod" href="modalidade.php?m=<?= e($m['slug']) ?>"
                       style="--mod-img:url('<?= $m['imagem'] ? e(url_upload($m['imagem'])) : '../img/' . e($el['imagem']) ?>')">
                        <span class="card-mod-num"><?= $pad($i + 1) ?></span>
                        <?php if ($m['nivel'] !== ''): ?><span class="card-mod-selo"><?= e($m['nivel']) ?></span><?php endif; ?>
                        <div class="card-mod-corpo">
                            <span class="eyebrow"><?= e($m['subtitulo']) ?></span>
                            <h3><?= e($m['nome']) ?></h3>
                            <p><?= e($m['descricao']) ?></p>
                            <span class="card-mod-link">Acessar modalidade <i class="fa-solid fa-arrow-right-long"></i></span>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="vazio">
                <h3>Nenhuma modalidade em <?= e($el['nome']) ?> ainda</h3>
                <p>As modalidades deste elemento aparecerão aqui assim que forem cadastradas.</p>
                <?php if (admin()): ?><a class="btn" href="nova_modalidade.php?e=<?= e($tema) ?>">+ Nova modalidade</a><?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if (admin() && $modalidades): ?>
            <p class="acao-admin"><a href="nova_modalidade.php?e=<?= e($tema) ?>">+ Nova modalidade em <?= e($el['nome']) ?></a></p>
        <?php endif; ?>
    </section>
</main>

<?php require __DIR__ . '/includes/footer.php';
