# Spec 05 · SEO técnico

**Proyecto:** CampoData · Landing Page (WordPress 7.1.3, tema de bloques `campodata`, mu-plugin `campodata-core`)
**Alcance de esta spec:** dejar la landing lista para que Google la entienda y para que se vea bien al compartirla. Se suman el título y la descripción para buscadores, editables en Ajustes; la vista previa al compartir (Open Graph), con una imagen propia; los datos estructurados de CampoData; el ícono de la pestaña, hecho desde el emblema; una limpieza de las URLs y etiquetas que no aportan; redirecciones para las URLs que hoy tiene indexadas el sitio anterior; y una regla de indexación por entorno, para que una base migrada a producción no quede invisible para Google. Todo con código propio, sin plugins de SEO. **No cambia ningún texto visible de la landing.**
**Rama de trabajo:** `dev`
**Depende de:** spec 04 ejecutada. No hay spec 03: el emblema actual (`assets/images/marca/emblema.webp`) es el logo de CampoData (decisión del usuario, 2026-11-10), y el ícono de la pestaña, que la spec 02 dejaba para la 03, entra en esta spec (§6).
**Versión:** 1 · 2026-11-10

### Historial de decisiones

| Versión | Cambio confirmado |
| --- | --- |
| v1 | Pedido del usuario (2026-11-10): mejorar el SEO de la landing con código. Quedan confirmados: **código propio en el mu-plugin**, sin plugins de SEO; **"CampoData SpA"** como nombre legal en los datos estructurados; y **el emblema actual es el logo**, así que no hay spec 03 y el ícono sale de él. El título y la descripción de §3 son **una propuesta**, por confirmar al revisar la spec (P1 y P2) |
| v1 (ejecución) | El usuario pidió implementarla tal como está (2026-11-10): **quedan confirmados T1 y D1**. Se ejecutó el mismo día. Los desvíos están en `docs/DECISIONS.md`, C22 a C27: entre otros, la base local ya decía `blog_public` 1 y `bin/setup` lo escribe sin el filtro (C23), y una categoría sin entradas responde 404, para que `/category/uncategorized/` responda su 410 (C24) |
| Pedido posterior | El usuario pidió que la pestaña diga CampoData (2026-11-11). El título pasa a **"CampoData | Software para predios lecheros"** (42 caracteres): la marca adelante y sin "del sur de Chile". Se cambió en `config/seo-inicial.json` y en Ajustes → SEO local. Detalle en DECISIONS D28 |
| Pedido posterior | El usuario pidió no limitar nada al sur de Chile (2026-11-11). La zona de contacto pasa a "Chile" (y con ella el `areaServed` de §5, que en el ejemplo dice "Los Ríos y Los Lagos, Chile"), y P6 queda resuelta: el título no lleva región. También cambiaron dos textos visibles, Por qué CampoData y el pie, fuera del alcance original de esta spec. Detalle en DECISIONS D32 |

---

## Resumen: qué cambia

| Qué | Hoy | Con esta spec | Dónde |
| --- | --- | --- | --- |
| Título de la portada | "CampoData – Gestión simple para tu predio" | "Software para predios lecheros del sur de Chile \| CampoData" (propuesta) | Ajustes → SEO (§3) |
| Meta descripción | No hay | 153 caracteres, con los dos públicos y la llamada a la demo (propuesta) | Ajustes → SEO (§3) |
| Vista previa al compartir | No hay: un enlace en WhatsApp o LinkedIn sale sin imagen ni texto | Título, descripción e imagen de 1200 × 630 | `seo.php` y la imagen en el tema (§4) |
| Datos estructurados | No hay | `Organization`, `WebSite` y `SoftwareApplication` | `seo.php` (§5) |
| Ícono de la pestaña | `/favicon.ico` lleva al logo de WordPress | El emblema, en PNG de 32 y 96 px | Tema (§6) |
| `<head>` y URLs sin contenido | Feeds, RSD, enlace corto, oEmbed y REST API en el `<head>`; `/feed/` y `/?s=` responden 200 | Fuera del `<head>`; feeds y búsqueda redirigen a la portada; el sitemap solo lista páginas | `seo.php` (§7) |
| URLs del sitio anterior | 8 URLs de plantilla indexadas en campodata.cl | 3 redirigen a su sección y 5 responden 410 | `seo.php` (§8) |
| Indexación | `bin/setup` deja la base en "no indexar" | La base dice "indexar" y el mu-plugin lo apaga en todo entorno que no sea producción | `seo.php` y `bin/setup` (§9) |

---

## 0. Instrucciones para la IA que ejecute esta spec

