# Spec 02 · Landing de CampoData

**Proyecto:** CampoData · Landing Page (WordPress 7.1.3, tema de bloques `campodata`)
**Alcance de esta spec:** la landing completa de una sola página, con la identidad del logo nuevo y movimiento. Incluye la paleta, las tipografías y el emblema; el encabezado; un banner oscuro con un "campo de píxeles" animado y un panel ilustrado; las secciones "Para quién", "Cómo funciona", "Reportes reales", "Beneficios", "Por qué CampoData" y "Solicitar demo"; y el pie. El objetivo es que dueños de lecherías, ganaderos y asesores sientan que están frente a **tecnología nueva** hecha para el campo. Los textos y datos del sitio actual se reutilizan; lo nuevo va como propuesta que el usuario confirma al revisar esta spec, o como texto guía.
**Sitio actual de referencia:** https://campodata.cl/ (medido el 2026-11-02)
**Modelo:** la spec 02 de Siete Colores y `Clientes Web/FRAMEWORK-WORDPRESS.md` (§6)
**Rama de trabajo:** `dev`
**Depende de:** spec 01 implementada y en commits (commit `4f82a53`).
**Versión:** 5 · 2026-11-10

### Historial de decisiones

| Versión | Cambio confirmado |
| --- | --- |
| v1 | Primera versión. Pedido del usuario: una landing de una sola página, más atractiva que la actual para **asesores de lecherías, ganaderos y dueños de esos rubros**, que transmita que CampoData es **tecnología nueva**, con animaciones y un diseño moderno. El usuario entregó el logo nuevo (JPG de 469 × 551). Los supuestos y las preguntas están en §18 |
| v1 (ejecución) | El usuario pidió implementarla tal como está (2026-11-02): **quedan confirmados los textos (propuesta)**; lo que es texto guía sigue como texto guía, y las preguntas de §18 siguen abiertas con sus supuestos. Se ejecutó el mismo día. Los desvíos están en `docs/DECISIONS.md` (C01 a C13): entre otros, Reportes queda con cuatro pestañas porque la imagen de "Leche por Lote" del sitio anterior es idéntica a la de "Producción Leche" (C02) |
| v2 | **La web no nombra sistemas ni empresas de terceros** (pedido del usuario: "nos podría meter en problemas"). Se quitan DairyPlan, Excel y Power BI de los textos, y de la captura "Producción Leche" se borran "WATTS" y "DP". Donde se nombraban, el mensaje pasa a ser que **CampoData se adapta a la tecnología y la maquinaria que tiene cada predio** (§0.13). Los textos nuevos de esta versión quedan confirmados (DECISIONS D21) |
| v3 | **Se elimina el alcance de predios ganaderos**: la landing es solo para predios lecheros y asesores (DECISIONS D22). Sin tarjeta "Ganaderos" ni opción "Ganadero" en el formulario; el título del banner y el pie hablan de lechería. Donde la spec habla de ganaderos (§1.1, §2, §6, P1, P2, P16), manda esta versión |
| v4 | La spec 04 reemplaza la ilustración del banner y las capturas de Reportes por pantallas del sistema con datos de demostración, quita las cifras del banner y corrige los textos que prometían más de lo que la app hace (DECISIONS D23 y D24). Donde esta spec dice otra cosa sobre el banner (§6.1), Reportes (§6.4), las imágenes (§11) o esos textos, manda la spec 04 |
| v5 | El pie suma una fila con los logos de quienes apoyan el proyecto: Instituto 3IE, Red de Mentores 3IE y "Proyecto apoyado por Corfo", como pide su manual de marca (DECISIONS D27). Es una excepción a D21: no son sistemas de terceros |

---

## 0. Instrucciones para la IA que ejecute esta spec

1. Lee este documento completo, la spec 01, `README.md`, `docs/DECISIONS.md` y el framework (§6) antes de escribir el primer archivo. Las reglas de la spec 01 siguen vigentes, salvo lo que esta spec cambie de forma explícita.
2. **Git lo maneja el usuario.** No hagas `commit`, `push` ni `add`, y no crees ni cambies ramas. **Al empezar, el árbol de trabajo debe estar limpio y la rama debe ser `dev`**; si no, detente y avísale al usuario. Al cerrar cada etapa, deja los cambios sin commit y sugiere el mensaje.
3. **Textos fijos, en español**, sin funciones de traducción (DECISIONS D09).
4. **Origen de cada texto.** En §6 cada texto lleva su origen:
   - **(actual):** sale tal cual del sitio actual. Va como está, salvo la marca, que se escribe siempre "CampoData".
   - **(propuesta):** lo redactó esta spec. **Solo se usa si el usuario lo confirmó al revisar la spec** (queda en el historial de decisiones). Si no está confirmado, va como texto guía.
   - **[Texto guía]:** entre corchetes, con el formato de §11.
5. **Nunca inventes contenido que parezca real:** ni testimonios, ni clientes, ni cifras, ni redes sociales, ni fotos. **No copies la foto del banner del sitio actual** (es de un banco de imágenes, Unsplash) **ni su logo antiguo**.
6. Colores, tipografías, tamaños y espaciados se usan **siempre por su token** de `theme.json`. En el CSS propio, por sus variables `--wp--preset--…` y `--wp--custom--…`. Los SVG del tema son la única excepción (archivos estáticos con el color escrito).
7. **Todo el movimiento es una mejora progresiva y respeta `prefers-reduced-motion`.** Sin JS, o con movimiento reducido, todo el contenido se ve completo y en su estado final (§10).
8. **Parte del código de Siete Colores** (`~/Documents/Siete Colores/LandingPage/`): `inc/recursos.php`, `assets/css/sitio.css`, `assets/js/movimiento.js`, `mu-plugins/siete-colores-core/contacto.php` y los pasos nuevos de `bin/setup` y `bin/check`. Cópialos, cambia los nombres según el framework (§9.1) y el prefijo de clases a `cd-`, y adáptalos a esta spec. **Ya traen las lecciones C12 a C24 de Siete Colores**: no las vuelvas a descubrir.
9. Antes de escribir el marcado de un bloque, revisa su `block.json` en el core 7.1.3 (dentro del contenedor, en `wp-includes/blocks/<bloque>/block.json`). Todo el marcado tiene que validar en el editor (§16).
10. Si un bloque o una API no se comporta como se describe, aplica el plan B del riesgo (§14), sigue, y déjalo en DECISIONS.
11. No toques lo que está fuera de alcance (§3).
12. Al terminar, verifica uno por uno los criterios de §16 y reporta el resultado, con capturas de escritorio (1440px) y de móvil (390px).
13. **Sin sistemas ni empresas de terceros** (v2): la web no nombra programas, plataformas ni empresas ajenas (por ejemplo DairyPlan, Excel, Power BI o la planta que recibe la leche), ni en los textos, ni en los `alt`, ni dentro de las imágenes. Donde haga falta hablar de con qué trabaja CampoData, el mensaje es que **se adapta a la tecnología y la maquinaria que tiene cada predio**. `bin/check` falla si la portada nombra alguno de la lista.

---

## 1. Punto de partida

### 1.1 El proyecto

| Pieza | Estado actual |
| --- | --- |
| Tema | `campodata` con tokens provisionales en grises y la fuente del sistema. Plantillas `front-page`, `page`, `index` y `404`. Partes `header` (solo el título del sitio) y `footer` (año y título). Patrón `inicio-provisional`. Sin CSS ni JS propios. `assets/fonts/` y `assets/images/` vacías |
| Portada | Página "Inicio", cuyo contenido es solo `<!-- wp:pattern {"slug":"campodata/inicio-provisional"} /-->` |
| mu-plugin | `campodata-core`, con `seguridad.php` (emojis apagados según D13) y `entorno-local.php` |
| Scripts | `bin/setup` crea "Inicio" solo si no existe. `bin/check` verifica el core, el tema, los plugins, el mu-plugin, la portada, la página 404 y que no haya recursos externos |
| Git | Repositorio en `Clientes Web/CampoData/` con las ramas `prod` y `dev`. Un solo commit (`4f82a53`). Árbol limpio en `dev` al escribir esta spec |
| Core 7.1.3 | Lo mismo que midió Siete Colores: `tabs` (todos los paneles salen con `hidden` del servidor, C22), `cover`, `navigation` con menú móvil, `social-links`, grilla con ajustes `@tablet` y `@mobile`, *block bindings* y patrones anidados |

### 1.2 El sitio actual (medido el 2026-11-02)

Una página HTML estática, con las imágenes incrustadas en base64 (1 MB en total).

