# Decisiones

Registro de las decisiones del proyecto. Hay dos tipos de entrada:

- **Decisión:** una elección de arquitectura o de forma de trabajo. Se escribe con *contexto*, *decisión* y *alternativas descartadas*.
- **Cambio respecto de la spec:** cuando la implementación se aparta de lo que dice una spec. Se escribe con *qué decía la spec*, *qué se hizo* y *por qué*.

Las entradas nuevas van al final de su sección. Un plugin de terceros nuevo siempre necesita una entrada (ver "Política de plugins de terceros").

Este proyecto sigue `Clientes Web/FRAMEWORK-WORDPRESS.md`. Las decisiones D01 a D11 son las estándar del framework y vienen de Siete Colores, donde se discutieron con más detalle.

---

## Decisiones

### D01 · WordPress estándar en vez de Bedrock

*2026-10-28 · spec 01*

- **Contexto:** hay que elegir cómo se organiza el proyecto. El hosting de producción todavía no está definido.
- **Decisión:** estructura estándar de WordPress. El repo versiona solo el tema, el mu-plugin, la configuración del entorno y los scripts; el core lo pone la imagen de Docker. Desplegar es copiar `wp-content/themes/campodata` y `wp-content/mu-plugins` al servidor.
- **Alternativas descartadas:** Bedrock (Composer gestiona el core y los plugins, y el *document root* pasa a `web/`). Exige cambiar el *document root* y correr Composer en el servidor, algo que muchos hostings compartidos no permiten. Como el código propio queda aislado, se puede migrar a Bedrock más adelante sin reescribirlo.

### D02 · Docker Compose en vez de wp-env

*2026-10-28 · spec 01*

- **Contexto:** el entorno local tiene que ser reproducible desde el repo, en cualquier máquina con Docker.
- **Decisión:** Docker Compose con las imágenes oficiales `wordpress:7.1.3-php8.4-apache`, `wordpress:cli-2.12.0-php8.4` y `mariadb:11.8.9`, las últimas de cada línea al 2026-10-28. Todo se instala con `bin/setup`, sin pasos manuales en `wp-admin`.
- **Alternativas descartadas:** `@wordpress/env`, más simple, pero esconde la configuración y depende de Node; LocalWP, que no se puede reproducir desde el repo.

### D03 · Tema de bloques propio

*2026-10-28 · spec 01*

- **Contexto:** el sitio necesita un tema que se pueda diseñar por completo y mantener sin depender de terceros.
- **Decisión:** tema de bloques propio, desde cero (`campodata`): plantillas HTML de bloques, `theme.json` como fuente única de los tokens de diseño y patrones en PHP.
- **Alternativas descartadas:** un tema clásico, que no tiene Editor del sitio ni `theme.json` completo; un tema hijo de un tema por defecto, que depende de actualizaciones ajenas y hereda estilos que habría que anular.

### D04 · Sin constructor de páginas

*2026-10-28 · spec 01*

- **Contexto:** hace falta armar la landing por secciones y que alguien no técnico pueda editar el contenido.
- **Decisión:** editor de bloques nativo, con patrones propios para cada sección.
- **Alternativas descartadas:** Elementor, Divi y similares. Encierran el contenido en su propio formato, pesan en rendimiento y atan el sitio al plugin.

### D05 · El contenido de la landing vive en la página "Inicio"

*2026-10-28 · spec 01*

- **Contexto:** la landing se puede escribir dentro de la plantilla de portada o en una página.
- **Decisión:** una página "Inicio" asignada como portada. Las plantillas solo arman la estructura (encabezado, contenido y pie). Mientras nadie guarde la página, muestra el patrón provisional; al guardarla en el editor, el contenido queda copiado en ella.
- **Alternativas descartadas:** escribir el contenido en `front-page.html`, que obliga a editar la landing desde el Editor del sitio y mezcla diseño con contenido.

### D06 · Tokens semánticos y editor limitado a los tokens

*2026-10-28 · spec 01*

