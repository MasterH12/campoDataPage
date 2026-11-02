# CampoData · Landing Page

Sitio WordPress de CampoData. El repositorio solo guarda **código y configuración propios**: un tema de bloques (`campodata`), un plugin de funcionalidad (`campodata-core`), el entorno local en Docker y los scripts que lo instalan. El core de WordPress, los plugins de terceros, los archivos subidos y la base de datos no se versionan.

Las decisiones del proyecto, y cada vez que algo se aparta de una spec, están en [docs/DECISIONS.md](docs/DECISIONS.md). Las specs están en [specs/](specs/). El método de trabajo es el de `Clientes Web/FRAMEWORK-WORDPRESS.md`.

## Requisitos

- **Docker** y **Docker Compose** (probado con Docker 29 y Compose v5). WordPress, la base de datos y WP-CLI corren en contenedores: no hace falta instalar nada más.
- **curl**, que usa `bin/check`.
- **PHP 8.3 o superior y Composer 2**, solo para revisar el código con `composer lint`.

## Primer arranque

```bash
cp .env.example .env
# Completa en .env las tres contraseñas vacías: WP_ADMIN_PASSWORD, DB_PASSWORD y DB_ROOT_PASSWORD.
bin/setup
```

`bin/setup` levanta los contenedores, instala WordPress en español de Chile, configura el sitio, instala los plugins declarados, activa el tema, crea los datos de contacto iniciales y arma la portada con la landing. Al terminar muestra la URL (por defecto `http://localhost:8081`) y el usuario administrador. La contraseña es la de `.env`.

`bin/setup` se puede correr las veces que sea: no duplica nada ni borra contenido. Córrelo de nuevo después de cambiar `config/plugins*.txt` o `WP_PORT`, o si se cortó a medias.

Los scripts funcionan desde cualquier carpeta, por ejemplo `"<ruta>/Clientes Web/CampoData/LandingPage/bin/check"` (con comillas, por el espacio de `Clientes Web`).

El puerto 8080 es de Siete Colores: los dos sitios pueden estar levantados a la vez, cada uno con sus contenedores y volúmenes (proyectos de Compose `siete-colores` y `campodata`).

## Comandos del día a día

| Para | Comando |
| --- | --- |
| Levantar el sitio | `docker compose up -d` |
| Bajarlo (conserva los datos) | `docker compose down` |
| Usar WP-CLI | `bin/wp <comando>`, por ejemplo `bin/wp plugin list` |
| Verificar que todo está en orden | `bin/check` |
| Revisar el código PHP | `composer install` (la primera vez) y después `composer lint` |
| Corregir lo que se pueda de forma automática | `composer lint:fix` |
| Ver el log de errores de PHP | `docker compose exec wordpress tail -f wp-content/debug.log` |
| Empezar de cero | `bin/reset`: borra la base, el core, los plugins y los archivos subidos, y vuelve a instalar |

## Ramas y flujo de trabajo

El repositorio tiene su raíz en `LandingPage/` (no en `CampoData/`, `Clientes Web/` ni `~/Documents`). Si todavía no existe, se crea con los comandos de la spec 01, §4.1.

| Rama | Para qué |
| --- | --- |
| `prod` | Rama principal: lo que está, o estará, en producción |
| `testing` | Lo que se prueba antes de pasar a `prod` |
| `dev` | Desarrollo. Las specs se ejecutan aquí |
| `hotfix` | Arreglos urgentes sobre lo que está en `prod` |

El trabajo avanza `dev` → `testing` → `prod`. Un arreglo urgente se hace en `hotfix` a partir de `prod`, vuelve a `prod` y se lleva también a `testing` y `dev`.

## Dónde va cada cosa