| Elemento | Valor |
| --- | --- |
| Título | "Campodata SpA – Gestión simple para tu predio lechero" |
| Colores | Verde `#4A7043`, verde oscuro `#2E4A29`, verde claro `#6B9464`, verde suave `#EAF2E9`, azul `#1E88E5`, azul suave `#E3F2FD`, naranja `#F4A261` (botones), gris de fondo `#F8F9F6`, borde `#E4E9E0`, texto `#1C2B1A`, texto suave `#5A6B57` |
| Tipografías | Fraunces (títulos, peso 600–700) y DM Sans (texto, 1,65 de interlineado), desde Google Fonts |
| Radios | Tarjetas 16–20px, botones 8–10px, píldoras 20px |
| Movimiento | Aparición con opacidad y `translateY(22px)`, 0,55s, escalonado de 0,1 a 0,4s, `IntersectionObserver` con `threshold` 0,12 y un solo disparo. Tarjetas que suben 4px al pasar el mouse. Encabezado fijo que gana sombra pasados los 20px |
| Menú | "Cómo funciona" (`#como`), "Reportes reales" (`#ejemplo`), "Por qué Campodata" (`#porque`) y el botón "Solicitar demo" (`#cta`) |
| Secciones | Banner (`#inicio`), Reportes reales (`#ejemplo`), Cómo funciona (`#como`), Ventajas (`#porque`), Beneficios (`#beneficios`), CTA (`#cta`) y pie |
| Banner | Foto de Unsplash (vacas en un campo) con un velo verde-azul, el logo antiguo, el título, dos botones y tres cifras |
| Reportes | Cinco capturas de reportes de 1100 × 627 en JPEG (84 a 176 KB cada una). **La quinta, "Leche por Lote", tiene su panel pero ningún botón de pestaña**: hoy no se puede ver |
| Contacto | WhatsApp `https://wa.me/56926304489?text=Hola,%20quiero%20saber%20más%20sobre%20CampoData` (CTA). Correo `fandradeg@campodata.cl` (botón "Solicitar demo", asunto "Solicitud de demo CampoData") y `contacto@campodata.cl` (pie). El pie enlaza además a `https://wa.me/56912345678`, **un número de ejemplo**. Zona: "Los Ríos y Los Lagos, Chile". Sin redes sociales. "Política de privacidad" enlaza a `#` |

### 1.3 El logo nuevo

El usuario entregó un JPG de 469 × 551 con fondo blanco: un **emblema circular** (de x 15 a 435 y de y 36 a 450, unos 420px de diámetro) y debajo la palabra **"CampoData"** (de y 454 a 503), con "Campo" en verde y "Data" en azul. El emblema muestra una espiga de trigo amarilla y verde, unos **píxeles que salen del campo y suben hacia el cielo**, una vaca azul, el cielo celeste y surcos verdes. El sitio actual todavía usa el logo antiguo.

Colores medidos en el JPG (los más frecuentes, sin el blanco):

| Parte del logo | Color medido |
| --- | --- |
| Cielo | `#53B0FD` |
| Espiga (amarillo) | `#FCCB04` |
| Vaca y "Data" | `#034A87` (entre `#004B85` y `#044B7E`) |
| "Campo" y surco medio | `#3A8D47` (en la palabra, `#3D9330`) |
| Brote (verde claro) | `#72C93C` |
| Surco oscuro | `#106E53` |

**La idea visual de la landing sale del logo:** los píxeles que nacen del campo y suben al cielo son "el campo convertido en datos". Esos píxeles cuadrados son el motivo que se repite en el banner, en el cierre y en los detalles.

---

## 2. Decisiones

| Tema | Decisión | Alternativa descartada |
| --- | --- | --- |
| Identidad | **La paleta sale del logo nuevo** (§5.1). Sobre fondos claros manda el azul marino de la vaca; sobre fondos oscuros, el amarillo de la espiga. Los verdes y el celeste son acentos | Mantener la paleta del sitio actual, que no coincide con el logo nuevo y usa un naranja que el logo no tiene |
| Tono visual | **Contraste de oscuro y claro**: el banner, Reportes y el cierre van sobre un azul noche casi negro, con brillos y píxeles. Las secciones de lectura van en blanco y en un verde muy suave | Todo claro, como hoy: se ve correcto, pero no transmite tecnología nueva |
| Slugs de los colores de marca | **Por parte del logo:** `cielo`, `brote`, `pradera` y `surco`. El marino y el amarillo ya son `primario` y `acento` | Por nombre de color (`verde`, `azul`): D06 lo descarta |
| Tipografías | **Sora** para títulos (geométrica, de trazos redondeados como la palabra del logo) y **DM Sans** para el texto (la del sitio actual), servidas desde el tema | Fraunces, la serif actual: se lee clásica y editorial, no tecnológica. Space Grotesk: más liviana (22 KB), pero sus formas no se parecen a la palabra del logo |
| Forma de la landing | **Una sola página** con secciones y navegación por anclas. Cada sección es un patrón PHP, y `landing.php` las ordena (framework §6.3) | Secciones escritas directo en la página |
| Público | **Una sección nueva, "Para quién"**, justo después del banner, con una tarjeta por perfil: dueños de lecherías, ganaderos y asesores. Cada tarjeta lleva a la demo con su perfil ya elegido | Un banner distinto por perfil: triplica el contenido y obliga a elegir antes de entender qué es CampoData |
| Reportes | **Las capturas reales de reportes del sitio actual**, sin nombres de terceros (§0.13),, en pestañas (`tabs` del core) dentro de un marco de ventana de aplicación. Se recupera "Leche por Lote", que hoy no tiene pestaña | Ilustraciones genéricas de un panel: los reportes reales son la mejor prueba que tiene CampoData |
| Banner | **Sin foto.** Fondo oscuro, el campo de píxeles animado y un panel ilustrado en SVG que muestra un gráfico y una recomendación del sitio actual ("Baja 2 kg de soya al Lote C hoy.") | La foto del sitio actual (es de banco). Una foto propia: se puede sumar después, pero el panel muestra mejor qué hace el producto |
| Movimiento | **La receta de campodata.cl** como base (framework §6.4), más los efectos de §10.2, todos con CSS y un módulo JS propio, sin librerías | AOS, GSAP o Lottie: peso y dependencias de terceros (framework §1.9) |
| Animaciones decorativas | **SVG con su propia animación CSS adentro** (`pixeles.svg` y `panel.svg`), cargados como imagen. Respetan el movimiento reducido con un `@media` dentro del SVG | Decenas de bloques vacíos animados con CSS (en el editor parecen grupos por completar, C18 de Siete Colores); un `<canvas>` con JS (más código y nada sin JS) |
| Logo | En esta spec, **el emblema recortado del JPG** (sin la palabra) en WebP con fondo transparente fuera del círculo, y la palabra "CampoData" escrita con Sora, "Campo" en verde y "Data" en celeste o marino según el fondo. El SVG oficial y el ícono de la pestaña quedan para la spec 03 (framework §7) | Usar el JPG completo: la palabra queda ilegible a 40px y el fondo blanco choca con el encabezado oscuro |
| Encabezado | **Oscuro y fijo.** Arriba de todo es del mismo color que el banner, así que se ve como parte de él; al bajar se vuelve translúcido, con desenfoque, y muestra una barra de progreso de lectura con el degradado de la marca | Un encabezado blanco sobre el banner oscuro (corta el banner en dos); uno transparente encima del banner (exige un margen negativo que depende del alto del encabezado) |
| Contacto | **WhatsApp y correo**, más un **formulario que arma el mensaje de WhatsApp** (la receta de Siete Colores, framework §6.5). No envía nada a un servidor | Un formulario con envío de correo: necesita SMTP y protección contra spam (framework §8) |
| Datos de contacto | **Una sola fuente**: la opción `campodata_contacto`, editable en Ajustes → Datos de contacto y mostrada con *block bindings* | Repetirlos en cada patrón |
| Contenido provisional | Textos guía entre corchetes. Las únicas imágenes son los reportes reales, el emblema y las ilustraciones SVG, que no son provisionales | Lorem ipsum, o fotos de banco |

---

## 3. Alcance

### Dentro de alcance

- Identidad en `theme.json`: paleta, degradados, tipografías, tamaños y valores propios (§5).
- El emblema en WebP, las ilustraciones `pixeles.svg` y `panel.svg`, los íconos de las secciones y las capturas de los reportes en WebP (§5.6 y §11).
- Estilos de sección y de bloque (§5.5).
- CSS y JS propios: movimiento, encabezado, pestañas, tarjetas y formulario (§10).
- Datos de contacto en una sola fuente (§9).
- Encabezado (§7), los siete patrones de sección, `landing.php` (§6) y el pie (§8).
- La migración de "Inicio" en `bin/setup` y las verificaciones nuevas de `bin/check` (§13).
- Una `screenshot.png` del tema nueva, sacada de la portada real.
- `README.md` y `docs/DECISIONS.md` (§17).

### Fuera de alcance (no lo hagas)

- El SVG oficial del logo y el ícono de la pestaña: spec 03.
- Testimonios, logos de clientes, casos de éxito y precios: no existen publicados.
- La "Política de privacidad": hoy enlaza a `#`. Se suma cuando exista la página (otra spec).
- Envío de correos (SMTP) y cualquier formulario que guarde o envíe datos a un servidor.
- SEO (título, metadescripción, datos estructurados), analítica, cookies, multilenguaje y despliegue.
- Un panel de reportes embebido en vivo: es contenido de terceros y pide recursos de otro dominio.
- Páginas adicionales.

---

## 4. Mapa de la landing

| # | Sección | Ancla | Patrón | Fondo | Título |
| --- | --- | --- | --- | --- | --- |
| 1 | Banner | `inicio` | `campodata/banner` | `seccion-noche` (con brillo y píxeles) | `h1` |
| 2 | Para quién | `para-quien` | `campodata/para-quien` | `seccion-base` | `h2` |
| 3 | Cómo funciona | `como` | `campodata/como-funciona` | `seccion-suave` | `h2` |
| 4 | Reportes reales | `reportes` | `campodata/reportes` | `seccion-noche` | `h2` |
| 5 | Beneficios | `beneficios` | `campodata/beneficios` | `seccion-base` | `h2` |
| 6 | Por qué CampoData | `porque` | `campodata/por-que` | `seccion-suave` | `h2` |
| 7 | Solicitar demo | `demo` | `campodata/demo` | `seccion-noche` con el degradado `cierre` | `h2` |

**Por qué este orden:** primero qué es (banner) y para quién es, porque el público nuevo tiene que reconocerse antes de seguir leyendo; después cómo funciona y la prueba (los reportes reales); al final los beneficios y la comparación, que cierran la decisión justo antes de la demo. Los fondos alternan oscuro, claro, suave, oscuro, claro, suave y oscuro.

