<?php
// Esta página é carregada pelo index.php (que já valida o login).
if (basename($_SERVER['SCRIPT_NAME']) !== 'index.php') {
    header('Location: ../index.php');
    exit;
}
require_once __DIR__ . '/includes/bootstrap.php';
?>

<html>

<head>
    <meta charset="UTF-8">
    <title>Primal X</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" type="image/png" href="./img/primalxlogo.png">
    <link rel="stylesheet" href="./css/home.css">
    <link rel="stylesheet" href="./css/nav.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
   <link rel="stylesheet" href="./css/topo.css">
</head>

<body class="fundo1">


   <div class="progresso" id="progresso"></div>
   <header class="topo">
       <a class="logo" href="./index.php">PRIMAL<span>X</span></a>
       <nav class="topo-nav">
           <?php foreach (ELEMENTOS as $k => $item): ?>
               <a class="t-<?= $k ?>" href="php/elemento.php?e=<?= $k ?>"><i class="<?= $item['icone'] ?>"></i> <?= $item['nome'] ?></a>
           <?php endforeach; ?>
       </nav>
       <div class="topo-direita">
           <span class="carrinho">Carrinho <b><?= str_pad((string) carrinho_qtd(), 2, '0', STR_PAD_LEFT) ?></b></span>
       </div>
   </header>



          <nav class="navbar">

        <div class="nav-link">

            <a href="#">Perfil</a>
            <a href="#">compras</a>
            <?php if (!empty($_SESSION['usuario_admin'])): ?><a href="./php/admin.php">painel</a><?php endif; ?>
            <a href="?logout">sair</a>

        </div>

        <button class="user-button" onclick="toggleNav()">
            <img src="img/usuario.png" alt="Usuário">
        </button>

    </nav>

    <script src="./js/nav.js"></script>


    <div class="imagemfixa1"></div>
    
    <div class="herocontent">
        <h5 class="descricaopequena">ESPORTES RADICAIS <span>·</span>   EQUIPAMENTO PROFISSIONAL</h5>
        <h1 class="titulo1">ESTÁ BUSCANDO <span class="neon-text" style="color: greenyellow;">ADRENALINA</span> PARA SUA
            VIDA?</h1>
        <p class="textodescritivo1">Equipamentos para quem não aceita limites. Fogo, Água, Terra e Ar — cada elemento,
            uma arena. Cada produto, uma declaração de coragem.</p>
        <button class="button1home">Explorar elementos</button> <button class="button2home">Ver catálogo</button>


    </div>



    <div class="divisoriametade">
        <div class="linha-divisoria"></div>
        <div class="icones-centralizados">
            <div class="caixa-icone fogo"><i class="fa-sharp fa-solid fa-fire-flame-curved"></i></div>
            <div class="caixa-icone agua"><i class="fa-solid fa-droplet"></i></div>
            <div class="caixa-icone terra"><i class="fa-solid fa-mountain"></i></div>
            <div class="caixa-icone ar"><i class="fa-solid fa-crosshairs"></i></div>
        </div>
        <div class="linha-divisoria"></div>
    </div>
    <div class="herocontent">

        <section class="secao-elementos">

            <div class="titulo-elementos">

                <h2>
                    DECIDA SEU LADO <strong>EXTREMO</strong>
                </h2>
            </div>

            <div class="cards-elementos">

                <!-- FOGO -->
                <article class="cardelementos1">
                    <div class="card-conteudo">

                        <div class="icone-card">
                            <i class="fa-sharp fa-solid fa-fire-flame-curved"></i>
                        </div>

                        <span class="categoria-card">
                            Globe of Death · Airsoft · hard enduro<br>Entre Outros...
                        </span>

                        <h3>FOGO</h3>

                        <p>
                            Para quem vive no limite da chama.
                            Equipamentos que suportam o inferno.
                        </p>

                        <a href="php/elemento.php?e=fogo" class="link-card">
                            VER PRODUTOS <span>→</span>
                        </a>

                    </div>
                </article>


                <!-- ÁGUA -->
                <article class="cardelementos2">
                    <div class="card-conteudo">

                        <div class="icone-card">
                            <i class="fa-solid fa-droplet"></i>
                        </div>

                        <span class="categoria-card">
                            Mergulho Técnico · Cave Diving · Kitesurf <br>Entre Outros...
                        </span>

                        <h3>ÁGUA</h3>

                        <p>
                            Nas profundezas onde a luz não chega.
                            Gear que resiste às pressões do abismo.
                        </p>

                        <a href="php/elemento.php?e=agua" class="link-card">
                            VER PRODUTOS <span>→</span>
                        </a>

                    </div>
                </article>


                <!-- TERRA -->
                <article class="cardelementos3">
                    <div class="card-conteudo">

                        <div class="icone-card">
                            <i class="fa-solid fa-mountain"></i>
                        </div>

                        <span class="categoria-card">
                            Equitação · Caça Tática · Canyoning<br>Entre Outros...
                        </span>

                        <h3>TERRA</h3>

                        <p>
                            Da mata fechada ao campo aberto.
                            Precisão, resistência, domínio do terreno.
                        </p>

                        <a href="php/elemento.php?e=terra" class="link-card">
                            VER PRODUTOS <span>→</span>
                        </a>

                    </div>
                </article>


                <!-- AR -->
                <article class="cardelementos4">
                    <div class="card-conteudo">

                        <div class="icone-card">
                            <i class="fa-solid fa-crosshairs"></i>
                        </div>

                        <span class="categoria-card">
                            Paraquedismo · Alpinismo · Wingsuit <br>Entre Outros...
                        </span>

                        <h3>AR</h3>

                        <p>
                            Onde o vento decide.
                            Equipamentos que desafiam a gravidade e a altitude.
                        </p>

                        <a href="php/elemento.php?e=ar" class="link-card">
                            VER PRODUTOS <span>→</span>
                        </a>

                    </div>
                </article>

            </div>

        </section>


    </div>
        <div class="divisoriametade">
        <div class="linha-divisoria"></div>
        <div class="icones-centralizados">
            <div class="caixa-icone fogo"><i class="fa-sharp fa-solid fa-fire-flame-curved"></i></div>
            <div class="caixa-icone agua"><i class="fa-solid fa-droplet"></i></div>
            <div class="caixa-icone terra"><i class="fa-solid fa-mountain"></i></div>
            <div class="caixa-icone ar"><i class="fa-solid fa-crosshairs"></i></div>
        </div>
        <div class="linha-divisoria"></div>
    </div>





    

