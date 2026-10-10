<?php
require_once __DIR__ . '/php/config.php';

// Sair
if (isset($_GET['logout'])) {
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $p = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
    }
    session_destroy();
    header('Location: php/login.php');
    exit;
}

// Visitante sem login vai para a tela de login; logado vê a home.
if (empty($_SESSION['usuario_id'])) {
    header('Location: php/login.php');
    exit;
}

include __DIR__ . '/php/home.php';
