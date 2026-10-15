<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>PRIMAL X</title>

    <link rel="stylesheet" href="../css/login.css">
</head>

<body>

    <div class="login">

        <!-- DESCRIÇÃO SUPERIOR -->
        <div class="tab">

            <h5 class="descricaopequena">
                ACESSO À SUA CONTA
            </h5>

            <!-- TÍTULO -->
            <h1 class="titulo1">
                BEM-VINDO
                <span class="neon-text">
                    DE VOLTA
                </span>
            </h1>

            <!-- DESCRIÇÃO -->
            <p class="textodescritivo1">
                Faça login para continuar sua jornada
                de adrenalina.
            </p>

        </div>

        <div class="tab-underline"></div>


        <!-- MENSAGEM DE ERRO -->
        <?php if (!empty($_SESSION['erro'])): ?>

            <p style="color:#d33; text-align:center; margin-bottom:1rem; font-weight:bold;">

                <?php
                echo htmlspecialchars($_SESSION['erro']);
                unset($_SESSION['erro']);
                ?>

            </p>

        <?php endif; ?>


        <!-- MENSAGEM DE SUCESSO -->
        <?php if (!empty($_SESSION['sucesso'])): ?>

            <p style="color:#2a2; text-align:center; margin-bottom:1rem; font-weight:bold;">

                <?php
                echo htmlspecialchars($_SESSION['sucesso']);
                unset($_SESSION['sucesso']);
                ?>

            </p>

        <?php endif; ?>


        <!-- FORMULÁRIO -->
        <form method="POST" action="processar_login.php">

            <!-- E-MAIL -->
            <label for="email">
                E-MAIL OU USUÁRIO
            </label>

            <input
                type="email"
                id="email"
                name="email"
                placeholder="E-MAIL OU USUÁRIO"
                required
            >


            <!-- SENHA -->
            <label for="senha">
                SENHA
            </label>

            <input
                type="password"
                id="senha"
                name="senha"
                placeholder="SENHA"
                required
            >


            <!-- LEMBRAR / ESQUECI -->
            <div class="opcoes-login">

                <label class="lembrar">
                    <input type="checkbox" name="lembrar">
                    Lembrar de mim
                </label>

                <div class="esquece_senha">
                    <a href="#">
                        Esqueceu sua senha?
                    </a>
                </div>

            </div>


            <!-- BOTÃO -->
            <button type="submit" class="btn-acessar">
                ENTRAR →
            </button>

        </form>


        <!-- DIVISOR -->
        <hr class="divider">


        <!-- GOOGLE -->
        <button type="button" class="btn-google">
            G&nbsp;&nbsp; ENTRAR COM GOOGLE
        </button>


        <!-- CADASTRO -->
        <div class="signup">

            Não tem uma conta?

            <a href="./cadastro.php">
                Cadastre-se agora →
            </a>

        </div>

    </div>

</body>

</html>