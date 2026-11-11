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

`bin/setup` levanta los contenedores, instala WordPress en español de Chile, configura el sitio, instala los plugins declarados, activa el tema, crea los datos de contacto y los textos de SEO iniciales y arma la portada con la landing. Al terminar muestra la URL (por defecto `http://localhost:8081`) y el usuario administrador. La contraseña es la de `.env`.

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
bin/                          scripts: wp, setup, reset, check e imagenes-de-marca
config/plugins.txt            plugins de producción, con versión fija
config/plugins-dev.txt        plugins solo para el entorno local
imagenes-sistema/             imágenes del sistema y logos originales, solo locales (ignorada en git)
config/contacto-inicial.json  datos de contacto con que bin/setup crea la opción (solo la primera vez)
config/seo-inicial.json       título y descripción para buscadores, igual que los datos de contacto
docs/DECISIONS.md             decisiones del proyecto
docs/marca/                   el logo original (JPG) que entregó el cliente, de referencia
docs/compartir/tarjeta.html   fuente de la imagen para compartir (ver SEO)
specs/                        specs numeradas
wp-content/themes/campodata/  tema de bloques: todo lo visual
├── theme.json                paleta, degradados, tipografías, tamaños, espaciados y valores propios
├── styles/                   estilos de sección (secciones/) y de bloque (bloques/) que solo usan theme.json
├── templates/, parts/        plantillas, encabezado y pie
├── patterns/                 landing.php, una sección por archivo y apoyos.php (logos del pie)
├── assets/fonts/             Sora y DM Sans (woff2) con sus licencias OFL
├── assets/images/            marca/ (emblema e ícono de la pestaña), compartir/ (imagen para compartir), ilustraciones/ (píxeles), iconos/, sistema/ (pantallas del sistema) y apoyos/ (logos de 3IE y Corfo)
├── assets/css/               sitio.css (todo el CSS propio) y editor.css (ajustes del editor)
├── assets/js/movimiento.js   el módulo de movimiento y el formulario de WhatsApp
├── inc/setup.php             patrones, estilos de bloque con CSS y el año del pie
└── inc/recursos.php          carga el CSS y el JS, el interruptor del movimiento, la precarga de tipografías y el ícono de la pestaña
wp-content/mu-plugins/        plugin de funcionalidad: lo que no es visual
└── campodata-core/           seguridad.php, contacto.php, seo.php y entorno-local.php
compose.yaml                  entorno local y versiones de WordPress, PHP, WP-CLI y MariaDB
```

`wp-content/` replica la estructura de WordPress: desplegar es copiar esas dos carpetas al servidor.

**Tema.** `theme.json` es la fuente única de los tokens de diseño: colores (ver [Identidad](#identidad)), tamaños de fuente (`x-small` a `xx-large`), espaciados (`20` a `80`) y valores propios en `settings.custom` (radios, movimiento, alto del encabezado y brillos), que el CSS usa como `--wp--custom--…`. En el código, el contenido y los patrones, los colores, tamaños y espaciados se usan **siempre por su token**, nunca con valores fijos: así, un cambio de marca solo cambia valores en `theme.json`. Quien edita contenido solo puede elegir entre esos tokens. Cada sección de la landing es un patrón en `patterns/`. Los textos van fijos, en español.

**Plugin de funcionalidad.** `campodata-core` es un plugin *must-use*: WordPress lo carga siempre y no se puede desactivar desde `wp-admin`. Ahí va lo que tiene que sobrevivir a un cambio de tema. Hoy tiene la seguridad básica (XML-RPC, versión de WordPress oculta, usuarios ocultos, sin emojis desde `s.w.org`), los [datos de contacto](#datos-de-contacto), el [SEO](#seo) y las protecciones del entorno local: fuera de producción el sitio nunca se indexa, y en local no envía correos (quedan anotados en `debug.log`).

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
| 4 | Reportes (el sistema por dentro) | `#reportes` | `campodata/reportes` | Noche con brillo |
| 5 | Beneficios | `#beneficios` | `campodata/beneficios` | Blanco |
| 6 | Por qué CampoData | `#porque` | `campodata/por-que` | Rocío |
| 7 | Solicitar demo | `#demo` | `campodata/demo` | Degradado del surco al marino |

