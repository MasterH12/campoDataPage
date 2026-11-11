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

*2026-11-02 · spec 02; alcance reducido el mismo día (D22)*

- **Contexto:** el sitio anterior hablaba solo a productores lecheros; el usuario quiere sumar a los asesores.
- **Decisión:** una tarjeta por perfil (dueños de lecherías y asesores), justo después del banner. Lo que el sitio anterior ya decía se reutiliza; lo propio de los asesores queda como texto guía hasta que el cliente lo confirme. Cada tarjeta lleva al formulario con su perfil elegido.
- **Alternativas descartadas:** un banner por perfil.

### D17 · Reportes reales en pestañas del core, y banner sin foto

*2026-11-02 · spec 02*

- **Decisión:** las capturas de Power BI del sitio anterior, pasadas a WebP, en el bloque `tabs` del core dentro de un marco de aplicación (estilo `ventana`). El banner no lleva foto: un panel ilustrado en SVG (sin números ni ejes con valores) muestra un gráfico y la recomendación "Baja 2 kg de soya al Lote C hoy.", que es del sitio anterior. No se usó la foto de banco del sitio anterior.
- **Alternativas descartadas:** un panel de Power BI embebido (contenido de terceros); ilustraciones genéricas en vez de las capturas reales.

*La web ya no nombra la herramienta de los reportes, y la captura "Producción Leche" se limpió de nombres de terceros: ver D21. **Reemplazada por D23:** las capturas de reportes se retiraron porque podían identificar un predio real, y Reportes muestra ahora pantallas del sistema con datos de demostración.*

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

### D22 · El alcance es solo predios lecheros y asesores

*2026-11-02 · pedido del usuario después de la spec 02 (spec 02 v3)*

- **Decisión:** se elimina el alcance de predios ganaderos (carne). Se quitó la tarjeta "Ganaderos" (Para quién queda en 2 columnas), la opción "Ganadero" del formulario y su CSS, y los textos pasaron a hablar de lechería: el título del banner ("…para tu predio lechero") y el pie ("predios lecheros").
- **Alternativas descartadas:** dejar la tarjeta con textos guía (promete un servicio que no se ofrece).

### D23 · Imágenes del sistema en la landing

*2026-11-09 · spec 04 (versión 2, con el análisis de administración `ANALISIS_LANDING.md`)*

- **Contexto:** el usuario dejó en `imagenes-sistema/` 73 capturas del sistema de CampoData, y administración las analizó: qué se puede publicar, qué muestra datos poco realistas y qué promete la landing que la app no hace. Las capturas de reportes de la landing (del sitio anterior) usaban un ejemplo de "~2.000 vacas", y el Campo A tiene 2.116 vacas en ordeña: el predio podía reconocerse.
- **Decisión:**
  - **Nueve imágenes del Campo Demostración** (datos ficticios), una por mensaje y sin repetir. La tabla de correspondencia está en el README ("Imágenes del sistema") y en la spec 04.
  - **Dónde viven:** `assets/images/sistema/`, versionada y dentro del tema, así que viaja con él al desplegar. `imagenes-sistema/` sigue local e ignorada.
  - **Retiradas:** `assets/images/reportes/` (las capturas del sitio anterior) y `assets/images/ilustraciones/panel.svg`. `bin/check` falla si vuelve la carpeta de reportes.
  - **Formato:** WebP de calidad 82, a la medida de origen. Pesos finales: `banner-hoy` 39,8 KB · `banner-movil-inicio` 17,4 · `perfil-lecheria-inicio` 21,5 · `perfil-asesor-explicame` 30,5 · `accion-que-mirar-hoy` 9,6 · `accion-cuando-pedir` 13,4 · `reportes-produccion` 53,6 · `reportes-calidad` 51,2 · `adaptacion-ciclo-reproductivo` 18,8. En total, 256 KB.
  - **Retoques sin inventar:** se borraron los punteros pintando con el color del fondo o copiando píxeles idénticos del propio sistema. En la pantalla de Calidad, el distintivo "2 de 9 análisis fuera del contrato" se copió de `12_calidad_rcs.jpg`, donde está igual y sin puntero. "Explícame" se recortó antes de la franja "DEMO · Simular datos nuevos". Cada retoque se revisó ampliado, contra el original.
  - **Carga:** `inc/imagenes.php` toma el ancho y el alto de cada archivo (el core solo difiere la carga de imágenes que los traen), carga de inmediato las dos del banner (la pantalla con `fetchpriority="high"`) y difiere las demás.
  - **Ampliar:** todas, salvo las del banner, con la ampliación del bloque `image` del core. Funciona con el teclado (Escape la cierra y el foco vuelve a la imagen).
  - **Lo que espera una corrección de la demo** (hoja de carga, temporadas, ensayos, agenda, datos cruzados) queda listado en la spec 04, §9.
