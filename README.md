# PRACTICA MINI-CRUD AJAX 

## Objetivos

Construir un servidor PHP con Apache dentro de Docker.

  • Una página HTML con un formulario simple y una tabla.
  • Un archivo JavaScript que, usando fetch(), hablará con una API PHP.
  • La API PHP leerá y escribirá en un archivo JSON para “persistir” los datos.
  • Todo se recargará en pantalla sin refrescar la página (AJAX).

Modelo mental muy simple:

  • El navegador pide “cosas” a PHP (por URL) y PHP responde siempre en JSON.
  • GET ?action=list devuelve la lista completa.
  • POST ?action=create crea un elemento nuevo.
  • POST ?action=delete borra uno (en proyectos reales usaríamos DELETE, aquí lo simplificamos).

### Pruebas

### Iniciando bases del proyecto

Iniciando el Docker del proyecto
<img width="1252" height="538" alt="image" src="https://github.com/user-attachments/assets/29aa9ec0-f5d7-4ecc-8d53-3fcaa4f789e8" />

Abre http://localhost:8080 y comprueba la página “Parte 1”.
<img width="805" height="281" alt="aj3" src="https://github.com/user-attachments/assets/69c1f442-b178-46c8-9e85-986d15969999" />

Abre http://localhost:8080/index_ajax.html.
<img width="1870" height="577" alt="aj2" src="https://github.com/user-attachments/assets/46929fa8-d275-4320-bbe3-6c572991af49" />

Prueba la API: http://localhost:8080/api.php debe devolver 
{"ok":true,"message":"API en construcción"}
<img width="480" height="217" alt="aj1" src="https://github.com/user-attachments/assets/0645c465-116a-48e1-bc55-6127ce1651c6" />

Listar: http://localhost:8080/api.php?action=list
  • Si devuelven {"ok":true,"data":[]}, la API está viva.
<img width="487" height="165" alt="image" src="https://github.com/user-attachments/assets/a84d7154-4062-4b21-9a52-bc4fa59aa1b3" />


### Pruebas del Postman

1. Listar usuarios (GET)
  • Abre Postman y crea una nueva Request.
  • Selecciona el método GET.
  • Escribe la URL: http://localhost:8080/api.php?action=list
  • No añadas body ni headers.
  • Pulsa Send.
  
Resultado esperado:
{
 "ok": true,
 "data": []
}

<img width="863" height="495" alt="image" src="https://github.com/user-attachments/assets/7af24761-de97-4522-be0d-a7ee8eed100e" />


2. Crear usuario (POST)
  • Crea una nueva pestaña o request en Postman.
  • Selecciona POST.
  • Escribe la URL: http://localhost:8080/api.php?action=create
  • En la pestaña Headers, añade:
      Key Value
      Content-Type application/json
      <img width="842" height="332" alt="image" src="https://github.com/user-attachments/assets/37e0b734-5dda-4215-a777-c3ac0fd5c8b9" />

  • Ve a la pestaña Body:
      o Selecciona raw.
      o En el menú derecho, elige JSON.
      o Escribe el siguiente JSON:
      o {
      o "nombre": "Lara",
      o "email": "lara@example.com"
      o }
      • Pulsa Send.
      <img width="636" height="297" alt="image" src="https://github.com/user-attachments/assets/4dfe68bc-5f53-4c7b-8bb3-f2f55b01784d" />

      Respuesta esperada:
      {
       "ok": true,
       "data": [
       { "nombre": "Lara", "email": "lara@example.com" }
       ]
      }

      <img width="638" height="515" alt="image" src="https://github.com/user-attachments/assets/7200c5c0-0faf-4e0b-aa93-418a33fe86ca" />

En data.json aparecerá este usuario guardado.
<img width="383" height="187" alt="image" src="https://github.com/user-attachments/assets/df899e19-c9b9-472e-be90-20542c84c64a" />


### JavaScript con fetch
Abre http://localhost:8080/index_ajax.html.
  F12 → Consola: no debe haber errores de sintaxis.
<img width="1262" height="375" alt="image" src="https://github.com/user-attachments/assets/1b2df406-6fca-4330-9b38-6bdfc65e101f" />

Inspecciona la red (pestaña “Network”) y verás las llamadas a /api.php?action=list, create y delete.
  
  action=list
  <img width="732" height="300" alt="image" src="https://github.com/user-attachments/assets/bfa15a45-8ccc-4e6c-b867-ffd1a23cb2ab" />
  
  Create
  <img width="1065" height="271" alt="image" src="https://github.com/user-attachments/assets/4fd169d1-c1cc-4b31-871f-56587c938a72" />
  
  Delete
  <img width="1062" height="248" alt="image" src="https://github.com/user-attachments/assets/0d72624f-e092-4a70-8d4f-5097409b8206" />


### Mejora: accesibilidad, UX y validaciones adicionales

Intenta crear un usuario con un email inválido. Debe responder { ok:false, error:"..." }.
<img width="646" height="338" alt="image" src="https://github.com/user-attachments/assets/f23ee73c-1cb6-42d4-9d58-3a463de93882" />


Intenta crear el mismo email dos veces (distinto casing, por ejemplo TEST@X.COM y test@x.com). La segunda debe fallar con 409.
<img width="647" height="334" alt="aj16" src="https://github.com/user-attachments/assets/c2dcd0cc-163f-4f73-a900-d094284f5775" />

Mejoras visuales en el diseño 

<img width="1234" height="900" alt="aj17" src="https://github.com/user-attachments/assets/c2b9f330-efc9-491e-a5d9-03328462d28b" />



