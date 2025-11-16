   
    <div class="glass-success" style="text-align: center; max-width: 600px; margin: 2rem auto;">
        <h2>¡Gracias, <?= htmlspecialchars($input['nombre']) ?>!</h2>
        <p>Tu respuesta se ha guardado correctamente.</p>
        <p>Total de respuestas recogidas: <strong><?= count($todo) ?></strong></p>
        
        <div style="margin: 2rem 0;">
            <a href="index.php" class="glass-button">Volver al formulario</a>
        </div>
        
    </div>