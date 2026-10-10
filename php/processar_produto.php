<?php
require_once __DIR__ . '/includes/bootstrap.php';
exigir_admin();
csrf_validar();

$nome      = trim($_POST['nome'] ?? '');
$tipo      = strtolower(trim($_POST['tipo'] ?? ''));
$modId     = trim($_POST['modalidade'] ?? '');
$valor     = paraNumero($_POST['valor'] ?? '');
$valorAnt  = paraNumero($_POST['valor_antigo'] ?? ''); // opcional

$erros = [];
if (mb_strlen($nome) < 3 || mb_strlen($nome) > 80) {
    $erros[] = 'Informe o nome do produto (3 a 80 caracteres).';
}
if (!isset(ELEMENTOS[$tipo])) {
    $erros[] = 'Escolha um tipo válido: fogo, água, terra ou ar.';
}
$modalidade = null;
foreach (catalogo()['modalidades'] as $m) {
    if ($m['id'] === $modId) {
        $modalidade = $m;
    }
}
if (!$modalidade || $modalidade['elemento'] !== $tipo) {
    $erros[] = 'Escolha uma modalidade que pertença ao tipo selecionado.';
}
if ($valor === null || $valor <= 0) {
    $erros[] = 'Informe um valor válido, maior que zero.';
}
if (($_POST['valor_antigo'] ?? '') !== '' && ($valorAnt === null || $valorAnt <= 0)) {
    $erros[] = 'O valor original informado é inválido.';
}
if ($valorAnt !== null && $valor !== null && $valorAnt <= $valor) {
    $erros[] = 'O valor original deve ser maior que o valor de venda.';
}

$imagem = salvar_imagem($_FILES['imagem'] ?? null, true, $erroImg);
if ($erroImg) {
    $erros[] = $erroImg;
}

if ($erros) {
    apagar_upload($imagem);
    flash('erros', $erros);
    flash('antigo', [
        'nome' => $nome, 'tipo' => $tipo, 'modalidade' => $modId,
        'valor' => $_POST['valor'] ?? '', 'valor_antigo' => $_POST['valor_antigo'] ?? '',
    ]);
    ir('criar_produto.php');
}

$ok = json_atualizar(ARQ_CATALOGO, CATALOGO_BASE, function (array $cat) use ($nome, $modId, $valor, $valorAnt, $imagem) {
    $cat['produtos'][] = [
        'id'           => bin2hex(random_bytes(6)),
        'modalidade'   => $modId,
        'nome'         => $nome,
        'valor'        => $valor,
        'valor_antigo' => $valorAnt,
        'imagem'       => $imagem,
        'criado'       => time(),
    ];
    return $cat;
});

if (!$ok) {
    apagar_upload($imagem);
    flash('erros', ['Não foi possível gravar em data/. Verifique as permissões da pasta.']);
    ir('criar_produto.php');
}

ir('modalidade.php?m=' . rawurlencode($modalidade['slug']) . '#gear');