1. Lee este documento completo, `README.md`, `docs/DECISIONS.md`, la spec 04 y `Clientes Web/FRAMEWORK-WORDPRESS.md` antes de escribir el primer archivo. Las reglas de las specs anteriores siguen vigentes, salvo lo que esta spec cambie de forma explícita.
2. **Git lo maneja el usuario.** No hagas `commit`, `push` ni `add`, y no crees ni cambies ramas. Al empezar debes estar en `dev`. Si el árbol de trabajo tiene cambios sin commit de trabajos anteriores, avísale al usuario y espera a que los commitee antes de seguir. Al cerrar cada etapa, deja los cambios sin commit y sugiere el mensaje.
3. **Ningún texto visible de la landing cambia.** No toques los patrones, el `h1`, los encabezados ni los `alt`. Esta spec solo agrega etiquetas al `<head>`, una pantalla de ajustes, imágenes de marca y reglas de servidor.
4. **Sin terceros** (D21) **y sin Corfo ni 3IE** fuera del pie (D27): ni el título, ni la descripción, ni los datos estructurados, ni la imagen para compartir nombran sistemas, instituciones o empresas ajenas.
5. **No inventes datos** (framework, regla 7): ni precios, ni calificaciones, ni reseñas, ni dirección, ni fecha de fundación, ni cifras. Los datos estructurados solo llevan lo que ya está publicado en la landing o en Ajustes → Datos de contacto.
6. **No prometas más de lo que la app hace hoy** (D24). La descripción no menciona "14 días gratis" mientras siga abierta la pregunta P9 de la spec 04.
7. Lo que no depende del tema (etiquetas, datos estructurados, redirecciones, indexación) va en el mu-plugin, en un archivo nuevo: `campodata-core/seo.php` (D07). Lo visual (el ícono y la imagen para compartir) va en el tema. El mu-plugin no puede romperse si falta un archivo del tema: si la imagen para compartir no existe, omite sus etiquetas.
8. Antes de usar un *hook* del core, revisa su firma y su prioridad en el core 7.1.3 del contenedor (`wp-includes/default-filters.php`, `general-template.php`, `sitemaps/`).
9. No se instala nada en el host. Las imágenes se procesan con el PHP (GD) del contenedor `wordpress`, y la imagen para compartir se captura con el Chrome del host, como el ícono de Siete Colores (framework, §7).
10. Si algo no se comporta como se describe, aplica el plan B del riesgo (§11), sigue, y anótalo en DECISIONS.
11. No toques lo que está fuera de alcance (§2.2).
12. Al terminar, verifica uno por uno los criterios de §13 y reporta el resultado.

---

## 1. Punto de partida

### 1.1 La landing nueva (medida el 2026-11-10 en `http://localhost:8081`)

| Pieza | Estado actual |
| --- | --- |
| `<title>` | "CampoData – Gestión simple para tu predio": el nombre del sitio y el lema (`LEMA` de `bin/setup`). No dice "lechero" ni "lechería" |
| Meta descripción | No hay |
| Open Graph y Twitter | No hay |
| Datos estructurados | No hay |
| Otras etiquetas del `<head>` | Dos feeds RSS, dos enlaces de oEmbed, el enlace a la REST API y al JSON de la página, RSD (`EditURI`) y `shortlink`. La respuesta trae además los encabezados `Link` de la REST API y del enlace corto |
| Feeds y búsqueda | `/feed/` y `/comments/feed/` responden 200, aunque no hay entradas. `/?s=leche` responde 200 (con `noindex`, que pone el core) |
| Sitemap y robots | `/wp-sitemap.xml` responde 404 en local, porque el core apaga los sitemaps cuando el sitio no es público. `/robots.txt` responde 200 |
| Ícono | No hay `<link rel="icon">`. `/favicon.ico` hace un 302 al logo de WordPress (`wp-includes/images/w-logo-gray-white-bg.png`) |
| Logo | `assets/images/marca/emblema.webp`: 256 × 256, un círculo opaco con las esquinas transparentes. El encabezado y el pie lo pintan con CSS, sobre una ficha blanca, y "CampoData" es texto en Sora |
| Encabezados | Un solo `h1` ("Gestión **simple y efectiva** para tu predio lechero") y un `h2` por sección. Bien |
| Imágenes | 30 `<img>`: 15 con carga diferida, la pantalla del banner con `fetchpriority="high"` y todas las de contenido con un `alt` que describe la pantalla (D23). Bien: no se tocan |
| `canonical` e idioma | `<link rel="canonical">` a la portada y `lang="es-CL"`. Bien |
| Indexación | `bin/setup` escribe `blog_public` en 0, y `entorno-local.php` lo fuerza a 0 en local |

### 1.2 El sitio actual (campodata.cl, medido el 2026-11-10)

| Pieza | Estado actual |
| --- | --- |
| Plataforma | WordPress, con un plugin que publica el sitemap en `/sitemaps.xml`. `/sitemap.xml` y `/wp-sitemap.xml` hacen un 301 a ese |
| Título | "Campodata SpA – Gestión simple para tu predio lechero" |
| Meta descripción, Open Graph y datos estructurados | No tiene |
| Ícono | `/favicon.ico` responde 404 |
| Versiones del sitio | `https://campodata.cl/`, `http://campodata.cl/` y `https://www.campodata.cl/` responden 200 sin redirigir: tres copias de la misma portada |
| URLs indexables | La portada y **8 URLs más**, todas en 200 y en inglés, de una plantilla (§8): `/about/`, `/contact/`, `/services/`, `/blog/`, `/sample-page/`, dos entradas ("Hello world!" y "Unlocking the Power of Data…") y `/category/uncategorized/` |

---

## 2. Decisiones y alcance

### 2.1 Decisiones