- **Contexto:** la identidad visual llega en la spec 02, pero el contenido y los patrones necesitan referenciar colores, tamaños y espaciados desde ya.
- **Decisión:** los colores tienen slugs por función (`base`, `contraste`, `primario`, `secundario`, `acento` y `suave`); los tamaños de fuente y espaciados usan los slugs estándar de WordPress (`small` a `xx-large` y `20` a `80`), por compatibilidad con los bloques del core. Hoy los valores son provisionales: grises y la fuente del sistema. Quien edite contenido solo elige entre los tokens del tema: sin color libre, degradados libres, tamaños de fuente libres ni espaciados libres. Se puede revisar si el cliente lo pide.
- **Alternativas descartadas:** slugs por nombre de color (`verde`, `azul`), con los que un cambio de marca deja el contenido con nombres falsos; valores libres en el editor, con los que el sitio pierde consistencia visual con el tiempo.

### D07 · Un plugin *must-use* para la funcionalidad propia

*2026-10-28 · spec 01*

- **Contexto:** hay funcionalidad que no es presentación (seguridad, protecciones del entorno local) y que tiene que seguir funcionando aunque cambie el tema.
- **Decisión:** plugin *must-use* `campodata-core`. WordPress solo carga los PHP de la raíz de `mu-plugins`, así que `campodata-core.php` carga los archivos de la carpeta `campodata-core/`.
- **Alternativas descartadas:** ponerlo todo en `functions.php` del tema.

### D08 · Política de plugins de terceros

*2026-10-28 · spec 01*

- **Contexto:** instalar plugins a mano desde `wp-admin` hace que cada entorno termine distinto y que nadie sepa por qué está cada uno.
- **Decisión:** cada plugin se declara con versión exacta en `config/plugins.txt` (producción) o `config/plugins-dev.txt` (solo local), y `bin/setup` lo instala. Un plugin de producción nuevo necesita una entrada aquí: para qué sirve, qué alternativas se miraron y por qué no basta el core. Hoy no hay plugins de producción. En local están Create Block Theme 2.10.2 (pasa al tema los cambios hechos en el Editor del sitio) y Query Monitor 4.1.1 (depura consultas, hooks y errores de PHP), las últimas versiones estables al 2026-10-28. Query Monitor publicó la 4.1.1 el 2026-10-27; Siete Colores sigue en 4.0.7.
- **Alternativas descartadas:** instalarlos a mano desde `wp-admin`.

### D09 · Textos fijos en español, sin funciones de traducción

*2026-10-28 · spec 01*

- **Contexto:** el sitio apunta solo a Chile.
- **Decisión:** los textos van fijos, en español, en todo el código propio: plantillas, patrones y PHP. El idioma de `wp-admin` y el `lang="es-CL"` del sitio no dependen de esto, sino del paquete de idioma `es_CL`.
- **Alternativas descartadas:** envolver los textos en funciones de traducción. Las plantillas HTML de bloques ni siquiera las admiten. Si algún día el sitio necesita varios idiomas, habrá que envolverlos en ese momento.

### D10 · Sin recursos de terceros

*2026-10-28 · spec 01*

- **Contexto:** la portada no debe pedir nada a otros dominios, por privacidad y rendimiento.
- **Decisión:** el mu-plugin apaga los emojis de WordPress, que se cargan desde `s.w.org` (ver D13 para el detalle). Las tipografías de la marca se servirán desde el tema (spec 02). `bin/check` falla si la portada pide algo a un dominio externo o trae el script o los estilos de los emojis.
- **Alternativas descartadas:** dejar los emojis del core; Google Fonts por CDN.

### D11 · El enlace "Volver a la portada" de la página 404 apunta a `/`

*2026-10-28 · spec 01*

- **Contexto:** las plantillas HTML de bloques no pueden calcular la URL del sitio.
- **Decisión:** el enlace usa `/`, que funciona mientras el sitio esté en la raíz del dominio.
- **Alternativas descartadas:** un patrón en PHP con `home_url()`, que se puede revisar si el hosting obliga a instalar WordPress en una subcarpeta.

### D12 · Puerto 8081 y proyecto de Compose propio

*2026-10-28 · spec 01*

- **Contexto:** Siete Colores usa el puerto 8080 y el proyecto de Compose `siete-colores` en la misma máquina.
- **Decisión:** CampoData usa el puerto 8081 y el proyecto `campodata`, con sus propios contenedores (`campodata-wordpress-1`, `campodata-db-1`) y volúmenes (`campodata_db_data`, `campodata_wordpress_data`). Se comprobó con los dos sitios levantados a la vez: cada uno responde en su puerto con su propio sitio. El puerto queda anotado en el registro del framework.
- **Alternativas descartadas:** compartir el 8080 y levantar un sitio a la vez.

