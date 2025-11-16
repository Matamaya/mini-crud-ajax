<?php

// json_decode() // convierte json en un array 
// json_encode() // convierte un array en un json

/* Cargar un archivo JSON y devolverlo como array */
function load_json(string $path): array {
    if (!file_exists($path)) {
        return []; // si no existe, devolvemos array vacío
    }
    $raw = file_get_contents($path);
    $data = json_decode($raw, true);
    return is_array($data) ? $data : [];
}

/* Guardar un array en un archivo JSON */
function save_json(string $path, array $data): bool {
    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    return file_put_contents($path, $json) !== false;
}

/* Escapar texto para imprimirlo en HTML sin riesgo */
function e(?string $value): string {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

//Helpers de rehidratación (includes/functions.php)

// Devuelve el valor anterior del campo si existe (rehidratación)
function old_field($name, $source = []) {
     // devolvemos lo que escribió el usuario
    // si no había nada, devolvemos vacío
    return isset($source[$name]) ? $source[$name] : "";
}

// Devuelve el error de un campo si existe
function field_error($name, $errors = []){
    return isset($errors[$name]) ? '<p class="error">' . $errors[$name] . "</p>" : "";
    // si no hay error, no mostramos nada, si hay error muestra un mensaje en rojo
}

?>