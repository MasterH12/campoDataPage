# Spec 01 · Inicialización del proyecto WordPress

**Proyecto:** CampoData · Landing Page (WordPress 7.1.3, PHP 8.4, MariaDB 11.8, Docker Compose)
**Alcance de esta spec:** dejar un proyecto WordPress que se reproduce desde cero con un solo comando. Incluye el entorno local en contenedores, un tema de bloques propio con sus tokens de diseño en `theme.json`, un plugin de funcionalidad propio, los scripts de instalación y verificación, el control de calidad del código y la documentación. No incluye el diseño ni el contenido final, que llegan en las specs siguientes.
**Rama de trabajo:** `dev`
**Base:** `Clientes Web/FRAMEWORK-WORDPRESS.md` (§5). Es la spec 01 estándar, con las lecciones de Siete Colores ya incorporadas.
**Versión:** 1 · 2026-10-28

### Historial de decisiones

| Versión | Cambio confirmado |
| --- | --- |
| v1 | Se generó desde el framework y la spec 01 de Siete Colores, con sus cambios C01 a C11 y la desactivación de los emojis (D16) incorporados desde el inicio. A pedido del usuario, se ejecutó en la misma sesión, antes de que existiera el repositorio (§4.1). Durante la ejecución se corrigió cómo se apagan los estilos de los emojis (§8 y DECISIONS D13), antes del primer commit. Los supuestos están en §16 |

---

## 0. Instrucciones para la IA que ejecute esta spec

1. Lee el documento completo y `Clientes Web/FRAMEWORK-WORDPRESS.md` antes de escribir el primer archivo.
2. **Git lo maneja el usuario.** No hagas `git init`, `git commit` ni `git push`, no crees ni cambies ramas y no agregues archivos al stage. Si el repositorio ya existe, trabaja en `dev`: si la rama actual es otra, detente y pídele al usuario que la cambie (etapa 0 de §13). Al terminar cada etapa, deja los cambios en el árbol de trabajo y sugiere el mensaje de commit.
3. **Regla central:** el repositorio solo contiene **código y configuración propios**. Nunca versiones el core de WordPress, plugins o temas de terceros, archivos subidos (`uploads`), volcados de base de datos ni secretos.
4. **Todo se reproduce con `bin/setup`.** Ningún paso de la instalación puede depender de clics en `wp-admin`. Si algo necesita configurarse, va en el script.
5. No instales nada en el host: ni `sudo`, ni `apt`, ni WP-CLI global. Todo corre en contenedores. PHP 8.4 y Composer 2 ya existen en el host y solo se usan para las herramientas de calidad (§11).
6. La ruta del proyecto tiene un espacio (`Clientes Web`). Cita siempre las rutas en los scripts y prueba cada script desde otra carpeta.
7. Si una versión, imagen o API no coincide con lo descrito, prioriza la documentación oficial vigente, resuelve y deja una entrada en `docs/DECISIONS.md` con este formato: qué decía la spec, qué hiciste y por qué.
8. Hay cinco **riesgos de ejecución** (§12), cada uno con su plan B. Si uno bloquea, aplica el plan B y sigue.
9. No toques lo que está fuera de alcance (§3).
10. Al terminar, verifica uno por uno los criterios de la sección 14 y reporta el resultado.

---

## 1. Punto de partida

| Pieza | Estado actual |
| --- | --- |
| `Clientes Web/CampoData/LandingPage/` | Vacía, salvo `specs/` con esta spec |
| Git | Todavía no hay repositorio en `LandingPage/`: lo crea el usuario (§4.1). La carpeta queda anidada dentro de un repositorio que abarca todo `~/Documents` (sin commits). **Ese repositorio no se toca** |
| Docker | Docker 29 y Docker Compose v5 instalados, con las imágenes de §5.1 ya descargadas (las usa Siete Colores) |
| PHP y Composer en el host | PHP 8.4 y Composer 2.5 |
| Otros sitios locales | Siete Colores usa el puerto 8080 y el proyecto de Compose `siete-colores` |
| WP-CLI en el host | No existe, y no se instala: se usa la imagen oficial |

---

## 2. Decisiones