### D13 · Los estilos de los emojis se apagan quitando `print_emoji_styles`

*2026-10-28 · spec 01, corregido durante la ejecución*

- **Contexto:** la v1 de la spec copiaba de Siete Colores la forma de apagar los emojis: quitar `wp_enqueue_emoji_styles` de `wp_enqueue_scripts`. Al verificar se encontró que la portada igual traía el CSS de los emojis (`img.wp-smiley, img.emoji {…}`) y que `debug.log` anotaba dos avisos por visita: "La función print_emoji_styles está descontinuado desde la versión 6.4.0". En el core 7.1.3, `default-filters.php` mantiene enganchada la función obsoleta `print_emoji_styles` en `wp_print_styles` por compatibilidad, y la única que la desengancha es `wp_enqueue_emoji_styles()`, justo la que se quitaba.
- **Decisión:** `seguridad.php` quita `print_emoji_styles` de `wp_print_styles`, que es la vía que el propio core documenta ("Back-compat for plugins that disable functionality by unhooking this action"). Con eso, `wp_enqueue_emoji_styles()` no hace nada. Se mantienen la eliminación del script de detección y el filtro `emoji_svg_url`. Después del cambio, la portada no menciona los emojis y `debug.log` queda vacío tras visitar la portada y la página 404. `bin/check` ahora falla si la portada trae el script o los estilos de los emojis. La spec se corrigió antes de su primer commit, porque sirve de plantilla para los clientes siguientes.
- **Alternativas descartadas:** quitar las dos cosas: con `print_emoji_styles` fuera, quitar `wp_enqueue_emoji_styles` ya no hace falta. **Siete Colores tiene el mismo problema** y se puede corregir allá con el mismo cambio.

### D14 · Identidad desde el logo nuevo: noche y blanco, con los colores del logo como acentos

*2026-11-02 · spec 02*

- **Contexto:** el usuario quiere que la landing transmita tecnología nueva a dueños de lecherías, ganaderos y asesores, y entregó un logo nuevo (JPG). El sitio anterior usaba otra paleta (verdes, azul y un naranja que el logo no tiene) y Fraunces, una serif editorial.
- **Decisión:**
  - **Paleta medida del JPG:** `primario` es el marino de la vaca (`#034A87`) y `acento` el amarillo de la espiga (`#FCCB04`); se suman `noche`, `bruma`, `borde` y cuatro colores con el nombre de su parte del logo (`cielo`, `brote`, `pradera`, `surco`). El contraste de cada combinación de texto se midió (README, "Identidad").
  - **Tono:** el banner, Reportes, la demo, el encabezado y el pie van sobre `noche`; las secciones de lectura, en blanco y en `suave`.
  - **Tipografías:** Sora (títulos) y DM Sans (texto, la del sitio anterior), de Fontsource 5.3.0 (consultado el 2026-11-02), con su licencia OFL, servidas desde el tema y precargadas.
  - **Motivo visual:** los píxeles del logo, que salen del campo hacia el cielo, son el campo de píxeles animado del banner y de la demo.
- **Alternativas descartadas:** conservar la paleta y Fraunces del sitio anterior (no coinciden con el logo nuevo ni se leen tecnológicas); Space Grotesk (más liviana, pero sus formas no se parecen a la palabra del logo).

### D15 · La portada es una página de secciones, compuesta por `landing.php`

*2026-11-02 · spec 02*

- **Decisión:** "Inicio" solo contiene `<!-- wp:pattern {"slug":"campodata/landing"} /-->`. `landing.php` (`Inserter: no`) ordena siete patrones de sección: banner, para quién, cómo funciona, reportes, beneficios, por qué y demo. `bin/setup` migra "Inicio" desde el contenido provisional de la spec 01 y no toca una página con contenido propio. Hay un solo `h1`, y `bin/check` verifica las anclas en orden.
- **Alternativas descartadas:** escribir las secciones directo en la página (el diseño quedaría en la base).

### D16 · Sección nueva "Para quién"