- **Reordenar, agregar o quitar una sección:** edita la lista de `patterns/landing.php`. Una sección nueva es un archivo en `patterns/` con `Categories: campodata`, un `group` con `tagName` `section`, su ancla, su estilo de sección y una ceja (`<strong>NN</strong>Nombre` con el estilo `ceja`). Si cambia el orden de las anclas, actualiza `ANCLAS` en `bin/check`; si la sección va en el menú, agrega el enlace en `parts/header.html` y mide el encabezado entre 320 y 1500px (hoy el menú pasa al botón móvil bajo 861px).
- **Reemplazar una imagen del sistema:** ver [Imágenes del sistema](#imágenes-del-sistema).
- **Sin terceros:** la web no nombra sistemas ni empresas ajenas (DairyPlan, Excel, Power BI, la planta que recibe la leche…), ni en textos ni dentro de las capturas. Para hablar de con qué trabaja CampoData, el mensaje es que se adapta a la tecnología y la maquinaria de cada predio (DECISIONS D21). `bin/check` falla si la portada nombra alguno; la lista está en el script. Los logos de Corfo y 3IE del pie no cuentan: son quienes apoyan el proyecto, no sistemas con los que trabaja (ver [Logos de apoyo](#logos-de-apoyo-corfo-y-3ie)).
- **Textos guía:** lo que está entre corchetes es contenido pendiente del cliente (hoy, lo propio de los asesores). `bin/check` avisa cuántos quedan.

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

**Logo:** el emblema (`assets/images/marca/emblema.webp`, un recorte del JPG entregado) es el logo de CampoData, y la palabra "CampoData" se escribe con Sora en dos colores. No hay una spec 03 pendiente: el ícono de la pestaña sale del emblema, sin la palabra, que a 32 px no se leería (spec 05, DECISIONS D29).

## Imágenes del sistema

`imagenes-sistema/` (en la raíz de `LandingPage/`) guarda en cada máquina las imágenes del sistema de CampoData. Está en `.gitignore`: git no la ve y nada de lo que hay ahí se sube. Quien clone el repo la crea vacía con `mkdir imagenes-sistema`. Lo que se use en la web se pasa, revisado, a `wp-content/themes/campodata/assets/images/sistema/`, que sí se versiona y viaja con el tema al desplegar (spec 04).

Hoy la landing usa catorce, todas del **Campo Demostración** (datos ficticios). **Cada una muestra lo mismo que dice el texto que acompaña**; una tarjeta o un paso sin una pantalla que lo muestre va sin imagen (DECISIONS D26).

| Imagen de origen | Dónde va | Qué texto ilustra | Archivo en `assets/images/sistema/` |
| --- | --- | --- | --- |
| `1_escritorio_demo/03_produccion_hoy_que_mirar.jpg` | Banner (pantalla) | "qué mirar hoy, cuánto alimento te queda" | `banner-hoy.webp` |
| `2_movil_demo/01_inicio.jpg` | Banner (celular) | El sistema en el celular | `banner-movil-inicio.webp` |
| `3_recortes_para_landing/kpis_inicio.jpg` | Para quién · Dueños de lecherías | "Sabe cada mañana cómo viene tu predio" | `perfil-lecheria-inicio.webp` |
| `3_recortes_para_landing/explicame_modal.jpg` | Para quién · Asesores | "Explícame: por qué cambió un número" | `perfil-asesor-explicame.webp` |
| `3_recortes_para_landing/alertas_que_mirar_hoy.jpg` | Cómo funciona, bajo los pasos | Paso 3, "Te avisamos qué mirar" | `accion-que-mirar-hoy.webp` |
| `1_escritorio_demo/06_produccion_curva_meta_y_dietas.jpg` | Reportes · Producción | La leyenda de la pestaña | `reportes-produccion.webp` |
| `1_escritorio_demo/13_calidad_que_es_esto_contrato.jpg` | Reportes · Calidad | La leyenda de la pestaña | `reportes-calidad.webp` |
| `3_recortes_para_landing/ensayo_tarjetas_resultado.jpg` | Reportes · Ensayos | La leyenda de la pestaña | `reportes-ensayo-resultados.webp` |
| `3_recortes_para_landing/ensayo_indice_grafico.jpg` | Reportes · Ensayos | La leyenda de la pestaña | `reportes-ensayo-indice.webp` |
| `3_recortes_para_landing/permisos_matriz.jpg` | Reportes · Equipo | La leyenda de la pestaña | `reportes-equipo-permisos.webp` |
| `3_recortes_para_landing/cuanto_queda_alimento.jpg` | Beneficios · Ahorra tiempo | "Lo que antes tomaba horas de cálculos, ahora en segundos" | `beneficio-dias-de-alimento.webp` |
| `3_recortes_para_landing/recetas_vs_habitual.jpg` (solo el recuadro "Sobras") | Beneficios · Optimización alimentaria | "Detecta dónde estás gastando más de lo necesario" | `beneficio-sobras.webp` |
| `1_escritorio_demo/29_analisis_minimo_30_dias.jpg` (recortada) | Beneficios · Decisiones con respaldo | "La advertencia de cuándo el dato no alcanza para concluir" | `beneficio-dato-no-alcanza.webp` |
| `3_recortes_para_landing/ciclo_reproductivo_selector.jpg` | Por qué CampoData | "Pensada para predios como el tuyo" | `adaptacion-ciclo-reproductivo.webp` |

Sin imagen, porque ninguna pantalla muestra lo que dicen: los pasos 1, 2 y 4 de Cómo funciona y las tarjetas "Qué mirar hoy" (ya ilustrada en el paso 3), "Mejor gestión diaria" y "Mejora continua real" de Beneficios.

**Para reemplazar una** (por ejemplo, con la recaptura a doble resolución de la spec 04, §9): guárdala como WebP en `assets/images/sistema/` **con el mismo nombre**, sin punteros del mouse, sin textos internos ("Demo", "Idea", "Simulado", "En construcción"), sin nombres de terceros y sin datos que un asesor note como poco realistas (ver `ANALISIS_LANDING.md`, §6). `bin/check` falla si pasa su peso máximo (90 KB las pantallas, 60 KB el celular y 50 KB los recortes). Las del banner van a calidad 82 y el resto a calidad 70. Los patrones no se tocan: un filtro del tema (`inc/imagenes.php`) toma el ancho y el alto del archivo y decide qué se carga diferido.

Las imágenes, salvo las del banner, se amplían al hacer clic (la ampliación del bloque `image` del core).

**Qué no se publica:** nada de `4_datos_reales_censurados/` ni de `5_referencia_interna_NO_publicar/`, ni las capturas de reportes del sitio anterior (podían identificar un predio; `bin/check` falla si vuelve `assets/images/reportes/`). Las imágenes que esperan una corrección de la demo antes de usarse están en la spec 04, §9.

## Logos de apoyo (Corfo y 3IE)

CampoData es un proyecto apoyado por Corfo, con el Instituto 3IE y su Red de Mentores. El manual "Uso correcto de la marca 3IE, Red de Mentores y Corfo para emprendedores/as" obliga a poner el logo de Corfo en la web, en la zona inferior, y sus ejemplos agregan el de 3IE. Por eso el pie tiene una fila propia (patrón `campodata/apoyos`) con los tres logos en su versión oficial para fondo oscuro (DECISIONS D27):

| Archivo en `assets/images/apoyos/` | Origen en `imagenes-sistema/` | Versión |
| --- | --- | --- |
| `logo-3ie.svg` | `Logo-Instituto-3IE/…/Logo 3IE Vector.ai`, mesa 3 | Completa, blanco con la tilde naranja ("fondo oscuro") |
| `logo-red-de-mentores-3ie.svg` | `Logo-Red-de-Mentores-3IE-USM/…/Logos Red de Mentores 3IE vector.ai`, mesa 2 | "Fondos oscuros" |
| `logo-corfo.svg` | `Logo-Corfo/…/Logo Corfo Vector.ai`, mesa 2 | "Proyecto apoyado por", blanco con la barra azul y roja |

- **Formato:** SVG sacado del `.ai` (que es un PDF) con `pdftocairo -svg`, con el lienzo recortado al dibujo y los trazos redondeados. No se redibuja ni se recolorea nada: el manual lo prohíbe.
- **Lo que no se hace:** deformarlos (en el CSS cada uno tiene solo un ancho), ponerles `cd-marco`, sombra, borde o lightbox, ni escribir "CORFO" o "3ie" en un texto o un `alt`. `bin/check` falla si pasa alguna de esas cosas o si falta un logo.
- **Pendiente:** validar la aplicación con comunicaciones@3ie.cl. El logo de Corfo se puede quitar cuando el proyecto termine y se audite.

## Movimiento

Todo es una mejora progresiva: sin JS, o con movimiento reducido en el sistema, el contenido se ve completo y en su estado final. Un script en el `<head>` agrega `cd-con-js` y, solo si el sistema no pide movimiento reducido, `cd-movimiento` al `<html>`; si el módulo no carga en 3 segundos, la quita.

| # | Efecto |
| --- | --- |
| M1 | Cada bloque de cada sección aparece al bajar (opacidad y 22px hacia arriba, 0,55s); las tarjetas, escalonadas |
| M2 | El campo de píxeles del banner y de la demo (animación dentro de `pixeles.svg`) |
| M3 | El degradado del título se desplaza en 8s |
| M4 | El banner entra escalonado al cargar |
| M5 | La pantalla del banner y su celular flotan y se inclinan con el mouse hasta 6°; sus tarjetas aparecen después |
| M6 | Los números con la clase `cd-contador` cuentan desde cero (hoy no hay ninguno: las cifras del banner se quitaron en la spec 04) |
| M7 y M8 | Barra de progreso de lectura y cristal del encabezado al bajar |
| M9 | La línea de Cómo funciona se dibuja, enciende los pasos y la recorre un "paquete de datos" |
| M10 | Foco de luz que sigue al mouse en las tarjetas |
| M11 | "Quiero una demo" elige el perfil en el formulario |
| M12 | Reflejo en la ventana de Reportes y *fade* al cambiar de pestaña |
| M13 | El degradado del cierre se desplaza en 16s |
| M14 y M15 | Botones que suben con una línea de color; checks que se dibujan |

- Lo que se repite se pausa cuando su sección no está a la vista o la pestaña está oculta.
- Para excluir un bloque, agrégale la clase `sin-movimiento` (Avanzado → Clases CSS adicionales).
- **Probar con movimiento reducido:** en Chrome, DevTools → menú ⋮ → More tools → Rendering → "Emulate CSS media feature prefers-reduced-motion: reduce". **Probar sin JS:** DevTools → ⋮ → Run command → "Disable JavaScript". Sin JS, Reportes muestra sus dos pantallas una debajo de otra y el formulario no aparece.

## Datos de contacto

Se editan en **Ajustes → Datos de contacto** (WhatsApp, mensaje inicial, teléfono, correo, asunto del correo, zona, LinkedIn e Instagram) y se muestran solos en los botones y los datos de la sección "Solicitar demo", en el formulario de WhatsApp y en los íconos del pie. Una red sin URL no aparece. `bin/setup` crea la opción desde `config/contacto-inicial.json` solo si no existe: nunca pisa lo que se cambió en Ajustes. El formulario no envía nada a un servidor: arma el mensaje y abre WhatsApp.

## SEO

Todo con código propio, sin plugins de SEO (spec 05, DECISIONS D28). Lo que no depende del tema está en `campodata-core/seo.php`. El ícono y la imagen para compartir están en el tema.

**Título y descripción.** Se editan en **Ajustes → SEO**, que muestra cuántos caracteres tiene cada texto: el título, hasta 60, y la descripción, entre 70 y 155. Se usan en la portada, en `<title>`, la meta descripción, la vista previa al compartir y los datos estructurados. `bin/setup` crea la opción desde `config/seo-inicial.json` solo si no existe, igual que los datos de contacto.

**Qué lleva el `<head>` de la portada:**

- el título y la meta descripción de Ajustes → SEO;
- la vista previa al compartir (Open Graph y `twitter:card`), con `assets/images/compartir/campodata.jpg` (1200 × 630, 200 KB como máximo);
- los datos estructurados (JSON-LD): `Organization` ("CampoData SpA"), `WebSite` y `SoftwareApplication`. El correo, el teléfono, la zona y las redes salen de Ajustes → Datos de contacto, y un dato vacío se omite. Nunca llevan precios, calificaciones, reseñas, dirección ni fecha de fundación: no se inventan;
- el ícono de la pestaña: el emblema en 32 y 96 px (`assets/images/marca/favicon-*.png`). `/favicon.ico` lleva al de 32. Un ícono cargado en Ajustes → General manda sobre el del tema.

No lleva feeds, RSD, enlace corto, oEmbed ni la REST API (que sigue funcionando para el editor). `/feed/`, `/comments/feed/` y la búsqueda (`/?s=`) redirigen a la portada con un 301, y una categoría sin entradas responde 404. El sitemap del core (`/wp-sitemap.xml`) lista solo páginas.

**Regenerar el ícono y la imagen para compartir:** `bin/imagenes-de-marca`. Lee `emblema.webp` y `docs/compartir/tarjeta.html`, y deja los tres archivos en el tema. Necesita el contenedor `wordpress` arriba y Chrome (o Chromium) en el host. Córrelo si cambia el emblema, el `h1` del banner (cámbialo también en `tarjeta.html`) o la pantalla del banner, y revisa las imágenes antes de hacer commit.

**Indexación por entorno.** La base dice "indexar" (`bin/setup` escribe `blog_public` en 1) y `seo.php` lo apaga en todo entorno que no sea `production`: así una base migrada a producción queda indexable, y ni el sitio local ni uno de pruebas se indexan. WordPress considera producción a todo sitio que no define `WP_ENVIRONMENT_TYPE`: **un servidor de pruebas tiene que definirlo como `staging`**. En local, Ajustes → Lectura muestra marcada la casilla "Disuadir a los motores de búsqueda": es el filtro, no la base. En local no hay sitemap (el core lo apaga cuando el sitio no es público); `bin/check` lo revisa simulando un sitio público.

**URLs del sitio anterior.** campodata.cl tiene indexadas URLs de una plantilla. Cuando la landing lo reemplace, responden así (la tabla está en `urls_del_sitio_anterior()`, en `seo.php`, y solo actúa si nada del sitio responde en esa ruta):

| URL anterior | Respuesta |
| --- | --- |
| `/about/`, `/services/`, `/contact/` | 301 a `/#para-quien`, `/#como` y `/#demo` |
| `/blog/`, `/sample-page/`, `/2026/01/12/hello-world/`, `/2026/01/13/unlocking-the-power-of-data-…/`, `/category/uncategorized/` | 410 (ya no existen) |
| `/sitemaps.xml` | 301 a `/wp-sitemap.xml` |

**Al publicar** (para la spec de despliegue; detalle en la spec 05, Anexo A):

1. `http://` y `www.` redirigen con 301 a `https://campodata.cl/` (hoy el sitio actual responde en las tres).
2. `WP_ENVIRONMENT_TYPE` es `production` o no se define; `home` y `siteurl` son `https://campodata.cl`.
3. La portada no trae `noindex`, y `robots.txt` trae `Sitemap: https://campodata.cl/wp-sitemap.xml`.
4. En Search Console: antes de cambiar el sitio, exportar las páginas con visitas del sitio anterior y sumar a la tabla las que falten; después, enviar `/wp-sitemap.xml`, quitar `/sitemaps.xml` y pedir que indexe la portada.
5. Probar los datos estructurados con la prueba de resultados enriquecidos de Google, y la vista previa compartiendo la URL por WhatsApp y en los depuradores de Facebook y LinkedIn.
6. Las URLs del sitio anterior responden su 301 o su 410.

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