| Tema | Decisión | Alternativa descartada |
| --- | --- | --- |
| Estructura del proyecto | **WordPress estándar.** El repo versiona solo el tema propio, el plugin de funcionalidad, la configuración del entorno y los scripts. El core lo pone la imagen de Docker | **Bedrock**, donde Composer gestiona el core y los plugins y el *document root* pasa a `web/`. Exige cambiar el *document root* y correr Composer en el servidor, algo que muchos hostings compartidos no permiten. Como el código propio queda aislado, se puede migrar después sin reescribirlo |
| Entorno local | **Docker Compose** con las imágenes oficiales `wordpress`, `mariadb` y `wordpress:cli`, con versiones exactas en `compose.yaml` | `@wordpress/env` (más simple, pero esconde la configuración y depende de Node); LocalWP (no se puede reproducir desde el repo) |
| Versiones | **WordPress 7.1.3**, **PHP 8.4** en local, **WP-CLI 2.12.0** y **MariaDB 11.8.9** (LTS). Viven **solo** en `compose.yaml` | Etiquetas flotantes (`latest`, `7.1`, `cli-php8.4`): cada máquina terminaría con una versión distinta |
| Compatibilidad PHP del código | El código propio debe correr en **PHP 8.3 o superior** (`Requires PHP: 8.3`), aunque el entorno local use 8.4 | Exigir 8.4: limita los hostings posibles sin ganar nada hoy |
| Tipo de tema | **Tema de bloques propio, desde cero** (`campodata`): plantillas HTML de bloques, `theme.json` como fuente única de los tokens de diseño y patrones en PHP | Tema clásico (sin Editor del sitio ni `theme.json` completo); tema hijo de un tema por defecto (depende de actualizaciones ajenas y hereda estilos que habría que anular) |
| Constructor de páginas | **Ninguno.** Editor de bloques nativo, con patrones propios | Elementor, Divi u otros: encierran el contenido en su formato, pesan en rendimiento y atan el sitio al plugin |
| Dónde vive el contenido de la landing | En una **página "Inicio"** asignada como portada. Las plantillas solo arman la estructura (encabezado, contenido y pie) | Contenido escrito dentro de `front-page.html`: obliga a editar la landing desde el Editor del sitio y mezcla diseño con contenido |
| Tokens de diseño | **Slugs semánticos** para los colores (`base`, `contraste`, `primario`, `secundario`, `acento`, `suave`), para que un cambio de marca solo cambie valores y no el contenido. Tamaños de fuente y espaciados con los slugs estándar de WordPress (`small`…`xx-large`, `20`…`80`), por compatibilidad con los bloques del core | Slugs por nombre de color (`verde`, `azul`): un cambio de marca deja el contenido con nombres falsos |
| Libertad del editor de contenido | Quien edite contenido solo elige entre los tokens del tema: sin selector de color libre ni tamaños de fuente libres. Se puede revisar si el cliente lo pide | Valores libres: con el tiempo el sitio pierde consistencia visual |
| Patrones | Solo los del tema. Se desactivan los patrones del core y los remotos del directorio de WordPress | Dejar los del core: llenan el insertador de diseños ajenos a la marca |
| Funcionalidad propia | **Plugin *must-use*** (`mu-plugins/campodata-core`). Lo que no es presentación vive ahí, para que sobreviva a un cambio de tema | Todo en `functions.php` del tema |
| Plugins de terceros | Declarados y con versión fija en `config/plugins.txt` (producción) y `config/plugins-dev.txt` (solo local). Cada plugin nuevo necesita una entrada en `docs/DECISIONS.md` | Instalarlos a mano desde `wp-admin` |
| Idioma y textos | `es_CL` y `America/Santiago`. **Los textos del código van fijos, en español**, sin funciones de traducción | Funciones de traducción: el sitio apunta solo a Chile y las plantillas HTML de bloques ni siquiera las admiten (Siete Colores C02) |
| Paso de compilación (Node) | **Ninguno en esta spec.** Se agrega `@wordpress/scripts` cuando haga falta el primer bloque propio | Montar la compilación ahora, sin nada que compilar |
| Tipografías | Por ahora, la pila de fuentes del sistema. Las fuentes de la marca (spec 02) se servirán **desde el tema** con `fontFace` de `theme.json` | Google Fonts por CDN (privacidad y rendimiento) |
| Recursos de terceros | **Ninguno.** La portada no pide nada a dominios externos: se desactivan los emojis de WordPress, que se cargan desde `s.w.org` | Dejar los emojis del core |
| Calidad del código | **PHPCS con WordPress Coding Standards** vía Composer | Sin linter |

---

## 3. Alcance

### Dentro de alcance

- Estructura del repositorio, `.gitignore`, `.editorconfig` y `.env.example`.
- Entorno local con Docker Compose: WordPress, MariaDB y WP-CLI.
- Scripts `bin/wp`, `bin/setup`, `bin/reset` y `bin/check`.
- Tema de bloques `campodata` con `theme.json` provisional, plantillas, partes y un patrón provisional de portada.
- Plugin *must-use* `campodata-core` con seguridad básica y protecciones del entorno local.
- Política de plugins de terceros, con los dos plugins de desarrollo.
- PHPCS con WordPress Coding Standards.
- `README.md` y `docs/DECISIONS.md`.

### Fuera de alcance (no lo hagas)

- Crear el repositorio git o sus ramas (§4.1).
- Identidad visual: colores, tipografías y logo definitivos (spec 02).
- Secciones y contenido de la landing.
- Formularios y envío de correos (SMTP).
- SEO, analítica, cookies y política de privacidad.
- Caché y optimización de rendimiento.
- Despliegue, hosting, dominio, HTTPS y copias de seguridad.
- Multilenguaje.
- Bloques propios y cualquier compilación con Node.
- Plugins de terceros para producción: `config/plugins.txt` queda vacío.
- CI (GitHub Actions u otro).

---

## 4. Estructura del proyecto

```
LandingPage/
├── specs/
│   └── 01-spec-inicializacion-wordpress.md
├── bin/
│   ├── wp                      # WP-CLI dentro del contenedor
│   ├── setup                   # instala o actualiza el sitio local (idempotente)
│   ├── reset                   # borra el entorno local y lo recrea
│   └── check                   # verificación rápida del sitio local
├── config/
│   ├── plugins.txt             # plugins de producción (vacío en esta spec)
│   └── plugins-dev.txt         # plugins solo para desarrollo local
├── docs/
│   └── DECISIONS.md
├── wp-content/
│   ├── themes/
│   │   └── campodata/          # tema propio (§7)
│   └── mu-plugins/
│       ├── campodata-core.php
│       └── campodata-core/     # plugin de funcionalidad (§8)
├── compose.yaml
├── composer.json               # solo herramientas de calidad (§11)
├── composer.lock
├── phpcs.xml.dist
├── .env.example
├── .editorconfig
├── .gitignore
└── README.md
```

