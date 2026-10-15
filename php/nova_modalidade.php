<?php
require_once __DIR__ . '/includes/bootstrap.php';
exigir_admin();

$erros  = flash('erros') ?? [];
$antigo = flash('antigo') ?? [];
$elSel  = $antigo['elemento'] ?? (isset(ELEMENTOS[$_GET['e'] ?? '']) ? $_GET['e'] : '');

$titulo = 'Nova modalidade';
$tema   = null;
$css    = ['admin.css'];
require __DIR__ . '/includes/header.php';
?>
<main class="admin-main">
    <div class="box">
        <h1>Nova modalidade</h1>
        <div class="sub">Cadastro de modalidade</div>

        <?php if ($erros): ?>
            <div class="erros"><?php foreach ($erros as $erro): ?><p>⚠ <?= e($erro) ?></p><?php endforeach; ?></div>
        <?php endif; ?>

        <form action="processar_modalidade.php" method="post" enctype="multipart/form-data" novalidate>
            <?= csrf_campo() ?>

            <label class="t">Elemento (obrigatório)</label>
            <div class="tipos">
                <?php foreach (ELEMENTOS as $chave => $el): ?>
                    <div class="opt t-<?= $chave ?>">
                        <input type="radio" name="elemento" id="el-<?= $chave ?>" value="<?= $chave ?>" <?= $elSel === $chave ? 'checked' : '' ?>>
                        <label for="el-<?= $chave ?>"><span class="ic"><i class="<?= e($el['icone']) ?>"></i></span><?= e($el['nome']) ?></label>
                    </div>
                <?php endforeach; ?>
            </div>

            <label class="t" for="nome">Nome da modalidade</label>
            <input type="text" id="nome" name="nome" required minlength="2" maxlength="60" value="<?= e($antigo['nome'] ?? '') ?>" placeholder="Ex.: Globe of Death">

            <label class="t" for="subtitulo">Chamada curta <small>(texto pequeno acima do nome)</small></label>
            <input type="text" id="subtitulo" name="subtitulo" maxlength="40" value="<?= e($antigo['subtitulo'] ?? '') ?>" placeholder="Ex.: Velocidade circular">

            <label class="t" for="descricao">Descrição</label>
            <textarea id="descricao" name="descricao" rows="3" maxlength="200" placeholder="Proteção, aderência e controle..."><?= e($antigo['descricao'] ?? '') ?></textarea>

            <label class="t" for="nivel">Selo <small>(opcional, ex.: PRO, TÁTICO)</small></label>
            <input type="text" id="nivel" name="nivel" maxlength="14" value="<?= e($antigo['nivel'] ?? '') ?>" placeholder="PRO">

            <label class="t" for="imagem">Imagem <small>(opcional, usa a imagem do elemento se vazio)</small></label>
            <label class="upload" for="imagem">
                <span id="upload-texto">📁 Clique para escolher uma imagem (JPG, PNG, WEBP ou GIF, até 5 MB)</span>
                <input type="file" id="imagem" name="imagem" accept="image/jpeg,image/png,image/webp,image/gif">
                <img id="preview" alt="Pré-visualização">
            </label>

            <button type="submit">+ Criar modalidade</button>
        </form>
        <a class="link" href="admin.php">← Painel</a>
    </div>
</main>
<script src="../js/admin.js"></script>
</body>
</html>
