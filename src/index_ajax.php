<?php
require_once __DIR__ . '/auth.php';

// Verificar que esté logueado
if (!usuarioLogueado()) {
    header('Location: /auth/login.php');
    exit;
}

// Si NO es admin, redirigir al sociograma
if (!esAdministrador()) {
    header('Location: /sociograma/index.php');
    exit;
}

$usuario = obtenerUsuarioLogueado();
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <title>Mini CRUD AJAX</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="/assets/css/styles.css" />
</head>

<body>
  <header class="encabezado-aplicacion">
    <h1 class="encabezado-aplicacion__titulo">
      CRUD - Administrador
    </h1>
    
   <nav class="glass-nav">
      <div class="nav-container">
          <div class="nav-options">          
            <strong>Usuario Activo:  <?= htmlspecialchars($usuario['nombre']) ?></strong>
            <br>
            <a href="/auth/logout.php" class="glass-nav-links">Cerrar Sesión</a>
          </div>
      </div>
    </nav>
  </header>

  <main class="zona-principal" id="zona-principal" tabindex="-1">
    <!-- Zona de mensajes (con aria-live para lectores de pantalla) -->
    <div id="msg" class="mensajes-estado" role="status" aria-live="polite" aria-atomic="true"></div>

    <!-- Formulario de alta de usuario con etiquetas asociadas y atributos de ayuda -->
    <section class="bloque-formulario" aria-labelledby="titulo-formulario">
      <h2 id="titulo-formulario">Agregar nuevo usuario</h2>

      <form id="formCreate" class="formulario-alta-usuario" autocomplete="on" novalidate>
        <div class="form-row">
          <label for="campo-nombre" class="form-label">Nombre</label>
          <input id="campo-nombre" name="nombre" class="form-input" type="text" required minlength="2" maxlength="60"
            placeholder="Ej.: Ana Pérez" autocomplete="name" inputmode="text" />
        </div>

        <div class="form-row">
          <label for="campo-email" class="form-label">Email</label>
          <input id="campo-email" name="email" class="form-input" type="email" required maxlength="120"
            placeholder="ejemplo@correo.com" autocomplete="email" inputmode="email" />
        </div>

        <div class="form-row">
          <label for="campo-password" class="form-label">Contraseña</label>
          <input id="campo-password" name="password" class="form-input" type="password" required minlength="4"
            placeholder="Contraseña123" autocomplete="new-password" />
        </div>

        <div class="form-row">
          <label for="campo-rol" class="form-label">Rol</label>
          <select id="campo-rol" name="rol" class="glass-select">
            <option value="user">Usuario</option>
            <option value="admin">Administrador</option>
          </select>
        </div>

        <div class="form-actions">
          <button id="boton-agregar-usuario" type="submit" class="boton-primario">
            Agregar usuario
          </button>
          <button type="button" id="cancel-edit" class="boton-primario hidden">Cancelar Edición</button>
        </div>
      </form>
    </section>

    <!-- Listado de usuarios -->
    <section class="bloque-listado" aria-labelledby="titulo-listado">
      <h2 id="titulo-listado">Listado de usuarios</h2>

      <div class="tabla-contenedor" role="region" aria-labelledby="titulo-listado">
        <table class="tabla-usuarios">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Nombre</th>
              <th scope="col">Email</th>
              <th scope="col">Rol</th>
              <th scope="col">Acciones</th>
            </tr>
          </thead>
          <tbody id="tbody">
            <!-- Fila de estado vacío (se alterna desde JS) -->
            <tr id="fila-estado-vacio" class="fila-estado-vacio" hidden>
              <td colspan="4">
                <em>No hay usuarios registrados todavía.</em>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </section>
  </main>

  <script src="/assets/js/main.js" defer></script>
</body>

</html>