`wp-content/` replica la estructura de WordPress para que el despliegue sea copiar esas dos carpetas al servidor, sea cual sea el hosting.

**`.gitignore`** (como mínimo): `.env`, `/vendor/`, `/node_modules/`, `*.log`, `*.sql`, `*.sql.gz`, `/wp-content/uploads/`, `/wp-content/plugins/`, `/backups/`.

**`.editorconfig`:** tabulaciones en PHP, JS, CSS, HTML y JSON (estándar de WordPress); 2 espacios en YAML; 4 espacios en `composer.lock`, que Composer siempre genera así; finales de línea LF; UTF-8.

### 4.1 Repositorio git

La raíz del repositorio es `LandingPage/`, no `CampoData/`, ni `Clientes Web/`, ni `~/Documents`. **Lo crea el usuario.** Como esta spec se ejecutó antes de que existiera el repositorio, el primer commit de `prod` lleva solo la spec, y el resto entra en `dev`:

```bash
cd "<ruta>/Clientes Web/CampoData/LandingPage"
git init -b prod
git add specs/01-spec-inicializacion-wordpress.md
git commit -m "docs(specs): spec 01 inicializacion del proyecto wordpress"
git branch hotfix
git branch testing
git switch -c dev
```

| Rama | Para qué |
| --- | --- |
| `prod` | Rama principal: lo que está, o estará, en producción |
| `testing` | Lo que se prueba antes de pasar a `prod` |
| `dev` | Desarrollo. Las specs se ejecutan aquí |
| `hotfix` | Arreglos urgentes sobre lo que está en `prod` |

El flujo es `dev` → `testing` → `prod`. Un arreglo urgente se hace en `hotfix` a partir de `prod`, vuelve a `prod` y se lleva también a `testing` y `dev`.

---

## 5. Entorno local (Docker Compose)

### 5.1 Servicios

| Servicio | Imagen | Rol |
| --- | --- | --- |
| `db` | `mariadb:11.8.9` | Base de datos. Datos en el volumen `db_data`. Sin puerto publicado |
| `wordpress` | `wordpress:7.1.3-php8.4-apache` | Sitio en `http://localhost:${WP_PORT}`, publicado **solo en `127.0.0.1`**. Core en el volumen `wordpress_data`; tema y mu-plugins montados desde el repo |
| `wpcli` | `wordpress:cli-2.12.0-php8.4` | WP-CLI. Perfil `cli`: no arranca con `docker compose up`, se usa con `bin/wp` |

### 5.2 `compose.yaml` de referencia

```yaml
name: campodata

x-wordpress-env: &wordpress-env
  WORDPRESS_DB_HOST: db
  WORDPRESS_DB_NAME: ${DB_NAME}
  WORDPRESS_DB_USER: ${DB_USER}
  WORDPRESS_DB_PASSWORD: ${DB_PASSWORD}
  WORDPRESS_DEBUG: "1"
  WORDPRESS_CONFIG_EXTRA: |
    define( 'WP_ENVIRONMENT_TYPE', 'local' );
    define( 'WP_DEBUG_LOG', true );
    define( 'WP_DEBUG_DISPLAY', false );
    define( 'SCRIPT_DEBUG', true );
    define( 'DISALLOW_FILE_EDIT', true );
    define( 'AUTOMATIC_UPDATER_DISABLED', true );
    define( 'WP_POST_REVISIONS', 20 );
    define( 'WP_DEVELOPMENT_MODE', 'theme' );

x-wordpress-volumes: &wordpress-volumes
  - wordpress_data:/var/www/html
  - ./wp-content/themes/campodata:/var/www/html/wp-content/themes/campodata
  - ./wp-content/mu-plugins:/var/www/html/wp-content/mu-plugins

services:
  db:
    image: mariadb:11.8.9
    environment:
      MARIADB_DATABASE: ${DB_NAME}
      MARIADB_USER: ${DB_USER}
      MARIADB_PASSWORD: ${DB_PASSWORD}
      MARIADB_ROOT_PASSWORD: ${DB_ROOT_PASSWORD}
    volumes:
      - db_data:/var/lib/mysql
    healthcheck:
      test: ["CMD", "healthcheck.sh", "--connect", "--innodb_initialized"]
      interval: 5s
      timeout: 5s
      retries: 20

  wordpress:
    image: wordpress:7.1.3-php8.4-apache
    depends_on:
      db:
        condition: service_healthy
    ports:
      - "127.0.0.1:${WP_PORT:-8081}:80"
    environment: *wordpress-env
    volumes: *wordpress-volumes

  wpcli:
    image: wordpress:cli-2.12.0-php8.4
    profiles: ["cli"]
    user: "33:33"
    depends_on:
      db:
        condition: service_healthy
    environment:
      <<: *wordpress-env
      WP_CLI_CACHE_DIR: /tmp/wp-cli-cache
    volumes: *wordpress-volumes

volumes:
  db_data:
  wordpress_data:
```

Puntos que no se pueden cambiar sin dejarlo en DECISIONS:

