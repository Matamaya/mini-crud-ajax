/** URL absoluta o relativa del endpoint PHP (API del servidor) */
const URL_API_SERVIDOR = "/api.php";

/** Elementos de la interfaz que necesitamos manipular */
const nodoCuerpoTablaUsuarios = document.getElementById("tbody");
const nodoFilaEstadoVacio = document.getElementById("fila-estado-vacio");
const formularioAltaUsuario = document.getElementById("formCreate");
const nodoZonaMensajesEstado = document.getElementById("msg");
const nodoBotonAgregarUsuario = document.getElementById("boton-agregar-usuario");
const nodoBotonCancelarEdicion = document.getElementById("cancel-edit");
const nodoIndicadorCargando = document.getElementById("indicador-cargando");

// Variables globales para controlar la edición
let editando = false;
let usuarioEditandoId = null;
let usuarioEditandoIndex = null;

// -----------------------------------------------------------------------------
// BLOQUE: Gestión de mensajes de estado
// -----------------------------------------------------------------------------
function mostrarMensajeDeEstado(tipoEstado, textoMensaje) {
  nodoZonaMensajesEstado.className = tipoEstado;
  nodoZonaMensajesEstado.textContent = textoMensaje;

  if (tipoEstado !== "") {
    setTimeout(() => {
      nodoZonaMensajesEstado.className = "";
      nodoZonaMensajesEstado.textContent = "";
    }, 2000);
  }
}

// -----------------------------------------------------------------------------
// BLOQUE: Indicador de carga
// -----------------------------------------------------------------------------
function activarEstadoCargando() {
  if (nodoBotonAgregarUsuario) nodoBotonAgregarUsuario.disabled = true;
  if (nodoIndicadorCargando) nodoIndicadorCargando.hidden = false;
}

function desactivarEstadoCargando() {
  if (nodoBotonAgregarUsuario) nodoBotonAgregarUsuario.disabled = false;
  if (nodoIndicadorCargando) nodoIndicadorCargando.hidden = true;
}

// -----------------------------------------------------------------------------
// BLOQUE: Sanitización de texto
// -----------------------------------------------------------------------------
function convertirATextoSeguro(entradaPosiblementePeligrosa) {
  return String(entradaPosiblementePeligrosa)
    .replaceAll("&", "&amp;")
    .replaceAll("<", "&lt;")
    .replaceAll(">", "&gt;")
    .replaceAll('"', "&quot;")
    .replaceAll("'", "&#39;");
}

// -----------------------------------------------------------------------------
// BLOQUE: Renderizado del listado de usuarios
// -----------------------------------------------------------------------------
function renderizarTablaDeUsuarios(arrayUsuarios) {
  nodoCuerpoTablaUsuarios.innerHTML = "";

  if (!Array.isArray(arrayUsuarios) || arrayUsuarios.length === 0) {
    nodoFilaEstadoVacio.hidden = false;
    return;
  }
  nodoFilaEstadoVacio.hidden = true;

  arrayUsuarios.forEach((usuario, posicionEnLista) => {
    const nodoFila = document.createElement("tr");
    nodoFila.innerHTML = `
            <td>${posicionEnLista + 1}</td>
            <td>${convertirATextoSeguro(usuario?.nombre ?? "")}</td>
            <td>${convertirATextoSeguro(usuario?.email ?? "")}</td>
            <td>${convertirATextoSeguro(usuario?.rol ?? "usuario")}</td>
            <td>
                <button
                    type="button"
                    data-id="${usuario?.id || ''}"
                    data-index="${posicionEnLista}"
                    class="btn-editar">
                    Editar
                </button>
                <button
                    type="button"
                    data-index="${posicionEnLista}"
                    class="btn-eliminar">
                    Eliminar
                </button>
            </td>
        `;
    nodoCuerpoTablaUsuarios.appendChild(nodoFila);
  });
}

// -----------------------------------------------------------------------------
// BLOQUE: Carga inicial y refresco del listado
// -----------------------------------------------------------------------------
async function obtenerYMostrarListadoDeUsuarios() {
  try {
    const respuestaHttp = await fetch(`${URL_API_SERVIDOR}?action=list`);
    const cuerpoJson = await respuestaHttp.json();

    if (!cuerpoJson.ok) {
      throw new Error(cuerpoJson.error || "No fue posible obtener el listado.");
    }

    renderizarTablaDeUsuarios(cuerpoJson.data);
  } catch (error) {
    mostrarMensajeDeEstado("error", error.message);
  }
}

// -----------------------------------------------------------------------------
// BLOQUE: Funciones para manejar la edición
// -----------------------------------------------------------------------------
function activarModoEdicion(usuario) {
  editando = true;
  usuarioEditandoId = usuario.id;
  usuarioEditandoIndex = usuario.index;
  
  // Llenar formulario con datos del usuario
  document.getElementById('campo-nombre').value = usuario.nombre || '';
  document.getElementById('campo-email').value = usuario.email || '';
  document.getElementById('campo-password').value = ''; // Dejar vacío por seguridad
  document.getElementById('campo-rol').value = usuario.rol || 'user';
  
  // Cambiar texto del botón y mostrar botón cancelar
  nodoBotonAgregarUsuario.textContent = 'Actualizar usuario';
  nodoBotonCancelarEdicion.classList.remove('hidden');
  
  // Enfocar el primer campo
  document.getElementById('campo-nombre').focus();
}