```
bin/                          scripts: wp, setup, reset y check
config/plugins.txt            plugins de producción, con versión fija
config/plugins-dev.txt        plugins solo para el entorno local
config/contacto-inicial.json  datos de contacto con que bin/setup crea la opción (solo la primera vez)
docs/DECISIONS.md             decisiones del proyecto
docs/marca/                   el logo original (JPG) que entregó el cliente, de referencia
specs/                        specs numeradas
wp-content/themes/campodata/  tema de bloques: todo lo visual
├── theme.json                paleta, degradados, tipografías, tamaños, espaciados y valores propios
├── styles/                   estilos de sección (secciones/) y de bloque (bloques/) que solo usan theme.json
├── templates/, parts/        plantillas, encabezado y pie
├── patterns/                 landing.php y una sección por archivo
├── assets/fonts/             Sora y DM Sans (woff2) con sus licencias OFL
├── assets/images/            marca/ (emblema), ilustraciones/ (píxeles y panel), iconos/ y reportes/
├── assets/css/               sitio.css (todo el CSS propio) y editor.css (ajustes del editor)
├── assets/js/movimiento.js   el módulo de movimiento y el formulario de WhatsApp
├── inc/setup.php             patrones, estilos de bloque con CSS y el año del pie
└── inc/recursos.php          carga el CSS y el JS, el interruptor del movimiento y la precarga de tipografías
wp-content/mu-plugins/        plugin de funcionalidad: lo que no es visual
└── campodata-core/           seguridad.php, contacto.php y entorno-local.php
compose.yaml                  entorno local y versiones de WordPress, PHP, WP-CLI y MariaDB
```

`wp-content/` replica la estructura de WordPress: desplegar es copiar esas dos carpetas al servidor.