- **`name: campodata`** fija el nombre del proyecto de Compose. Así, sus contenedores y volúmenes no chocan con los de otro cliente.
- **`user: "33:33"` en `wpcli`.** La imagen de WP-CLI usa para `www-data` otro UID que la de Apache (33). Sin esto, WP-CLI crea archivos que Apache no puede escribir.
- **`WP_CLI_CACHE_DIR`.** Con el UID 33 no hay carpeta personal (`HOME=/`), y WP-CLI no puede crear su caché en `/.wp-cli/cache`.
- **`WP_DEBUG` se activa con `WORDPRESS_DEBUG`, no con un `define`.** El `wp-config.php` de la imagen ya define `WP_DEBUG` a partir de esa variable, antes de `WORDPRESS_CONFIG_EXTRA`. Un segundo `define` se ignora y genera un aviso en cada comando de WP-CLI.
- **`WP_DEVELOPMENT_MODE` en `theme`.** Sin esta constante, WordPress guarda en caché la lista de patrones del tema y no registra un patrón nuevo hasta que esa caché vence.
- **`wpcli` recibe las mismas variables que `wordpress`.** `wp-config.php` lee la base de datos y `WORDPRESS_CONFIG_EXTRA` del entorno en cada ejecución.
- **Solo `127.0.0.1`:** el sitio local no queda expuesto a la red.
- Sin política `restart`: los contenedores no arrancan solos al prender el equipo.

### 5.3 Variables de entorno (`.env`, no versionado)

`.env.example` se versiona con todas las variables y sin secretos reales.

| Variable | Ejemplo | Uso |
| --- | --- | --- |
| `WP_PORT` | `8081` | Puerto local. La URL del sitio es `http://localhost:${WP_PORT}`. El 8080 es de Siete Colores |
| `WP_ADMIN_USER` | `cd-admin` | Administrador local. **Nunca `admin`** |
| `WP_ADMIN_PASSWORD` | *(vacío)* | Obligatoria; `bin/setup` se detiene si falta |
| `WP_ADMIN_EMAIL` | `dev@example.com` | |
| `DB_NAME` | `campodata` | |
| `DB_USER` | `campodata` | |
| `DB_PASSWORD` | *(vacío)* | Obligatoria |
| `DB_ROOT_PASSWORD` | *(vacío)* | Obligatoria |

Las versiones, el idioma, la zona horaria y el título del sitio **no** van en `.env`: son datos del proyecto, no de cada máquina.

### 5.4 Constantes de `wp-config.php` en local

| Constante | Valor | Por qué |
| --- | --- | --- |
| `WP_ENVIRONMENT_TYPE` | `local` | El mu-plugin activa las protecciones del entorno local con esto (§8) |
| `WP_DEBUG` / `WP_DEBUG_LOG` / `WP_DEBUG_DISPLAY` | `true` / `true` / `false` | Errores al log (`wp-content/debug.log`, dentro del volumen), no en pantalla |
| `SCRIPT_DEBUG` | `true` | Carga los JS y CSS del core sin minificar |
| `DISALLOW_FILE_EDIT` | `true` | Nadie edita el tema ni los plugins desde `wp-admin`: el código vive en el repo |
| `AUTOMATIC_UPDATER_DISABLED` | `true` | La versión local es la de `compose.yaml`, no la que WordPress descargue por su cuenta |
| `WP_POST_REVISIONS` | `20` | Limita las revisiones guardadas |
| `WP_DEVELOPMENT_MODE` | `theme` | Los patrones nuevos del tema se registran sin esperar a que venza la caché |

Las claves y *salts* las genera la imagen oficial al crear `wp-config.php`. No van en `.env`.

---

## 6. Scripts (`bin/`)

Reglas comunes:

- Bash con `set -euo pipefail`. Cada script hace `cd "$(dirname "$0")/.."` (con comillas) y funciona desde cualquier carpeta.
- Mensajes en español. Si un paso falla, el mensaje dice qué hacer.
- Ejecutables (`chmod +x`).

### 6.1 `bin/wp`

Pasa los argumentos a WP-CLI en el contenedor: `docker compose --progress quiet --profile cli run --rm wpcli wp "$@"`. Pide una terminal (TTY) solo si la entrada **y** la salida estándar son terminales; si no, agrega `-T`. Con TTY, Docker agrega un retorno de carro a cada línea, y los valores que los scripts capturan dejan de coincidir.

### 6.2 `bin/setup`

Instala el sitio o lo pone al día. **Es idempotente:** correrlo dos veces seguidas no duplica nada, no falla y no borra contenido. Cada comando de WP-CLI recibe la URL global (`--url`), y las consultas de sí o no (`is-installed`, `is-active`) se hacen sin stderr.

| # | Paso | Detalle |
| --- | --- | --- |
| 1 | Validar `.env` | Si no existe, se detiene y pide copiar `.env.example`. Si falta una variable obligatoria (§5.3), se detiene y la nombra. Rechaza `admin` como usuario |
| 2 | Levantar servicios | `docker compose up -d --wait` |
| 3 | Esperar `wp-config.php` | Lo crea el contenedor `wordpress` al arrancar. Espera hasta 60 s; si no aparece, se detiene |
| 4 | Instalar (solo la primera vez) | Si `wp core is-installed` falla: `wp core install` con título "CampoData", URL, usuario, contraseña y correo del `.env`, y `--skip-email`. **Solo en esta primera instalación**, borra el post "Hola, mundo" y la "Página de ejemplo" (no toca el borrador de la política de privacidad) |
| 5 | Ajustar la URL | Si `siteurl` no coincide con `http://localhost:${WP_PORT}`, corre `wp search-replace` de la URL anterior a la nueva con `--skip-columns=guid`. Así, cambiar el puerto no obliga a reinstalar |
| 6 | Idioma | Instala `es_CL` y lo activa fijando la opción `WPLANG`. Sin internet, avisa y sigue en inglés |
| 7 | Opciones | `timezone_string=America/Santiago`, `date_format=d-m-Y`, `time_format=H:i`, `start_of_week=1`, `default_comment_status=closed`, `default_ping_status=closed`, `blog_public=0` |
| 8 | Enlaces permanentes | Estructura `/%postname%/` y `wp rewrite flush` |
| 9 | Plugins | Borra `akismet` y `hello` si existen. Instala y activa los de `config/plugins.txt` y, en local, los de `config/plugins-dev.txt`, con la versión indicada. Si hay plugins instalados que no están declarados, **avisa sin borrarlos**. Al final, instala las traducciones de los plugins |
| 10 | Tema | Activa `campodata`. De los temas del core (`twenty*`), conserva solo el tema por defecto (`WP_DEFAULT_THEME`) como respaldo y borra los demás. Un tema que no venga del core no se toca |
| 11 | Portada | Si no existe una página con slug `inicio`, la crea publicada, con título "Inicio" y contenido `<!-- wp:pattern {"slug":"campodata/inicio-provisional"} /-->`. Asigna `show_on_front=page` y `page_on_front` a esa página |
| 12 | Versión del core | Compara `wp core version` con la versión de la imagen, que se lee de `/usr/src/wordpress/wp-includes/version.php` en el contenedor `wordpress` (la imagen ya no define `WORDPRESS_VERSION`). Si difieren, avisa y muestra cómo actualizar (§10) |
| 13 | Resumen | Muestra la URL del sitio, la de `wp-admin` y el usuario |

