<?php
declare(strict_types=1);

require_once __DIR__ . '/../auth.php';

// Si ya está logueado, redirigir según su rol
if (usuarioLogueado()) {
    if (esAdministrador()) {
        header('Location: /index_ajax.php');
    } else {
        header('Location: /sociograma/index.php');
    }
    exit;
}

// Procesar login
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (!empty($email) && !empty($password)) {
        $resultado = verificarCredenciales($email, $password);
        
        if ($resultado['success']) {
            // Iniciar sesión
            $_SESSION['usuario_id'] = $resultado['usuario']['id'];
            $_SESSION['usuario_nombre'] = $resultado['usuario']['nombre'];
            $_SESSION['usuario_email'] = $resultado['usuario']['email'];
            $_SESSION['usuario_rol'] = $resultado['usuario']['rol'];
            
            // Redirigir según rol
            if ($resultado['usuario']['rol'] === 'admin') {
                header('Location: /index_ajax.php');
            } else {
                header('Location: /sociograma/index.php');
            }
            exit;
        } else {
            $error = $resultado['error'];
        }
    } else {
        $error = 'Por favor, completa todos los campos';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body style="display: flex; justify-content: center;">
    <div class="login-container">
        <h1 style="text-align: center; margin-bottom: 2rem;">Iniciar Sesión</h1>
        
        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <form method="POST" class="login-form">
            <div class="form-row">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required 
                       value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
            </div>
            
            <div class="form-row">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" class="login-button">Iniciar Sesión</button>
        </form>
        
        <div class="footer">
            <small>¿No tienes cuenta? <a href="#" onclick="alert('Contacta al administrador para crear una cuenta')">Solicitar acceso</a></small>
        </div>
    </div>
</body>
</html>