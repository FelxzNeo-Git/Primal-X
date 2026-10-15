<?php
// Ícones de linha (SVG) dos quatro elementos, usados em todas as páginas
function icone(string $tipo, int $tam = 20): string
{
    $paths = [
        'fogo'  => '<path d="M12 3c.9 3.4 5 5.6 5 10a5 5 0 0 1-10 0c0-2 1-3.3 2-4.3.2 1.3.8 2.1 1.6 2.5C10.2 8.3 10.7 5.5 12 3z"/>',
        'agua'  => '<path d="M12 3s6 6.2 6 10.5a6 6 0 0 1-12 0C6 9.2 12 3 12 3z"/>',
        'terra' => '<path d="M3 19l6.5-11 4 6.5 2-3L21 19H3z"/>',
        'ar'    => '<path d="M3 8h10a2.5 2.5 0 1 0-2.5-2.5M3 12h15a2.5 2.5 0 1 1-2.5 2.5M3 16h7a2 2 0 1 1-2 2"/>',
    ];
    $p = $paths[$tipo] ?? $paths['fogo'];
    return '<svg class="icone" width="' . $tam . '" height="' . $tam . '" viewBox="0 0 24 24" fill="none" '
         . 'stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">'
         . $p . '</svg>';
}
