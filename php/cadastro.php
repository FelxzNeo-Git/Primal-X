<?php

require_once 'config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>PRIMAL X | Criar Conta</title>

    <!-- Mesmo estilo visual da página de login -->
    <link rel="stylesheet" href="../css/cadastro.css">

</head>

<body>

    <div class="login cadastro">

        <!-- CABEÇALHO -->
        <div class="tab">

            <h5 class="descricaopequena">
                CRIE SUA CONTA GRATUITAMENTE
            </h5>

            <h1 class="titulo1">
                FAÇA PARTE DO
                <span class="neon-text">PRIMAL X</span>
            </h1>

            <p class="textodescritivo1">
                Crie sua conta gratuitamente e tenha acesso
                aos nossos produtos e recursos exclusivos.
            </p>

        </div>


        <!-- MENSAGEM DE ERRO -->
        <?php if (!empty($_SESSION['erro'])): ?>
            <p class="msg msg-erro">
                <?php
                    echo htmlspecialchars($_SESSION['erro']);
                    unset($_SESSION['erro']);
                ?>
            </p>
        <?php endif; ?>


        <!-- MENSAGEM DE SUCESSO -->
        <?php if (!empty($_SESSION['sucesso'])): ?>
            <p class="msg msg-sucesso">
                <?php
                    echo htmlspecialchars($_SESSION['sucesso']);
                    unset($_SESSION['sucesso']);
                ?>
            </p>
        <?php endif; ?>


        <!-- FORMULÁRIO DE CADASTRO -->
        <form method="POST" action="processar_cadastro.php">

            <!-- Os labels ficam ocultos pelo CSS (.login form > label), como no login.
                 Mantidos no HTML por acessibilidade. -->

            <label for="nome">NOME</label>
            <input
                type="text"
                id="nome"
                name="nome"
                placeholder="SEU NOME"
                required
                minlength="2"
                maxlength="100"
                autocomplete="name"
            >

            <label for="email">E-MAIL</label>
            <input
                type="email"
                id="email"
                name="email"
                placeholder="SEU E-MAIL"
                required
                maxlength="150"
                autocomplete="email"
            >

            <label for="senha">SENHA</label>
            <input
                type="password"
                id="senha"
                name="senha"
                placeholder="SUA SENHA"
                required
                minlength="6"
                maxlength="100"
                autocomplete="new-password"
            >

            <label for="confirmar_senha">CONFIRMAR SENHA</label>
            <input
                type="password"
                id="confirmar_senha"
                name="confirmar_senha"
                placeholder="CONFIRME SUA SENHA"
                required
                minlength="6"
                maxlength="100"
                autocomplete="new-password"
            >


            <!-- PERMISSÃO DE LOCALIZAÇÃO -->
            <div class="localizacao-card">

                <p class="localizacao-titulo">
                    Podemos acessar sua localização para facilitar o envio dos produtos?
                </p>

                <p class="localizacao-aviso">
                    Você poderá alterar essa preferência posteriormente.
                </p>

                <div class="localizacao-opcoes">

                    <label>
                        <input
                            type="radio"
                            name="permitir_localizacao"
                            value="sim"
                            required
                        >
                        SIM
                    </label>

                    <label>
                        <input
                            type="radio"
                            name="permitir_localizacao"
                            value="nao"
                            required
                        >
                        NÃO
                    </label>

                </div>

            </div>


            <!-- BOTÃO -->
            <button type="submit" class="btn-acessar">
                CRIAR CONTA →
            </button>

        </form>


        <!-- DIVISOR -->
        <hr class="divider">


        <!-- LINK PARA LOGIN -->
        <div class="signup">
            Já possui uma conta?
            <a href="./login.php">Entrar agora →</a>
        </div>

    </div>

</body>

</html>