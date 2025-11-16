<?php
declare(strict_types=1);

session_start();

/**
 * Función para verificar credenciales de usuario
 */
function verificarCredenciales(string $email, string $password): array
{
    $rutaArchivoDatosJson = __DIR__ . '/data.json';
    
    if (!file_exists($rutaArchivoDatosJson)) {
        return ['success' => false, 'error' => 'No hay usuarios registrados | archivo no encontrado'];
    }

    $listaUsuarios = json_decode((string) file_get_contents($rutaArchivoDatosJson), true);
    
    if (!is_array($listaUsuarios)) {
        return ['success' => false, 'error' => 'Error en los datos de usuarios'];
    }

    $emailNormalizado = mb_strtolower(trim($email));

    foreach ($listaUsuarios as $usuario) {
        if (isset($usuario['email']) && mb_strtolower($usuario['email']) === $emailNormalizado) {
            // Verificar contraseña hasheada
            if (isset($usuario['password']) && password_verify($password, $usuario['password'])) {
                return [
                    'success' => true,
                    'usuario' => [
                        'id' => $usuario['id'] ?? null,
                        'nombre' => $usuario['nombre'] ?? '',
                        'email' => $usuario['email'] ?? '',
                        'rol' => $usuario['rol'] ?? 'user'
                    ]
                ];
            }
            break;
        }
    }

    return ['success' => false, 'error' => 'Credenciales incorrectas'];
}

/**
 * Función para verificar si el usuario está logueado
 */
function usuarioLogueado(): bool
{
    return isset($_SESSION['usuario_id']);
}

/**
 * Función para obtener datos del usuario logueado
 */
function obtenerUsuarioLogueado(): array
{
    return [
        'id' => $_SESSION['usuario_id'] ?? null,
        'nombre' => $_SESSION['usuario_nombre'] ?? '',
        'email' => $_SESSION['usuario_email'] ?? '',
        'rol' => $_SESSION['usuario_rol'] ?? 'user'
    ];
}

/**
 * Función para verificar si el usuario es administrador
 */
function esAdministrador(): bool
{
    return ($_SESSION['usuario_rol'] ?? '') === 'admin';
}

/**
 * Función para cerrar sesión
 */
function cerrarSesion(): void
{
    $_SESSION = [];
    session_destroy();
}