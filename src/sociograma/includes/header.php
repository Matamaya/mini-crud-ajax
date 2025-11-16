<?php
// Si venimos “de cero”, que existan $old_field y $errors vacíos:
$old_field = isset($old_field) ? $old_field : [];
$errors = isset($errors) ? $errors : [];

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sociograma</title>
  <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body class="container">
 <header class="encabezado-aplicacion">
    <h1 class="encabezado-aplicacion__titulo">
      Formulario - Sociograma
    </h1>
    
   <nav class="glass-nav">
      <div class="nav-container">
          <div class="nav-options">          
            <br>
            <a href="/auth/logout.php" class="glass-nav-links">Cerrar Sesión</a>
          </div>
      </div>
    </nav>
  </header>