*2026-11-02 · spec 02*

- **Contexto:** el sitio anterior hablaba solo a productores lecheros; el usuario quiere sumar a ganaderos y asesores.
- **Decisión:** una tarjeta por perfil, justo después del banner. Lo que el sitio anterior ya decía se reutiliza; lo propio de la ganadería de carne y de los asesores queda como texto guía hasta que el cliente lo confirme. Cada tarjeta lleva al formulario con su perfil elegido.
- **Alternativas descartadas:** un banner por perfil (triplica el contenido).

### D17 · Reportes reales en pestañas del core, y banner sin foto

*2026-11-02 · spec 02*

- **Decisión:** las capturas de Power BI del sitio anterior, pasadas a WebP, en el bloque `tabs` del core dentro de un marco de aplicación (estilo `ventana`). El banner no lleva foto: un panel ilustrado en SVG (sin números ni ejes con valores) muestra un gráfico y la recomendación "Baja 2 kg de soya al Lote C hoy.", que es del sitio anterior. No se usó la foto de banco del sitio anterior.
- **Alternativas descartadas:** un panel de Power BI embebido (contenido de terceros); ilustraciones genéricas en vez de las capturas reales.

*La web ya no nombra la herramienta de los reportes, y la captura "Producción Leche" se limpió de nombres de terceros: ver D21.*

### D18 · Movimiento con CSS, SVG animados y un módulo JS propio

*2026-11-02 · spec 02*

- **Decisión:** la receta de campodata.cl (framework §6.4) más 15 efectos con código (M1 a M15, README "Movimiento"). Las animaciones decorativas que se repiten viven dentro de los SVG (`pixeles.svg`, `panel.svg`), con su propio `@media (prefers-reduced-motion)`. Un script de una línea en el `<head>` agrega `cd-con-js` y `cd-movimiento`, y quita la segunda si el módulo no carga en 3 segundos. Lo que se repite se pausa fuera de la vista y con la pestaña oculta.
- **Alternativas descartadas:** AOS, GSAP o Lottie (framework §1.9); un `<canvas>` con JS para los píxeles (más código y nada sin JS); decenas de bloques vacíos animados (en el editor parecen grupos por completar).

### D19 · Encabezado oscuro y fijo, con cristal y barra de progreso

*2026-11-02 · spec 02*

- **Decisión:** el encabezado es `noche`, del mismo color que el banner, y queda fijo. Pasados los 20px de scroll gana un cristal translúcido con desenfoque, y en su borde inferior una barra con el degradado de la marca muestra cuánto se leyó. El enlace de la sección visible queda marcado.
- **Alternativas descartadas:** un encabezado blanco sobre el banner oscuro; uno transparente encima del banner, que exige un margen negativo atado al alto del encabezado.

### D20 · Demo por WhatsApp y correo, con datos en una sola fuente

*2026-11-02 · spec 02*

- **Decisión:** los datos viven en la opción `campodata_contacto` (Ajustes → Datos de contacto, mu-plugin `contacto.php`) y se muestran con la fuente de *block bindings* `campodata/contacto`. `bin/setup` la crea una sola vez desde `config/contacto-inicial.json`, con el WhatsApp del botón del sitio anterior (`56926304489`) y `contacto@campodata.cl`. **No se usó** el `56912345678` del pie anterior, que es un número de ejemplo; `bin/check` falla si aparece. El formulario arma el mensaje de WhatsApp en el navegador, sin enviar nada a un servidor.
- **Alternativas descartadas:** un formulario con envío de correo (SMTP y antispam, framework §8); `fandradeg@campodata.cl`, el correo del botón anterior (queda como pregunta P8 de la spec: se cambia en Ajustes).

### D21 · La web no nombra sistemas ni empresas de terceros

*2026-11-02 · pedido del usuario después de la spec 02 (spec 02 v2)*