| Tema | Decisión | Alternativa descartada |
| --- | --- | --- |
| Dónde vive | **Código propio** en `campodata-core/seo.php`: sobrevive a un cambio de tema (D07). El ícono y la imagen para compartir viven en el tema, porque son marca | Yoast SEO, Rank Math o SEOPress: decenas de pantallas y opciones para una sola página, más peso en cada visita y un plugin de producción que justificar (D08) |
| Textos editables | El título y la descripción viven en la opción `campodata_seo` (**Ajustes → SEO**). `bin/setup` la crea desde `config/seo-inicial.json` solo si no existe, igual que los datos de contacto (D20) | Fijos en el código: cambiar una palabra exigiría desplegar. El extracto de "Inicio": las páginas no lo traen, y "Inicio" a veces se devuelve a la referencia de la landing (C15) |
| Una sola fuente | El título y la descripción de la opción alimentan `<title>`, la meta descripción, Open Graph y los datos estructurados. El teléfono, el correo, la zona y las redes salen de Ajustes → Datos de contacto | Repetirlos en cada etiqueta |
| Imagen para compartir | Una tarjeta de **1200 × 630 en JPG** con el emblema, la palabra CampoData, el `h1` y la pantalla del banner, capturada desde un HTML versionado | La pantalla del banner sola: su proporción (1118 × 679) no es la de las vistas previas y no muestra la marca. WebP: WhatsApp y otras redes no siempre lo muestran |
| Datos estructurados | `Organization`, `WebSite` y `SoftwareApplication`, en un solo `@graph`. Sin precios, calificaciones ni reseñas | `LocalBusiness`: CampoData no atiende en un local. `Product` con `offers`: no hay un precio público. Las estrellas en Google exigen calificaciones, y no se inventan |
| Ícono | Del emblema actual, en PNG de **32 px** (pestañas) y **96 px** (Google pide un múltiplo de 48) | Esperar un SVG oficial: no lo hay, y el emblema es el logo (decisión del usuario) |
| Feeds y búsqueda | **301 a la portada.** No hay entradas ni buscador | Dejarlos: son URLs sin contenido que Google rastrea |
| Sitemap | El del core, **solo con páginas** (sin entradas, taxonomías ni usuarios) | Un sitemap propio |
| Indexación | **La base dice "indexar"** (`blog_public` 1), y el mu-plugin la apaga en todo entorno que no sea `production` | Dejar 0 y cambiarlo a mano al publicar: si se olvida, Google no indexa el sitio y nada lo avisa |
| URLs del sitio anterior | Las 3 que tienen una sección equivalente hacen un **301** a ella; las 5 de plantilla responden **410** (ya no existen) | Un 301 de todo a la portada: Google lo trata como un 404 encubierto y tarda más en olvidarlas. Dejarlas en 404: funciona, pero el 410 las saca antes del índice |

### 2.2 Alcance

**Dentro:**
- `campodata-core/seo.php`: Ajustes → SEO, título, descripción, Open Graph, datos estructurados, limpieza, redirecciones e indexación por entorno (§3 a §5 y §7 a §9);
- `config/seo-inicial.json`;
- el ícono y la imagen para compartir, con su fuente y el script que los genera (§4 y §6);
- `bin/setup` y `bin/check` (§10);
- README y DECISIONS (§14).

**Fuera (no lo hagas):**
- Cambiar textos visibles, el `h1`, los encabezados, los `alt` o las imágenes del sistema.
- El despliegue: hosting, HTTPS, un solo host, DNS y Search Console. El Anexo A los deja listados para esa spec.
- Analítica, cookies y política de privacidad.
- El Perfil de Empresa de Google.
- Un blog, páginas nuevas o varios idiomas (`hreflang`).
- Íconos para la pantalla de inicio y manifiesto (`apple-touch-icon`, `theme-color`).
- Un SVG del logo.
- Los logos de apoyo (D27).

---

## 3. Título y descripción

### 3.1 Textos (propuesta)

**Título** (60 caracteres como máximo; Google corta los más largos):

| | Texto | Caracteres | Por qué |
| --- | --- | --- | --- |
| **T1 (recomendado)** | Software para predios lecheros del sur de Chile \| CampoData | 59 | Dice qué es ("software") y para quién ("predios lecheros"), con las palabras que busca un productor. "Del sur de Chile" está en la portada ("medianos productores del sur de Chile") y ayuda en las búsquedas de la zona |
| T2 | CampoData – Gestión simple para tu predio lechero | 49 | El título del sitio actual, sin "SpA". Mantiene lo que Google ya conoce, pero "gestión simple" no es algo que la gente busque |
| T3 | Software de gestión para lecherías \| CampoData | 46 | El más corto. Sin región: sirve si se vende en todo Chile (P6) |

**Descripción** (entre 70 y 155 caracteres):

| | Texto | Caracteres |
| --- | --- | --- |
| **D1 (recomendada)** | Qué mirar hoy, cuánto alimento te queda y cómo va la producción de tu lechería, en simple. Para dueños de predios lecheros y asesores. Solicita una demo. | 153 |
| D2 | CampoData ordena los datos de tu predio lechero y te muestra, en simple, qué mirar hoy, cuánto alimento te queda y cómo va la producción contra tu meta. | 152 |
| D3 | Producción contra tu meta, días de alimento, calidad de la leche y reproducción en una pantalla. Para lecherías de 50 a 200 vacas y sus asesores. | 145 |

Todas salen de frases que la portada ya dice: el banner ("qué mirar hoy, cuánto alimento te queda y cómo va la producción contra tu meta"), Para quién ("Dueños de lecherías", "Asesores") y Por qué CampoData ("predios de 50 a 200 vacas"). Ninguna promete la demo gratis (P9 de la spec 04).

`config/seo-inicial.json` lleva T1 y D1:

```json
{
	"titulo": "Software para predios lecheros del sur de Chile | CampoData",
	"descripcion": "Qué mirar hoy, cuánto alimento te queda y cómo va la producción de tu lechería, en simple. Para dueños de predios lecheros y asesores. Solicita una demo."
}
```

### 3.2 Ajustes → SEO

- La opción `campodata_seo` tiene dos claves, `titulo` y `descripcion`, y está vacía por defecto. Se registra igual que `campodata_contacto` (`register_setting`, `show_in_rest` en `false`, `manage_options`). Las dos se limpian con `sanitize_text_field`: quedan en una línea.
- La pantalla es `add_options_page( 'SEO', 'SEO', 'manage_options', 'campodata-seo', … )` y tiene:
  - **Título para buscadores:** un `input` de texto, con la ayuda "Aparece en la pestaña, en Google y al compartir. Hasta 60 caracteres: Google corta los más largos. Hoy tiene N."
  - **Descripción:** un `textarea` de 3 filas, con la ayuda "Aparece bajo el título en Google y al compartir. Entre 70 y 155 caracteres. Hoy tiene N."
  - Una introducción: "Estos textos se usan en la portada. El teléfono, el correo, la zona y las redes de los datos estructurados salen de Ajustes → Datos de contacto."