- **Alternativas descartadas:** la Biblioteca de medios (el contenido no se reproduce con `bin/setup`, D05); las 17 imágenes de la spec 04 v1, varias con datos que un asesor detecta como poco realistas; usar las capturas censuradas de campos reales.

### D24 · Los textos dicen lo que la app hace hoy

*2026-11-09 · spec 04, §7*

- **Contexto:** el análisis de administración (§1.3 y §5) detectó que la landing prometía recomendaciones automáticas ("Baja 2 kg de soya al Lote C hoy"), cifras sin fuente (+12 %, 10 h, 100 %) y procesos automáticos que la app todavía no tiene.
- **Decisión:** los textos pasan a lo que la app sí hace: avisar qué mirar hoy, decir cuánto alimento queda y cuándo pedir, mostrar la producción contra la meta con los cambios de dieta, explicar la calidad según el contrato y explicar por qué cambió un número ("Explícame"). Se quitaron las cifras del banner. La tarjeta flotante del banner muestra una alerta real de la pantalla ("Ordeña primavera-verano: sobró 6 % en el comedero"). `bin/check` falla si vuelven "Baja 2 kg de soya", "+12 %" o "~2.000 vacas".
- **Lo que se mantiene:** "Nos adaptamos a la tecnología y la maquinaria…" (D21, pedido del usuario), sin nombrar el programa que sugiere el análisis.
- **Pendiente:** la demo "con los datos de tu propio predio" y los "14 días gratis" de Solicitar demo siguen sin cambios hasta que administración confirme si hoy se pueden ofrecer (spec 04, P9).
- **Alternativas descartadas:** dejar los textos de la spec 02 junto a capturas reales que no los respaldan.

### D25 · Más recortes del sistema, más comprimidos

*La ubicación de las imágenes de Cómo funciona y de Beneficios fue reemplazada por D26.*

*2026-11-09 · pedido del usuario después de la spec 04*

- **Contexto:** el usuario pidió usar casi todos los recortes de `3_recortes_para_landing/` y comprimir más las imágenes, porque ocupaban demasiado espacio. Pidió dejar las dos del banner tal como están.
- **Decisión:**
  - **Se usan 12 de los 20 recortes** (antes, 5). Los nuevos son "cuánto queda" en Cómo funciona; en Reportes, dos pestañas nuevas, **Ensayos** (resultado e índice de litros) y **Equipo** (permisos por perfil); y en Beneficios, la meta de producción, la explicación del contrato y la curva contra la meta.
  - **Quedan fuera 8**, por lo que señala el análisis de administración: `hoja_de_carga` y `recetas_vs_habitual` (sales minerales al 5 % de la ración), `temporada_otono` y `curvas_partos_servicios` (temporadas poco realistas), `agenda_tareas` ("cojas" en vez de "cojeras"), `pronostico_clima` (nombra la fuente del pronóstico), `ensayo_checklist` (el puntero tapa el punto inconsistente del ensayo) y `rebano_salidas_grafico` (gráfico débil). Se suman cuando la demo se corrija (spec 04, §9).
  - **Compresión:** todo a WebP de calidad 70, salvo las dos del banner, que quedan idénticas byte a byte (calidad 82). Bajar de 82 a 74 ahorraba 23 %; bajar más casi no ahorraba. Máximo por recorte: 50 KB. Las 16 imágenes pesan 277 KB (antes, 9 imágenes pesaban 256 KB). La portada pesa 278 KB en la primera pantalla y 388 KB completa.
  - **Retoques nuevos:** el puntero de "cuánto queda" (sobre el borde entre dos tarjetas: se repitió una fila limpia de arriba) y el del índice del ensayo (fondo plano). `permisos_matriz` se recortó antes de su nota interna ("Las casillas tenues se guardan pero hoy no habilitan nada…"), y con eso también salió el puntero.
  - **La pestaña Equipo** dice que cada persona tiene permisos por módulo según su perfil, que es lo que la app hace hoy. No promete vistas por rol, que el análisis indica que todavía no están configuradas.