Reglas (framework §6.3):

- Cada sección es un `group` con `tagName` `section`, `align` `full`, `anchor` igual a su ancla, su estilo de sección, `padding` arriba y abajo `var:preset|spacing|80` y `layout` `constrained`. El banner usa `padding` arriba `var:preset|spacing|60`.
- **Un solo `h1`**, el del banner. Cada sección tiene un `h2`, y sus elementos internos usan `h3`.
- Cada sección (salvo el banner) abre con una **ceja** (§5.5): número, una mini barra con el degradado de la marca y el nombre. Por ejemplo, "01 · Para quién".
- `patterns/landing.php` tiene `Inserter: no` y las siete referencias en orden. Los patrones de sección tienen `Categories: campodata`.
- `front-page.html`: el `post-content` lleva `"style":{"spacing":{"blockGap":"0"}}`, para que no queden franjas entre fondos.
- Las anclas del sitio actual que cambian (`#ejemplo` → `#reportes` y `#cta` → `#demo`) no se redirigen: es una página nueva y nadie enlaza a ellas desde afuera (P13).

---

## 5. Identidad (`theme.json`)

### 5.1 Paleta

Los slugs de la spec 01 se mantienen; cambian sus valores. Se agregan `borde`, `noche`, `bruma` y los cuatro colores del logo.

| Slug | Nombre | Valor | Origen |
| --- | --- | --- | --- |
| `base` | Blanco | `#FFFFFF` | Fondo del logo |
| `contraste` | Tinta | `#0B2233` | Un marino casi negro, de la familia del azul del logo, para el texto principal |
| `primario` | Marino | `#034A87` | La vaca y "Data" del logo |
| `secundario` | Texto suave | `#4D5F6B` | Gris azulado para los párrafos sobre fondo claro |
| `acento` | Espiga | `#FCCB04` | La espiga del logo |
| `suave` | Rocío | `#F3F7F2` | Un blanco verdoso, como el verde suave del sitio actual (`#EAF2E9`) pero más claro |
| `borde` | Borde | `#DCE6DA` | Líneas y bordes sobre fondo claro |
| `noche` | Noche | `#061A2B` | Fondo de las secciones oscuras, el encabezado y el pie |
| `bruma` | Bruma | `#B4C3CF` | Texto de los párrafos sobre `noche` |
| `cielo` | Cielo | `#53B0FD` | El cielo del logo |
| `brote` | Brote | `#72C93C` | El verde claro del logo |
| `pradera` | Pradera | `#3A8D47` | "Campo" y el surco medio del logo |
| `surco` | Surco | `#106E53` | El surco oscuro del logo |

**Contraste** (WCAG 2.2, medido con los valores de esta tabla):

| Fondo | Texto normal (4,5 : 1 o más) | Solo texto grande (3 : 1) o elementos que no son texto | Nunca como texto |
| --- | --- | --- | --- |
| `base` | `contraste` (16,3), `primario` (9,0), `secundario` (6,6), `surco` (6,2) | `pradera` (4,1) | `acento` (1,5), `cielo` (2,3), `brote` (2,1), `bruma` (1,8) |
| `suave` | `contraste` (15,0), `primario` (8,3), `secundario` (6,1), `surco` (5,7) | `pradera` (3,8) | `acento`, `cielo`, `brote` y `bruma` |
| `noche` | `base` (17,6), `acento` (11,5), `bruma` (9,8), `brote` (8,5), `cielo` (7,6) | `pradera` (4,3) | `primario` (2,0), `secundario` (2,7), `surco` (2,8) |
| `acento` (botón) | `noche` (11,5) y `contraste` (10,6) | — | `base` |
| `primario` (botón) | `base` (9,0) | `acento` (5,9) | `contraste` |
| `surco` (inicio del degradado `cierre`) | `base` (6,2) | `acento` (4,1) | — |

### 5.2 Degradados

`settings.color.gradients` (los del core siguen apagados):

| Slug | Valor (con los hexadecimales de la paleta) | Uso |
| --- | --- | --- |
| `marca` | `linear-gradient(90deg, acento 0%, brote 45%, cielo 100%)` | El recorrido del logo, de la espiga al cielo: el texto destacado del `h1`, la barra de progreso, las mini barras de las cejas y la línea de Cómo funciona |
| `brillo-noche` | `radial-gradient(60% 55% at 78% 30%, rgba(3, 74, 135, 0.55) 0%, rgba(6, 26, 43, 0) 70%), noche` | El fondo del banner y de Reportes: un resplandor marino detrás del panel |
| `cierre` | `linear-gradient(135deg, surco 0%, noche 50%, primario 100%)` | El fondo de Solicitar demo (como el CTA actual, que va del verde oscuro al azul) |

### 5.3 Tipografías y tamaños

- **`fontFamilies`** (Fontsource 5.3.0, licencia OFL copiada en `assets/fonts/`, `font-display: swap`, las dos precargadas en el `<head>`):
  - `titulos`: Sora, `assets/fonts/sora-latin-wght-normal.woff2` (33 KB), pesos `100 800`.
  - `texto`: DM Sans, `assets/fonts/dm-sans-latin-wght-normal.woff2` (37 KB), pesos `100 1000`.
- **Tamaños** (slugs del core, fluidos; se agrega `x-small` como en Siete Colores C14):
  - `x-small`: 0,75rem (cejas, píldoras, rótulos del panel);
  - `small`: 0,875rem;
  - `medium`: de 1 a 1,0625rem;
  - `large`: de 1,125 a 1,375rem;
  - `x-large`: de 1,875 a 2,875rem (el `h2`);
  - `xx-large`: de 2,125 a 4,25rem (el `h1`; el mínimo cabe a 360px, C13 de Siete Colores).
- **Estilos:**
  - **`h1` y `h2`:** `titulos`, peso 700, interletra −0,025em, interlineado 1,08.
  - **`h3`:** `titulos`, peso 600, `large`, interlineado 1,3.
  - **Texto:** `texto`, `medium`, interlineado 1,65. El color lo pone el estilo de sección.
  - **Botón:** `texto` peso 600, `medium`, radio `boton`, *padding* 0,875rem × 1,625rem. El color lo pone el estilo de sección (§5.5). La variación `outline` lleva el mismo *padding* menos 1,5px por el borde (C20 de Siete Colores).
  - **Números (cifras, pasos):** `titulos` con `font-variant-numeric: tabular-nums` en `sitio.css`, para que no bailen al contar.
- **`settings.custom`** (se usan como `--wp--custom--…`):
  - `radio.tarjeta`: `20px`; `radio.boton`: `12px`; `radio.pildora`: `999px`;
  - `movimiento.duracion`: `0.55s`; `movimiento.distancia`: `22px`; `movimiento.escalon`: `0.1s`;
  - `encabezado.alto`: `72px` (para `scroll-padding-top`);
  - `brillo.acento`: `0 8px 28px rgba(252, 203, 4, 0.35)` y `brillo.marino`: `0 12px 40px rgba(3, 74, 135, 0.18)` (las sombras de los botones y tarjetas al pasar el mouse).
- **Ancho:** se mantienen `contentSize` 720px y `wideSize` 1200px de la spec 01.

### 5.4 Dónde va cada color

Esta es la regla para que la página se vea viva sin perder orden:

1. **El degradado `marca`** aparece solo en: el texto destacado del `h1`, la barra de progreso del encabezado, las mini barras de las cejas, la línea de Cómo funciona y la línea que crece bajo el botón principal al pasar el mouse.
2. **`acento` (espiga)** es el color de la acción sobre fondo oscuro: los botones principales del banner, de Reportes y de la demo, y el botón "Solicitar demo" del encabezado.
3. **`primario` (marino)** es el color de la acción sobre fondo claro: botones, enlaces y la pestaña activa.
4. **Los cuatro colores del logo** (`cielo`, `brote`, `pradera`, `surco`) van en los píxeles, los íconos de las tarjetas, los checks y los puntos del panel. Cada perfil de "Para quién" tiene el suyo: dueños de lecherías `cielo`, ganaderos `brote`, asesores `acento`.
5. **La selección de texto** (`::selection`): fondo `acento` y texto `noche`.

### 5.5 Estilos de sección y de bloque

Los que solo usan propiedades de `theme.json` van como JSON en `styles/`. Los que necesitan CSS se registran con `register_block_style()` en `inc/setup.php`, y su CSS va en `sitio.css`.