- **Contexto:** la landing reutilizaba textos del sitio anterior que nombraban DairyPlan, Excel y Power BI, y la captura "Producción Leche" mostraba "WATTS" en dos títulos y "DP" en una columna y en una leyenda. El usuario pidió sacar cualquier alusión a sistemas de terceros, porque "nos podría meter en problemas", y aclaró que CampoData se adapta a las tecnologías y la maquinaria que tiene cada predio.
- **Decisión:**
  - **Textos:** donde se nombraba un sistema, el mensaje pasa a ser la adaptación: el párrafo del banner ("Nos adaptamos a la tecnología y la maquinaria que ya tiene tu predio…"), la tarjeta del panel ("Se adapta a la tecnología de tu predio"), el tercer punto de "Dueños de lecherías", el paso 01 de Cómo funciona (ahora "Nos adaptamos a tu predio"), el punto "Se adapta a lo que ya tienes" de Por qué CampoData y la fila "Se adapta a tu tecnología y maquinaria" de la comparación. Reportes deja de decir "de Power BI" en el párrafo, en el título de la ventana y en los `alt`.
  - **Imagen:** en "Producción Leche" se borró "WATTS" de "Leche WATTS Mes" y "Leche WATTS Diario" (la palabra siguiente se corrió para no dejar un hueco), "DP" de la columna "Total DP" y la leyenda "Prod. DP" completa. No se escribió texto nuevo en la imagen. Las otras tres capturas no nombran a terceros.
  - **Contacto:** WhatsApp, LinkedIn e Instagram se mantienen: son canales para escribirle a CampoData, no sistemas con los que trabaja.
  - **Verificación:** `bin/check` falla si la portada nombra DairyPlan, Power BI, Excel o WATTS (la lista está en el script; "excelente" no cuenta).
- **Alternativas descartadas:** decir "compatible con los principales sistemas del mercado" (sigue aludiendo a terceros y promete algo que no se puede verificar); quitar la captura "Producción Leche" (es la más clara de las cuatro); difuminar las palabras en vez de borrarlas (se nota la marca de la edición).

---

## Cambios respecto de la spec 01

Sin cambios: la implementación sigue la spec 01 (con la corrección de D13 ya incorporada en su texto).

---

## Riesgos de ejecución de la spec 01 (§12)

| # | Riesgo | Qué pasó |
| --- | --- | --- |
| R1 | Parche más nuevo o etiqueta inexistente | No pasó: al 2026-10-28, 7.1.3, `cli-2.12.0-php8.4` y 11.8.9 siguen siendo las últimas de su línea en Docker Hub |
| R2 | Apache (UID 33) no puede escribir en las carpetas montadas desde el repo | **Pasó**, como se esperaba: la carpeta del tema es del usuario del host (UID 1000, permisos 775) y el UID 33 no puede escribir en ella. Se aplicó el plan A: no hace falta escribir desde WordPress en esta spec. El README documenta el plan B (`setfacl` o exportar el zip). No se cambiaron permisos |
| R3 | El puerto 8081 está ocupado | No pasó |
| R4 | Sin internet no se instala `es_CL` | No pasó con el idioma. Sí hubo un corte con `api.wordpress.org` en la primera instalación: `bin/setup` se detuvo en el paso de plugins ("WordPress no pudo establecer una conexión segura a WordPress.org"). Un minuto después, el contenedor respondía 200, y al volver a correr `bin/setup` retomó y terminó. Quedó en "Problemas conocidos" del README |
| R5 | No se puede sacar `screenshot.png` | No pasó: se sacó de la portada con Chrome sin cabeza, a 1200 × 900 |

---

## Cambios respecto de la spec 02

### C01 · Se empezó con la spec sin commit

- **Qué decía la spec:** §0.2 y la etapa 0: el árbol de trabajo debe estar limpio al empezar.
- **Qué se hizo:** se ejecutó con un solo archivo sin commit, la propia spec (`specs/02-spec-estructura-landing.md`).
- **Por qué:** el usuario pidió implementarla en la misma sesión en que se escribió. La spec se puede commitear sola, antes que el resto.

### C02 · Reportes tiene cuatro pestañas, no cinco

- **Qué decía la spec:** §6.4 y P6: sumar "Leche por Lote" como segunda pestaña, porque en el sitio anterior tenía panel pero no botón.
- **Qué se hizo:** cuatro pestañas, como el sitio anterior: Producción Leche, Distribución Animales, Resumen Diario e Inventario Animal.
- **Por qué:** la imagen del panel "Leche por Lote" del sitio anterior es **idéntica byte a byte** a la de "Producción Leche" (mismo MD5). Su leyenda describiría un reporte que no se ve. Si existe la captura real, se agrega como quinta pestaña.