- "Hoy tiene N" se calcula en el servidor con `mb_strlen`, al dibujar la pantalla. No hace falta JS.
- Una función `dato_seo( string $clave ): string` devuelve el valor, o una cadena vacía, como `dato_de_contacto()`.

### 3.3 En la portada

Solo en la portada (`is_front_page()`):

- **Título:** el filtro `pre_get_document_title` devuelve `titulo` si no está vacío. Si está vacío, queda el título del core. Las demás páginas, como la 404, conservan el del core ("Página no encontrada – CampoData").
- **Descripción:** `<meta name="description" content="…">`, con `esc_attr`, si `descripcion` no está vacía.

---

## 4. Vista previa al compartir

### 4.1 Etiquetas

Solo en la portada, en `wp_head`:

```html
<meta property="og:type" content="website">
<meta property="og:site_name" content="CampoData">
<meta property="og:locale" content="es_CL">
<meta property="og:url" content="<home_url('/')>">
<meta property="og:title" content="<titulo>">
<meta property="og:description" content="<descripcion>">
<meta property="og:image" content="<tema>/assets/images/compartir/campodata.jpg?ver=<fecha del archivo>">
<meta property="og:image:type" content="image/jpeg">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:alt" content="CampoData: gestión simple y efectiva para tu predio lechero, con la pantalla Hoy de Producción">
<meta name="twitter:card" content="summary_large_image">
```

- Las URL son absolutas (`home_url`, `get_theme_file_uri`). En producción van con `https` (Anexo A).
- El ancho y el alto se leen del archivo con `wp_getimagesize()`, no se escriben a mano.
- Si el archivo no existe, se omiten todas las `og:image*`. El resto de las etiquetas se imprimen igual.
- `og:site_name` es `get_bloginfo( 'name' )`.
- `?ver=` con la fecha del archivo, como el CSS y el ícono: las redes guardan la vista previa en caché.

### 4.2 La imagen

**Archivo:** `assets/images/compartir/campodata.jpg`, de 1200 × 630, en JPG de calidad 85 y con **200 KB como máximo**. WhatsApp no muestra imágenes de más de unos 300 KB.

**Fuente:** `docs/compartir/tarjeta.html`, versionada. Es una página estática de 1200 × 630 que carga las tipografías y las imágenes del tema por ruta relativa (`../../wp-content/themes/campodata/assets/…`). Como es un archivo estático, los colores van escritos en hexadecimal, con un comentario que nombra su token (framework, regla 6).

**Composición**, toda centrada:

| Zona | Contenido |
| --- | --- |
| Fondo | `noche` (`#061A2B`) con el brillo del banner |
| Arriba | El emblema a 96 px, en su ficha blanca como en el encabezado, y "Campo" (`brote`) "Data" (`cielo`) en Sora 700, a 64 px |
| Centro | El `h1` tal cual, "Gestión **simple y efectiva** para tu predio lechero", en Sora 600 a 52 px, en dos líneas como máximo, en `base`, con "simple y efectiva" en el degradado `marca`, como en el banner |
| Abajo | La pantalla `assets/images/sistema/banner-hoy.webp` a 720 px de ancho, en un marco como `cd-marco`, cortada por el borde inferior (se ve su mitad de arriba) |

El emblema, la palabra y el título quedan **dentro del cuadrado central de 630 × 630**: algunas apps muestran la vista previa recortada a un cuadrado.

**Cómo se genera:** con `bin/imagenes-de-marca` (§6.2).

---

## 5. Datos estructurados

Solo en la portada, un único `<script type="application/ld+json">` impreso con `wp_print_inline_script_tag()` y `wp_json_encode( $datos, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE )`. Con los datos de hoy, en local, queda así:

```json
{
	"@context": "https://schema.org",
	"@graph": [
		{
			"@type": "Organization",
			"@id": "http://localhost:8081/#organizacion",
			"name": "CampoData",
			"legalName": "CampoData SpA",
			"url": "http://localhost:8081/",
			"logo": {
				"@type": "ImageObject",
				"url": "http://localhost:8081/wp-content/themes/campodata/assets/images/marca/emblema.webp",
				"width": 256,
				"height": 256
			},
			"email": "contacto@campodata.cl",
			"telephone": "+56 9 2630 4489",
			"areaServed": "Los Ríos y Los Lagos, Chile",
			"contactPoint": {
				"@type": "ContactPoint",
				"contactType": "ventas",
				"email": "contacto@campodata.cl",
				"telephone": "+56 9 2630 4489",
				"availableLanguage": "es"
			}
		},
		{
			"@type": "WebSite",
			"@id": "http://localhost:8081/#sitio",
			"url": "http://localhost:8081/",
			"name": "CampoData",
			"inLanguage": "es-CL",
			"publisher": { "@id": "http://localhost:8081/#organizacion" }
		},
		{
			"@type": "SoftwareApplication",
			"@id": "http://localhost:8081/#aplicacion",
			"name": "CampoData",
			"url": "http://localhost:8081/",
			"applicationCategory": "BusinessApplication",
			"operatingSystem": "Web",
			"inLanguage": "es",
			"description": "<descripcion de Ajustes → SEO>",
			"screenshot": "http://localhost:8081/wp-content/themes/campodata/assets/images/sistema/banner-hoy.webp",
			"publisher": { "@id": "http://localhost:8081/#organizacion" }
		}
	]
}
```

Reglas:

