<?php
require_once __DIR__ . '/includes/bootstrap.php';
exigir_login();

$mod = modalidade_por_slug((string) ($_GET['m'] ?? ''));
if (!$mod) {
    ir('../index.php');
}
$tema = $mod['elemento'];
$el   = ELEMENTOS[$tema];
$url  = 'modalidade.php?m=' . rawurlencode($mod['slug']);

$produtos = produtos_da_modalidade($mod['id']);

// Botão "+ Carrinho" de cada card
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    csrf_validar();
    $id = (string) $_POST['add'];
    if (in_array($id, array_column($produtos, 'id'), true)) {
        $_SESSION['carrinho'][$id] = ($_SESSION['carrinho'][$id] ?? 0) + 1;
    }
    ir($url . '#gear');
}

$carrinho = $_SESSION['carrinho'] ?? [];

/** Partículas animadas do elemento (brasas, bolhas, folhas, rajadas de vento). */
function particulas(string $tipo): string
{
    $qtd  = $tipo === 'ar' ? 7 : 12;
    $html = '<div class="fx" aria-hidden="true">';
    for ($n = 0; $n < $qtd; $n++) {
        $html .= sprintf(
            '<i style="--x:%d%%;--y:%d%%;--d:%.1fs;--t:%.1fs;--s:%dpx"></i>',
            mt_rand(4, 96), mt_rand(8, 85), mt_rand(0, 50) / 10, mt_rand(30, 65) / 10, mt_rand(4, 10)
        );
    }
    return $html . '</div>';
}

$titulo = $mod['nome'];
$css    = ['produto.css'];
require __DIR__ . '/includes/header.php';
?>

<main>
    <a class="voltar" href="elemento.php?e=<?= e($tema) ?>"><i class="fa-solid fa-arrow-left"></i> Voltar a <?= e($el['nome']) ?></a>

    <section class="hero hero-modalidade"<?= $mod['imagem'] ? ' style="--hero-img:url(\'' . e(url_upload($mod['imagem'])) . '\')"' : " style=\"--hero-img:url('../img/" . e($el['imagem']) . "')\"" ?>>
        <div class="losango losango-lado" aria-hidden="true"><i class="<?= e($el['icone']) ?>"></i></div>
        <div class="hero-modalidade-corpo">
            <p class="eyebrow">// <?= e($el['nome']) ?> / <?= e($mod['subtitulo']) ?></p>
            <h1 class="hero-titulo"><em><?= e($mod['nome']) ?></em></h1>
            <p class="hero-texto"><?= e($mod['descricao']) ?></p>
            <dl class="meta">
                <div><dt>Protocolo</dt><dd>PX-<?= str_pad((string) $mod['numero'], 3, '0', STR_PAD_LEFT) ?></dd></div>
                <?php if ($mod['nivel'] !== ''): ?><div><dt>Nível</dt><dd><?= e($mod['nivel']) ?></dd></div><?php endif; ?>
                <div><dt>Status</dt><dd>Operacional</dd></div>
            </dl>
        </div>
    </section>

    <section class="secao" id="gear">
        <div class="secao-topo">
            <div>
                <p class="eyebrow">// Equipamento da modalidade</p>
                <h2 class="secao-titulo">Escolha seu <em>gear</em></h2>
            </div>
            <p class="secao-nota">
                <?= count($produtos) ?> <?= count($produtos) === 1 ? 'item selecionado' : 'itens selecionados' ?> por especialistas Primal X.
            </p>
        </div>

        <?php if ($produtos): ?>
            <div class="grade-produtos">
                <?php foreach ($produtos as $p):
                    $desconto = !empty($p['valor_antigo']) ? (int) round((1 - $p['valor'] / $p['valor_antigo']) * 100) : 0;
                    $novo     = (time() - ($p['criado'] ?? 0)) < 30 * 86400;
                ?>
                    <article class="pcard t-<?= e($tema) ?>">
                        <div class="thumb">
                            <img class="foto" src="<?= e(url_upload($p['imagem'])) ?>" alt="<?= e($p['nome']) ?>" loading="lazy">
                            <div class="veu"></div>

                            <?php if ($tema === 'agua'): ?>
                                <svg class="onda" viewBox="0 0 1200 60" preserveAspectRatio="none"><path fill="#1765ff" d="M0 30 Q75 0 150 30 T300 30 T450 30 T600 30 T750 30 T900 30 T1050 30 T1200 30 V60 H0Z"/></svg>
                                <svg class="onda b" viewBox="0 0 1200 60" preserveAspectRatio="none"><path fill="#00c8ff" d="M0 30 Q75 60 150 30 T300 30 T450 30 T600 30 T750 30 T900 30 T1050 30 T1200 30 V60 H0Z"/></svg>
                            <?php endif; ?>

                            <?= particulas($tema) ?>

                            <span class="tag"><i class="<?= e($el['icone']) ?>"></i> <?= e($el['nome']) ?></span>
                            <?php if ($novo): ?><span class="badge">Novo</span><?php endif; ?>
                            <?php if ($desconto > 0): ?><span class="desc">-<?= $desconto ?>%</span><?php endif; ?>
                        </div>
                        <div class="body">
                            <p class="cat"><b><?= e($mod['nome']) ?></b> · <?= e($el['cat']) ?></p>
                            <h3 class="nome"><?= e($p['nome']) ?></h3>
                            <div class="barra"></div>
                            <div class="rodape">
                                <div>
                                    <?php if (!empty($p['valor_antigo'])): ?><span class="antigo"><?= preco($p['valor_antigo']) ?></span><?php endif; ?>
                                    <span class="preco"><?= preco($p['valor']) ?></span>
                                </div>
                                <form method="post" action="<?= e($url) ?>">
                                    <?= csrf_campo() ?>
                                    <input type="hidden" name="add" value="<?= e($p['id']) ?>">
                                    <button class="btn" type="submit">+ Carrinho</button>
                                </form>
                            </div>
                            <?php if (!empty($carrinho[$p['id']])): ?>
                                <div class="qtd">No carrinho: <?= (int) $carrinho[$p['id']] ?></div>
                            <?php endif; ?>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="vazio">
                <h3>Nenhum item nesta modalidade ainda</h3>
                <p>Os equipamentos de <?= e($mod['nome']) ?> aparecerão aqui assim que forem cadastrados.</p>
                <?php if (admin()): ?><a class="btn" href="criar_produto.php?m=<?= e($mod['slug']) ?>">+ Cadastrar produto</a><?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if (admin() && $produtos): ?>
            <p class="acao-admin"><a href="criar_produto.php?m=<?= e($mod['slug']) ?>">+ Novo produto em <?= e($mod['nome']) ?></a></p>
        <?php endif; ?>
    </section>
</main>

<?php require __DIR__ . '/includes/footer.php';
