<?php
require_once __DIR__ . '/../auth.php';
// Verificar que esté logueado
if (!usuarioLogueado()) {
    header('Location: /auth/login.php');
    exit;
}

// Si es admin, redirigir al CRUD
if (esAdministrador()) {
    header('Location: /index_ajax.php');
    exit;
}

$usuario = obtenerUsuarioLogueado();

require_once __DIR__ . '/includes/functions.php';
include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/form.php';
?> 