- **De dónde sale cada dato:** `name` es el nombre del sitio; `legalName` es la constante "CampoData SpA" en `seo.php`; `email`, `telephone` y `areaServed` son `correo`, `telefono` y `zona` de los datos de contacto; `description` es la descripción de Ajustes → SEO; las URL salen de `home_url()` y `get_theme_file_uri()`; el ancho y el alto del logo, de `wp_getimagesize()`.
- **Un dato vacío no se imprime:** la propiedad se omite, no va vacía. Si no hay correo ni teléfono, se omite también `contactPoint`.
- **Redes:** `sameAs` lleva las URL de LinkedIn e Instagram de los datos de contacto que no estén vacías. Hoy las dos lo están, así que `sameAs` no aparece (P9).
- **Si falta un archivo del tema** (el emblema o la pantalla), se omite su propiedad.
- **Nunca** llevan `offers`, `aggregateRating`, `review`, `address` ni `foundingDate` (§0.5), ni nombran a terceros, a Corfo o a 3IE (§0.4).

---

## 6. Ícono de la pestaña

### 6.1 Archivos y etiquetas

| Archivo en `assets/images/marca/` | Medida | Uso | Peso máximo |
| --- | --- | --- | --- |
| `favicon-32.png` | 32 × 32 | Pestañas y `/favicon.ico` | 6 KB |
| `favicon-96.png` | 96 × 96 | Resultados de Google (múltiplo de 48) y pantallas de alta densidad | 24 KB |

- Los dos son **el logo de CampoData sin la palabra**: el círculo del logo (`emblema.webp`, el mismo de la esquina del encabezado), reducido y con sus esquinas transparentes. Por dentro el círculo es opaco, así que se ve igual sobre pestañas claras y oscuras. La palabra "CampoData" no va: a 32 px mediría unos 3 px de alto y no se leería, y achicaría el círculo (se comparó el 2026-11-10).
- Se imprimen desde el tema, en `inc/recursos.php`, con la receta de Siete Colores (framework, §7), en `wp_head`:

  ```html
  <link rel="icon" href="…/favicon-32.png?ver=…" sizes="32x32" type="image/png">
  <link rel="icon" href="…/favicon-96.png?ver=…" sizes="96x96" type="image/png">
  ```

- La acción `do_faviconico` redirige `/favicon.ico` a `favicon-32.png`, con `wp_safe_redirect`.
- Si hay un ícono cargado en Ajustes → General (`has_site_icon()`), el tema no imprime el suyo ni redirige `/favicon.ico`.

### 6.2 `bin/imagenes-de-marca`

Un script nuevo que genera las tres imágenes de marca de esta spec. Se corre a mano cuando cambia el emblema, el `h1` o la pantalla del banner. Sus resultados se versionan.

1. **Íconos:** con el PHP del contenedor `wordpress` lee `emblema.webp`, lo reduce con `imagecopyresampled` a 32 y 96 px conservando la transparencia (`imagealphablending( false )` y `imagesavealpha( true )`), y escribe el PNG en la **salida estándar**. El script lo redirige al archivo desde el host: así los archivos quedan a nombre del usuario y no de root.
2. **Imagen para compartir:** captura `docs/compartir/tarjeta.html` con el Chrome del host (`google-chrome --headless=new --hide-scrollbars --window-size=1200,630 --screenshot=<temporal>.png file://…`), la pasa al PHP del contenedor por la entrada estándar y escribe el JPG de calidad 85 en `assets/images/compartir/campodata.jpg`.
3. Al final imprime la medida y el peso de cada archivo, y falla si alguno no tiene su medida o pasa su peso máximo.

Busca `google-chrome` y, si no está, `chromium`. Si no encuentra ninguno, se detiene con un mensaje claro. Como los demás scripts, funciona desde cualquier carpeta.

---

## 7. Limpieza del `<head>`, feeds, búsqueda y sitemap

En `seo.php`, para todo el sitio:

| Qué | Cómo (prioridades del core 7.1.3) |
| --- | --- |
| Enlaces a los feeds | `remove_action( 'wp_head', 'feed_links', 2 )` y `remove_action( 'wp_head', 'feed_links_extra', 3 )` |
| RSD (`EditURI`) | `remove_action( 'wp_head', 'rsd_link' )` |
| Enlace corto | `remove_action( 'wp_head', 'wp_shortlink_wp_head', 10 )` y `remove_action( 'template_redirect', 'wp_shortlink_header', 11 )` |
| REST API | `remove_action( 'wp_head', 'rest_output_link_wp_head', 10 )` y `remove_action( 'template_redirect', 'rest_output_link_header', 11 )`. La REST API sigue funcionando: el editor no usa estos enlaces |
| oEmbed | `remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 4 )` y también la de prioridad 10 (el core la engancha dos veces) |
| Feeds | En `template_redirect` (prioridad 1), si `is_feed()`: `wp_safe_redirect( home_url( '/' ), 301 )` y `exit` |
| Búsqueda | En `template_redirect` (prioridad 1), si `is_search()` y no es el panel: lo mismo. No hay buscador en la landing. La búsqueda de la REST API, que usa el editor, no cambia |
| Sitemap | `wp_sitemaps_post_types` devuelve solo `page`; `wp_sitemaps_add_provider` devuelve `false` para `taxonomies` (los usuarios ya los quita `seguridad.php`). En producción, `/wp-sitemap.xml` lista solo la portada |
| `robots.txt` | No cambia. En producción el core agrega la línea `Sitemap: …/wp-sitemap.xml` |

---

## 8. URLs del sitio anterior

Cuando la landing reemplace a campodata.cl, estas URLs, que hoy están en su sitemap y responden 200, se manejan así:

| URL anterior | Respuesta | Destino |
| --- | --- | --- |
| `/about/` | 301 | `/#para-quien` |
| `/services/` | 301 | `/#como` |
| `/contact/` | 301 | `/#demo` |
| `/blog/` | 410 | — |
| `/sample-page/` | 410 | — |
| `/2026/01/12/hello-world/` | 410 | — |
| `/2026/01/13/unlocking-the-power-of-data-how-campodata-transforms-business-management/` | 410 | — |
| `/category/uncategorized/` | 410 | — |
| `/sitemaps.xml` | 301 | `/wp-sitemap.xml` |