Formato de `config/plugins*.txt`: una línea por plugin, `<slug> <versión>`. Las líneas vacías y las que empiezan con `#` se ignoran.

### 6.3 `bin/reset`

Borra el entorno local completo (`docker compose --profile cli down --volumes --remove-orphans`: base de datos, core y archivos subidos) y corre `bin/setup`. Pide confirmación escribiendo `si`, salvo que reciba `--yes`. No toca nada del repo.

### 6.4 `bin/check`

Verificación rápida del sitio local. Termina con código distinto de 0 si algo falla:

- El sitio está instalado y la versión del core coincide con la de la imagen.
- `wp core verify-checksums` pasa.
- `campodata` es el tema activo y `theme.json` es JSON válido.
- Los plugins instalados son exactamente los declarados, **con su versión** (si no, falla y los nombra).
- El mu-plugin `campodata-core` está cargado.
- La portada responde 200 y su HTML trae `lang="es-CL"`.
- Una URL inexistente (`/pagina-que-no-existe/`) responde 404 con la plantilla `404.html` del tema. Esto comprueba los enlaces permanentes y la plantilla a la vez.
- La portada no pide recursos (scripts, estilos, imágenes, iframes) a dominios externos, ni a `s.w.org`, y no trae el script ni los estilos de los emojis.
- **Avisa, sin fallar,** si la base tiene plantillas o partes del tema modificadas desde el Editor del sitio. Son cambios que no están en el repo (§10).

---

## 7. Tema `campodata`

### 7.1 Archivos

```
wp-content/themes/campodata/
├── style.css              # solo la cabecera del tema; los estilos van en theme.json
├── theme.json
├── functions.php          # solo carga los archivos de inc/
├── inc/
│   └── setup.php
├── templates/
│   ├── index.html
│   ├── front-page.html
│   ├── page.html
│   └── 404.html
├── parts/
│   ├── header.html
│   └── footer.html
├── patterns/
│   └── inicio-provisional.php
├── styles/                # variaciones de estilo (vacía por ahora, con .gitkeep)
├── assets/
│   ├── fonts/             # (vacía, con .gitkeep)
│   └── images/            # (vacía, con .gitkeep)
└── screenshot.png         # 1200×900, sacada de la portada (§12, R5)
```

Cabecera de `style.css`: `Theme Name: CampoData`, `Description`, `Version: 0.1.0`, `Requires at least: 7.0`, `Tested up to: 7.1`, `Requires PHP: 8.3`, `License: GPL-2.0-or-later`, `License URI` y `Text Domain: campodata`. Sin `Author`, que es opcional (Siete Colores C08).

El PHP del tema usa el *namespace* `CampoData\Tema`.

### 7.2 `theme.json`

Esquema `https://schemas.wp.org/wp/7.1/theme.json` y `"version": 3`. Si el core trae una versión de esquema más nueva, úsala y anótalo en DECISIONS.

**Los valores son provisionales:** paleta en escala de grises y pila de fuentes del sistema, para que se note que la identidad visual todavía no existe. La spec 02 reemplaza los valores; **los slugs no cambian**.

```jsonc
{
  "settings": {
    "appearanceTools": true,
    "useRootPaddingAwareAlignments": true,
    "layout": { "contentSize": "720px", "wideSize": "1200px" },
    "color": {
      "custom": false, "customGradient": false,
      "defaultPalette": false, "defaultGradients": false, "defaultDuotone": false,
      "palette": [ /* base, contraste, primario, secundario, acento, suave */ ]
    },
    "typography": {
      "fluid": true, "customFontSize": false, "defaultFontSizes": false,
      "fontFamilies": [ /* texto, titulos: pila del sistema */ ],
      "fontSizes": [ /* small, medium, large, x-large, xx-large, con tamaños fluidos */ ]
    },
    "spacing": {
      "defaultSpacingSizes": false, "customSpacingSize": false,
      "spacingSizes": [ /* 20, 30, 40, 50, 60, 70, 80 */ ]
    }
  },
  "styles": { /* fondo base, texto contraste, enlaces y botones primario, títulos con la familia titulos */ },
  "templateParts": [
    { "name": "header", "title": "Encabezado", "area": "header" },
    { "name": "footer", "title": "Pie de página", "area": "footer" }
  ]
}
```

