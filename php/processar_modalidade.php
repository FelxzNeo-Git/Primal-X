<?php
require_once __DIR__ . '/includes/bootstrap.php';
exigir_admin();
csrf_validar();

$dados = [
    'elemento'  => strtolower(trim($_POST['elemento'] ?? '')),
    'nome'      => trim($_POST['nome'] ?? ''),
    'subtitulo' => trim($_POST['subtitulo'] ?? ''),
    'descricao' => trim($_POST['descricao'] ?? ''),
    'nivel'     => mb_strtoupper(trim($_POST['nivel'] ?? '')),
];

$erros = [];
if (!isset(ELEMENTOS[$dados['elemento']])) {
    $erros[] = 'Escolha um elemento válido: fogo, água, terra ou ar.';
}
if (mb_strlen($dados['nome']) < 2 || mb_strlen($dados['nome']) > 60) {
    $erros[] = 'Informe o nome da modalidade (2 a 60 caracteres).';
}
if (mb_strlen($dados['subtitulo']) > 40 || mb_strlen($dados['descricao']) > 200 || mb_strlen($dados['nivel']) > 14) {
    $erros[] = 'Algum campo excede o tamanho máximo.';
}

$imagem = salvar_imagem($_FILES['imagem'] ?? null, false, $erroImg);
if ($erroImg) {
    $erros[] = $erroImg;
}

if ($erros) {
    apagar_upload($imagem);
    flash('erros', $erros);
    flash('antigo', $dados);
    ir('nova_modalidade.php');
}

$novoSlug = null;
$ok = json_atualizar(ARQ_CATALOGO, CATALOGO_BASE, function (array $cat) use ($dados, $imagem, &$novoSlug) {
    $base = slug($dados['nome']);
    $slugs = array_column($cat['modalidades'], 'slug');
    $novoSlug = $base;
    for ($n = 2; in_array($novoSlug, $slugs, true); $n++) {
        $novoSlug = $base . '-' . $n;
    }
    $cat['seq_modalidade'] = ($cat['seq_modalidade'] ?? 0) + 1;
    $cat['modalidades'][] = $dados + [
        'id'     => bin2hex(random_bytes(6)),
        'slug'   => $novoSlug,
        'numero' => $cat['seq_modalidade'],
        'imagem' => $imagem,
        'criado' => time(),
    ];
    return $cat;
});

if (!$ok) {
    apagar_upload($imagem);
    flash('erros', ['Não foi possível gravar em data/. Verifique as permissões da pasta.']);
    flash('antigo', $dados);
    ir('nova_modalidade.php');
}

ir('modalidade.php?m=' . rawurlencode($novoSlug));
