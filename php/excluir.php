<?php
require_once __DIR__ . '/includes/bootstrap.php';
exigir_admin();
csrf_validar();

$tipo = $_POST['tipo'] ?? '';
$id   = (string) ($_POST['id'] ?? '');
$imagensApagar = [];

json_atualizar(ARQ_CATALOGO, CATALOGO_BASE, function (array $cat) use ($tipo, $id, &$imagensApagar) {
    if ($tipo === 'modalidade') {
        foreach ($cat['modalidades'] as $m) {
            if ($m['id'] === $id) {
                $imagensApagar[] = $m['imagem'];
            }
        }
        foreach ($cat['produtos'] as $p) {
            if ($p['modalidade'] === $id) {
                $imagensApagar[] = $p['imagem'];
            }
        }
        $cat['modalidades'] = array_values(array_filter($cat['modalidades'], fn($m) => $m['id'] !== $id));
        $cat['produtos']    = array_values(array_filter($cat['produtos'], fn($p) => $p['modalidade'] !== $id));
    } elseif ($tipo === 'produto') {
        foreach ($cat['produtos'] as $p) {
            if ($p['id'] === $id) {
                $imagensApagar[] = $p['imagem'];
            }
        }
        $cat['produtos'] = array_values(array_filter($cat['produtos'], fn($p) => $p['id'] !== $id));
        unset($_SESSION['carrinho'][$id]);
    } else {
        return null;
    }
    return $cat;
});

array_map('apagar_upload', $imagensApagar);
ir('admin.php');