<section class="manifesto">
 
    <div class="manifesto-icones">
        <i class="fa-sharp fa-solid fa-fire-flame-curved" style="color:#ff2028"></i>
        <i class="fa-solid fa-droplet" style="color:#1765ff"></i>
        <i class="fa-solid fa-mountain" style="color:#00d85a"></i>
        <i class="fa-solid fa-crosshairs" style="color:#aab7bc"></i>
    </div>
 
    <h2 class="manifesto-titulo">
        NÃO COMPRAMOS MEDO.<br>
        <strong>VENDEMOS FERRAMENTAS</strong> PARA SUPERÁ-LO.
    </h2>
 
    <p class="manifesto-texto">
        Cada produto Primal X é testado nos extremos. Do fundo do oceano ao topo das montanhas,
        da pista em chamas ao vazio do céu — nosso equipamento não falha quando você não pode.
    </p>
 
    <div class="manifesto-stats">
        <div class="stat fogo">
            <i class="fa-sharp fa-solid fa-fire-flame-curved"></i>
            <span class="stat-numero">12+</span>
            <span class="stat-legenda">Anos de campo</span>
        </div>
        <div class="stat agua">
            <i class="fa-solid fa-droplet"></i>
            <span class="stat-numero">4.800+</span>
            <span class="stat-legenda">Atletas atendidos</span>
        </div>
        <div class="stat terra">
            <i class="fa-solid fa-mountain"></i>
            <span class="stat-numero">4</span>
            <span class="stat-legenda">Elementos dominados</span>
        </div>
        <div class="stat ar">
            <i class="fa-solid fa-crosshairs"></i>
            <span class="stat-numero">0</span>
            <span class="stat-legenda">Compromissos falhos</span>
        </div>
    </div>
 
</section>
 
<footer class="rodape">
    <div class="rodape-topo">
 
        <div class="rodape-marca">
            <div class="rodape-logo">PRIMAL<span>X</span></div>
            <p>Equipamentos para esportes radicais.<br>Testados nos extremos. Aprovados por quem não aceita limites.</p>
            <div class="rodape-pontos">
                <span style="background:#ff2028"></span>
                <span style="background:#1765ff"></span>
                <span style="background:#00d85a"></span>
                <span style="background:#aab7bc"></span>
            </div>
        </div>
 
        <div class="rodape-colunas">
            <div class="rodape-coluna">
                <h4>Loja</h4>
                <a href="#">Produtos</a>
                <a href="#">Lançamentos</a>
                <a href="#">Promoções</a>
                <a href="#">Kits</a>
            </div>
            <div class="rodape-coluna">
                <h4>Suporte</h4>
                <a href="#">Sobre nós</a>
                <a href="#">Contato</a>
                <a href="#">Envios</a>
                <a href="#">Devoluções</a>
            </div>
            <div class="rodape-coluna">
                <h4>Atletas</h4>
                <a href="#">Programas Pro</a>
                <a href="#">Embaixadores</a>
                <a href="#">Eventos</a>
                <a href="#">Blog</a>
            </div>
        </div>
 
    </div>
 
    <div class="rodape-base">
        <span>© 2026 Primal X · Todos os direitos reservados</span>
        <div class="rodape-linhas">
            <i style="background:#ff2028"></i>
            <i style="background:#1765ff"></i>
            <i style="background:#00d85a"></i>
            <i style="background:#aab7bc"></i>
        </div>
    </div>
</footer>














</body>

</html>