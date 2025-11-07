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


Docker Compose

-
-
-
-
-
