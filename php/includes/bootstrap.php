<?php
/**
 * Inicialização comum: sessão, helpers, autenticação, catálogo (modalidades/produtos) e carrinho.
 */

require_once __DIR__ . '/../config.php';

/* ------------------------------------------------------------------ */
/*  Elementos (fixos, definem tema/cores de todas as páginas)          */
/* ------------------------------------------------------------------ */
const ELEMENTOS = [
    'fogo' => [
        'nome' => 'Fogo', 'icone' => 'fa-sharp fa-solid fa-fire-flame-curved', 'imagem' => 'motocrosscard.jpg',
        'titulo' => ['Domine o', 'Fogo'], 'cat' => 'Performance extremo',
        'texto' => 'Para quem vive no limite da chama. Equipamentos que suportam o inferno.',
    ],
    'agua' => [
        'nome' => 'Água', 'icone' => 'fa-solid fa-droplet', 'imagem' => 'cavediving.avif',
        'titulo' => ['Mergulhe na', 'Água'], 'cat' => 'Fluxo & precisão',
        'texto' => 'Nas profundezas onde a luz não chega. Gear que resiste às pressões do abismo.',
    ],
    'terra' => [
        'nome' => 'Terra', 'icone' => 'fa-solid fa-mountain', 'imagem' => 'canioncard.jfif',
        'titulo' => ['Conquiste a', 'Terra'], 'cat' => 'Força bruta',
        'texto' => 'Da mata fechada ao campo aberto. Precisão, resistência, domínio do terreno.',
    ],
    'ar' => [
        'nome' => 'Ar', 'icone' => 'fa-solid fa-crosshairs', 'imagem' => 'wingsuitcard.png',
        'titulo' => ['Desafie o', 'Ar'], 'cat' => 'Leveza & velocidade',
        'texto' => 'Onde o vento decide. Equipamentos que desafiam a gravidade e a altitude.',
    ],
];

const ARQ_CATALOGO  = DIR_DATA . '/catalogo.json';
const CATALOGO_BASE = ['seq_modalidade' => 0, 'modalidades' => [], 'produtos' => []];

/* ------------------------------------------------------------------ */
/*  Helpers gerais                                                     */
/* ------------------------------------------------------------------ */
function e(?string $s): string
{
    return htmlspecialchars($s ?? '', ENT_QUOTES, 'UTF-8');
}

function preco(float $v): string
{
    return 'R$ ' . number_format($v, 2, ',', '.');
}

function ir(string $url): never
{
    header('Location: ' . $url);
    exit;
}

/** Converte "4.890,00", "R$ 4890,00" ou "4890.00" em float (null se inválido). */
function paraNumero(string $v): ?float
{
    $v = trim(str_ireplace(['R$', ' '], '', $v));
    if ($v === '') {
        return null;
    }
    if (str_contains($v, ',')) {
        $v = str_replace(['.', ','], ['', '.'], $v);
    }
    return is_numeric($v) ? (float) $v : null;
}

function slug(string $texto): string
{
    // Sem depender da extensão intl: remove acentos comuns do português
    $texto = strtr(mb_strtolower($texto), [
        'á' => 'a', 'à' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'é' => 'e', 'è' => 'e', 'ê' => 'e', 'ë' => 'e',
        'í' => 'i', 'ì' => 'i', 'î' => 'i', 'ï' => 'i', 'ó' => 'o', 'ò' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o',
        'ú' => 'u', 'ù' => 'u', 'û' => 'u', 'ü' => 'u', 'ç' => 'c', 'ñ' => 'n',
    ]);
    $texto = preg_replace('/[^a-z0-9]+/', '-', $texto);
    return trim($texto, '-') ?: 'item';
}

/* ------------------------------------------------------------------ */
/*  Flash (mensagens/dados antigos de formulário) e CSRF               */
/* ------------------------------------------------------------------ */
function flash(string $chave, mixed $valor = null): mixed
{
    if ($valor !== null) {
        $_SESSION['flash'][$chave] = $valor;
        return null;
    }
    $v = $_SESSION['flash'][$chave] ?? null;
    unset($_SESSION['flash'][$chave]);
    return $v;
}

function csrf_token(): string
{
    return $_SESSION['csrf'] ??= bin2hex(random_bytes(32));
}

function csrf_campo(): string
{
    return '<input type="hidden" name="csrf" value="' . e(csrf_token()) . '">';
}

function csrf_validar(): void
{
    $esperado = $_SESSION['csrf'] ?? '';
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || $esperado === ''
        || !hash_equals($esperado, (string) ($_POST['csrf'] ?? ''))) {
        http_response_code(400);
        exit('Requisição inválida. Volte e tente novamente.');
    }
}