- **Alternativas descartadas:** usar los 20 recortes (8 muestran datos o textos que el análisis pide corregir antes); calidad 62, que ahorraba solo 26 KB más y ensucia el texto.

### D26 · Cada imagen muestra lo que dice su texto

*2026-11-09 · corrección pedida por el usuario sobre D25*

- **Contexto:** el usuario notó que varias imágenes no tenían que ver con el texto que acompañaban, sobre todo en Beneficios. Se habían repartido por sección y no por lo que dice cada tarjeta. Por ejemplo, "Mejor gestión diaria" (en qué lote enfocarte) llevaba la meta de producción, y "Decisiones con respaldo" (cuándo el dato no alcanza) llevaba la explicación del contrato de calidad. En Cómo funciona, "cuánto queda" y "cuándo pedir" no correspondían a ninguno de los cuatro pasos.
- **Decisión:** una imagen va solo donde muestra exactamente lo que dice su texto. Una tarjeta o un paso sin una pantalla que lo muestre va sin imagen.
  - **Beneficios:** "Ahorra tiempo" lleva "cuánto queda" (los días calculados solos); "Optimización alimentaria", el recuadro "Sobras 6 %, lo habitual 3 %" de `recetas_vs_habitual`, sin la barra de la receta, que muestra las sales minerales al 5 %; y "Decisiones con respaldo", la pantalla de datos cruzados que dice "con 9 días medidos a la vez no alcanza para decirlo (hacen falta 30)" (`29_analisis_minimo_30_dias`, recortada sin el menú lateral ni el puntero). Se cambió el orden de las tarjetas para que las dos imágenes anchas caigan en las dos tarjetas anchas.
  - **Cómo funciona:** solo "Qué mirar hoy", con el título "Así se ve el paso 3 en el sistema".
  - **Por qué CampoData:** el pie del selector del ciclo dice lo que muestra la propia pantalla (CampoData arma el calendario y mide contra tus metas).
  - **Se retiraron** `cuanto_queda` de Cómo funciona, y `compras_cuando_pedir`, `meta_produccion`, `curva_produccion_meta` y `explicacion_contrato_planta`: no calzaban con ningún texto libre, y las tres últimas repiten lo que ya muestran las pestañas Producción y Calidad de Reportes.
  - Las imágenes chicas se muestran como máximo a su tamaño real, para que no se vean borrosas.
- **Resultado:** 14 imágenes, 254 KB en total. La portada pesa 278 KB en la primera pantalla y 364 KB completa.
- **Alternativas descartadas:** poner una imagen en cada tarjeta, aunque no corresponda; reescribir los textos de las tarjetas para que calcen con las imágenes (los textos los decide el cliente).

### D27 · Los logos de Corfo y 3IE van en el pie

*2026-11-10 · pedido del usuario, con el manual "Uso correcto de la marca 3IE, Red de Mentores y Corfo para emprendedores/as"*