En el código, el contenido y los patrones, los colores, tamaños y espaciados se referencian **siempre por su token**, nunca con valores fijos.

### 7.3 Plantillas y partes

| Archivo | Contenido |
| --- | --- |
| `parts/header.html` | Título del sitio (bloque `site-title`). Sin menú todavía |
| `parts/footer.html` | "© año" y el nombre del sitio. El año sale de la fuente de *block bindings* `campodata/anio` (§7.5); el texto del HTML es solo el respaldo |
| `templates/front-page.html` | `header` + `<main>` con el bloque `post-content` de la página de portada + `footer`. Sin título de página |
| `templates/page.html` | Igual a `front-page.html`, pero con el título de la página |
| `templates/index.html` | Respaldo obligatorio de un tema de bloques: `header` + `query` simple + `footer` |
| `templates/404.html` | `header` + el mensaje "Página no encontrada", con un enlace a la portada (`/`) + `footer` |

### 7.4 Patrones

`patterns/inicio-provisional.php`, con cabecera `Title`, `Slug: campodata/inicio-provisional`, `Categories: campodata` y `Description`. Contiene una sección con el nombre del sitio y el texto "Sitio en construcción", usando solo los tokens del tema. Los textos van fijos, en español.

Las secciones reales de la landing serán patrones en esta misma carpeta, en las specs siguientes.

### 7.5 `inc/setup.php`

- Registra la categoría de patrones `campodata` ("CampoData").
- Quita los patrones del core (`remove_theme_support( 'core-block-patterns' )`) y desactiva los remotos (filtro `should_load_remote_block_patterns`).
- Registra la fuente de *block bindings* `campodata/anio`, que entrega "© <año actual>". Con textos fijos, un año escrito en el HTML quedaría desactualizado cada 1 de enero.
- Nada más: sin CSS ni JS propios todavía.

---

## 8. Plugin de funcionalidad (`mu-plugins`)

WordPress solo carga los archivos PHP de la **raíz** de `mu-plugins`, así que hay un cargador:

```
wp-content/mu-plugins/
├── campodata-core.php       # cabecera del plugin y require de los archivos de abajo
└── campodata-core/
    ├── seguridad.php
    └── entorno-local.php
```

*Namespace* `CampoData\Core`. Cada archivo empieza con `defined( 'ABSPATH' ) || exit;`. Sin `Author` en la cabecera.

**`seguridad.php`** (todos los entornos):

| Medida | Cómo |
| --- | --- |
| XML-RPC desactivado | Filtro `xmlrpc_enabled` → `false`, que solo apaga los métodos con autenticación. Además, filtro `xmlrpc_methods` para quitar `pingback.ping` y `pingback.extensions.getPingbacks` |
| No publicar la versión de WordPress | Quita `wp_generator` de `wp_head` y vacía el filtro `the_generator` |
| Sin recursos de terceros | Quita `print_emoji_detection_script` de `wp_head` y `print_emoji_styles` de `wp_print_styles`, y vacía `emoji_svg_url`. Los emojis de WordPress se cargan desde `s.w.org`. **No** quites `wp_enqueue_emoji_styles`: es la función que desengancha `print_emoji_styles`, y sin ella los estilos se imprimen igual y cada visita anota un aviso `Deprecated` (DECISIONS D13) |
| No revelar usuarios por la REST API | Si no hay sesión iniciada, quita las rutas `/wp/v2/users` y `/wp/v2/users/(?P<id>[\d]+)` (filtro `rest_endpoints`). El editor sigue funcionando porque se usa con sesión |
| No revelar usuarios por `?author=N` ni por los archivos de autor | Responde 404 en las páginas de autor y en `?author=N`. Se engancha en `template_redirect` con prioridad 5, **antes** de `redirect_canonical`: si no, WordPress redirige a `/author/<usuario>/` y revela el nombre |
| No revelar usuarios en el sitemap ni en oEmbed | Quita el proveedor `users` de los sitemaps del core (`wp_sitemaps_add_provider`) y el nombre y la URL del autor de las respuestas de oEmbed (`oembed_response_data`) |

**`entorno-local.php`** (solo si `wp_get_environment_type() === 'local'`). Sirve para cuando se traiga a local una base de producción:

| Medida | Cómo |
| --- | --- |
| El sitio local nunca se indexa | Filtro `pre_option_blog_public` → `0` |
| El sitio local nunca envía correos | Filtro `pre_wp_mail`: no envía y anota destinatario y asunto en el log de depuración |

---

## 9. Plugins de terceros

- **Producción** (`config/plugins.txt`): vacío en esta spec, solo con un comentario que explica el formato.
- **Desarrollo** (`config/plugins-dev.txt`), instalados solo en local, con la última versión estable al momento de ejecutar:

| Plugin | Para qué |
| --- | --- |
| `create-block-theme` | Pasar al tema los cambios hechos en el Editor del sitio (§10) |
| `query-monitor` | Depurar consultas, hooks y errores de PHP |

Regla para el futuro: agregar un plugin de producción exige una entrada en `docs/DECISIONS.md` (para qué, qué alternativas se miraron y por qué no basta el core) y su línea con versión en `config/plugins.txt`.

---

## 10. Qué vive en el código y qué en la base de datos