| Estilo | Bloque | Dónde se define | Qué hace |
| --- | --- | --- | --- |
| `seccion-base` | `group` | `styles/secciones/seccion-base.json` | Fondo `base`, texto `secundario`, títulos `contraste`, enlaces `primario`, botón `primario` con texto `base` |
| `seccion-suave` | `group` | `styles/secciones/seccion-suave.json` | Lo mismo que `seccion-base` sobre `suave`, con borde de 1px en `borde` arriba y abajo |
| `seccion-noche` | `group` | `styles/secciones/seccion-noche.json` | Fondo `noche` (o el degradado que tenga el bloque), texto `bruma`, títulos `base`, enlaces `acento`, botón `acento` con texto `noche`, botón `outline` en `base` |
| `tarjeta` | `group` | `styles/bloques/tarjeta.json` | Fondo `base`, borde de 1px en `borde`, radio `tarjeta` y *padding* `var:preset|spacing|50` |
| `cristal` | `group` | `register_block_style` + CSS | Tarjeta sobre fondo oscuro: fondo blanco al 6%, borde blanco al 12%, `backdrop-filter: blur(12px)` y radio `tarjeta` |
| `ceja` | `paragraph` | `register_block_style` + CSS | `x-small`, mayúsculas, interletra 0,14em, peso 600, con una barra de 28 × 3px con el degradado `marca` antes del texto (`::before`) |
| `pildora` | `paragraph` | `register_block_style` + CSS | Una "píldora": `x-small`, radio `pildora`, *padding* 0,35em × 0,9em, borde de 1px en `currentColor` al 30% y un punto de 6px a la izquierda que late (`acento` en fondos oscuros, `brote` en claros) |
| `titulo-marca` | `heading` | `register_block_style` + CSS | Lo que esté en `<strong>` dentro del título se pinta con el degradado `marca` (`background-clip: text`). Con `forced-colors` o sin soporte de `background-clip: text`, se ve en `acento` |
| `lista-check` | `list` | `register_block_style` + CSS | Sin viñetas: cada elemento lleva un círculo de 20px con un check (máscara SVG) en `surco` sobre fondo claro y en `brote` sobre oscuro |
| `ventana` | `group` | `register_block_style` + CSS | Marco de aplicación: radio `tarjeta`, borde blanco al 12%, sombra `brillo.marino` y una barra superior de 40px con tres puntos (`::before`), para enmarcar los reportes |
| `comparacion` | `table` | `register_block_style` + CSS | Tabla sin bordes verticales, filas separadas por 1px en `borde`, encabezado en `x-small` mayúsculas, y en la segunda columna el texto oculto a la vista con un check de 18px en `surco` en su lugar |

### 5.6 El emblema

- **`assets/images/marca/emblema.webp`**: el círculo del logo recortado del JPG (§1.3), sin la palabra, de 256 × 256, con transparencia fuera del círculo y 20 KB como máximo. El interior del círculo tiene zonas blancas (detrás de la espiga y los píxeles): sobre fondo oscuro se muestra como una ficha blanca redonda con un anillo de 2px en `base` al 20%, como en el sitio actual.
- **La palabra** se escribe en HTML (§7): "Campo" en `brote` y "Data" en `cielo` sobre fondo oscuro; "Campo" en `pradera` y "Data" en `primario` sobre fondo claro (solo como texto grande: `large`, peso 700).
- El JPG original no se versiona en el tema: se guarda en `docs/marca/logo-campodata.jpg` como referencia para la spec 03.

---

## 6. Secciones

El origen de cada texto va entre paréntesis (§0.4). Los textos (actual) llevan la marca escrita "CampoData".

### 6.1 Banner (`campodata/banner`)

- Sección `seccion-noche` con el degradado `brillo-noche`, `minHeight` de `calc(100vh - 72px)` (con un mínimo de 560px en CSS) y contenido centrado en vertical.
- **Fondo animado (M2):** `pixeles.svg` (§11) como `::before` de la sección, cubriendo la mitad inferior izquierda, con opacidad 0,9. Es decorativo.
- **`columns` en `align` `wide`** (58% y 42%; se apila en móvil con el panel debajo):
  - **Izquierda:**
    - píldora (`pildora`): "Nueva tecnología para el campo" (propuesta);
    - `h1` con el estilo `titulo-marca`: "Gestión **simple y efectiva** para tu lechería o predio ganadero" (propuesta; el actual dice "Gestión *simple y efectiva* para tu predio lechero"). Lo destacado va en `<strong>`;
    - párrafo en `large`, color `bruma`: "Nos adaptamos a la tecnología y la maquinaria que ya tiene tu predio. Ordenamos sus datos y te entregamos recomendaciones prácticas y claras para mejorar alimentación, producción y eficiencia diaria." (v2, a partir del actual);
    - dos botones: "Solicitar demo gratis" (principal, a `/#demo`) y "Ver reportes reales" (`outline`, a `/#reportes`) (actual);
    - **cifras** en una fila de tres, separadas por una línea vertical de 1px en `base` al 15%. Número en `titulos`, `x-large`, color `base`; rótulo en `small`, color `bruma`. **Cuentan desde cero al aparecer (M6)**:

      | Número | Rótulo |
      | --- | --- |
      | "+12%" | "Mejora promedio en producción" |
      | "10 hrs" | "Ahorradas por semana" |
      | "100%" | "Adaptable al predio" |

      Las tres son del sitio actual (P3).
  - **Derecha:** una imagen con `panel.svg` (§11), con `alt` "Panel de CampoData: un gráfico de producción diaria y una recomendación del día". Flota y se inclina con el mouse (M5).
- **Entrada al cargar (M4):** píldora, título, párrafo, botones y cifras entran escalonados (0,08s entre cada uno). El panel entra 0,3s después, desde 30px a la derecha.
- Bajo 782px: el panel queda debajo, al 90% del ancho; las cifras se mantienen en una fila de tres con el número en `large`.

### 6.2 Para quién (`campodata/para-quien`)

- Ceja "01 · Para quién".
- `h2`: "Hecho para quienes viven del campo" (propuesta).
- Párrafo en `large`: "Ya sea que administres tu propio predio o asesores a varios, CampoData ordena tus datos y te dice qué hacer con ellos." (propuesta).
- **Grilla de tres `tarjeta`** (una columna en móvil). Cada tarjeta tiene:
  - un ícono de 48px en una ficha de 56px redondeada, con el color del perfil (§5.4);
  - el `h3` del perfil;
  - una frase en `contraste`;
  - una `lista-check` de tres puntos;
  - al pie, el enlace "Quiero una demo →", que lleva a `/#demo` y deja elegido ese perfil en el formulario (M11).

| Perfil (`h3`) | Frase | Puntos |
| --- | --- | --- |
| "Dueños de lecherías" | "Sabe cada mañana cómo viene tu predio, sin abrir una planilla." (propuesta) | "Producción diaria por turno y por lote." (propuesta, a partir del reporte Producción Leche) · "Dónde se va el gasto en soya, maíz o concentrado." (actual, Beneficios) · "Nos adaptamos a los equipos y la maquinaria que ya tienes." (v2) |
| "Ganaderos" | "[Qué gana un predio ganadero con CampoData, en una frase. Confirmar qué datos de ganadería de carne se usan]" | "Inventario al día: salidas, muertes y ventas con causa y lote." (propuesta, a partir del reporte Inventario Animal) · "[Un dato propio de la ganadería de carne que CampoData ordene: por ejemplo, pesajes o ganancia diaria de peso. Confirmar]" · "Decisiones con datos reales de tu propio predio." (actual, Beneficios) |
| "Asesores" | "Llega a cada visita con los números del predio ya ordenados." (propuesta) | "Reportes claros para compartir con el productor y su equipo." (propuesta, a partir de "Dashboards visuales claros para ti y tu equipo") · "Recomendaciones accionables, no jerga estadística." (actual, Cómo funciona) · "[Si CampoData permite ver varios predios desde una misma cuenta, decirlo aquí. Confirmar]" |

- **Al pasar el mouse (M10):** la tarjeta sube 4px, el borde toma el color de su perfil y un foco de luz suave sigue al cursor dentro de ella.

### 6.3 Cómo funciona (`campodata/como-funciona`)

- Ceja "02 · Cómo funciona".
- `h2`: "Así de simple funciona CampoData" (actual).
- Párrafo: "Sin configuraciones complejas ni curvas de aprendizaje. En días ya estás viendo resultados." (actual).
- **Línea de tiempo de cuatro pasos** (`group` en grilla de cuatro columnas; una columna en móvil). Cada paso tiene un nodo (una ficha de 56px con el ícono, sobre la línea), el número grande "01" a "04" en `borde`, el `h3` y su párrafo (todos del sitio actual):

| # | `h3` | Párrafo |
| --- | --- | --- |
| 01 | "Nos adaptamos a tu predio" (v2) | "Trabajamos con la tecnología y la maquinaria que ya usa tu predio para reunir sus datos. Sin tecnicismos y sin cambiar lo que ya tienes." (v2) |
| 02 | "Organizamos todo" | "CampoData limpia, organiza y cruza la información automáticamente. Producción, alimentación e inventario, todo unificado." |
| 03 | "Recomendaciones prácticas" | "\"Baja 2 kg de soya al Lote C hoy.\" Mensajes directos y accionables, no jerga estadística que nadie entiende." |
| 04 | "Ves los resultados" | "Dashboards visuales claros para ti y tu equipo. Seguimiento diario, semanal y mensual. Las mejoras se ven rápido." |

- **Movimiento (M9):** al aparecer la sección, una línea de 2px con el degradado `marca` une los cuatro nodos y se dibuja de izquierda a derecha en 1,6s (de arriba abajo en móvil). Cada nodo se enciende (anillo en `brote` y sombra) cuando la línea llega a él. Después, un "paquete de datos" (un cuadrado de 6px en `acento`) recorre la línea cada 4s.

### 6.4 Reportes reales (`campodata/reportes`)

- Sección `seccion-noche` con el degradado `brillo-noche`.
- Ceja "03 · Reportes reales".
- `h2`: "Mira lo que CampoData puede mostrarte" (actual).
- Párrafo: "Estos son reportes reales que usamos con nuestros clientes: producción diaria, distribución de animales, alimentación, inventario y más. Todo en un solo lugar." (actual).
- **Un `group` con el estilo `ventana`** (`align` `wide`). En su barra superior, el título "CampoData — Reportes interactivos" y tres píldoras: "Dashboard activo" (con el punto que late), "Ene 2023 – Ago 2025" y "~2.000 vacas / ejemplo" (actual). Dentro, un **`tabs` del core** con cinco pestañas. Cada panel lleva la captura (`image`, ancho completo, radio de 10px) y debajo su leyenda (párrafo en `small` con el nombre en `<strong>`):

