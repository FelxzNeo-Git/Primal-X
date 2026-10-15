<?php
require_once __DIR__ . '/includes/bootstrap.php';
exigir_login();

$cat = catalogo();

// Indexa os produtos por ID para acesso direto
$produtos = [];
foreach ($cat['produtos'] ?? [] as $p) {
    $produtos[(string) $p['id']] = $p;
}

// Ações do carrinho
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_validar();

    $acao = $_POST['acao'] ?? (isset($_POST['add']) ? 'mais' : '');

    // Pagamento
    if ($acao === 'pagar') {
        $itens = $_SESSION['carrinho'] ?? [];
        $totalPedido = 0;

        foreach ($itens as $idItem => $qtd) {
            if (isset($produtos[(string) $idItem])) {
                $totalPedido += (float) $produtos[(string) $idItem]['valor'] * (int) $qtd;
            }
        }

        if ($totalPedido > 0) {
            // Aqui entraria a integração real (Mercado Pago, Stripe, etc.)
            // e o registro do pedido no banco.
            $_SESSION['pedido_ok'] = $totalPedido;
            $_SESSION['carrinho'] = [];
        }

        ir('carrinho.php');
    }

    // Mais, menos, remover (e "add" vindo do catálogo)
    $id = (string) ($_POST['id'] ?? $_POST['add'] ?? '');

    if (isset($produtos[$id])) {
        $atual = (int) ($_SESSION['carrinho'][$id] ?? 0);

        switch ($acao) {
            case 'mais':
                $_SESSION['carrinho'][$id] = $atual + 1;
                break;

            case 'menos':
                if ($atual > 1) {
                    $_SESSION['carrinho'][$id] = $atual - 1;
                } else {
                    unset($_SESSION['carrinho'][$id]);
                }
                break;

            case 'remover':
                unset($_SESSION['carrinho'][$id]);
                break;
        }
    }

    ir('carrinho.php');
}

// Mensagem de pedido concluído (mostrada uma vez)
$pedidoOk = $_SESSION['pedido_ok'] ?? null;
unset($_SESSION['pedido_ok']);

$carrinho = $_SESSION['carrinho'] ?? [];
$total = 0;

$titulo = 'Meu carrinho';
$css = ['modalidade.css', 'carrinho.css'];

require __DIR__ . '/includes/header.php';
?>

<main class="secao">
    <div class="secao-topo">
        <div>
            <p class="eyebrow">// Seu equipamento</p>
            <h1 class="secao-titulo">Meu <em>carrinho</em></h1>
        </div>
    </div>

    <?php if ($pedidoOk !== null): ?>
        <div class="pedido-ok">
            <h3>Pedido realizado com sucesso!</h3>
            <p>Total pago: <strong><?= preco($pedidoOk) ?></strong></p>
        </div>
    <?php endif; ?>

    <?php if (empty($carrinho)): ?>

        <div class="vazio">
            <h3>Seu carrinho está vazio</h3>
            <p>Explore as arenas e escolha seus equipamentos.</p>
            <a class="btn" href="home.php">Explorar equipamentos</a>
        </div>

    <?php else: ?>

        <div class="carrinho-lista">

            <?php foreach ($carrinho as $id => $quantidade): ?>
                <?php
                $produto = $produtos[(string) $id] ?? null;
                if (!$produto) continue;

                $quantidade = (int) $quantidade;
                $subtotal   = (float) $produto['valor'] * $quantidade;
                $total     += $subtotal;
                ?>

                <article class="item-carrinho">
                    <img
                        class="item-foto"
                        src="<?= e(url_upload($produto['imagem'])) ?>"
                        alt="<?= e($produto['nome']) ?>"
                        loading="lazy"
                    >

                    <div class="item-info">
                        <h3 class="nome"><?= e($produto['nome']) ?></h3>
                        <span class="preco-unit"><?= preco($produto['valor']) ?> cada</span>

                        <form method="post" class="qtd-controle">
                            <?= csrf_campo() ?>
                            <input type="hidden" name="id" value="<?= e((string) $id) ?>">

                            <button type="submit" name="acao" value="menos" aria-label="Diminuir">−</button>
                            <span class="qtd-num"><?= $quantidade ?></span>
                            <button type="submit" name="acao" value="mais" aria-label="Aumentar">+</button>

                            <button type="submit" name="acao" value="remover" class="btn-remover">Remover</button>
                        </form>
                    </div>

                    <div class="item-subtotal">
                        <span class="preco"><?= preco($subtotal) ?></span>
                    </div>
                </article>

            <?php endforeach; ?>

        </div>

        <div class="carrinho-total">
            <span>Total</span>
            <strong class="preco"><?= preco($total) ?></strong>
        </div>

        <form method="post" class="form-pagar">
            <?= csrf_campo() ?>
            <a class="btn-continuar" href="home.php">Continuar comprando</a>
            <button type="submit" name="acao" value="pagar" class="btn btn-pagar">
                Finalizar compra
            </button>
        </form>

    <?php endif; ?>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>