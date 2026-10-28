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
