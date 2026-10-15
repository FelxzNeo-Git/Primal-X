<?php

require_once __DIR__ . '/config.php';


if (empty($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}


$usuario = null;
foreach (carregarUsuarios() as $u) {
    if ((int) ($u['id'] ?? 0) === (int) $_SESSION['usuario_id']) {
        $usuario = $u;
        break;
    }
}


if (!$usuario) {
    session_destroy();
    header('Location: login.php');
    exit;
}

$nome    = $usuario['nome']  ?? '';
$email   = $usuario['email'] ?? '';
$inicial = mb_strtoupper(mb_substr($nome, 0, 1));
$tipo    = !empty($usuario['admin']) ? 'Administrador' : 'Cliente';

if (!array_key_exists('localizacao', $usuario)) {
    $localizacao = 'Não informado';
} else {
    $localizacao = $usuario['localizacao'] ? 'Permitida' : 'Não permitida';
}


$dados = [
    'Nome'                   => $nome,
    'E-mail'                 => $email,
    'Localização para envio' => $localizacao,
    'Tipo de conta'          => $tipo,
];

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>PRIMAL X | Meu Perfil</title>

    
    <link rel="stylesheet" href="../css/perfil.css">

</head>

<body>

    <main class="perfil-pagina">

        
        <header>

           

            <h1 class="perfil-titulo">
                OLÁ,
                <span class="perfil-destaque">
                    <?php echo htmlspecialchars(explode(' ', trim($nome))[0]); ?>
                </span>
            </h1>

            <p class="perfil-texto">
                Confira os dados da sua conta no Primal X.
            </p>

        </header>


        
        <section class="perfil-card">

            <div class="perfil-avatar">
                <?php echo htmlspecialchars($inicial); ?>
            </div>

            <dl class="perfil-dados">

                <?php foreach ($dados as $rotulo => $valor): ?>
                    <div class="perfil-linha">
                        <dt><?php echo htmlspecialchars($rotulo); ?></dt>
                        <dd><?php echo htmlspecialchars($valor); ?></dd>
                    </div>
                <?php endforeach; ?>

            </dl>

        </section>


        
        <a href="../index.php" class="btn-voltar">
            VOLTAR À LOJA →
        </a>

        <hr class="perfil-divisor">

        <p class="perfil-sair">
            Não é você?
            <a href="login.php">Sair da conta →</a>
        </p>

    </main>

</body>

</html>