<?php
require_once __DIR__ . '/includes/bootstrap.php';
exigir_admin();

$erros  = flash('erros') ?? [];
$antigo = flash('antigo') ?? [];
$cat    = catalogo();

// Pré-seleciona a modalidade vinda do link (?m=slug) ou do formulário anterior
$modSel = $antigo['modalidade'] ?? '';
if ($modSel === '' && isset($_GET['m'])) {
    foreach ($cat['modalidades'] as $m) {
        if ($m['slug'] === $_GET['m']) {
            $modSel = $m['id'];
        }
    }
}
$elSel = $antigo['tipo'] ?? '';
foreach ($cat['modalidades'] as $m) {
    if ($m['id'] === $modSel && $elSel === '') {
        $elSel = $m['elemento'];
    }
}

$titulo = 'Novo produto';
$tema   = null;
$css    = ['admin.css'];
require __DIR__ . '/includes/header.php';
?>
<main class="admin-main">
    <div class="box">
        <h1>Novo produto</h1>
        <div class="sub">Cadastro de produto</div>

        <?php if ($erros): ?>
            <div class="erros"><?php foreach ($erros as $erro): ?><p>⚠ <?= e($erro) ?></p><?php endforeach; ?></div>
        <?php endif; ?>

        <?php if (!$cat['modalidades']): ?>
            <div class="erros"><p>⚠ Cadastre uma modalidade antes de criar produtos.</p></div>
            <a class="link" href="nova_modalidade.php">+ Nova modalidade →</a>
        <?php else: ?>
        <form action="processar_produto.php" method="post" enctype="multipart/form-data" novalidate id="form">
            <?= csrf_campo() ?>

            <label class="t" for="nome">Nome do produto</label>
            <input type="text" id="nome" name="nome" required minlength="3" maxlength="80" value="<?= e($antigo['nome'] ?? '') ?>" placeholder="Ex.: Globe of Death Pro Kit">

            <label class="t">Tipo (obrigatório)</label>
            <div class="tipos">
                <?php foreach (ELEMENTOS as $chave => $el): ?>
                    <div class="opt t-<?= $chave ?>">
                        <input type="radio" name="tipo" id="tipo-<?= $chave ?>" value="<?= $chave ?>" <?= $elSel === $chave ? 'checked' : '' ?>>
                        <label for="tipo-<?= $chave ?>"><span class="ic"><i class="<?= e($el['icone']) ?>"></i></span><?= e($el['nome']) ?></label>
                    </div>
                <?php endforeach; ?>
            </div>

            <label class="t" for="modalidade">Modalidade</label>
            <select id="modalidade" name="modalidade" required data-selecionada="<?= e($modSel) ?>">
                <option value="">Escolha o tipo primeiro</option>
                <?php foreach ($cat['modalidades'] as $m): ?>
                    <option value="<?= e($m['id']) ?>" data-el="<?= e($m['elemento']) ?>"><?= e($m['nome']) ?></option>
                <?php endforeach; ?>
            </select>

            <label class="t" for="valor">Valor (R$)</label>
            <input type="text" id="valor" name="valor" required inputmode="decimal" value="<?= e($antigo['valor'] ?? '') ?>" placeholder="4.890,00">

            <label class="t" for="valor_antigo">Valor original <small>(opcional, gera o selo de desconto)</small></label>
            <input type="text" id="valor_antigo" name="valor_antigo" inputmode="decimal" value="<?= e($antigo['valor_antigo'] ?? '') ?>" placeholder="6.200,00">

            <label class="t" for="imagem">Imagem do produto (obrigatória)</label>
            <label class="upload" for="imagem">
                <span id="upload-texto">📁 Clique para escolher uma imagem (JPG, PNG, WEBP ou GIF, até 5 MB)</span>
                <input type="file" id="imagem" name="imagem" accept="image/jpeg,image/png,image/webp,image/gif" required>
                <img id="preview" alt="Pré-visualização">
            </label>

            <button type="submit">+ Adicionar produto</button>
        </form>
        <a class="link" href="admin.php">← Painel</a>
        <?php endif; ?>
    </div>
</main>
<script src="../js/admin.js"></script>
</body>
</html>