| Pestaña | Imagen (`assets/images/reportes/`) | Leyenda (actual) |
| --- | --- | --- |
| "Producción Leche" | `produccion-leche.webp` | "**Producción Leche:** Seguimiento diario mañana/tarde, variación porcentual, consumo de maíz y soya, y totales históricos desde 2023. Todo filtrable por período con un slider." |
| "Leche por Lote" | `leche-por-lote.webp` | "**Leche por Lote:** Producción diaria desglosada por Lote 1, 2, 3, 4, Cojas, Mastitis, Calostro y Fresco Total. Detecta cuál lote está bajando rendimiento." |
| "Distribución Animales" | `distribucion-animales.webp` | "**Distribución Animales:** Vacas en ordeña, vacas estanque, enfermas, engorda, cojas y reproductoras. Partos, calostros y tendencia histórica de 2 años." |
| "Resumen Diario" | `resumen-diario.webp` | "**Resumen Diario:** Tabla completa con cabezas, % ordeño, litros totales, L/C por lote, mortalidad, tratamientos, y detalle de alimentación (soya, maíz, sales, raps, etc.) por cada día." |
| "Inventario Animal" | `inventario-animal.webp` | "**Inventario Animal:** Seguimiento diario de estanque completo: vacas lecheras, secas, pre-parto, calostro, crianza (H0-H45), más registro de salidas, muertes y ventas con causa y lote." |

- El `alt` de cada captura es el nombre del reporte y lo que muestra, por ejemplo: "Reporte Producción Leche: tabla diaria por turno y gráficos de producción mensual y diaria".
- La pestaña "Leche por Lote" va segunda porque su imagen estaba segunda en el sitio actual (P6).
- **Movimiento (M12):** al aparecer, un reflejo diagonal cruza la ventana una vez (0,9s). La línea de la pestaña activa se desliza a la nueva. Al cambiar de pestaña, el panel entra con *fade* y 8px hacia arriba (0,3s).
- **Sin JS**, se ven los cinco paneles uno debajo del otro, cada uno con su nombre arriba, y la lista de pestañas se oculta (C22 de Siete Colores).
- Debajo de la ventana, centrado, el botón principal "Quiero ver mis datos así" a `/#demo` (propuesta).

### 6.5 Beneficios (`campodata/beneficios`)

- Ceja "04 · Beneficios".
- `h2`: "Lo que cambia en tu predio desde el primer mes" (actual).
- **Grilla "bento" de seis `tarjeta`** con la grilla del core: 3 columnas y 2 filas en escritorio, con la primera y la última tarjeta de 2 columnas; 2 columnas en tablet y 1 en móvil (`@tablet` y `@mobile`, D19 de Siete Colores). Cada tarjeta: ícono de 40px con el color del logo que le toca (en orden: `cielo`, `acento`, `brote`, `primario`, `pradera`, `surco`), `h3` y párrafo (todos del sitio actual):

| `h3` | Párrafo |
| --- | --- |
| "Mejor gestión diaria" | "Empieza el día sabiendo exactamente en qué lote enfocarte y por qué." |
| "Recomendaciones para hoy" | "No análisis para el mes que viene. Acciones concretas que puedes aplicar ahora mismo." |
| "Ahorra tiempo" | "Lo que antes tomaba horas de planillas y cálculos, ahora lo tienes en segundos." |
| "Decisiones más inteligentes" | "Con datos reales de tu propio predio, dejas de adivinar y empiezas a decidir con certeza." |
| "Optimización alimentaria" | "Detecta dónde estás gastando más de lo necesario en soya, maíz o concentrado." |
| "Mejora continua real" | "No solo mides: identificas oportunidades concretas de subir producción y reducir costos." |

- **Movimiento:** aparición escalonada (M1) y foco de luz al pasar el mouse (M10). El ícono de cada tarjeta sube 2px y gira 4° al pasar el mouse.

### 6.6 Por qué CampoData (`campodata/por-que`)

- Ceja "05 · Por qué CampoData".
- `columns` (50% y 50%; se apilan en móvil):
  - **Izquierda:**
    - `h2`: "Simple, práctica y pensada para predios como el tuyo" (actual);
    - párrafo: "No es una plataforma genérica de datos. Es una herramienta hecha para medianos productores del sur de Chile." (actual);
    - `lista-check` con lo destacado en `<strong>` (actual): "**Más simple que las grandes plataformas** — Sin curva de aprendizaje, sin consultores." · "**Recomendaciones accionables** — No solo datos, sino qué hacer hoy con ellos." · "**Precio accesible para medianos** — Diseñado para predios de 50 a 200 vacas, no para megaempresas." (P7) · "**Se adapta a lo que ya tienes** — Nos ajustamos a la tecnología y la maquinaria de cada predio. No hay que cambiar nada." (v2) · "**Soporte cercano y en español** — Te atiende alguien que conoce el rubro, no un chatbot."
  - **Derecha:** una `tarjeta` con la comparación. Arriba, una franja de 52px con el degradado `cierre`, el emblema de 28px y el título "CampoData vs. otras opciones" en `base`. Debajo, un bloque `table` (`hasFixedLayout`) con las columnas "Característica", "CampoData" y "Plataformas grandes" (actual):

| Característica | CampoData | Plataformas grandes |
| --- | --- | --- |
| Fácil de usar | ✓ | Requiere capacitación |
| Recomendaciones diarias | ✓ | Solo reportes |
| Se adapta a tu tecnología y maquinaria (v2) | ✓ | Parcial |
| Precio para medianos | ✓ | Costoso |
| Soporte local en español | ✓ | Limitado |
| Sin instalación compleja | ✓ | IT requerida |

  El "✓" se escribe como el texto "Sí". El `table` lleva el estilo `comparacion` (§5.5), que oculta visualmente ese texto y dibuja un check en `surco`, así el lector de pantalla lee "Sí".
- **Movimiento:** los checks de la lista se dibujan uno por uno (trazo de 0,4s, 0,12s entre cada uno). Las filas de la tabla aparecen escalonadas (M1, con un máximo de 0,4s).

### 6.7 Solicitar demo (`campodata/demo`)

- Sección `seccion-noche` con el degradado `cierre`, que se desplaza lento (M13), y el campo de píxeles a la derecha con opacidad 0,5.
- `columns` (50% y 50%; se apilan en móvil):
  - **Izquierda:**
    - ceja "06 · Solicitar demo";
    - píldora: "Sin tarjeta de crédito · Sin compromiso · 14 días gratis" (actual, P4);
    - `h2`: "Empieza a potenciar tu predio hoy" (actual);
    - párrafo en `large`: "Prueba CampoData 14 días sin costo. Te hacemos una demo personalizada con los datos de tu propio predio para que veas el resultado antes de decidir." (actual);
    - dos botones: "Escribir por WhatsApp" (principal, enlazado a `whatsapp_url`) y "Solicitar demo por correo" (`outline`, enlazado a `correo_url`) (actual). El respaldo de los dos es `#demo`;
    - una línea en `small`, color `bruma`: "Demo personalizada con los datos de tu predio · Soporte en español · Sin letra chica" (actual);
    - los datos enlazados `correo`, `telefono` y `zona`.
  - **Derecha:** el **formulario de WhatsApp** dentro de una tarjeta `cristal`. Va en un bloque `html` con solo el marcado; el comportamiento está en `movimiento.js` (riesgo R8). Campos:
    - "Tu nombre" (obligatorio);
    - "Predio o empresa" (opcional);
    - "¿Quién eres?": botones de opción con forma de píldora: "Dueño de lechería", "Ganadero", "Asesor" u "Otro";
    - el botón "Pedir mi demo por WhatsApp" (propuesta);
    - la nota "Al enviar se abre WhatsApp con tu mensaje ya escrito. No guardamos tus datos." (propuesta).
- **Al enviar**, el JS arma `https://wa.me/<whatsapp>?text=<mensaje>` y lo abre en una pestaña nueva. El mensaje: "Hola, CampoData. Soy {nombre}{, de {predio}}. Perfil: {perfil}. Quiero solicitar una demo." El número sale de los datos de contacto (§9), que el tema le pasa al módulo con `script_module_data_{id}`.
- **Al llegar desde una tarjeta de "Para quién"** (M11), el perfil queda marcado y la tarjeta del formulario se ilumina un momento (anillo en `acento` de 0,8s).
- **Sin JS**, el formulario no se muestra (§10.1) y quedan los dos botones directos. No guarda ni envía nada a un servidor.

---

## 7. Encabezado (`parts/header.html`)

- Fondo `noche`, **fijo arriba** (`position: sticky` en el contenedor de la parte, considerando la barra de administración). Alto de 72px (`encabezado.alto`).
- **Fila `align` `wide`** con `justifyContent` `space-between`:
  - **A la izquierda, la marca:** un párrafo con un enlace a `/` (D11) que contiene el emblema (`<img>` de 40px, `alt=""`) y la palabra "Campo**Data**" en `titulos`, `large`, peso 700 ("Campo" en `brote`, "Data" en `cielo`, §5.6). El enlace lleva `aria-label="CampoData, ir al inicio"`. Al pasar el mouse, el emblema gira 8° y vuelve (0,4s).
  - **A la derecha:**
    - el menú (`navigation` con `overlayMenu` `mobile`, enlaces escritos en la parte y sin `ref`): "Para quién" → `/#para-quien`, "Cómo funciona" → `/#como`, "Reportes" → `/#reportes`, "Por qué CampoData" → `/#porque`;
    - el botón "Solicitar demo" → `/#demo`, en `acento` con texto `noche` y la sombra `brillo.acento` al pasar el mouse.