- **Contexto:** el manual obliga a los proyectos apoyados por Corfo a poner su logo en todo material de difusión, páginas web incluidas: en la zona inferior y respetando proporciones y área de resguardo. Sus ejemplos de sitio web ponen al lado el logo de 3IE, y el de la Red de Mentores 3IE es opcional. La landing no tenía ninguno. El usuario entregó los archivos oficiales (vector `.ai`, PNG y JPG) en `imagenes-sistema/` y pidió usar SVG cuando se pueda y, si no, JPG.
- **Decisión:**
  - **Dónde:** una fila propia en el pie, entre el menú y "© CampoData SpA", separada por una línea arriba y otra abajo. Lleva Instituto 3IE (versión completa), Red de Mentores 3IE y "Proyecto apoyado por Corfo", en ese orden, como en el ejemplo del manual. En el celular, 3IE va arriba y los otros dos debajo, centrados.
  - **Versiones:** las oficiales para fondo oscuro, porque el pie es `noche`: 3IE blanco con la tilde naranja, Red de Mentores para fondos oscuros, y Corfo blanco con la barra azul y roja.
  - **Archivos:** SVG sacados de la mesa de trabajo de cada `.ai`, sin redibujar nada. Se recortó el lienzo al dibujo, se redondearon los trazos a 0,1 punto y se quitaron paradas de degradado repetidas. En Chrome se ven igual que el vector original. Pesan 31, 21 y 7 KB, y están en `assets/images/apoyos/`.
  - **Reglas del manual:** cada logo tiene solo un ancho en el CSS (15, 5,5 y 7,5 rem) y el alto sale del archivo, así que no se deforman. Van sin `cd-marco`, sombra, borde ni lightbox, y sin enlace.
  - **Texto alternativo:** "Instituto 3IE: Instituto Internacional para la Innovación Empresarial, Universidad Técnica Federico Santa María", "Red de Mentores 3IE" y "Proyecto apoyado por Corfo". El manual pide escribir "Corfo" y "3IE", nunca "CORFO" ni "3ie".
  - **Carga:** `inc/imagenes.php` ahora completa también las imágenes de `assets/images/apoyos/` y lee el ancho y el alto de los SVG. Se cargan diferidas, porque están al final.
  - **Excepción a D21:** D21 prohíbe nombrar sistemas y empresas de terceros. Corfo y 3IE no son sistemas con los que trabaja CampoData: son quienes apoyan el proyecto, y mostrarlos es una obligación.
  - **Verificación:** `bin/check` falla si falta uno de los tres logos en el pie, si uno no tiene texto alternativo, si uno lleva `cd-marco`, si un SVG pasa su peso máximo (40, 30 y 12 KB) o si la portada escribe "CORFO" o "3ie".
- **Pendiente:** el manual pide validar la aplicación de la marca escribiendo a comunicaciones@3ie.cl. El logo de Corfo se puede quitar cuando el proyecto termine y se audite.
- **Alternativas descartadas:**
  - **JPG:** no tiene transparencia, y sobre el pie oscuro quedaría un rectángulo blanco.
  - **PNG:** el usuario prefiere SVG, y los PNG pesan más y se ven peor ampliados.
  - **La versión compacta de 3IE:** la completa cabe incluso a 320 px y es la del ejemplo web.
  - **Enlazar los logos a los sitios de Corfo y 3IE:** el manual no lo pide, y sacaría al visitante de la landing.

### D28 · SEO técnico con código propio

*2026-11-10 · spec 05 · confirmado por el usuario*