- La tabla vive en una función de `seo.php` (`urls_del_sitio_anterior()`), para sumar URLs sin tocar la lógica.
- Se aplica en `template_redirect` (prioridad 1, antes de `redirect_canonical`) y **solo si la consulta es un 404** (`is_404()`): si algún día se crea una página con una de esas rutas, la página manda.
- Se compara la ruta de `$_SERVER['REQUEST_URI']` (sin la consulta y con la barra final normalizada).
- **301:** `wp_safe_redirect( home_url( $destino ), 301 )`. **410:** `status_header( 410 )` y `nocache_headers()`, y la plantilla 404 del tema se muestra igual.
- Funciona en local y en producción. Antes de publicar, revisa en Search Console si el sitio anterior tiene otras URLs con visitas (Anexo A).

---

## 9. Indexación por entorno

| Pieza | Cambio |
| --- | --- |
| `seo.php` | Si `wp_get_environment_type()` no es `production`, `add_filter( 'pre_option_blog_public', '__return_zero' )`. Cubre local, `development` y `staging` |
| `entorno-local.php` | Se quita esa misma línea, que ahora vive en `seo.php`. El archivo sigue con los correos |
| `bin/setup` | En "Opciones del sitio", `blog_public 1`, con el comentario: "La base dice público. Fuera de producción, el mu-plugin lo apaga (seo.php): así una base migrada a producción queda indexable." |

- WordPress considera `production` a todo sitio que no define `WP_ENVIRONMENT_TYPE`. **Un servidor de pruebas tiene que definirlo como `staging`** (README y Anexo A).
- En local, Ajustes → Lectura muestra marcada la casilla "Disuadir a los motores de búsqueda", porque el filtro devuelve 0. Si alguien guarda esa pantalla, la base vuelve a 0: `bin/setup` lo corrige y `bin/check` lo avisa (R8).

---

## 10. `bin/setup` y `bin/check`

### 10.1 `bin/setup`

- **Opciones del sitio:** `blog_public 1` (§9).
- **Paso nuevo "SEO"**, después de "Datos de contacto", con la misma lógica: si la opción `campodata_seo` no existe, la crea desde `config/seo-inicial.json` con `wp option add … --format=json` y dice "Creados desde config/seo-inicial.json"; si existe, dice "Ya existen: se editan en Ajustes → SEO" y no la toca.

### 10.2 `bin/check`

En la lista de recursos del tema, con su peso máximo en KB:

```
assets/images/marca/favicon-32.png 6
assets/images/marca/favicon-96.png 24
assets/images/compartir/campodata.jpg 200
```

Un bloque nuevo, **"SEO"**, después de "Landing":

| Verificación | Falla o aviso |
| --- | --- |
| El `<title>` de la portada es igual al título de Ajustes → SEO | Falla si no. **Aviso** si pasa los 60 caracteres o si la opción está vacía |
| Hay exactamente una `<meta name="description">` y es igual a la descripción de Ajustes → SEO | Falla si no. **Aviso** si tiene menos de 70 o más de 155 caracteres |
| Están `og:type`, `og:site_name`, `og:locale` (`es_CL`), `og:url`, `og:title`, `og:description`, `og:image` con su ancho, alto y `alt`, y `twitter:card` | Falla y nombra las que faltan |
| `og:image` responde 200 con `image/jpeg` y mide 1200 × 630 | Falla si no |
| Hay exactamente un `application/ld+json`, es JSON válido (con el PHP del contenedor, como `theme.json`) y trae `Organization` con `legalName` "CampoData SpA", `WebSite` y `SoftwareApplication` | Falla si no |
| El JSON-LD no trae `offers`, `aggregateRating`, `review`, `address` ni `foundingDate`, y su correo y su teléfono son los de Ajustes → Datos de contacto | Falla si no |
| El `<head>` no trae feeds, `EditURI`, `shortlink`, oEmbed ni `api.w.org`, y los encabezados de la respuesta no traen `Link` | Falla y nombra lo que queda |
| `/feed/`, `/comments/feed/` y `/?s=leche` responden 301 a la portada | Falla si no |
| Cada URL de §8 responde lo que dice la tabla, y las 301 van a su destino | Falla y nombra la URL |
| En la base, `blog_public` vale 1 (leído con `wp eval` quitando el filtro `pre_option_blog_public`), y la portada local trae `noindex` | Falla si la base vale 0 ("corre bin/setup") o si la portada local no trae `noindex` |
| Con el sitio simulado como público (`wp eval`: el filtro devuelve 1 y se registran los sitemaps del core), el sitemap lista solo la portada | Falla y nombra las URL de más |
| Hay dos `<link rel="icon">` (32 y 96) con `?ver=`, y un GET a `/favicon.ico` redirige a `favicon-32.png` | Falla si no. Si hay un ícono en Ajustes → General, **aviso** y no revisa el del tema (como Siete Colores, C24) |

La verificación de terceros que ya existe (D21) recorre todo el HTML, `<head>` incluido, así que también cubre el título, la descripción y el JSON-LD.

---

## 11. Riesgos de ejecución