- **Tipografía del menú:** `texto`, `small`, peso 500, color `bruma`. Al pasar el mouse o en la sección visible, el texto pasa a `base` y una línea de 2px con el degradado `marca` crece debajo.
- **Al pasar los 20px de scroll (M8)**, `movimiento.js` agrega `cd-con-scroll`: fondo `noche` al 82%, `backdrop-filter: blur(12px)`, borde inferior blanco al 8% y sombra suave.
- **Barra de progreso (M7):** una línea de 2px en el borde inferior del encabezado, con el degradado `marca`, cuyo `scaleX` sigue la proporción leída de la página.
- **Menú móvil:** el *overlay* del core en `noche`, con los enlaces en `x-large` y `titulos`, y el botón "Solicitar demo" al final.
- `html { scroll-padding-top: var(--wp--custom--encabezado--alto) }` (más la barra de administración), y `scroll-behavior: smooth` salvo con el movimiento reducido. Al llegar con un ancla desde otra página, se aplica la vuelta al ancla de Siete Colores (C16).
- **Mide el encabezado de a 1px entre 320 y 1500px** (framework §6.8). Plan si se desborda: R9.

---

## 8. Pie (`parts/footer.html`)

- Fondo `noche` con un borde superior de 1px en blanco al 8%. Texto `bruma`, enlaces `base`, foco en `acento`.
- **Fila `align` `wide`** con `justifyContent` `space-between` (se apila en móvil):
  - **Izquierda:** la marca (igual que en el encabezado) y debajo "Gestión de datos para predios lecheros y ganaderos · Los Ríos y Los Lagos, Chile" (el actual dice "Gestión de datos para predios lecheros"; "y ganaderos" es propuesta).
  - **Centro:** los enlaces "Para quién", "Cómo funciona", "Reportes" y "Solicitar demo", en `small`.
  - **Derecha:** `social-links` con WhatsApp (`whatsapp_url`) y correo (`correo_url`), íconos de 22px en `base` que suben 2px al pasar el mouse. LinkedIn e Instagram se muestran solo si tienen URL (P10).
- **Fila de apoyos** (patrón `campodata/apoyos`, v5), separada por un borde de 1px en blanco al 8%: los logos oficiales de Instituto 3IE, Red de Mentores 3IE y Corfo, en su versión para fondo oscuro, centrados, sin marco ni sombra (DECISIONS D27).
- **Última línea**, separada por un borde de 1px en blanco al 8%: "© año CampoData SpA" (fuente `campodata/anio` más el texto "CampoData SpA").
- Arriba del pie, una franja de 4px con el degradado `marca`.

---

## 9. Datos de contacto (`campodata-core/contacto.php`)

Archivo nuevo del mu-plugin, que se carga en todos los entornos. Es el `contacto.php` de Siete Colores con estos cambios:

**Opción `campodata_contacto`** (un arreglo), con `register_setting` y un valor por defecto con todas las claves vacías:

| Clave | Etiqueta en Ajustes | Sanitización | Valor inicial (`config/contacto-inicial.json`) |
| --- | --- | --- | --- |
| `whatsapp` | WhatsApp (formato internacional, solo dígitos) | Solo dígitos | `56926304489` |
| `mensaje_whatsapp` | Mensaje inicial de WhatsApp | Texto de una línea | `Hola, quiero saber más sobre CampoData` |
| `telefono` | Teléfono como se muestra | Texto de una línea | `+56 9 2630 4489` |
| `correo` | Correo | `sanitize_email` | `contacto@campodata.cl` (P8) |
| `asunto_correo` | Asunto del correo | Texto de una línea | `Solicitud de demo CampoData` |
| `zona` | Zona | Texto de una línea | `Los Ríos y Los Lagos, Chile` |
| `linkedin` | LinkedIn (URL) | `esc_url_raw` | vacío (P10) |
| `instagram` | Instagram (URL) | `esc_url_raw` | vacío (P10) |

- **Pantalla:** Ajustes → "Datos de contacto", con la Settings API y `manage_options`.
- **Fuente de *block bindings* `campodata/contacto`**, con `args.campo`: `whatsapp_url` (`https://wa.me/<whatsapp>?text=<mensaje codificado>`), `telefono`, `correo`, `correo_url` (`mailto:<correo>?subject=<asunto codificado>`), `zona`, `linkedin_url` e `instagram_url`. Un dato vacío devuelve `null` y el bloque muestra su respaldo.
- `social-link` acepta la URL enlazada con el filtro `block_bindings_supported_attributes_core/social-link` (riesgo R7).
- La función `CampoData\Core\dato_de_contacto( $clave )` devuelve un dato (C17 de Siete Colores).
- `bin/setup` crea la opción desde `config/contacto-inicial.json` (archivo nuevo) **solo si no existe**.
- **No se usa** el número `56912345678` del pie del sitio actual: es de ejemplo.

---

## 10. Movimiento, CSS y JS

### 10.1 Archivos y carga

| Archivo | Qué contiene | Cómo se carga |
| --- | --- | --- |
| `assets/css/sitio.css` | Estilos de bloque con CSS, encabezado, apariciones, efectos de §10.2, pestañas, tarjetas, tabla y formulario | `wp_enqueue_style` en el sitio y `add_editor_style` en el editor |
| `assets/css/editor.css` | En el editor: nada oculto por las animaciones y las pestañas usables | Solo en el editor |
| `assets/js/movimiento.js` | Módulo ES sin dependencias: apariciones, contadores, encabezado, progreso, inclinación del panel, foco de luz, pestañas, vuelta al ancla y formulario | `wp_enqueue_script_module` en el sitio |
| `inc/recursos.php` | Carga lo anterior, imprime el interruptor del `<head>`, precarga las tipografías y pasa los datos al módulo | `require` desde `functions.php` |

**Mejora progresiva** (igual que Siete Colores):

- Un script de una línea en el `<head>` agrega `cd-con-js` al `<html>` y, **solo si el usuario no prefiere movimiento reducido**, `cd-movimiento`. Solo con `cd-movimiento` el CSS oculta lo que va a aparecer.
- Si en 3 segundos el módulo no avisó que cargó, el script quita `cd-movimiento`.
- El formulario solo se muestra con `cd-con-js`. Sin `cd-con-js`, las pestañas muestran todos sus paneles (C22).

### 10.2 Efectos

Cada efecto tiene un código para poder pedir que se quite o se cambie al revisar la spec.

| # | Qué | Cómo |
| --- | --- | --- |
| M1 | **Aparición** de cada hijo directo de cada sección (salvo el banner) y del pie | Opacidad de 0 a 1 y `translateY` de `movimiento.distancia` a 0, en `movimiento.duracion` con `ease-out`. `IntersectionObserver` con `threshold` 0,12, una sola vez. Los hijos de una grilla o una fila se escalonan: `escalon` × posición, hasta 0,4s. Es la receta de campodata.cl |
| M2 | **Campo de píxeles** (banner y demo) | `pixeles.svg`: unos 36 cuadrados de 6 a 14px en `acento`, `brote`, `pradera` y `cielo`, más densos abajo a la izquierda, como en el logo. Cada uno sube entre 40 y 140px mientras se desvanece, en ciclos de 6 a 12s con retrasos distintos. La animación vive dentro del SVG |
| M3 | **Degradado vivo en el título** | El `background-position` del degradado `marca` del texto destacado va y vuelve en 8s |
| M4 | **Entrada del banner al cargar** | Píldora, título, párrafo, botones y cifras: el *fade* de M1 al cargar, escalonado de a 0,08s. El panel, desde 30px a la derecha, 0,3s después |
| M5 | **Panel vivo** | Dentro de `panel.svg`: la línea del gráfico se dibuja (`stroke-dashoffset`, 2s), las barras crecen escalonadas, y a los 2,2s aparece la tarjeta de recomendación con un punto que late. Por fuera, el panel flota (±6px en 6s) y se inclina hacia el mouse hasta 6° (`perspective` de 1000px), solo con `(hover: hover) and (pointer: fine)` |
| M6 | **Contadores** | Las cifras cuentan desde 0 hasta su valor en 1,2s, con el prefijo y el sufijo fijos ("+", "%", " hrs"). El HTML siempre trae el valor final, y el JS lo vuelve a dejar exacto al terminar |
| M7 | **Barra de progreso de lectura** | `scaleX` de 0 a 1 según el scroll. Un solo listener pasivo con `requestAnimationFrame`, compartido con M8 |
| M8 | **Encabezado con cristal** | `cd-con-scroll` pasados los 20px (§7) |
| M9 | **Línea de Cómo funciona** | §6.3 |
| M10 | **Foco de luz en tarjetas** | Con `pointermove`, el JS escribe `--x` y `--y` en la tarjeta; un `::before` con un `radial-gradient` de 220px (blanco al 60% en fondo claro, color del perfil al 15%) sigue al cursor. La tarjeta sube 4px con la sombra `brillo.marino`. Solo con `(hover: hover)` |
| M11 | **De la tarjeta al formulario** | §6.2 y §6.7 |
| M12 | **Reportes** | §6.4 |
| M13 | **Cierre vivo** | El degradado `cierre` se desplaza en 16s ida y vuelta (`background-size: 200%`) |
| M14 | **Botones** | Suben 2px con su sombra. El principal muestra debajo una línea de 2px con el degradado `marca` que crece desde el centro |
| M15 | **Checks que se dibujan** | §6.6 |