- **Contexto:** la landing no tenía meta descripción, vista previa al compartir, datos estructurados ni ícono de la pestaña, y su título ("CampoData – Gestión simple para tu predio") no decía "lechero". El sitio actual tampoco tiene nada de eso.
- **Decisión:**
  - **Dónde:** `campodata-core/seo.php` en el mu-plugin, porque sobrevive a un cambio de tema (D07). El ícono y la imagen para compartir viven en el tema; si falta uno de sus archivos, `seo.php` omite sus etiquetas.
  - **Textos:** el título y la descripción viven en la opción `campodata_seo` (Ajustes → SEO), que `bin/setup` crea desde `config/seo-inicial.json` solo si no existe, como los datos de contacto (D20). Se usan en `<title>`, la meta descripción, Open Graph y el JSON-LD. Quedó D1 de la spec como descripción, y como título T1 con la marca adelante, a pedido del usuario (2026-11-11), para que la pestaña diga CampoData: "CampoData | Software para predios lecheros" (42 caracteres). La pestaña y Google muestran el mismo `<title>`, así que la marca va primero y las palabras clave después. La descripción es "Qué mirar hoy, cuánto alimento te queda y cómo va la producción de tu lechería, en simple. Para dueños de predios lecheros y asesores. Solicita una demo." (153). El título se escapa con `esc_html`, porque el core imprime tal cual lo que devuelve `pre_get_document_title`.
  - **Vista previa al compartir:** Open Graph y `twitter:card`, solo en la portada, con una imagen de 1200 × 630 en JPG (69 KB, calidad 85) generada desde `docs/compartir/tarjeta.html`: el emblema, "CampoData", el `h1` y la pantalla Hoy de Producción, todo centrado.
  - **Datos estructurados:** `Organization` ("CampoData SpA"), `WebSite` y `SoftwareApplication`, con el correo, el teléfono, la zona y las redes de los datos de contacto. Un dato vacío se omite. Sin precios, calificaciones, reseñas, dirección ni fecha de fundación. Se imprimen con `JSON_HEX_TAG`: ningún texto puede cerrar la etiqueta `<script>`.
  - **Limpieza:** sin feeds, RSD, enlace corto, oEmbed ni enlaces a la REST API en el `<head>` ni en los encabezados. Feeds y búsqueda redirigen con 301 a la portada. El sitemap lista solo páginas.
  - **Imágenes de marca:** `bin/imagenes-de-marca` genera el ícono y la imagen para compartir con el PHP (GD) del contenedor y el Chrome del host, y escribe los archivos desde el host, a nombre del usuario.
- **Alternativas descartadas:** Yoast SEO, Rank Math o SEOPress (decenas de pantallas para una sola página, más peso y un plugin de producción que justificar, D08); los textos fijos en el código (cambiar una palabra exigiría desplegar); `LocalBusiness` (CampoData no atiende en un local); `Product` con precio (no hay uno público).

### D29 · El emblema es el logo: no hay spec 03

*2026-11-10 · decisión del usuario, spec 05*

- **Contexto:** la spec 02 dejaba para una spec 03 el SVG oficial del logo y el ícono de la pestaña, y la spec 04 reservó ese número. Mientras tanto, `/favicon.ico` llevaba al logo de WordPress.
- **Decisión:** el emblema actual (`emblema.webp`) es el logo de CampoData y no habrá spec 03. El ícono de la pestaña entró en la spec 05: el círculo del emblema, sin la palabra, en PNG de 32 px (pestañas) y 96 px (Google pide un múltiplo de 48), con sus esquinas transparentes. Por dentro el círculo es opaco, así que se ve igual sobre pestañas claras y oscuras. Se imprime con la receta de Siete Colores (framework, §7): `?ver=`, `/favicon.ico` redirigido al de 32 y prioridad para un ícono cargado en Ajustes → General.
- **Alternativas descartadas:** el logo completo, con la palabra: a 32 px la palabra mide unos 3 px de alto y no se lee, el círculo se achica, y el JPG trae fondo blanco, que en pestañas oscuras es un cuadrado (se comparó el 2026-11-10).

### D30 · Indexación por entorno

*2026-11-10 · spec 05*