| # | Riesgo | Plan A | Plan B |
| --- | --- | --- | --- |
| R1 | Chrome captura la tarjeta con otra medida (en algunas versiones, el modo sin cabeza descuenta la barra del navegador) | `--headless=new --hide-scrollbars --window-size=1200,630` | Capturar a 1200 × 800 y recortar 1200 × 630 desde arriba con GD en el contenedor. Anotarlo |
| R2 | El JPG pasa los 200 KB | Calidad 85 | Bajar a 80 y después a 75. Anotar la calidad final |
| R3 | A 32 px el emblema no se distingue | El emblema tal cual (su círculo es opaco por dentro) | Mostrar al usuario el ícono ampliado al lado de una pestaña real y preguntar antes de recortar o simplificar el logo. No se redibuja sin su visto bueno |
| R4 | `pre_get_document_title` no cambia el título en un tema de bloques | Es el filtro de `wp_get_document_title()`, que usa el core 7.1 | `document_title_parts`, cambiando `title` y quitando `tagline` en la portada. Anotarlo |
| R5 | La redirección de la búsqueda rompe algo del panel o del editor | El editor busca por la REST API, no por `?s=` | Quitar la redirección de la búsqueda (el core ya le pone `noindex`). Anotarlo |
| R6 | Quitar el enlace a la REST API rompe algo | El editor usa `wpApiSettings`, no el descubrimiento | Volver a poner `rest_output_link_wp_head` y su encabezado. Anotarlo |
| R7 | En `wp eval` no se pueden registrar los sitemaps simulando un sitio público | Forzar el filtro a 1 y llamar a `register_sitemaps()` del servidor del core | Verificar solo los filtros: tipos de contenido = `page` y sin `taxonomies` ni `users`. Anotarlo |
| R8 | Alguien guarda Ajustes → Lectura en local y la base vuelve a `blog_public` 0 | `bin/setup` escribe 1 cada vez que corre, y `bin/check` falla si lee 0 | — |
| R9 | Una red social sigue mostrando una vista previa vieja | `?ver=` en la imagen | Tras publicar, forzar la actualización con las herramientas de cada red (Anexo A) |

---

## 12. Orden de ejecución

Al cerrar cada etapa, deja los cambios sin commit y sugiere el mensaje (Conventional Commits, en español y sin tildes). Cada etapa agrega a `bin/check` sus propias verificaciones de §10.2.

0. **Verificar sin cambiar nada:** la rama es `dev` y no hay cambios sin commit (§0.2). Los contenedores están arriba y `bin/check` pasa. Anota el `<head>` de la portada para comparar al final.
1. **Indexación por entorno** (§9): `seo.php` con la regla, `campodata-core.php` lo carga (y su `Description` suma "SEO"), `entorno-local.php` sin la línea y `bin/setup` con `blog_public 1`. Mensaje: `fix(core): solo produccion se indexa y la base queda publica`.
2. **Título y descripción** (§3): la opción, Ajustes → SEO, `config/seo-inicial.json`, el paso de `bin/setup` y las etiquetas. Mensaje: `feat(core): titulo y descripcion para buscadores`.
3. **Limpieza y sitio anterior** (§7 y §8). Mensaje: `feat(core): sin feeds ni busqueda, sitemap de paginas y urls del sitio anterior`.
4. **Ícono** (§6) y la parte de íconos de `bin/imagenes-de-marca`. Mensaje: `feat(tema): icono de la pestana desde el emblema`.
5. **Vista previa al compartir** (§4): `docs/compartir/tarjeta.html`, la parte de la tarjeta de `bin/imagenes-de-marca`, `campodata.jpg` y las etiquetas. Muéstrale la imagen al usuario antes de seguir. Mensaje: `feat(core): vista previa al compartir`.
6. **Datos estructurados** (§5). Mensaje: `feat(core): datos estructurados de campodata`.
7. **Verificación** (§13) y **documentación** (§14). Mensaje: `docs: seo tecnico`.

---

## 13. Criterios de aceptación

- [ ] Se trabajó en `dev` y la IA no hizo commits ni cambió de rama.
- [ ] Ningún texto visible de la landing cambió: `git diff` no toca `patterns/`, `parts/` ni `templates/`.
- [ ] El `<title>` de la portada es el de Ajustes → SEO; la 404 conserva "Página no encontrada – CampoData".
- [ ] La portada tiene una sola meta descripción, igual a la de Ajustes → SEO.
- [ ] Al cambiar el título o la descripción en Ajustes → SEO y guardar, la portada muestra el cambio en `<title>`, en la meta descripción, en `og:title`, en `og:description` y en el JSON-LD. Después se dejan los textos de `config/seo-inicial.json`.
- [ ] Ajustes → SEO solo es visible para administradores y muestra cuántos caracteres tiene cada texto.
- [ ] Están todas las etiquetas Open Graph de §4.1 y `twitter:card`. `og:image` responde 200, es un JPG de 1200 × 630 y pesa 200 KB o menos.
- [ ] El usuario vio la imagen para compartir y la aprobó. El emblema, la palabra y el título quedan dentro del cuadrado central de 630 × 630.
- [ ] Hay un solo JSON-LD, válido, con `Organization` (y `legalName` "CampoData SpA"), `WebSite` y `SoftwareApplication`. Sus datos coinciden con Ajustes → Datos de contacto y Ajustes → SEO, y no lleva precios, calificaciones, reseñas, dirección ni fecha de fundación.
- [ ] Al vaciar el teléfono en Ajustes → Datos de contacto, el JSON-LD lo omite (no queda vacío). Después se repone.
- [ ] Ni el `<head>` ni el JSON-LD nombran a terceros, a Corfo o a 3IE.
- [ ] El `<head>` no trae feeds, RSD, enlace corto, oEmbed ni la REST API, y la respuesta no trae encabezados `Link`. El editor de "Inicio" y el Editor del sitio funcionan igual que antes, con todos los bloques válidos.
- [ ] `/feed/`, `/comments/feed/` y `/?s=leche` responden 301 a la portada.
- [ ] Las URLs de §8 responden su 301 o su 410, y las 410 muestran la plantilla 404 del tema.
- [ ] Hay dos íconos (32 y 96 px), la pestaña muestra el emblema y `/favicon.ico` redirige a `favicon-32.png`.
- [ ] `bin/imagenes-de-marca` regenera los tres archivos, desde otra carpeta, sin cambios de medida ni de peso fuera de sus máximos, y los archivos quedan a nombre del usuario.
- [ ] En la base, `blog_public` vale 1, y la portada local trae `noindex, nofollow`.
- [ ] Con el sitio simulado como público, el sitemap lista solo la portada.
- [ ] `bin/check` pasa con las verificaciones nuevas, `bin/setup` corrido dos veces no duplica nada, `bin/reset --yes` deja todo en pie sin pasos manuales, y `composer lint` pasa sin errores ni advertencias.
- [ ] `README.md` y `docs/DECISIONS.md` están al día (§14).