| Qué | Dónde vive | Fuente de verdad |
| --- | --- | --- |
| Core de WordPress | Imagen de Docker / volumen `wordpress_data` | `compose.yaml` |
| Diseño: `theme.json`, plantillas, partes, patrones | Repo (tema) | **Repo** |
| Funcionalidad propia | Repo (mu-plugin) | **Repo** |
| Plugins de terceros | Volumen | `config/plugins*.txt` |
| Configuración del sitio (idioma, zona horaria, enlaces, portada) | Base de datos | `bin/setup` |
| Contenido: páginas, textos, imágenes | Base de datos y `uploads` | La base (la de producción, cuando exista) |
| Cambios hechos en el **Editor del sitio** (plantillas, partes, estilos globales) | Base de datos (`wp_template`, `wp_template_part`, `wp_global_styles`) | **Ninguna, hasta pasarlos al repo** |

Reglas que van en el README:

- Una plantilla modificada en el Editor del sitio **tapa** al archivo del tema: desde ese momento, cambiar el archivo no se ve en el sitio. Si se usa el Editor del sitio para diseñar, hay que pasar el resultado al tema con Create Block Theme ("Guardar cambios en el tema"), o copiarlo a mano al archivo, y luego **borrar la personalización** en la base. `bin/check` avisa cuando queda alguna.
- El contenido de la landing se edita en la página "Inicio", no en las plantillas.
- **Actualizar WordPress en local:** cambiar la etiqueta en `compose.yaml`, correr `docker compose pull` y `docker compose up -d`, y después `bin/wp core update --version=<nueva>` y `bin/wp core update-db`. La imagen solo copia el core cuando el volumen está vacío, por eso cambiar la etiqueta no basta. La otra vía es `bin/reset`, que borra el contenido local.

---

## 11. Calidad de código

- `composer.json` de tipo `project`, solo con dependencias de desarrollo:
  - `wp-coding-standards/wpcs` (3.x);
  - `phpcompatibility/phpcompatibility-wp` (2.1);
  - `dealerdirect/phpcodesniffer-composer-installer`, habilitado en `config.allow-plugins`.
- `config.platform.php` en `8.3`: las dependencias se resuelven para el PHP mínimo del proyecto, aunque el `composer.lock` se genere con PHP 8.4.
- `composer.lock` se versiona; `vendor/` no.
- Scripts: `composer lint` (`phpcs`) y `composer lint:fix` (`phpcbf`).
- `phpcs.xml.dist`:
  - revisa `wp-content/themes/campodata` y `wp-content/mu-plugins`;
  - estándar `WordPress` y `PHPCompatibilityWP`;
  - `minimum_wp_version` 7.0;
  - dominio de texto `campodata`;
  - prefijos `campodata` y `CampoData` (`PrefixAllGlobals`);
  - `testVersion` `8.3-`.
- Se corre con el PHP y el Composer del host. Si fallan, la alternativa es la imagen oficial `composer:2`.

---

## 12. Riesgos de ejecución

| # | Riesgo | Plan A | Plan B |
| --- | --- | --- | --- |
| R1 | Hay un parche más nuevo de WordPress 7.1, de WP-CLI o de MariaDB 11.8, o una etiqueta no existe | Las etiquetas de esta spec; si hay un parche más nuevo, usar ese | La etiqueta más cercana de la misma línea. Dejarlo en DECISIONS |
| R2 | Apache (UID 33) no puede escribir en las carpetas montadas desde el repo, así que Create Block Theme no puede guardar en el tema | No hace falta escribir desde WordPress en esta spec: documentar el problema en el README | Documentar en el README `setfacl -R -m u:33:rwX -m d:u:33:rwX wp-content/themes/campodata` (no requiere `sudo`), o exportar el tema como zip desde Create Block Theme. **No** cambies dueños ni permisos del host por tu cuenta |
| R3 | El puerto 8081 está ocupado | `WP_PORT=8081` | El siguiente puerto libre. Actualizar el registro del framework y anotarlo |
| R4 | Sin internet, o translate.wordpress.org no responde: no se instala `es_CL` | `bin/setup` instala el idioma | `bin/setup` sigue en inglés y avisa; al volver a correrlo instala el idioma. `bin/check` falla por el `lang` hasta entonces |
| R5 | No se puede sacar `screenshot.png` de la portada | Chrome sin cabeza (`google-chrome --headless=new --window-size=1200,900 --screenshot=…`) | Generarla con PHP GD; si tampoco, omitirla hasta la spec 02 |

---

## 13. Orden de ejecución

Al cerrar cada etapa, deja los cambios sin commit y sugiere el mensaje (Conventional Commits, en español y sin tildes).

0. Verificar sin cambiar nada: si existe un repositorio en `LandingPage/`, `git rev-parse --show-toplevel` debe ser `LandingPage/` y la rama actual debe ser `dev`. Si algo no cuadra, detente y avísale al usuario. Si no existe, sigue: el usuario lo crea al final (§4.1).
1. Base del repo: `.gitignore`, `.editorconfig`, `.env.example` y `docs/DECISIONS.md` con su formato. Mensaje: `chore: estructura base del proyecto`.
2. `compose.yaml` y `bin/wp`. Verificar con `docker compose up -d --wait`, que exista `wp-config.php` y con `bin/wp --info`. Mensaje: `chore(docker): entorno local con wordpress, mariadb y wp-cli`.
3. Tema `campodata` (§7). Mensaje: `feat(tema): tema de bloques campodata`.
4. mu-plugin `campodata-core` (§8). Mensaje: `feat(core): plugin de funcionalidad con seguridad basica`.
5. `config/plugins*.txt`, `bin/setup` y `bin/reset`. Verificar: `bin/setup` dos veces seguidas, y luego `bin/reset --yes`. Mensaje: `feat(setup): instalacion reproducible del sitio local`.
6. `composer.json`, `phpcs.xml.dist` y `bin/check`. `composer lint` en verde. Mensaje: `chore(calidad): phpcs con estandares de wordpress y verificacion del sitio`.
7. `screenshot.png`, `README.md` y las entradas de DECISIONS (§15). Mensaje: `docs: readme y decisiones iniciales`.