- **Contexto:** `bin/setup` pedía `blog_public` 0, y `entorno-local.php` forzaba 0 en local. Si una base con 0 llegaba a producción, Google no indexaba el sitio y nada lo avisaba.
- **Decisión:** la base dice "indexar" (`blog_public` 1) y `seo.php` lo apaga en todo entorno que no sea `production`: local, `development` y `staging`. La regla salió de `entorno-local.php`. WordPress considera producción a todo sitio que no define `WP_ENVIRONMENT_TYPE`, así que un servidor de pruebas tiene que definirlo como `staging` (README, "SEO"). `bin/check` falla si la base vale 0 o si la portada local no trae `noindex`.
- **Alternativas descartadas:** dejar 0 y cambiarlo a mano al publicar.

### D31 · URLs del sitio anterior

*2026-11-10 · spec 05*

- **Contexto:** el sitemap de campodata.cl (medido el 2026-11-10) lista, además de la portada, 8 URLs de una plantilla en inglés, todas en 200: `/about/`, `/contact/`, `/services/`, `/blog/`, `/sample-page/`, dos entradas y `/category/uncategorized/`.
- **Decisión:** las 3 con una sección equivalente redirigen con 301 (`/#para-quien`, `/#demo` y `/#como`), las 5 de plantilla responden 410 con la plantilla 404 del tema, y `/sitemaps.xml` redirige a `/wp-sitemap.xml`. La tabla vive en `urls_del_sitio_anterior()` (`seo.php`) y solo actúa cuando nada del sitio responde en esa ruta. `bin/check` lee la misma tabla y prueba cada URL.
- **Alternativas descartadas:** un 301 de todo a la portada (Google lo trata como un 404 encubierto); dejarlas en 404 (el 410 las saca antes del índice); reglas en el servidor (el hosting no está definido).

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

---

## Cambios respecto de la spec 04

### C14 · Se empezó con cambios sin commit

- **Qué decía la spec:** §0.2: si hay cambios sin commit de trabajos anteriores, avisar antes de seguir.
- **Qué se hizo:** se siguió, porque el usuario pidió implementar en la misma sesión. Los cambios pendientes eran la quita de ganaderos (D22) y la carpeta `imagenes-sistema/`, además de `wp-content/themes/campodata.zip`, que no es de esta spec y no se tocó.

### C15 · "Inicio" estaba guardada desde el editor

- **Qué decía la spec:** nada.
- **Qué se hizo:** "Inicio" tenía una copia fija de la landing, guardada desde el editor el 2026-11-02 a las 16:38, y por eso la portada no mostraba ningún cambio de los patrones. Se comparó su texto con los patrones de ese día: solo tenía dos errores accidentales ("la tecnología y la que ya tiene", sin "maquinaria", y "Quiero unademo"). Se devolvió a `<!-- wp:pattern {"slug":"campodata/landing"} /-->`. La copia guardada sigue en las revisiones de la página (IDs 7 y 8).
- **Por qué:** con una copia fija, la portada nunca toma los cambios del tema (README, "Qué vive en el código y qué en la base de datos").

### C16 · Retoques distintos de lo previsto

- **Qué decía la spec:** §4: en `kpis_inicio`, rehacer el "($)" tapado; en "Explícame", pintar la franja "DEMO".
- **Qué se hizo:** en `kpis_inicio` el puntero no tapaba el "($)" y bastó pintar el fondo. "Explícame" se recortó antes de la franja (859 × 527).
- **Por qué:** al ampliar se vio que el "($)" estaba entero. Recortar deja la ventana más limpia que un rectángulo vacío al pie.

### C17 · En Para quién, la imagen va al pie de la tarjeta

- **Qué decía la spec:** §6.2: entre el ícono y el título.
- **Qué se hizo:** la imagen va después de la lista, justo antes de "Quiero una demo", y las dos quedan a la misma altura.
- **Por qué:** las dos imágenes tienen proporciones muy distintas (1024 × 295 y 859 × 527), y arriba desalineaban los títulos de las tarjetas.
- **Ajuste posterior (2026-11-10, pedido del usuario):** la imagen ya no se empuja al pie: va justo debajo de la lista, y el pie de la tarjeta lo ocupa solo "Quiero una demo". Empujada al pie, en "Dueños de lecherías" (lista corta) quedaba un hueco grande sobre la imagen.