---

## 14. Documentación

**`README.md`:**
- una sección **"SEO"**: dónde se editan el título y la descripción (Ajustes → SEO) y qué lleva el `<head>` de la portada; de dónde salen los datos estructurados; cómo regenerar el ícono y la imagen para compartir (`bin/imagenes-de-marca`, que necesita Chrome en el host); la indexación por entorno (un servidor de pruebas define `WP_ENVIRONMENT_TYPE` como `staging`); la tabla de URLs del sitio anterior; y el Anexo A como lista "Al publicar";
- en **"Logo"**: el emblema es el logo de CampoData; el ícono de la pestaña sale de él (esta spec); ya no hay una spec 03 pendiente;
- en **"Dónde va cada cosa"**: `seo.php`, `config/seo-inicial.json`, `docs/compartir/`, `assets/images/compartir/`, los íconos de `assets/images/marca/` y `bin/imagenes-de-marca`;
- en **"Plugin de funcionalidad"**: suma el SEO, y el sitio nunca se indexa fuera de producción (no solo en local).

**`docs/DECISIONS.md`:**
- **D28**, SEO técnico con código propio: las decisiones de §2.1;
- **D29**, el emblema es el logo: no hay spec 03, y el ícono sale del emblema (decisión del usuario, 2026-11-10);
- **D30**, indexación por entorno: la base dice "indexar" y el mu-plugin la apaga fuera de producción;
- **D31**, URLs del sitio anterior: la tabla de §8 y por qué 301 o 410;
- **C22**, cambio respecto de la spec 01: `bin/setup` escribe `blog_public` 1, no 0, y la regla de `entorno-local.php` pasa a `seo.php`;
- una entrada por cada riesgo de §11 que se haya materializado, y la tabla "Riesgos de ejecución de la spec 05".

**Framework** (`Clientes Web/FRAMEWORK-WORDPRESS.md`): no lo edites. Al terminar, **propónle al usuario** sumar esta receta de SEO a §8 (hoy dice que el SEO no tiene receta) y la lección de la indexación por entorno a §5.4, para aplicarlas en Siete Colores (framework, §0.6).

---

## 15. Supuestos y preguntas abiertas

| # | Tema | Supuesto de esta spec | Qué cambia si es distinto |
| --- | --- | --- | --- |
| P1 | Título | T1: "Software para predios lecheros del sur de Chile \| CampoData" | Se cambia `config/seo-inicial.json` antes de ejecutar, o en Ajustes → SEO después |
| P2 | Descripción | D1 | Igual que P1 |
| P3 | Dominio de producción | `https://campodata.cl/`, sin `www`, en el lugar del sitio actual | Con otro dominio, hacen falta 301 del dominio anterior al nuevo y el aviso de cambio de dirección en Search Console |
| P4 | Nombre legal | "CampoData SpA" (confirmado por el usuario) | Si en el registro figura escrito de otra forma (el sitio actual dice "Campodata SpA"), se cambia la constante en `seo.php` |
| P5 | Sistema operativo | "Web": la app se usa desde el navegador, en el computador y en el celular | Si hay una app en las tiendas, se suman "Android" o "iOS" |
| P6 | "Del sur de Chile" en el título | La portada lo dice ("medianos productores del sur de Chile") y la zona de contacto es Los Ríos y Los Lagos | Si se vende en todo Chile, T3 |
| P7 | Páginas del sitio anterior | Son de plantilla, en inglés y sin contenido propio que conservar | Si alguna tiene contenido de CampoData, se migra o se redirige a su sección |
| P8 | Imagen para compartir | Usa el `h1` actual | Si cambia el `h1`, se edita `tarjeta.html` y se corre `bin/imagenes-de-marca` |
| P9 | LinkedIn e Instagram | Están vacíos en Ajustes → Datos de contacto, así que `sameAs` no aparece | Al completarlos aparecen solos en el JSON-LD |

---

## Anexo A · Al publicar (para la spec de despliegue)

Esta spec no despliega, pero el SEO depende de estos pasos:

1. **HTTPS y un solo host:** `http://campodata.cl/` y `https://www.campodata.cl/` hacen un 301 a `https://campodata.cl/`. Hoy el sitio actual responde 200 en las tres.
2. **Entorno:** en producción, `WP_ENVIRONMENT_TYPE` es `production` o no se define. En un servidor de pruebas, `staging`.
3. **URLs:** `home` y `siteurl` son `https://campodata.cl`.
4. **Revisión:** la portada no trae `noindex`, y `https://campodata.cl/robots.txt` trae `Sitemap: https://campodata.cl/wp-sitemap.xml`.
5. **Search Console:** una propiedad de dominio; antes de cambiar el sitio, exportar las páginas con visitas del sitio anterior y sumar a §8 las que falten; después, enviar `/wp-sitemap.xml`, quitar `/sitemaps.xml` e inspeccionar la portada para pedir que la indexe.
6. **Datos estructurados:** la prueba de resultados enriquecidos de Google y validator.schema.org, con la URL publicada.
7. **Vista previa:** compartir la URL por WhatsApp, y refrescarla en el depurador de Facebook y en el inspector de publicaciones de LinkedIn.
8. **Sitio anterior:** las URLs de §8 responden su 301 o su 410.