### C03 · Beneficios en una grilla de 4 columnas

- **Qué decía la spec:** §6.5: 3 columnas y 2 filas, con la primera y la última tarjeta de 2 columnas.
- **Qué se hizo:** 4 columnas y 2 filas (2 + 1 + 1 y 1 + 1 + 2). En tablet, 2 columnas con las mismas dos tarjetas anchas; en móvil, una.
- **Por qué:** seis tarjetas con dos dobles ocupan 8 celdas, y 3 × 2 son 6.

### C04 · Íconos con su color escrito

- **Qué decía la spec:** §11: íconos pintados con máscara y `currentColor`.
- **Qué se hizo:** 13 SVG de trazo propios en `assets/images/iconos/`, en `primario` (`#034A87`) escrito en el archivo, dentro de bloques `image`. La ficha que los rodea sí toma el color del perfil o del beneficio desde los tokens.
- **Por qué:** es la lección C18 de Siete Colores: una máscara necesita un bloque vacío, que en el editor parece un grupo por completar. Con imagen, cada ícono se ve y se cambia en el editor.

### C05 · Los números de los pasos son pequeños

- **Qué decía la spec:** §6.3: el número grande "01" a "04" en `borde`.
- **Qué se hizo:** el número va en `small`, en `surco`, con interletra, entre el nodo y el título.
- **Por qué:** arriba a la derecha de cada paso quedaba justo sobre la línea que une los nodos, que lo cortaba.

### C06 · El menú pasa al botón móvil bajo 861px

- **Qué decía la spec:** §7 y R9: el menú del core (botón bajo 600px); si se desborda, ocultar el botón "Solicitar demo" bajo 1100px.
- **Qué se hizo:** el botón "Solicitar demo" del encabezado se oculta hasta 1023px, y entre 600 y 860px el CSS muestra el botón del menú móvil, que el core solo muestra bajo 600px. El menú móvil trae un enlace "Solicitar demo" en `acento` que en escritorio no se ve (clase `cd-solo-menu-movil`).
- **Por qué:** medido de a 1px, el encabezado se desbordaba entre 320 y 374px (el botón seguía visible: la regla del core para `.wp-block-buttons` ganaba en especificidad), entre 600 y 711px y entre 782 y 817px. Después del cambio, no hay desborde ni scroll horizontal en ningún ancho entre 320 y 1500px.

### C07 · El cristal del encabezado va en un pseudoelemento

- **Qué decía la spec:** §7: `backdrop-filter` en el encabezado al bajar.
- **Qué se hizo:** el fondo translúcido y el desenfoque van en `header::before`.
- **Por qué:** un `backdrop-filter` en el encabezado lo vuelve el contenedor de sus elementos `position: fixed`. Al abrir el menú móvil después de bajar, el menú quedaba encerrado en los 72px del encabezado.

### C08 · Ajustes del banner

- **Qué decía la spec:** §6.1: `minHeight` en el bloque; el campo de píxeles en la mitad inferior izquierda; solo la tarjeta de recomendación sobre el panel.
- **Qué se hizo:**
  - la altura mínima (`max(560px, 100vh − 72px)`) va en CSS y no en el bloque, para no estorbar en el editor; bajo 782px no hay altura mínima;
  - los píxeles van a la derecha, detrás del panel (el SVG espejado), y en móvil solo en el 38% inferior;
  - sobre el panel hay una segunda tarjeta, tomada de "Compatible con lo que ya usas" del sitio anterior. Desde D21 dice "Se adapta a la tecnología de tu predio";
  - el enlace de la marca no lleva `aria-label`: su texto, "CampoData", ya lo nombra.
- **Por qué:** a la izquierda, los píxeles quedaban detrás del título y del párrafo y estorbaban la lectura; en móvil, detrás del párrafo. La segunda tarjeta equilibra el panel y repite un mensaje real.

### C09 · El degradado del cierre se anima en un pseudoelemento

- **Qué decía la spec:** M13: desplazar el degradado `cierre` de la sección.
- **Qué se hizo:** la sección conserva su degradado (el editor lo muestra), y la animación va en `.cd-demo::after`.
- **Por qué:** la clase del degradado del core usa `background: … !important`, y una animación no puede cambiar una propiedad con `!important`.

