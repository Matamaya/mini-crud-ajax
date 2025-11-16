<?php
declare(strict_types=1);

require_once __DIR__ . '/../auth.php';

cerrarSesion();

// Redirigir al login
header('Location: /auth/login.php');
exit;