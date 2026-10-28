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

`bin/setup` levanta los contenedores, instala WordPress en español de Chile, configura el sitio, instala los plugins declarados, activa el tema y crea la portada. Al terminar muestra la URL (por defecto `http://localhost:8081`) y el usuario administrador. La contraseña es la de `.env`.

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
docs/DECISIONS.md             decisiones del proyecto
specs/                        specs numeradas
wp-content/themes/campodata/  tema de bloques: todo lo visual
├── theme.json                paleta, tipografías, tamaños y espaciados
├── templates/, parts/        plantillas, encabezado y pie
├── patterns/                 secciones de la portada (hoy, solo la provisional)
└── inc/setup.php             patrones propios y el año del pie
wp-content/mu-plugins/        plugin de funcionalidad: lo que no es visual
└── campodata-core/           seguridad.php y entorno-local.php
compose.yaml                  entorno local y versiones de WordPress, PHP, WP-CLI y MariaDB
```

`wp-content/` replica la estructura de WordPress: desplegar es copiar esas dos carpetas al servidor.

**Tema.** `theme.json` es la fuente única de los tokens de diseño: colores (`base`, `contraste`, `primario`, `secundario`, `acento`, `suave`), tamaños de fuente (`small` a `xx-large`) y espaciados (`20` a `80`). Hoy los valores son provisionales (grises y la fuente del sistema): la identidad llega en la spec 02, que cambia los valores y no los slugs. En el código, el contenido y los patrones, los colores, tamaños y espaciados se usan **siempre por su token**, nunca con valores fijos: así, un cambio de marca solo cambia valores en `theme.json`. Quien edita contenido solo puede elegir entre esos tokens. Las secciones de la landing serán patrones en `patterns/`. Los textos van fijos, en español.

**Plugin de funcionalidad.** `campodata-core` es un plugin *must-use*: WordPress lo carga siempre y no se puede desactivar desde `wp-admin`. Ahí va lo que tiene que sobrevivir a un cambio de tema. Hoy tiene la seguridad básica (XML-RPC, versión de WordPress oculta, usuarios ocultos, sin emojis desde `s.w.org`) y las protecciones del entorno local: el sitio local nunca se indexa ni envía correos, y los correos quedan anotados en `debug.log`.

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

**El contenido de la landing se edita en la página "Inicio"**, no en las plantillas. Hoy esa página solo inserta el patrón provisional `campodata/inicio-provisional`, así que muestra lo que diga el archivo del patrón. Cuando alguien la abre en el editor y la guarda, el contenido del patrón queda copiado en la página y desde ahí se edita en ella.

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