function desactivarModoEdicion() {
  editando = false;
  usuarioEditandoId = null;
  usuarioEditandoIndex = null;
  
  // Restaurar formulario
  formularioAltaUsuario.reset();
  nodoBotonAgregarUsuario.textContent = 'Agregar usuario';
  nodoBotonCancelarEdicion.classList.add('hidden');
}

// -----------------------------------------------------------------------------
// BLOQUE: Alta/Actualización de usuario
// -----------------------------------------------------------------------------
formularioAltaUsuario?.addEventListener("submit", async (evento) => {
  evento.preventDefault();
  const datosFormulario = new FormData(formularioAltaUsuario);
  
  const datosUsuario = {
    nombre: String(datosFormulario.get("nombre") || "").trim(),
    email: String(datosFormulario.get("email") || "").trim(),
    password: String(datosFormulario.get("password") || "").trim(),
    rol: String(datosFormulario.get("rol") || "user").trim(),
  };

  // Validación mínima en cliente
  if (!datosUsuario.nombre || !datosUsuario.email) {
    mostrarMensajeDeEstado("error", "Los campos Nombre y Email son obligatorios.");
    return;
  }

  try {
    activarEstadoCargando();

    let url, method, body;
    
    if (editando) {
      // Modo edición
      url = `${URL_API_SERVIDOR}?action=update`;
      method = "POST";
      body = JSON.stringify({
        ...datosUsuario,
        id: usuarioEditandoId
      });
    } else {
      // Modo creación
      url = `${URL_API_SERVIDOR}?action=create`;
      method = "POST";
      body = JSON.stringify(datosUsuario);
    }

    const respuestaHttp = await fetch(url, {
      method: method,
      headers: { "Content-Type": "application/json" },
      body: body,
    });

    const cuerpoJson = await respuestaHttp.json();

    if (!cuerpoJson.ok) {
      throw new Error(cuerpoJson.error || 
        (editando ? "No fue posible actualizar el usuario." : "No fue posible crear el usuario.")
      );
    }

    renderizarTablaDeUsuarios(cuerpoJson.data);
    
    if (editando) {
      mostrarMensajeDeEstado("ok", "Usuario actualizado correctamente.");
      desactivarModoEdicion();
    } else {
      mostrarMensajeDeEstado("ok", "Usuario agregado correctamente.");
      formularioAltaUsuario.reset();
    }
  } catch (error) {
    mostrarMensajeDeEstado("error", error.message);
  } finally {
    desactivarEstadoCargando();
  }
});

// -----------------------------------------------------------------------------
// BLOQUE: Manejo de eventos de la tabla (editar y eliminar)
// -----------------------------------------------------------------------------
nodoCuerpoTablaUsuarios?.addEventListener("click", async (evento) => {
  const target = evento.target;
  
  // Manejar edición
  const nodoBotonEditar = target.closest(".btn-editar");
  if (nodoBotonEditar) {
    const indexUsuario = parseInt(nodoBotonEditar.dataset.index, 10);
    const idUsuario = parseInt(nodoBotonEditar.dataset.id, 10);
    
    if (!Number.isInteger(indexUsuario)) return;
    
    try {
      const respuestaHttp = await fetch(`${URL_API_SERVIDOR}?action=list`);
      const cuerpoJson = await respuestaHttp.json();

      if (!cuerpoJson.ok) {
        throw new Error("No fue posible obtener los datos del usuario.");
      }

      const usuario = cuerpoJson.data[indexUsuario];
      if (usuario) {
        activarModoEdicion({
          ...usuario,
          index: indexUsuario
        });
      }
    } catch (error) {
      mostrarMensajeDeEstado("error", error.message);
    }
    return;
  }

  // Manejar eliminación (código existente)
  const nodoBotonEliminar = target.closest(".btn-eliminar");
  if (!nodoBotonEliminar) return;

  const posicionUsuarioAEliminar = parseInt(nodoBotonEliminar.dataset.index, 10);
  if (!Number.isInteger(posicionUsuarioAEliminar)) return;

  if (!window.confirm("¿Deseas eliminar este usuario?")) return;

  try {
    const respuestaHttp = await fetch(`${URL_API_SERVIDOR}?action=delete`, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ index: posicionUsuarioAEliminar }),
    });

    const cuerpoJson = await respuestaHttp.json();

    if (!cuerpoJson.ok) {
      throw new Error(cuerpoJson.error || "No fue posible eliminar el usuario.");
    }

    // Si estábamos editando el usuario que se eliminó, cancelar edición
    if (editando && usuarioEditandoIndex === posicionUsuarioAEliminar) {
      desactivarModoEdicion();
    }

    renderizarTablaDeUsuarios(cuerpoJson.data);
    mostrarMensajeDeEstado("ok", "Usuario eliminado correctamente.");
  } catch (error) {
    mostrarMensajeDeEstado("error", error.message);
  }
});

// -----------------------------------------------------------------------------
// BLOQUE: Cancelar edición
// -----------------------------------------------------------------------------
nodoBotonCancelarEdicion?.addEventListener("click", () => {
  desactivarModoEdicion();
  mostrarMensajeDeEstado("", ""); // Limpiar mensajes
});

// -----------------------------------------------------------------------------
// BLOQUE: Inicialización de la pantalla
// -----------------------------------------------------------------------------
obtenerYMostrarListadoDeUsuarios();