### C18 · Por qué CampoData alineado arriba

- **Qué decía la spec:** §6.5: la imagen del ciclo de 495 px bajo la comparación.
- **Qué se hizo:** las dos columnas se alinean arriba y la imagen mide 420 px como máximo.
- **Por qué:** centradas, la columna derecha (tabla e imagen) dejaba un hueco grande sobre el título de la izquierda.

### C19 · Un texto más que prometía de más

- **Qué decía la spec:** §7 no listaba la introducción de Para quién.
- **Qué se hizo:** "CampoData ordena tus datos y te dice qué hacer con ellos" pasa a "…y te muestra, en simple, qué mirar".
- **Por qué:** es la misma promesa que el análisis pide quitar (§0.5 de la spec).

### C20 · Dos arreglos de `bin/check`

- **Qué decía la spec:** nada.
- **Qué se hizo:**
  - la verificación de recursos externos solo mira los atributos `src` y `href` de verdad;
  - el conteo de textos guía ya no corta el script cuando no queda ninguno.
- **Por qué:** la ampliación del core trae `data-wp-bind--src="state.selectedImage.currentSrc"`, que se leía como una URL externa. Y con cero textos guía, `grep` devolvía 1 y, con `pipefail`, `bin/check` terminaba en silencio con código 1 (el error venía de la plantilla de Siete Colores).

### C21 · No se corrió `bin/reset --yes`

- **Qué decía la spec:** §12: `bin/reset --yes` deja todo en pie.
- **Qué se hizo:** se corrieron `bin/setup` (no cambió nada), `bin/check` y `composer lint`, y la validación del editor (516 bloques, ninguno inválido).
- **Por qué:** `bin/reset` borra la base local, y con ella la copia guardada de "Inicio" (C15) y lo que se haya cargado en Ajustes. Se puede correr cuando el usuario lo decida.

---

## Riesgos de ejecución de la spec 04 (§10)

| # | Riesgo | Qué pasó |
| --- | --- | --- |
| R1 | Capturas blandas en alta densidad | Pendiente de ver en una pantalla real. Se muestran como máximo a su medida de origen y se pueden ampliar |
| R2 | Un retoque deja marca o necesitaría inventar | No pasó: los cinco retoques se revisaron ampliados contra el original. Uno necesitó una segunda pasada (la sombra de la punta del puntero sobre el "7" de "$91,7 mill.") |
| R3 | El banner se ve quieto sin `panel.svg` | No pasó: siguen la entrada, la flotación y la inclinación |
| R4 | El alto salta al cambiar de pestaña | No pasó: las dos pantallas tienen la misma proporción fija |
| R5 | La ampliación pide recursos externos | No pasó: es un módulo del core, local. Solo hubo el falso positivo de C20 |
| R6 | La ampliación falla dentro de las pestañas | No pasó: las dos pantallas de Reportes tienen su botón de ampliar |
| R7 | Hueco al quitar las cifras | No pasó |
| R8 | Desborde del encabezado o de la página | No pasó: medido de a 1 px entre 320 y 1500 px, sin desborde ni scroll horizontal |

---

## Cambios respecto de la spec 05

### C22 · `bin/setup` escribe `blog_public` en 1 (cambia la spec 01)

- **Qué decía la spec 01:** §6, `bin/setup` fija `blog_public` en 0, y `entorno-local.php` lo fuerza a 0 en local.
- **Qué se hizo:** lo pidió la spec 05, §9: la base dice 1 y la regla de no indexar pasó a `seo.php`, para todo entorno que no sea producción (D30).
- **Por qué:** una base con 0 que llega a producción deja el sitio fuera de Google sin ningún aviso.

### C23 · `blog_public` se escribe sin el filtro, y la base ya decía 1