- La clase `sin-movimiento` excluye a un bloque de todo esto.
- Solo se animan `opacity`, `transform`, `background-position` y `stroke-dashoffset`: nada que obligue a recalcular el diseño.
- **Con `prefers-reduced-motion: reduce`:** no hay aparición, píxeles que se muevan (el SVG queda quieto), degradados en movimiento, flotación, inclinación, contadores ni reflejos. El scroll es instantáneo. Todo se ve en su estado final.
- Las animaciones que se repiten (M2, M3, M5, M13) se pausan cuando su sección no está a la vista (`animation-play-state` con el mismo `IntersectionObserver`) y cuando la pestaña del navegador está oculta.
- **Presupuesto:** `sitio.css` hasta 24 KB y `movimiento.js` hasta 12 KB, sin minificar (Siete Colores terminó con 21 y 10 KB, C15). `pixeles.svg` hasta 8 KB y `panel.svg` hasta 16 KB.

---

## 11. Textos guía e imágenes

- **Formato de los textos guía:** `[Qué va aquí: detalle y largo aproximado]`. Los de esta spec están en §6.2. Más los textos (propuesta) que el usuario no confirme.
- **Imágenes del tema:**

  | Archivo | Medidas y peso máximo | Qué es |
  | --- | --- | --- |
  | `assets/images/marca/emblema.webp` | 256 × 256, 20 KB | El emblema del logo (§5.6) |
  | `assets/images/ilustraciones/pixeles.svg` | 8 KB | El campo de píxeles animado (M2). Decorativo, `alt=""` |
  | `assets/images/ilustraciones/panel.svg` | Proporción 5:4, 16 KB | Un panel de aplicación sobre fondo `noche` claro (`#0D2A44`): una barra con el emblema simplificado (un círculo con los cuatro colores) y la etiqueta "Producción diaria"; un gráfico de línea en `cielo` sobre un área con degradado; seis barras en `brote` y `pradera`; y una tarjeta "Recomendación de hoy" en `acento` con el texto "Baja 2 kg de soya al Lote C hoy." (actual). **El gráfico no tiene números ni ejes con valores**: es una ilustración, no un dato |
  | `assets/images/iconos/*.svg` | 1 KB cada uno | Íconos de trazo de 24px (`stroke-width` 1,75, puntas redondeadas) para los perfiles, los pasos y los beneficios. Se dibujan a mano con formas simples (balde de leche, vaca, portapapeles, nube que sube, engranajes, mensaje, gráfico, calendario, reloj, brújula, espiga, flecha que sube) y se pintan con máscara y `currentColor`. **No se copian los íconos de Font Awesome del sitio actual** (tienen su propia licencia) |
  | `assets/images/reportes/*.webp` | 1100 × 627 (la medida de origen), 120 KB cada uno | Las cinco capturas del sitio actual (§6.4), sacadas del HTML y pasadas a WebP con calidad 82. Las imágenes que están en pestañas ocultas llevan `loading="lazy"` |

- **Cómo sacar las capturas:** descarga `https://campodata.cl/` a una carpeta temporal propia, decodifica las imágenes `data:image/jpeg;base64` por su `alt` y conviértelas con `cwebp` o Pillow, dentro de un contenedor o con el Python del host. Mide su peso y anótalo en DECISIONS.

---

## 12. Accesibilidad y móvil

- **Títulos:** un solo `h1`, un `h2` por sección y `h3` dentro de ellas.
- **Regiones:** `header`, `nav` ("Menú principal"), `main`, una `section` por sección y `footer`. El enlace "Saltar al contenido" del core funciona con el encabezado fijo.
- **Contraste:** solo las combinaciones de §5.1. El texto destacado del `h1` con el degradado tiene que llegar a 4,5 : 1 en sus tres colores sobre `noche` (`acento` 11,5, `brote` 8,5 y `cielo` 7,6).
- **Teclado:** el menú, el menú móvil, las pestañas y el formulario se usan con teclado y tienen el foco visible: un contorno de 2px en `primario` sobre fondo claro y en `acento` sobre fondo oscuro, separado 3px.
- **Pestañas:** activación manual del core (las flechas mueven el foco; Enter o Espacio activan).
- **Móvil (desde 360px):** sin scroll horizontal. Las columnas se apilan. Si las pestañas de Reportes no caben, su lista se desplaza en horizontal con un degradado que avisa que hay más. El `h1` no se corta. El menú pasa a un botón.
- **Formulario:** cada campo con su `label`. Sin nombre, se muestra un error en texto que anuncia el lector de pantalla (`aria-live`).
- **Tabla:** con `th` de columna y `scope`. En móvil se desplaza en horizontal dentro de su tarjeta.

---

## 13. `bin/setup` y `bin/check`

### 13.1 `bin/setup`

- **Paso "Portada"**, como Siete Colores:

  | Estado de "Inicio" | Qué hace `bin/setup` |
  | --- | --- |
  | No existe | La crea con `<!-- wp:pattern {"slug":"campodata/landing"} /-->` |
  | Su contenido es exactamente el provisional de la spec 01 | Lo reemplaza y avisa: "migración de la spec 01" |
  | Su contenido ya es el nuevo | Nada |
  | Tiene otro contenido | No la toca y avisa |

- **Paso "Datos de contacto":** crea `campodata_contacto` desde `config/contacto-inicial.json` solo si la opción no existe.
- **Opciones:** `blogdescription` = "Gestión simple para tu predio" (adaptado del título actual, P2).
- Se borra `patterns/inicio-provisional.php`. `bin/setup` sigue siendo idempotente.

### 13.2 `bin/check`

Se agregan:

| Verificación | Si no se cumple |
| --- | --- |
| Están registrados `campodata/landing` y los siete patrones de sección | Falla |
| La portada tiene **exactamente un** `<h1` | Falla |
| La portada tiene los `id` de `ANCLAS="inicio para-quien como reportes beneficios porque demo"`, **en ese orden** | Falla y nombra las que faltan o están fuera de orden |
| Cada enlace `/#ancla` del menú y del pie apunta a un `id` de la portada | Falla y nombra el enlace |
| Las dos tipografías, el emblema, las dos ilustraciones y las cinco capturas existen en el tema | Falla |
| Ninguna imagen del tema supera su peso máximo (§11) | Falla y nombra el archivo |
| Quedan textos guía (`[…]`) en la portada | **Avisa** con la cantidad |
| LinkedIn o Instagram están vacíos en los datos de contacto | **Avisa** |

---

## 14. Riesgos de ejecución

| # | Riesgo | Plan A | Plan B |
| --- | --- | --- | --- |
| R1 | Las pestañas del core no dejan poner las píldoras en la barra de la ventana o el reflejo encima | El `tabs` dentro del `group` con estilo `ventana`, y la barra como un `group` hermano arriba | Barra y reflejo con pseudoelementos del `group`. Anotarlo |
| R2 | Un navegador no anima el SVG cargado como imagen, o no respeta el `@media (prefers-reduced-motion)` de adentro | Animación CSS dentro del SVG | Un SVG quieto y la animación hecha en `sitio.css` sobre la imagen completa (subida lenta y *fade*), solo con `cd-movimiento`. Anotarlo |
| R3 | `background-clip: text` deja el título invisible en algún navegador | `@supports` con respaldo en `acento` | El texto destacado solo en `acento`, sin degradado. Anotarlo |
| R4 | La grilla "bento" no admite las tarjetas de 2 columnas o se rompe en tablet | Grilla del core con `columnSpan` y `@tablet`/`@mobile` | Tres columnas iguales sin tarjetas anchas. Anotarlo |
| R5 | El emblema recortado del JPG queda con un halo blanco o dientes en el borde | Máscara circular con 1px de suavizado | Mantener la ficha blanca con el anillo (§5.6), que tapa el borde. Pedir el SVG para la spec 03 |
| R6 | Las capturas de 1100px se ven borrosas en pantallas de alta densidad | Mostrarlas a su medida máxima (1100px) | Pedir al usuario exportaciones de 2200px y reemplazar los archivos; mientras, limitar el ancho de la imagen a 1100px |
| R7 | `social-link` no toma la URL enlazada | Filtro `block_bindings_supported_attributes_core/social-link` | Solo WhatsApp y correo, con la URL escrita en `footer.html`. Anotarlo |
| R8 | El formulario dentro de un bloque `html` pierde atributos al guardar la página | Marcado mínimo, sin JS en línea | Un patrón aparte (`campodata/formulario-demo`) referenciado desde el de demo. Anotarlo |
| R9 | El encabezado se desborda entre 320 y 1500px ("Por qué CampoData" es largo) | Menú en `small` con 1,5rem entre enlaces | Bajo 1100px se oculta el botón "Solicitar demo" (el menú móvil lo trae); si no alcanza, "Por qué CampoData" pasa a "Por qué nosotros". Anotarlo con medidas |
| R10 | La inclinación del panel deja el texto borroso o se nota brusca | `transform` con `will-change` solo mientras el mouse está encima | Quitar la inclinación y dejar solo la flotación. Anotarlo |
| R11 | El foco de luz choca con los fondos de los estilos de bloque | `::before` encima del fondo con `pointer-events: none` | Solo la subida y el borde de color, sin foco. Anotarlo |
| R12 | Las animaciones que se repiten gastan batería o bajan los cuadros por segundo en un teléfono | Pausa fuera de la vista (§10.2) | Bajo 782px, M2 con la mitad de los cuadrados y sin M3 ni M13. Anotarlo |

---

## 15. Orden de ejecución

Al cerrar cada etapa, deja los cambios sin commit y sugiere el mensaje (Conventional Commits, en español y sin tildes).