---

## 14. Criterios de aceptación

- [ ] La IA no creó el repositorio, no hizo commits y no cambió de rama. El usuario tiene los comandos de §4.1.
- [ ] En una máquina con Docker, `cp .env.example .env`, completar los secretos y correr `bin/setup` deja el sitio en `http://localhost:8081`, sin ningún paso manual.
- [ ] `bin/setup` corrido dos veces seguidas no falla ni duplica nada: hay una sola página "Inicio".
- [ ] `bin/reset --yes` borra el entorno y lo recrea; sin `--yes` pide confirmación.
- [ ] Los scripts funcionan corridos desde otra carpeta (por ejemplo, `cd /tmp && "<ruta>/LandingPage/bin/check"`).
- [ ] `bin/check` pasa.
- [ ] La portada es la página "Inicio" con el patrón provisional. El HTML trae `lang="es-CL"` y `wp-admin` está en español.
- [ ] `/pagina-que-no-existe/` responde 404 con la plantilla del tema.
- [ ] La versión del core es la de `compose.yaml` y `bin/wp core verify-checksums` pasa.
- [ ] No están Akismet ni Hello Dolly; solo están los plugins de `config/plugins-dev.txt`, con su versión.
- [ ] En el editor de bloques solo aparece la paleta del tema, sin selector de color libre ni tamaños de fuente libres. Los patrones del core y los remotos no aparecen; el provisional aparece en la categoría "CampoData".
- [ ] Por `/xmlrpc.php`, un método con autenticación (por ejemplo, `wp.getUsersBlogs`) responde que XML-RPC está desactivado, y `system.listMethods` no incluye `pingback.ping`. Sin sesión, `/wp-json/wp/v2/users` responde 404. `/?author=1` responde 404 sin redirigir. El HTML no trae `<meta name="generator">` de WordPress ni el script de los emojis.
- [ ] La portada local trae `noindex`, y `wp_mail()` en local no envía nada y queda anotado en `debug.log`.
- [ ] El puerto está publicado solo en `127.0.0.1` (`docker compose ps`).
- [ ] Siete Colores y CampoData pueden estar levantados a la vez, cada uno con sus contenedores y volúmenes.
- [ ] `composer lint` pasa sin errores ni advertencias.
- [ ] `.env` está ignorado (`.gitignore`), y el proyecto no contiene archivos del core, plugins de terceros, `uploads` ni volcados de base de datos fuera de lo ignorado.
- [ ] Siguiendo solo el `README.md`, alguien nuevo puede levantar el proyecto.
- [ ] `docs/DECISIONS.md` tiene las entradas de §15.

---

## 15. Documentación a crear

**`README.md`:**

- requisitos (Docker y Docker Compose, curl; PHP 8.3+ y Composer solo para `lint`);
- primer arranque (`.env` y `bin/setup`);
- comandos del día a día: levantar y bajar, `bin/wp`, `bin/check`, `composer lint` y ver el log (`docker compose exec wordpress tail -f wp-content/debug.log`);
- ramas y flujo de trabajo (§4.1);
- dónde va cada cosa y qué vive en el código y qué en la base (§10);
- flujo con el Editor del sitio y Create Block Theme;
- cómo agregar un plugin de terceros (§9);
- cómo actualizar WordPress en local;
- el problema de permisos de R2 y su solución.

**`docs/DECISIONS.md`**, con una entrada por cada uno de estos temas:

- WordPress estándar en vez de Bedrock;
- Docker Compose en vez de wp-env;
- tema de bloques propio;
- sin constructor de páginas;
- contenido en la página "Inicio";
- tokens semánticos y editor limitado a los tokens;
- mu-plugin para la funcionalidad;
- política de plugins, con las versiones instaladas y la fecha;
- textos fijos en español;
- sin recursos de terceros;
- el enlace de la página 404 a `/`;
- cada riesgo de §12 que se haya materializado, con el plan aplicado.

---

## 16. Supuestos y preguntas abiertas

| # | Tema | Supuesto de esta spec | Qué cambia si es distinto |
| --- | --- | --- | --- |
| P1 | Hosting de producción | Aún no definido. La estructura sirve para hosting compartido, WordPress administrado o VPS | La spec de despliegue. Con un VPS propio se puede reconsiderar Bedrock |
| P2 | Idioma | Solo español de Chile | Con multilenguaje se agrega un plugin (Polylang o WPML) y hay que envolver los textos en funciones de traducción |
| P3 | Quién edita el contenido | Alguien no técnico, que solo debe poder elegir entre los tokens del tema | Si edita solo el equipo técnico, se puede abrir la libertad de colores y tamaños |
| P4 | Identidad visual | Se toma del sitio actual (campodata.cl) en la spec 02 | La spec 02 define paleta, tipografías y logo sobre los slugs de esta spec |
| P5 | Flujo de ramas | `dev` → `testing` → `prod`. `hotfix` sale de `prod`, y su arreglo vuelve a `prod`, `testing` y `dev` | Solo la descripción del flujo en §4.1 y en el README |
| P6 | Puerto local | 8081, porque el 8080 es de Siete Colores | Un valor en `.env` y en el registro del framework |