### C10 · Pausa de lo que se repite

- **Qué decía la spec:** §10.2: pausar con `animation-play-state`.
- **Qué se hizo:** las animaciones del CSS se pausan así. Las que viven dentro de los SVG no se pueden pausar desde la página: fuera de la vista, el campo de píxeles y el panel se ocultan con `visibility` (nadie los ve en ese momento).
- **Por qué:** un SVG cargado como imagen o como fondo es un documento aparte.

### C11 · Las capturas de Reportes no se cargan en diferido

- **Qué decía la spec:** §11: `loading="lazy"` en las imágenes de las pestañas ocultas.
- **Qué se hizo:** se cargan las cuatro.
- **Por qué:** el bloque `image` no guarda ese atributo, y el core no lo agrega a imágenes sin ancho ni alto. Las cuatro suman 289 KB, y la portada completa pesa 469 KB en 32 pedidos, menos de la mitad del máximo de 1 MB.

### C12 · Peso del CSS

- **Qué decía la spec:** §10.2: `sitio.css` hasta 24 KB y `movimiento.js` hasta 12 KB, sin minificar.
- **Qué se hizo:** `sitio.css` pesa 36 KB (8 KB comprimido) y `movimiento.js` 9,6 KB (3,6 KB comprimido).
- **Por qué:** los 15 efectos, la tabla, el formulario sobre fondo oscuro, el menú móvil y los ajustes de C05 a C10. Como en Siete Colores (C15), el peso comprimido es lo que cuenta en la portada.

### C13 · Detalles del formulario y de la tabla

- **Qué decía la spec:** nada de esto.
- **Qué se hizo:**
  - los campos del formulario llevan ejemplos ("Nombre y apellido", "Fundo, lechería o empresa"), y sin JS se oculta toda su tarjeta, no solo el formulario;
  - en pantallas de hasta 600px, los rótulos de la tabla van sin mayúsculas ni interletra, con otros anchos de columna y guiones automáticos en la primera columna.
- **Por qué:** sin JS quedaba una tarjeta de cristal vacía. A 390px, la tabla partía palabras ("CAM POD ATA", "Recomendacion es").

---

## Riesgos de ejecución de la spec 02 (§14)

| # | Riesgo | Qué pasó |
| --- | --- | --- |
| R1 | Las pestañas no dejan poner la barra ni el reflejo | No pasó: la barra es un `group` hermano de las pestañas y el reflejo un `::after` de la ventana |
| R2 | El SVG animado no anima o no respeta el movimiento reducido | No pasó en Chrome 156: con movimiento reducido la línea del panel aparece completa y quieta. No se probó en Safari ni en Firefox |
| R3 | `background-clip: text` deja el título invisible | No pasó. Hay respaldo en `acento` con `@supports` y con `forced-colors` |
| R4 | La grilla bento no admite tarjetas anchas | No pasó con la grilla del core, pero la geometría de la spec no cerraba: C03 |
| R5 | Halo en el emblema recortado | No pasó: recorte circular con suavizado, sobre una ficha blanca con anillo (256 × 256, 15 KB) |
| R6 | Capturas borrosas en alta densidad | Pendiente de revisar en una pantalla real: las capturas de origen miden 1100px y se muestran a 1100px como máximo. Conviene pedir exportaciones de 2200px |
| R7 | `social-link` no toma la URL enlazada | No pasó: WhatsApp y correo toman su URL; LinkedIn e Instagram, vacíos, no aparecen |
| R8 | El formulario pierde atributos al guardar la página | No se probó guardar "Inicio" desde el editor (cambiaría su contenido). El editor valida los 576 bloques sin errores |
| R9 | El encabezado se desborda | **Pasó** entre 320–374, 600–711 y 782–817px. Se aplicó una variante del plan B: C06 |
| R10 | La inclinación del panel deja el texto borroso | No se observó en Chrome sin cabeza. Se verificó que el ángulo no pasa de 6° |
| R11 | El foco de luz choca con los fondos | No pasó: `::before` con `z-index: -1` en una tarjeta con `isolation: isolate` |
| R12 | Las animaciones que se repiten gastan batería | No se midió en un teléfono. Se pausan fuera de la vista (C10) |