- **Qué decía la spec:** §9 y §10.1: `blog_public 1` en la lista de opciones de `bin/setup`.
- **Qué se hizo:** `bin/setup` lo escribe con `wp eval`, quitando antes el filtro `pre_option_blog_public`.
- **Por qué:** con el filtro, `update_option` cree que el valor guardado es 0. Se encontró que **la base local siempre tuvo 1**: el `blog_public 0` de antes nunca escribió nada, porque `update_option` comparaba 0 con 0 y no hacía nada. Ahora `wp option update blog_public 1` sí intentaba escribir, la base no cambiaba ninguna fila y WP-CLI lo daba por error ("Could not update option"), lo que cortaba `bin/setup`. Por la misma razón, guardar Ajustes → Lectura en local no puede devolver la base a 0: el riesgo R8 no puede pasar.

### C24 · Una categoría sin entradas responde 404

- **Qué decía la spec:** §8: las URLs del sitio anterior se manejan solo si la consulta es un 404.
- **Qué se hizo:** en `seo.php`, una categoría, etiqueta o taxonomía sin entradas pasa a ser un 404 antes de revisar la tabla.
- **Por qué:** la instalación crea la categoría "Uncategorized" (`/category/uncategorized/`), y WordPress muestra el archivo de una categoría que existe aunque esté vacío: respondía 200 con "No hay publicaciones para mostrar", una página sin contenido que se podría indexar. Las fechas, etiquetas y autores ya respondían 404. Ahora esa URL responde su 410, como dice la tabla.

### C25 · Se empezó con la spec sin commit

- **Qué decía la spec:** §0.2: si hay cambios sin commit de trabajos anteriores, avisar antes de seguir.
- **Qué se hizo:** se siguió. Lo único sin commit era la propia spec 05, y el usuario pidió implementarla en la misma sesión (como C01).

### C26 · No se corrió `bin/reset --yes`

- **Qué decía la spec:** §13: `bin/reset --yes` deja todo en pie sin pasos manuales.
- **Qué se hizo:** se corrió `bin/setup` dos veces (la segunda no cambió nada), `bin/check` y `composer lint`.
- **Por qué:** como en C21, `bin/reset` borra la base local y lo que se haya cargado en Ajustes. Se puede correr cuando el usuario lo decida.

### C27 · El editor no se abrió en un navegador

- **Qué decía la spec:** §13: el editor de "Inicio" y el Editor del sitio funcionan igual, con todos los bloques válidos.
- **Qué se hizo:** se verificó que la REST API responde (200) y que ni los patrones, ni las partes, ni las plantillas cambiaron. Ajustes → SEO se probó de punta a punta con el formulario del panel.
- **Por qué:** la spec solo quita enlaces del `<head>` público (`wp_head`), que el panel no usa: el editor llega a la REST API por `wpApiSettings`. Queda abrir "Inicio" en el editor una vez, para confirmarlo.

---

## Riesgos de ejecución de la spec 05 (§11)

| # | Riesgo | Qué pasó |
| --- | --- | --- |
| R1 | Chrome captura la tarjeta con otra medida | No pasó: la captura sale de 1200 × 630. `bin/imagenes-de-marca` igual lo verifica y se detiene si no |
| R2 | El JPG pasa los 200 KB | No pasó: 69 KB con calidad 85 |
| R3 | A 32 px el emblema no se distingue | No pasó: se reconocen la espiga, la vaca y los colores, en pestañas claras y oscuras |
| R4 | `pre_get_document_title` no cambia el título | No pasó |
| R5 | La redirección de la búsqueda rompe el panel o el editor | No pasó: `template_redirect` no corre en el panel, y el editor busca por la REST API |
| R6 | Quitar el enlace a la REST API rompe algo | No pasó: la REST API responde y el panel no usa ese enlace (ver C27) |
| R7 | No se pueden simular los sitemaps de un sitio público | No pasó: con el filtro en 1 y `register_sitemaps()`, el sitemap lista solo la portada |
| R8 | Guardar Ajustes → Lectura en local devuelve la base a 0 | No puede pasar (C23) |
| R9 | Una red social muestra una vista previa vieja | Se verá al publicar (Anexo A de la spec) |