**Tema.** `theme.json` es la fuente única de los tokens de diseño: colores (ver [Identidad](#identidad)), tamaños de fuente (`x-small` a `xx-large`), espaciados (`20` a `80`) y valores propios en `settings.custom` (radios, movimiento, alto del encabezado y brillos), que el CSS usa como `--wp--custom--…`. En el código, el contenido y los patrones, los colores, tamaños y espaciados se usan **siempre por su token**, nunca con valores fijos: así, un cambio de marca solo cambia valores en `theme.json`. Quien edita contenido solo puede elegir entre esos tokens. Cada sección de la landing es un patrón en `patterns/`. Los textos van fijos, en español.

**Plugin de funcionalidad.** `campodata-core` es un plugin *must-use*: WordPress lo carga siempre y no se puede desactivar desde `wp-admin`. Ahí va lo que tiene que sobrevivir a un cambio de tema. Hoy tiene la seguridad básica (XML-RPC, versión de WordPress oculta, usuarios ocultos, sin emojis desde `s.w.org`), los [datos de contacto](#datos-de-contacto) y las protecciones del entorno local: el sitio local nunca se indexa ni envía correos, y los correos quedan anotados en `debug.log`.

### Qué vive en el código y qué en la base de datos

| Qué | Dónde vive | Fuente de verdad |
| --- | --- | --- |
| Core de WordPress | Imagen de Docker y volumen `wordpress_data` | `compose.yaml` |
| Diseño: `theme.json`, plantillas, partes y patrones | Repo (tema) | **El repo** |
| Funcionalidad propia | Repo (mu-plugin) | **El repo** |
| Plugins de terceros | Volumen | `config/plugins*.txt` |
| Configuración del sitio (idioma, zona horaria, enlaces, portada) | Base de datos | `bin/setup` |
| Contenido: páginas, textos e imágenes | Base de datos y `uploads` | La base (la de producción, cuando exista) |
| Cambios hechos en el **Editor del sitio** (plantillas, partes, estilos globales) | Base de datos | **Ninguna, hasta pasarlos al repo** |

**El contenido de la landing se edita en la página "Inicio"**, no en las plantillas. Hoy esa página solo inserta el patrón `campodata/landing`, así que muestra lo que digan los archivos de `patterns/`. Cuando alguien la abre en el editor y la guarda, el contenido de los patrones queda copiado en la página y desde ahí se edita en ella: los cambios posteriores a los archivos de `patterns/` ya no se ven. Mientras el diseño siga cambiando, conviene no guardar "Inicio" desde el editor.

## La landing

Es una sola página con siete secciones. `patterns/landing.php` las ordena y cada una es su propio patrón:

| # | Sección | Ancla | Patrón | Fondo |
| --- | --- | --- | --- | --- |
| 1 | Banner | `#inicio` | `campodata/banner` | Noche con brillo, retícula y campo de píxeles |
| 2 | Para quién | `#para-quien` | `campodata/para-quien` | Blanco |
| 3 | Cómo funciona | `#como` | `campodata/como-funciona` | Rocío |
| 4 | Reportes reales | `#reportes` | `campodata/reportes` | Noche con brillo |
| 5 | Beneficios | `#beneficios` | `campodata/beneficios` | Blanco |
| 6 | Por qué CampoData | `#porque` | `campodata/por-que` | Rocío |
| 7 | Solicitar demo | `#demo` | `campodata/demo` | Degradado del surco al marino |

- **Reordenar, agregar o quitar una sección:** edita la lista de `patterns/landing.php`. Una sección nueva es un archivo en `patterns/` con `Categories: campodata`, un `group` con `tagName` `section`, su ancla, su estilo de sección y una ceja (`<strong>NN</strong>Nombre` con el estilo `ceja`). Si cambia el orden de las anclas, actualiza `ANCLAS` en `bin/check`; si la sección va en el menú, agrega el enlace en `parts/header.html` y mide el encabezado entre 320 y 1500px (hoy el menú pasa al botón móvil bajo 861px).
- **Reemplazar una captura de Reportes:** revisa antes que no muestre nombres de terceros, y guárdala como WebP en `assets/images/reportes/` con el mismo nombre (1100 × 627 o el doble, 120 KB como máximo). `bin/check` falla si pesa más.
- **Sin terceros:** la web no nombra sistemas ni empresas ajenas (DairyPlan, Excel, Power BI, la planta que recibe la leche…), ni en textos ni dentro de las capturas. Para hablar de con qué trabaja CampoData, el mensaje es que se adapta a la tecnología y la maquinaria de cada predio (DECISIONS D21). `bin/check` falla si la portada nombra alguno; la lista está en el script.
- **Textos guía:** lo que está entre corchetes es contenido pendiente del cliente (hoy, lo propio de ganaderos y asesores). `bin/check` avisa cuántos quedan.

## Identidad

La paleta sale del logo nuevo (`docs/marca/logo-campodata.jpg`):

| Slug | Nombre | Valor | Uso |
| --- | --- | --- | --- |
| `base` | Blanco | `#FFFFFF` | Fondo claro |
| `contraste` | Tinta | `#0B2233` | Títulos y texto destacado sobre claro |
| `primario` | Marino | `#034A87` | La vaca y "Data" del logo: acción sobre fondo claro |
| `secundario` | Texto suave | `#4D5F6B` | Párrafos sobre claro |
| `acento` | Espiga | `#FCCB04` | La espiga del logo: acción sobre fondo oscuro |
| `suave` | Rocío | `#F3F7F2` | Fondo de las secciones alternas |
| `borde` | Borde | `#DCE6DA` | Líneas sobre claro |
| `noche` | Noche | `#061A2B` | Encabezado, pie y secciones oscuras |
| `bruma` | Bruma | `#B4C3CF` | Párrafos sobre noche |
| `cielo`, `brote`, `pradera`, `surco` | Partes del logo | `#53B0FD`, `#72C93C`, `#3A8D47`, `#106E53` | Píxeles, íconos, checks y detalles |

El degradado `marca` (espiga → brote → cielo) va solo en lo destacado del título, la barra de progreso, las cejas, la línea de Cómo funciona y la línea que crece bajo los botones.

**Combinaciones de texto permitidas** (WCAG 2.2, 4,5 : 1 o más): sobre `base` y `suave`, `contraste`, `primario`, `secundario` y `surco` (`pradera` solo en texto grande). Sobre `noche`, `base`, `acento`, `bruma`, `brote` y `cielo` (`pradera` solo en texto grande). Nunca `acento`, `cielo`, `brote` ni `bruma` como texto sobre fondo claro. Los botones: `acento` con texto `noche` (11,5 : 1) y `primario` con texto `base` (9 : 1).

**Tipografías:** Sora (títulos) y DM Sans (texto), servidas desde `assets/fonts/` (Fontsource 5.3.0, licencia OFL).

**Logo:** hoy el emblema es un recorte del JPG entregado (`assets/images/marca/emblema.webp`), y la palabra "CampoData" se escribe con Sora en dos colores. El SVG oficial y el ícono de la pestaña llegan en la spec 03.

## Movimiento

Todo es una mejora progresiva: sin JS, o con movimiento reducido en el sistema, el contenido se ve completo y en su estado final. Un script en el `<head>` agrega `cd-con-js` y, solo si el sistema no pide movimiento reducido, `cd-movimiento` al `<html>`; si el módulo no carga en 3 segundos, la quita.

| # | Efecto |
| --- | --- |
| M1 | Cada bloque de cada sección aparece al bajar (opacidad y 22px hacia arriba, 0,55s); las tarjetas, escalonadas |
| M2 | El campo de píxeles del banner y de la demo (animación dentro de `pixeles.svg`) |
| M3 | El degradado del título se desplaza en 8s |
| M4 | El banner entra escalonado al cargar |
| M5 | El panel se dibuja, flota y se inclina con el mouse hasta 6°; sus tarjetas aparecen después |
| M6 | Las cifras cuentan desde cero |
| M7 y M8 | Barra de progreso de lectura y cristal del encabezado al bajar |
| M9 | La línea de Cómo funciona se dibuja, enciende los pasos y la recorre un "paquete de datos" |
| M10 | Foco de luz que sigue al mouse en las tarjetas |
| M11 | "Quiero una demo" elige el perfil en el formulario |
| M12 | Reflejo en la ventana de Reportes y *fade* al cambiar de pestaña |
| M13 | El degradado del cierre se desplaza en 16s |
| M14 y M15 | Botones que suben con una línea de color; checks que se dibujan |

- Lo que se repite se pausa cuando su sección no está a la vista o la pestaña está oculta.
- Para excluir un bloque, agrégale la clase `sin-movimiento` (Avanzado → Clases CSS adicionales).
- **Probar con movimiento reducido:** en Chrome, DevTools → menú ⋮ → More tools → Rendering → "Emulate CSS media feature prefers-reduced-motion: reduce". **Probar sin JS:** DevTools → ⋮ → Run command → "Disable JavaScript". Sin JS, Reportes muestra las cuatro capturas una debajo de otra y el formulario no aparece.

## Datos de contacto

Se editan en **Ajustes → Datos de contacto** (WhatsApp, mensaje inicial, teléfono, correo, asunto del correo, zona, LinkedIn e Instagram) y se muestran solos en los botones y los datos de la sección "Solicitar demo", en el formulario de WhatsApp y en los íconos del pie. Una red sin URL no aparece. `bin/setup` crea la opción desde `config/contacto-inicial.json` solo si no existe: nunca pisa lo que se cambió en Ajustes. El formulario no envía nada a un servidor: arma el mensaje y abre WhatsApp.

## El Editor del sitio y Create Block Theme

Una plantilla o parte modificada en el Editor del sitio (Apariencia → Editor) se guarda en la base y **tapa** al archivo del tema: desde ese momento, los cambios al archivo no se ven en el sitio. Si se usa el Editor del sitio para diseñar:

1. Diseña en el Editor del sitio.
2. Pasa el resultado al tema. Con Create Block Theme (su menú en el Editor del sitio → "Guardar cambios en el tema"), que necesita permiso de escritura (ver [Permisos](#permisos-para-escribir-en-el-tema-desde-wordpress)), o copiando a mano el marcado de bloques al archivo de `templates/` o `parts/`.
3. **Borra la personalización** en la base: en Apariencia → Editor → Plantillas (o Partes), elige la plantilla y usa "Resetear". Si no, la base sigue tapando al archivo.
4. Corre `bin/check`: avisa si queda alguna plantilla o parte modificada en la base.

Los estilos globales cambiados en el Editor del sitio (colores, tipografías) también quedan en la base. Esos valores van en `theme.json`, no en el editor.

## Agregar un plugin de terceros

1. Escribe una entrada en `docs/DECISIONS.md`: para qué sirve, qué alternativas miraste y por qué no basta el core.
2. Agrega una línea `<slug> <versión>` en `config/plugins.txt` (producción) o en `config/plugins-dev.txt` (solo local). El slug es el de la URL en wordpress.org/plugins/.
3. Corre `bin/setup`, que lo instala con esa versión exacta y lo activa.

No instales plugins desde `wp-admin`: `bin/setup` avisa si encuentra uno no declarado y `bin/check` falla.

## Actualizar WordPress en local

1. Cambia la etiqueta de la imagen `wordpress` en `compose.yaml` (por ejemplo `wordpress:7.1.4-php8.4-apache`).
2. `docker compose pull` y `docker compose up -d`.
3. `bin/wp core update --version=<nueva>` y `bin/wp core update-db`.

La imagen solo copia el core cuando el volumen está vacío: por eso cambiar la etiqueta no basta. La otra vía es `bin/reset`, que borra todo el contenido local. `bin/setup` y `bin/check` avisan si la versión instalada no coincide con la de la imagen.

Las etiquetas de MariaDB y de WP-CLI también tienen versión exacta en `compose.yaml` y se actualizan del mismo modo: se cambia el número y se hace `docker compose pull`.

## Permisos para escribir en el tema desde WordPress

La carpeta del tema es de tu usuario, pero Apache corre en el contenedor con otro usuario (UID 33). Por eso WordPress puede leer el tema pero no escribirlo, y Create Block Theme no puede "Guardar cambios en el tema". Hay dos salidas:

- **Darle permiso de escritura a ese usuario**, sin `sudo` y sin cambiar el dueño de los archivos:

  ```bash
  setfacl -R -m u:33:rwX -m d:u:33:rwX wp-content/themes/campodata
  ```

  Se deshace con `setfacl -R -b wp-content/themes/campodata`.
- **Exportar el tema** como zip desde Create Block Theme y descomprimirlo sobre `wp-content/themes/campodata`.

Después de cualquiera de las dos, revisa con `git diff` qué cambió antes de hacer commit.

## Problemas conocidos

- **El puerto 8081 está ocupado.** Cambia `WP_PORT` en `.env` y corre `bin/setup`: actualiza las URLs del sitio sin reinstalar.
- **`bin/setup` se corta en el paso de plugins con "WordPress no pudo establecer una conexión segura a WordPress.org".** Es un corte de conexión con `api.wordpress.org`. Vuelve a correr `bin/setup`: retoma donde quedó.
- **WP-CLI imprime avisos `Deprecated` de Symfony Finder.** Salen a veces al terminar un comando que descarga algo (idiomas o plugins). Son internos de WP-CLI 2.12 con PHP 8.4 y no afectan el resultado.
- **Composer imprime muchos `Deprecation Notice`.** Pasa con Composer 2.5 sobre PHP 8.4 y tampoco afecta el resultado. Se quitan actualizando Composer, o se puede usar la imagen oficial: `docker run --rm -u "$(id -u):$(id -g)" -v "$PWD":/app composer:2 lint` (y `composer:2 install` la primera vez).
