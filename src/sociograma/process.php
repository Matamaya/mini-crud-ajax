<?php
require __DIR__ . '/includes/functions.php';

// 1) Aceptamos solo POST. Si no, volvemos al formulario.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

// 2) Recogemos las respuestas del formulario en un array asociativo
$input = [
    'nombre' => trim($_POST['nombre'] ?? ''),
    'apellido' => trim($_POST['apellido'] ?? ''),
    'grupo' => trim($_POST['grupo'] ?? ''),
    'email' => trim($_POST['email'] ?? ''),
    'telefono' => trim($_POST['telefono'] ?? ''),
    'fecha_nacimiento' => trim($_POST['fecha_nacimiento'] ?? ''),
    'hora' => trim($_POST['hora'] ?? ''),
    'color_favorito' => trim($_POST['color_favorito'] ?? ''),
    'experiencia' => trim($_POST['experiencia'] ?? ''),
    'nivel_estudio' => trim($_POST['nivel_estudio'] ?? ''),
    'idiomas' => $_POST['idiomas'] ?? [],
    'lenguaje_fav' => trim($_POST['lenguaje_fav'] ?? ''),
    'habilidades' => trim($_POST['habilidades'] ?? ''),
    'estresLvl' => trim($_POST['estresLvl'] ?? ''),
    'proyecto_favorito' => trim($_POST['proyecto_favorito'] ?? ''),
    'fav_partner' => trim($_POST['fav_partner'] ?? ''),
    'sec_partner' => trim($_POST['sec_partner'] ?? ''),
    'foe_partner' => trim($_POST['foe_partner'] ?? ''),
    'motivo' => trim($_POST['motivo'] ?? ''),
    'rol_fav' => trim($_POST['rol_fav'] ?? ''),
];

// 3) Validar (muy básico)
$errors = [];
if (strlen($input['nombre']) < 3 || strlen($input['nombre']) > 25) {
    $errors['nombre'] = 'El nombre debe tener al menos 3 caracteres y máximo 25.';
}
if (strlen($input['apellido']) < 3 || strlen($input['apellido']) > 50) {
    $errors['apellido'] = 'El apellido debe tener al menos 3 caracteres y máximo 50';
}
if (empty($input['grupo'])) {
    $errors['grupo'] = 'Debes seleccionar un grupo.';
}

if (!filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'El correo electrónico no es válido.';
}
if (!isset($input['fecha_nacimiento']) || $input['fecha_nacimiento'] === '') {
    $errors['fecha_nacimiento'] = 'Debes indicar tu fecha de nacimiento.';
}

if (!isset($input['experiencia']) || $input['experiencia'] === '' ) {
    $errors['experiencia'] = ' Debe indicar su experiencia.';
}

if (!isset($input['nivel_estudio']) || $input['nivel_estudio'] === '') {
    $errors['nivel_estudio'] = 'Debes seleccionar un nivel de estudio.';
}

if (empty($input['fav_partner'])) {
    $errors['fav_partner'] = 'Debes indicar su compañero favorito.';
}

if (empty($input['foe_partner'])) {
    $errors['foe_partner'] = 'Debes indicar su compañero menos favorito.';
}


// 4) Si hay errores: rehidratar (volver a index con $old_field y $errors)
if ($errors) {
    // IMPORTANTE: definimos $old_field y $errors antes de incluir index.php
    $old_field = $input;
    include __DIR__ . '/index.php';
    // Reutilizamos el mismo index para no duplicar el formulario:
    // truco simple: hacemos include del formulario “central”
    // Si prefieres, puedes extraer el <form> a partials/form.php y requerirlo aquí.
    exit;
}

// 5) Si todo está bien: guardar en JSON y confirmar
$file = __DIR__ . '/data/sociograma.json';
$todo = load_json($file);
$registro = [
    'nombre' => $input['nombre'],
    'apellido' => $input['apellido'],
    'grupo' => $input['grupo'],
    'email' => $input['email'],
    'telefono' => $input['telefono'],
    'fecha_nacimiento' => $input['fecha_nacimiento'],
    'hora' => $input['hora'],
    'color_favorito' => $input['color_favorito'],
    'experiencia' => $input['experiencia'],
    'nivel_estudio' => $input['nivel_estudio'],
    'idiomas' => $input['idiomas'],
    'lenguaje_fav' => $input['lenguaje_fav'],
    'habilidades' => $input['habilidades'],
    'estresLvl' => $input['estresLvl'],
    'proyecto_favorito' => $input['proyecto_favorito'],
    'fav_partner' => $input['fav_partner'],
    'sec_partner' => $input['sec_partner'],
    'foe_partner' => $input['foe_partner'],
    'motivo' => $input['motivo'],
    'rol_fav' => $input['rol_fav'],
    'fecha' => date('Y-m-d H:i:s')
];

$todo[] = $registro;
if (!save_json($file, $todo)) {
    http_response_code(500);
    echo 'Error guardando los datos. Inténtalo más tarde.';
    exit;
}

// 6) Confirmación muy simple

// Mostrar éxito

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/success.php';
?>

