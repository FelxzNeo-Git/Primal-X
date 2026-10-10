<?php
/**
 * Configuração geral + usuários.
 * As funções carregarUsuarios / salvarUsuarios / buscarUsuarioPorEmail / criarUsuario
 * mantêm a mesma assinatura do pacote de login; só o armazenamento mudou
 * (de $_SESSION para data/usuarios.json) para as contas não sumirem ao sair.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/includes/storage.php';

const ARQ_USUARIOS = DIR_DATA . '/usuarios.json';

/** Conta administradora criada na primeira execução. TROQUE a senha após o primeiro acesso. */
function usuarioAdminPadrao(): array
{
    return [
        'id'    => 1,
        'nome'  => 'Administrador',
        'email' => 'admin@empresa.com',
        'senha' => password_hash('admin123', PASSWORD_DEFAULT),
        'admin' => true,
    ];
}

function carregarUsuarios(): array
{
    if (!is_file(ARQ_USUARIOS)) {
        json_atualizar(ARQ_USUARIOS, [], fn(array $u) => $u ?: [usuarioAdminPadrao()]);
    }
    return json_ler(ARQ_USUARIOS);
}

function salvarUsuarios(array $usuarios): bool
{
    return json_atualizar(ARQ_USUARIOS, [], fn() => array_values($usuarios));
}

function buscarUsuarioPorEmail(string $email): ?array
{
    foreach (carregarUsuarios() as $usuario) {
        if (mb_strtolower($usuario['email']) === mb_strtolower($email)) {
            return $usuario;
        }
    }
    return null;
}

/** Cria o usuário e devolve false se o e-mail já existir (checagem feita dentro do lock). */
function criarUsuario(string $nome, string $email, string $senha, bool $localizacao = false): bool
{
    carregarUsuarios(); // garante o admin padrão antes de qualquer cadastro
    $criado = false;

    json_atualizar(ARQ_USUARIOS, [], function (array $usuarios) use ($nome, $email, $senha, $localizacao, &$criado) {
        $novoId = 1;
        foreach ($usuarios as $u) {
            if (mb_strtolower($u['email']) === mb_strtolower($email)) {
                return null;
            }
            $novoId = max($novoId, ($u['id'] ?? 0) + 1);
        }
        $usuarios[] = [
            'id'          => $novoId,
            'nome'        => $nome,
            'email'       => $email,
            'senha'       => password_hash($senha, PASSWORD_DEFAULT),
            'admin'       => false,
            'localizacao' => $localizacao,
        ];
        $criado = true;
        return $usuarios;
    });

    return $criado;
}