/* ------------------------------------------------------------------ */
/*  Autenticação                                                       */
/* ------------------------------------------------------------------ */
function logado(): bool
{
    return !empty($_SESSION['usuario_id']);
}

function admin(): bool
{
    return logado() && !empty($_SESSION['usuario_admin']);
}

function exigir_login(): void
{
    if (!logado()) {
        ir(dirname($_SERVER['SCRIPT_NAME']) . '/login.php');
    }
}

function exigir_admin(): void
{
    exigir_login();
    if (!admin()) {
        http_response_code(403);
        exit('Acesso restrito a administradores. <a href="../index.php">Voltar</a>');
    }
}

/* ------------------------------------------------------------------ */
/*  Catálogo                                                           */
/* ------------------------------------------------------------------ */
function catalogo(): array
{
    return json_ler(ARQ_CATALOGO, CATALOGO_BASE);
}

function modalidades_do_elemento(string $el): array
{
    return array_values(array_filter(catalogo()['modalidades'], fn($m) => $m['elemento'] === $el));
}

function modalidade_por_slug(string $slug): ?array
{
    foreach (catalogo()['modalidades'] as $m) {
        if ($m['slug'] === $slug) {
            return $m;
        }
    }
    return null;
}

function produtos_da_modalidade(string $id): array
{
    return array_values(array_filter(catalogo()['produtos'], fn($p) => $p['modalidade'] === $id));
}

function contar_produtos_do_elemento(string $el): int
{
    $cat = catalogo();
    $ids = array_column(array_filter($cat['modalidades'], fn($m) => $m['elemento'] === $el), 'id');
    return count(array_filter($cat['produtos'], fn($p) => in_array($p['modalidade'], $ids, true)));
}

/** URL pública de um arquivo enviado (relativa às páginas dentro de /php). */
function url_upload(?string $arquivo): string
{
    return $arquivo ? '../uploads/' . rawurlencode($arquivo) : '';
}

function apagar_upload(?string $arquivo): void
{
    $caminho = DIR_UPLOADS . '/' . basename((string) $arquivo);
    if ($arquivo && is_file($caminho)) {
        unlink($caminho);
    }
}

/**
 * Valida e salva uma imagem enviada. Devolve o nome do arquivo salvo ou null (e preenche $erro).
 * Se $obrigatoria for false e nenhum arquivo for enviado, devolve null sem erro.
 */
function salvar_imagem(?array $arquivo, bool $obrigatoria, ?string &$erro): ?string
{
    $erro = null;
    $permitidas = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp', 'image/gif' => 'gif'];

    if (!$arquivo || $arquivo['error'] === UPLOAD_ERR_NO_FILE) {
        $erro = $obrigatoria ? 'Envie uma imagem.' : null;
        return null;
    }
    if ($arquivo['error'] === UPLOAD_ERR_INI_SIZE || $arquivo['error'] === UPLOAD_ERR_FORM_SIZE) {
        $erro = 'A imagem é grande demais (máximo 5 MB).';
        return null;
    }
    if ($arquivo['error'] !== UPLOAD_ERR_OK) {
        $erro = 'Não foi possível enviar a imagem. Tente novamente.';
        return null;
    }
    if ($arquivo['size'] > 5 * 1024 * 1024) {
        $erro = 'A imagem deve ter no máximo 5 MB.';
        return null;
    }
    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($arquivo['tmp_name']);
    if (!isset($permitidas[$mime]) || @getimagesize($arquivo['tmp_name']) === false) {
        $erro = 'O arquivo enviado não é uma imagem válida (use JPG, PNG, WEBP ou GIF).';
        return null;
    }
    if (!is_dir(DIR_UPLOADS) && !mkdir(DIR_UPLOADS, 0755, true)) {
        $erro = 'Pasta uploads/ inexistente e não pôde ser criada.';
        return null;
    }
    $nome = bin2hex(random_bytes(8)) . '.' . $permitidas[$mime];
    if (!move_uploaded_file($arquivo['tmp_name'], DIR_UPLOADS . '/' . $nome)) {
        $erro = 'Falha ao salvar a imagem. Verifique a permissão da pasta uploads/.';
        return null;
    }
    return $nome;
}

/* ------------------------------------------------------------------ */
/*  Carrinho (sessão)                                                  */
/* ------------------------------------------------------------------ */
function carrinho_qtd(): int
{
    return array_sum($_SESSION['carrinho'] ?? []);
}
