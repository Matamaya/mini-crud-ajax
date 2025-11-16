  
  <form method="POST" action="process.php" novalidate>

    <div class="questions-container">
      <!-- Sección Información Personal -->
      <fieldset id="personal_info" class="glass-card">
        <h1>Información Personal</h1>

        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required minlength="2" maxlength="25" value="<?= old_field('nombre', $old_field) ?>" class="glass-input">
        <?= field_error('nombre', $errors) ?>

        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" required minlength="3" maxlength="50" value="<?= old_field('apellido', $old_field) ?>">
        <?= field_error('apellido', $errors) ?>

        <label for="grupo">Grupo:</label>
        <select id="grupo" name="grupo" required class="glass-select">
          <option value="">Seleccionar...</option>
          <option value="daw1" <?= (old_field('grupo', $old_field) == 'daw1') ? 'selected' : '' ?>>DAW 1</option>
          <option value="daw2" <?= (old_field('grupo', $old_field) == 'daw2') ? 'selected' : '' ?>>DAW 2</option>
        </select>
        <?= field_error('grupo', $errors) ?>

        <label for="email">Correo electrónico:</label>
        <input type="email" id="email" name="email" required value="<?= old_field('email', $old_field) ?>">
        <?= field_error('email', $errors) ?>

        <label for="telefono">Número de teléfono:</label>
        <input type="tel" id="telefono" name="telefono" pattern="[0-9]{9}" placeholder="123456789" class="glass-input">

        <label for="fecha_nacimiento">Fecha de nacimiento:</label>
        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required class="glass-date" value="<?= old_field('fecha_nacimiento', $old_field) ?>">
        <?= field_error('fecha_nacimiento', $errors) ?>

        <label for="hora">Hora favorita:</label>
        <input type="time" id="hora" name="hora" class="glass-time">


        <label for="color_favorito">Color favorito:</label>
        <input type="text" id="color_favorito" name="color_favorito">

      </fieldset>

      <!-- Sección Experiencia y Habilidades -->
      <fieldset id="skills" class="glass-card">
        <h1>Experiencia y Habilidades</h1>

        <label for="experiencia">Años de experiencia:</label>
        <input type="number" id="experiencia" name="experiencia" min="0" max="50" required value="<?= old_field('experiencia', $old_field) ?>">
        <?= field_error('experiencia', $errors) ?>

        <label for="nivel_estudio">Nivel de estudio:</label>
        <select id="nivel_estudio" name="nivel_estudio" class="glass-select" required>
          <option value="">Seleccione</option>
          <option value="primaria" <?= old_field('nivel_estudio', $old_field) == 'primaria' ? 'selected' : '' ?>>Primaria</option>
          <option value="secundaria" <?= old_field('nivel_estudio', $old_field) == 'secundaria' ? 'selected' : '' ?>>Secundaria</option>
          <option value="universidad" <?= old_field('nivel_estudio', $old_field) == 'universidad' ? 'selected' : '' ?>>Universidad</option>
          <option value="postgrado" <?= old_field('nivel_estudio', $old_field) == 'postgrado' ? 'selected' : '' ?>>Postgrado</option>
        </select>
        <?= field_error('nivel_estudio', $errors) ?>


        <h4 for="idiomas">Idiomas que hablas:</h4>
        <div class="form-idiomas">
          <div class="idioma">
            <label for="ingles">Inglésㅤ</label>
            <input type="checkbox" id="ingles" name="idiomas[]" value="ingles" class="glass-checkbox">
          </div>

          <div class="idioma">
            <label for="español">Español</label>
            <input type="checkbox" id="español" name="idiomas[]" value="espanol" class="glass-checkbox">
          </div>

          <div class="idioma">
            <label for="frances">Francés</label>
            <input type="checkbox" id="frances" name="idiomas[]" value="frances" class="glass-checkbox">
          </div>

        </div>

        <label for="lenguaje_fav">Lenguaje preferido:</label>
        <select id="lenguaje_fav" name="lenguaje_fav" class="glass-select">
          <option value="">Seleccione uno</option>
          <option value="js">Javascript</option>
          <option value="python">Python</option>
          <option value="java">Java</option>
          <option value="php">PHP</option>
        </select>

        <label for="habilidades">Habilidades destacadas:</label>
        <select id="habilidades" name="habilidades" class="glass-select">
          <option value="">Seleccione una</option>
          <option value="comunicacion">Comunicación</option>
          <option value="liderazgo">Liderazgo</option>
          <option value="tecnologia">Tecnología</option>
          <option value="creatividad">Creatividad</option>
        </select>

        <label for="estresLvl">Nivel de estres: <span id="valorRango"></span></label>
        <input type="range" id="estresLvl" name="estresLvl" class="glass-range" min="0" max="100" value="50">


        <label for="proyecto_favorito">Proyecto favorito realizado:</label>
        <input type="text" id="proyecto_favorito" name="proyecto_favorito">

      </fieldset>

      <!-- Sección Preferencias Laborales -->
      <fieldset id="preferences" class="glass-card">
        <h1>Preferencias Colaborativas</h1>

        <label for="fav_partner">¿Quién es tu compañero de trabajo favorito?</label>
        <input type="text" id="fav_partner" name="fav_partner" required value="<?= old_field('fav_partner', $old_field) ?>">
        <?= field_error('fav_partner', $errors) ?>

        <label for="sec_partner">¿Con quién más te gusta trabajar?</label>
        <input type="text" id="sec_partner" name="sec_partner">

        <label for="foe_partner">¿Con quién prefieres NO trabajar?</label>
        <input type="text" id="foe_partner" name="foe_partner" required value="<?= old_field('foe_partner', $old_field) ?>">
        <?= field_error('foe_partner', $errors) ?>

        <label for="motivo">Motivos de Preferencia:</label>
        <textarea id="motivo" name="motivo" rows="3" maxlength=300></textarea>

        <label for="rol_fav">Rol preferido:</label>
        <select id="rol_fav" name="rol_fav" class="glass-select" required>
          <option value="">Seleccione una</option>
          <option value="frontend">Front-End Dev</option>
          <option value="backend">Back-End Dev</option>
          <option value="disenador">Diseñador</option>
          <option value="gestor_servidores">Gestor de Servidores</option>
        </select>
      </fieldset>

    </div>
    <button type="submit" class="glass-button" style="margin-top: 3rem;">Enviar</button>
  </form>
