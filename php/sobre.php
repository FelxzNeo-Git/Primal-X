<?php
session_start();
require __DIR__ . '/icones.php';
$qtdCarrinho = array_sum($_SESSION['carrinho'] ?? []);

$elementos = [
  'fogo'  => ['Fogo',  'Performance extremo',  'Intensidade e presença de palco. Produtos para quem trabalha com risco calculado e espera o máximo do equipamento.'],
  'agua'  => ['Água',  'Fluxo & precisão',     'Controle, ritmo e fluidez. Equipamentos pensados para quem prioriza movimento limpo e execução exata.'],
  'terra' => ['Terra', 'Força bruta',          'Resistência e durabilidade. Itens construídos para uso intenso e longa vida útil, sem concessões.'],
  'ar'    => ['Ar',    'Leveza & velocidade',  'Agilidade e baixo peso. Para quem precisa de equipamentos rápidos, portáteis e de resposta imediata.'],
];

require_once __DIR__ . '/includes/bootstrap.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sobre nós · Loja Elementos</title>
  <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;700&family=Inter:wght@400;500&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../css/sobre.css">
  <link rel="stylesheet" href="../css/topo.css">
</head>

<body>


  <div class="hero">
    <div class="wrap">
      <p class="eyebrow">Sobre nós</p>
      <h2>Equipamentos de performance, organizados por <em>elemento</em></h2>
      <p class="lead">Selecionamos produtos para profissionais e entusiastas que levam o próprio desempenho a sério. Cada item pertence a um dos quatro elementos: fogo, água, terra ou ar. Isso torna a escolha mais clara e rápida.</p>
      <div class="acoes">
        <a class="btn cheio" href="./home.php">Ver produtos</a>
        <a class="btn" href="#elementos">Conhecer os elementos</a>
      </div>
    </div>
  </div>

  <section>
    <div class="wrap duas">
      <div class="reveal">
        <p class="eyebrow">Nossa história</p>
        <h2 class="titulo">Curadoria com critério</h2>
        <p class="lead">A loja nasceu de uma dificuldade comum: encontrar equipamentos de performance bem selecionados, com informação clara e apresentados de forma profissional.</p>
      </div>
      <div class="tempo reveal">
        <div class="marco">
          <small>01 · Origem</small>
          <h3>A necessidade</h3>
          <p>Percebemos que cada tipo de performance exige um perfil diferente de equipamento, e que o mercado raramente organizava isso de forma útil.</p>
        </div>
        <div class="marco">
          <small>02 · Seleção</small>
          <h3>Os primeiros produtos</h3>
          <p>Começamos com kits e equipamentos escolhidos por qualidade, segurança e desempenho, como o Globe of Death Pro Kit, nosso bestseller.</p>
        </div>
        <div class="marco">
          <small>03 · Organização</small>
          <h3>Classificação por elementos</h3>
          <p>Criamos uma estrutura simples em Fogo, Água, Terra e Ar. Ela facilita a busca e dá identidade ao catálogo.</p>
        </div>
        <div class="marco">
          <small>04 · Hoje</small>
          <h3>Catálogo em expansão</h3>
          <p>Continuamos ampliando a loja com o mesmo padrão: só entra o que podemos recomendar com segurança.</p>
        </div>
      </div>
    </div>
  </section>

  <section id="elementos" class="alt">
    <div class="wrap">
      <div class="cab centro reveal">
        <p class="eyebrow">Como organizamos o catálogo</p>
        <h2 class="titulo">Os quatro elementos</h2>
        <p class="lead">Todo produto é classificado em um elemento, de acordo com o tipo de performance a que se destina.</p>
      </div>

      <div class="elementos">
        <?php $n = 0;
        foreach ($elementos as $classe => [$nome, $cat, $texto]): $n++; ?>
          <article class="el <?= $classe ?> reveal">
            <span class="num">0<?= $n ?></span>
            <div class="ico"><?= icone($classe, 24) ?></div>
            <h3><?= $nome ?></h3>
            <p class="sub"><?= $cat ?></p>
            <p class="txt"><?= $texto ?></p>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <section>
    <div class="wrap">
      <div class="cab reveal">
        <p class="eyebrow">Princípios</p>
        <h2 class="titulo">O que nos orienta</h2>
      </div>
      <div class="valores">
        <div class="valor reveal">
          <span class="num">01</span>
          <h3>Qualidade</h3>
          <p>Cada item passa por uma seleção cuidadosa antes de entrar no catálogo. Preferimos oferecer menos opções, todas confiáveis.</p>
        </div>
        <div class="valor reveal">
          <span class="num">02</span>
          <h3>Transparência</h3>
          <p>Preço claro e descrição objetiva. Quando há desconto, você vê o valor original e o valor atual lado a lado.</p>
        </div>
        <div class="valor reveal">
          <span class="num">03</span>
          <h3>Identidade</h3>
          <p>Performance tem personalidade. Do catálogo ao visual da loja, tudo foi pensado para refletir esse posicionamento.</p>
        </div>
      </div>
    </div>
  </section>

  <section class="alt">
    <div class="wrap">
      <div class="cab reveal">
        <p class="eyebrow">Passo a passo</p>
        <h2 class="titulo">Como funciona a loja</h2>
      </div>
      <div class="passos reveal">
        <div class="passo">
          <div class="n">01</div>
          <h3>Escolha o elemento</h3>
          <p>Identifique o tipo que se adequa ao seu uso. O selo em cada card indica o elemento do produto.</p>
        </div>
        <div class="passo">
          <div class="n">02</div>
          <h3>Confira os detalhes</h3>
          <p>Veja foto, nome, preço e desconto de cada produto, tudo organizado no mesmo formato.</p>
        </div>
        <div class="passo">
          <div class="n">03</div>
          <h3>Adicione ao carrinho</h3>
          <p>Use o botão "+ Carrinho" e acompanhe a quantidade de itens no topo da página.</p>
        </div>
      </div>
    </div>
  </section>

  <section>
    <div class="wrap">
      <div class="cab centro reveal">
        <p class="eyebrow">Dúvidas</p>
        <h2 class="titulo">Perguntas frequentes</h2>
      </div>
      <div class="faq reveal">
        <details>
          <summary>O que significam os elementos?</summary>
          <p>São categorias que organizam os produtos pelo tipo de performance: Fogo (intensidade), Água (fluidez e precisão), Terra (força e resistência) e Ar (leveza e velocidade).</p>
        </details>
        <details>
          <summary>Posso cadastrar um produto novo?</summary>
          <p>Sim. Na página "Novo produto" você informa nome, elemento, valor e imagem, e o item passa a aparecer na loja imediatamente.</p>
        </details>
        <details>
          <summary>Como o desconto é calculado?</summary>
          <p>Ao cadastrar o produto, você pode informar o valor original. A loja compara com o valor de venda e exibe o preço anterior riscado e a porcentagem de desconto.</p>
        </details>
        <details>
          <summary>O que indica o selo "Novo"?</summary>
          <p>Indica que o produto foi adicionado recentemente ao catálogo.</p>
        </details>
      </div>
    </div>
  </section>

  <section class="cta">
    <div class="wrap reveal">
      <h2>Encontre o equipamento do seu <em>elemento</em></h2>
      <p>Explore o catálogo completo e escolha com clareza.</p>
      <a class="btn cheio" href="./home.php">Ir para a loja</a>
    </div>
  </section>

  <footer>© <?= date('Y') ?> Loja <span>Elementos</span></footer>

  <script>
    (function() {
      var itens = document.querySelectorAll('.reveal');
      if (!('IntersectionObserver' in window)) {
        itens.forEach(function(el) {
          el.classList.add('on');
        });
        return;
      }
      var obs = new IntersectionObserver(function(es) {
        es.forEach(function(e) {
          if (e.isIntersecting) {
            e.target.classList.add('on');
            obs.unobserve(e.target);
          }
        });
      }, {
        threshold: .12
      });
      itens.forEach(function(el) {
        obs.observe(el);
      });
    })();
  </script>
</body>

</html>