0. **Verificar sin cambiar nada:** la rama actual es `dev` y el árbol de trabajo está limpio. Si no, detente y avísale al usuario.
1. **Identidad:** tipografías y licencias en `assets/fonts/`, `theme.json` (§5.1 a §5.3), los estilos JSON (§5.5), el emblema (§5.6) y `docs/marca/logo-campodata.jpg`. Mensaje: `feat(tema): identidad de campodata desde el logo`.
2. **CSS y JS propios** (§10), `inc/recursos.php` y los estilos de bloque con CSS. Mensaje: `feat(tema): movimiento y estilos propios`.
3. **Datos de contacto** (§9). Mensaje: `feat(core): datos de contacto con una sola fuente`.
4. **Encabezado y pie** (§7 y §8). Medir el encabezado de 320 a 1500px. Mensaje: `feat(tema): encabezado fijo y pie`.
5. **Imágenes** (§11): ilustraciones, íconos y capturas. Mensaje: `feat(tema): ilustraciones, iconos y reportes`.
6. **Los siete patrones y `landing.php`**, el `blockGap` de `front-page.html`, borrar `inicio-provisional.php` y una `screenshot.png` nueva (1200 × 900) sacada de la portada. Mensaje: `feat(tema): secciones de la landing`.
7. **`bin/setup` y `bin/check`** (§13). Verificar: `bin/setup` sobre la instalación actual (migra), `bin/setup` otra vez (no cambia nada), `bin/reset --yes`, `bin/check` y `composer lint`. Mensaje: `feat(setup): portada con la landing y verificaciones`.
8. **Documentación** (§17). Mensaje: `docs: landing de campodata`.

---

## 16. Criterios de aceptación

- [ ] Se trabajó en `dev`, se empezó con el árbol limpio y la IA no hizo commits ni cambió de rama.
- [ ] Sobre la instalación de la spec 01, `bin/setup` migra "Inicio". Corrido otra vez no cambia nada. `bin/reset --yes` deja la landing completa sin pasos manuales.
- [ ] La portada muestra, en orden: Banner, Para quién, Cómo funciona, Reportes reales, Beneficios, Por qué CampoData y Solicitar demo. Sin franjas entre fondos.
- [ ] El banner muestra el `h1` con "simple y efectiva" en el degradado de la marca, el campo de píxeles que sube, el panel que se dibuja, flota y se inclina con el mouse, y las tres cifras que cuentan.
- [ ] Las tres tarjetas de "Para quién" llevan al formulario con su perfil elegido.
- [ ] La línea de Cómo funciona se dibuja y enciende los cuatro pasos en orden.
- [ ] Las cinco pestañas de Reportes muestran su captura y su leyenda, se usan con mouse y con teclado, y "Leche por Lote" se puede ver.
- [ ] Al bajar, cada sección aparece con *fade* (0,55s, desde 22px más abajo) y las tarjetas aparecen escalonadas.
- [ ] Con movimiento reducido (emulado en Chrome), todo se ve en su estado final: sin apariciones, píxeles quietos, sin contadores ni inclinación. **Con el JS bloqueado, todo el contenido se ve**: los cinco reportes uno debajo del otro (se verifica el atributo `hidden`, no solo la opacidad) y el formulario no aparece.
- [ ] Las animaciones que se repiten se pausan fuera de la vista (verificado en el panel de Rendimiento de Chrome o con `animation-play-state`).
- [ ] El encabezado queda fijo, gana el cristal y la barra de progreso al bajar, y no tapa ninguna sección al usar el menú. Cada enlace lleva a su sección, también desde `/pagina-que-no-existe/`. **No se desborda entre 320 y 1500px**, medido de a 1px.
- [ ] El formulario arma `https://wa.me/56926304489?text=…` con el nombre, el predio (si lo hay) y el perfil. Sin nombre, muestra el error.
- [ ] Los datos de contacto se editan en Ajustes → Datos de contacto, y los botones, el pie y el formulario los toman de ahí.
- [ ] Las tipografías se sirven desde el tema y la portada no pide nada a dominios externos.
- [ ] A 360px de ancho no hay scroll horizontal, el menú se abre con su botón, las pestañas y la tabla se pueden usar y el `h1` se ve completo.
- [ ] En el editor, todos los patrones, plantillas y partes validan sin bloques inválidos. Los siete patrones están en "CampoData" (`landing` no aparece). Los estilos de §5.5 están disponibles. Nada queda oculto por las animaciones.
- [ ] La paleta del editor tiene los 13 colores de §5.1, y solo se usan las combinaciones de texto permitidas.
- [ ] No hay contenido inventado: cada texto es (actual), (propuesta) confirmada por el usuario o un texto guía. No se usaron la foto de banco, el logo antiguo, los íconos de Font Awesome ni el número de WhatsApp de ejemplo.
- [ ] La portada pesa menos de 1 MB transferido en la primera visita, con las tipografías, las ilustraciones y la primera captura.
- [ ] `bin/check` pasa con las verificaciones nuevas, y `composer lint` pasa sin errores ni advertencias.
- [ ] El usuario revisó las capturas de escritorio (1440px) y de móvil (390px) y las aprobó.
- [ ] `README.md` y `docs/DECISIONS.md` están al día (§17).

---

## 17. Documentación

**`README.md`:**

- sección "La landing": el mapa de §4, cómo reordenar, agregar o quitar una sección, cómo reemplazar una captura de reportes y cuándo pasa el contenido a la página "Inicio";
- "Datos de contacto": dónde se editan y dónde aparecen;
- "Movimiento": la tabla de efectos (§10.2), la clase `sin-movimiento` y cómo probar con movimiento reducido y sin JS;
- la identidad: la paleta, dónde va cada color (§5.4) y qué combinaciones de texto se pueden usar;
- "Dónde va cada cosa", con `assets/`, `styles/`, `inc/recursos.php`, `contacto.php`, `config/contacto-inicial.json` y `docs/marca/`.

**`docs/DECISIONS.md`:** una entrada por cada decisión de §2, una por cada riesgo de §14 que se haya materializado, una con la fecha y versión de Fontsource, una con el peso final de cada imagen, y la tabla de riesgos de la spec 02.

---

## 18. Supuestos y preguntas abiertas

| # | Tema | Supuesto de esta spec | Qué cambia si es distinto |
| --- | --- | --- | --- |
| P1 | Qué ofrece CampoData a **ganaderos** (carne) y a **asesores** | No está publicado. Las tarjetas usan lo que ya se sabe (inventario, reportes, recomendaciones) y dejan textos guía para lo propio de cada perfil (§6.2) | Si el usuario lo cuenta al revisar la spec, se escribe como texto definitivo. Si CampoData hoy no sirve para ganadería de carne, la tarjeta "Ganaderos" se quita y el título del banner vuelve a "predio lechero" |
| P2 | Título del banner y lema | "Gestión simple y efectiva para tu lechería o predio ganadero" y el lema "Gestión simple para tu predio" (propuestas) | Se cambia el texto del patrón y el `blogdescription` de `bin/setup` |
| P3 | Cifras del banner (+12%, 10 hrs, 100%) | Son del sitio actual y se reutilizan. **Hay que confirmar que son medidas reales** | Si no lo son, se quitan o pasan a texto guía; el banner queda sin fila de cifras |
| P4 | "14 días gratis · Sin tarjeta de crédito · Sin compromiso" | La oferta sigue vigente | Se cambia o se quita la píldora y el párrafo de la demo |
| P5 | Publicar los reportes | Ya están publicados en el sitio actual, así que se reutilizan. Muestran datos reales de un predio (litros diarios). En v2 se borraron de la captura los nombres de terceros | Si el dueño de esos datos no lo autorizó, hay que reemplazarlos por capturas con datos de ejemplo antes de publicar |
| P6 | Pestaña "Leche por Lote" | Se suma como segunda pestaña: hoy su panel existe pero no tiene botón | Si se dejó fuera a propósito, se quita su pestaña e imagen |
| P7 | "Diseñado para predios de 50 a 200 vacas" | Se mantiene, porque es del sitio actual | Choca con el ejemplo de "~2.000 vacas" de Reportes y con el público nuevo (asesores, ganaderos). Si cambió, se reescribe ese punto |
| P8 | Correo de contacto | `contacto@campodata.cl` (el del pie) para todos los botones | Si las demos deben llegar a `fandradeg@campodata.cl` (el del botón actual), se cambia un valor en Ajustes |
| P9 | WhatsApp | `56926304489`, el del botón del sitio actual | Un valor en Ajustes |
| P10 | Redes sociales | No hay publicadas: el pie solo muestra WhatsApp y correo, y LinkedIn e Instagram quedan como claves vacías | Si existen, se cargan sus URL en Ajustes y aparecen solas |
| P11 | Logo | El JPG entregado sirve para esta spec (emblema recortado). El SVG oficial y el ícono de la pestaña van en la spec 03 | Si el usuario tiene el SVG ahora, el emblema sale de ahí y la spec 03 se reduce al ícono |
| P12 | Tipografías y paleta | Sora y DM Sans; la paleta del logo, sin el naranja del sitio actual | Si prefiere conservar Fraunces o el naranja, se cambian los tokens (los slugs no cambian) |
| P13 | Anclas nuevas | `#reportes` y `#demo` reemplazan a `#ejemplo` y `#cta` sin redirección | Si hay campañas o enlaces que usen las anclas viejas, se agregan dos `id` extra |
| P14 | Formulario de WhatsApp | Se agrega (el sitio actual solo tiene botones), con nombre, predio y perfil | Si no lo quiere, la demo queda con los dos botones |
| P15 | Cantidad de movimiento | Los 15 efectos de §10.2 | El usuario puede quitar o cambiar cualquiera por su código (M1 a M15) al revisar la spec |
| P16 | Foto en el banner | Sin foto: el panel ilustrado ocupa ese lugar | Si el cliente tiene una foto propia de su trabajo en terreno, se puede sumar en otra iteración |
