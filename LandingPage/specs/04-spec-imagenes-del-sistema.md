# Spec 04 · Imágenes del sistema en la landing

**Proyecto:** CampoData · Landing Page (WordPress 7.1.3, tema de bloques `campodata`)
**Alcance de esta spec:** volcar en la landing imágenes del propio sistema de CampoData, elegidas entre las 73 de `imagenes-sistema/`, y dejarlas preparadas dentro del tema, en una carpeta incluida en el repositorio, para subirlas a WordPress con él. De paso **retira las capturas de reportes que hoy muestra la sección Reportes**, que podrían identificar a un predio real, y **corrige los textos que prometen más de lo que la app hace hoy**, siguiendo el análisis del departamento de administración (`ANALISIS_LANDING.md`).
**Rama de trabajo:** `dev`
**Depende de:** spec 02 ejecutada (versión 3). El número 03 queda reservado para el logo oficial y el ícono de la pestaña (spec 02, §3).
**Versión:** 2 · 2026-11-09

### Historial de decisiones

| Versión | Cambio confirmado |
| --- | --- |
| v1 | Pedido del usuario: analizar las imágenes de `imagenes-sistema/`, elegir las mejores y decidir a qué sección va cada una, con una tabla de correspondencia (imagen → sección) e instrucciones para volcarlas, dejando las imágenes finales en una carpeta incluida en el repositorio para subir a WordPress. Se eligieron 17 imágenes |
| v2 | El usuario pidió tomar en cuenta `ANALISIS_LANDING.md` (administración, 2026-11-07). La selección baja a **9 imágenes**: salen las que muestran datos poco realistas o errores de texto que un asesor detecta (hoja de carga, temporadas, ensayos, datos cruzados, agenda, celular de producción), y entran las que el análisis marca como más fuertes. Se suman: el **retiro prioritario de las capturas de reportes** (riesgo de privacidad), la **corrección de los textos que prometen de más** (§7) y una **lista de recaptura** a doble resolución (§9). Cómo se tomó cada recomendación del análisis está en §2. Los textos marcados **(propuesta)** y los supuestos de §14 quedan por confirmar al revisar la spec |
| v2 (ejecución) | El usuario pidió implementarla tal como está (2026-11-09): **quedan confirmados los textos (propuesta)**; las preguntas de §14 siguen abiertas con sus supuestos (en especial P4 y P9). Se ejecutó el mismo día. Los desvíos están en `docs/DECISIONS.md`, C14 a C21: entre otros, "Inicio" estaba guardada desde el editor con una copia fija de la landing y se devolvió a la referencia (C15), y las imágenes de Para quién van al pie de cada tarjeta (C17) |
| Pedido posterior | El usuario pidió usar casi todos los recortes y comprimir más (2026-11-09). Se usan 12 de los 20 recortes, con dos pestañas nuevas en Reportes (Ensayos y Equipo) e imágenes en Beneficios, y todo va a calidad 70 salvo el banner, que queda igual. Detalle en DECISIONS D25; la tabla de correspondencia vigente está en el README ("Imágenes del sistema") |

---

## Resumen: tabla de correspondencia

Se eligieron **9 imágenes de 73**. Las rutas son relativas a `imagenes-sistema/` (carpeta local, ignorada en git). El detalle de cada una (archivo final, retoque y texto alternativo) está en §4.

| Imagen | Sección a la que va |
| --- | --- |
| `1_escritorio_demo/03_produccion_hoy_que_mirar.jpg` | **Banner**: pantalla principal |
| `2_movil_demo/01_inicio.jpg` | **Banner**: teléfono que se superpone a la pantalla |
| `3_recortes_para_landing/kpis_inicio.jpg` | **Para quién**: tarjeta "Dueños de lecherías" |
| `3_recortes_para_landing/explicame_modal.jpg` | **Para quién**: tarjeta "Asesores" |
| `3_recortes_para_landing/alertas_que_mirar_hoy.jpg` | **Cómo funciona**: bloque "Así se ve en el sistema" |
| `3_recortes_para_landing/compras_cuando_pedir.jpg` | **Cómo funciona**: bloque "Así se ve en el sistema" |
| `1_escritorio_demo/06_produccion_curva_meta_y_dietas.jpg` | **Reportes**: pestaña "Producción" |
| `1_escritorio_demo/13_calidad_que_es_esto_contrato.jpg` | **Reportes**: pestaña "Calidad" |
| `3_recortes_para_landing/ciclo_reproductivo_selector.jpg` | **Por qué CampoData**: bajo la comparación |

**Beneficios** y **Solicitar demo** no llevan imágenes en esta versión. Las que se agregarán cuando la demo esté corregida están en §9.

---

## 0. Instrucciones para la IA que ejecute esta spec

1. Lee este documento completo, `ANALISIS_LANDING.md`, la spec 02, `README.md`, `docs/DECISIONS.md` y `Clientes Web/FRAMEWORK-WORDPRESS.md` antes de escribir el primer archivo. Las reglas de la spec 02 siguen vigentes, salvo lo que esta spec cambie de forma explícita.
2. **Git lo maneja el usuario.** No hagas `commit`, `push` ni `add`, y no crees ni cambies ramas. Al empezar debes estar en `dev`. Si el árbol de trabajo tiene cambios sin commit de trabajos anteriores, avísale al usuario antes de seguir. Al cerrar cada etapa, deja los cambios sin commit y sugiere el mensaje.
3. **`imagenes-sistema/` es solo de lectura y queda fuera de git.** No muevas, renombres ni borres nada ahí. Todo lo que se publique sale de copias procesadas en el tema (§5). **No abras `5_referencia_interna_NO_publicar/` ni uses `4_datos_reales_censurados/`** (§3).
4. **Sin terceros** (spec 02, §0.13; DECISIONS D21): ninguna imagen ni texto publicado nombra sistemas, instituciones ni empresas ajenas. Esta regla **manda sobre el análisis**: donde el análisis sugiere nombrar un programa de gestión del rebaño, la fuente oficial de precios o el servicio de meteorología, no se nombran (§2). Revisa cada imagen **a tamaño real** antes de usarla.
5. **No prometer más de lo que la app hace hoy** (análisis, §1.3 y §5). Ningún texto dice que CampoData da recomendaciones automáticas de qué hacer, que se conecta solo a sensores o que el cliente carga sus archivos por su cuenta. Lo que sí hace la app es avisar qué mirar hoy, decir cuánto alimento queda y cuándo pedir, mostrar la producción contra la meta y los cambios de dieta, explicar la calidad según el contrato y explicar por qué cambió un número.
6. **Datos de demostración, dicho con honestidad.** Las pantallas son del "Campo Demostración", con datos ficticios. La portada nunca dice que son datos de clientes (§6.4). Nunca inventes cifras ni textos que no estén en las imágenes.
7. **Ningún retoque inventa contenido** (§5.3): solo se borran punteros y franjas internas, o se copian píxeles idénticos del propio sistema.
8. Colores, tamaños y espaciados salen de los tokens de `theme.json`. En el CSS, por sus variables `--wp--preset--…` y `--wp--custom--…`.
9. Antes de escribir el marcado de un bloque, revisa su `block.json` en el core 7.1.3 (dentro del contenedor, en `wp-includes/blocks/<bloque>/block.json`). Todo tiene que validar en el editor.
10. Si algo no se comporta como se describe, aplica el plan B del riesgo (§10), sigue, y anótalo en DECISIONS.
11. No toques lo que está fuera de alcance (§2.3).
12. Al terminar, verifica uno por uno los criterios de §12 y reporta el resultado, con capturas de escritorio (1440 px) y de móvil (390 px).

---

## 1. Punto de partida

| Pieza | Estado actual |
| --- | --- |
| Banner | A la derecha, `panel.svg` (una ilustración animada de un panel) con dos tarjetas flotantes: "Se adapta a la tecnología de tu predio" y "Recomendación de hoy: Baja 2 kg de soya al Lote C hoy.". Abajo, tres cifras: "+12 %", "10 hrs" y "100 %" |
| Reportes | Cuatro pestañas con capturas de reportes del sitio anterior, en `assets/images/reportes/*.webp`, con la píldora "~2.000 vacas / ejemplo" y el párrafo "reportes reales que usamos con nuestros clientes". **El análisis advierte que el ejemplo de ~2.000 vacas podría ser el Campo A (2.116 vacas en ordeña), y que entonces el predio se reconocería** |
| Textos | Hablan de "recomendaciones prácticas" y "acciones concretas", que la app todavía no da (análisis, §1.3) |
| `imagenes-sistema/` | 73 imágenes en cinco carpetas. Local, ignorada en git |
| `ANALISIS_LANDING.md` | Recorrido de la plataforma de administración: qué se puede publicar, qué no, qué tiene cada módulo y qué falta. Está en la raíz de `LandingPage/` |

**Qué muestran las imágenes.** Son pantallas del sistema de CampoData: Inicio, Producción (Hoy, Producción, Calidad, Panel, Plan de alimentación, Historial, Entregas y Compras), Reproducción, Rebaño, Análisis (Datos cruzados y Ensayos de alimentación), Mi predio, Calendario y "Explícame". Las de escritorio miden 1118 × 679 px, las de celular 390 × 659 px y los recortes, entre 299 y 1024 px de ancho. Según el análisis, para la versión final conviene recapturarlas a doble resolución (§9).

---

## 2. Decisiones, análisis y alcance

### 2.1 Decisiones

| Tema | Decisión | Alternativa descartada |
| --- | --- | --- |
| Qué se muestra | **El propio sistema, con datos de demostración**, en lugar de la ilustración del banner y de las capturas de reportes del sitio anterior | Mantener las capturas de reportes: no son del producto y pueden identificar un predio |
| Criterio de elección | Que se entienda en 3 segundos, que muestre algo que una planilla o un panel genérico no hacen y que sea 100 % ficticia (criterio del análisis, §4). A eso se suma: **legible, sin punteros que no se puedan borrar, sin textos internos y sin datos que un asesor note como poco realistas** | Elegir por cantidad de pantallas o por cuántos módulos aparecen |
| Cuántas | **9**, sin repetir contenido entre secciones. Las que se ven bien pero muestran datos poco realistas esperan la corrección de la demo (§9) | 17 imágenes (v1): varias mostraban errores que el análisis detectó |
| Banner | La pantalla **Hoy de Producción** ("qué mirar hoy" y "cuánto queda") con el **celular de Inicio** encima. Es el mensaje que el análisis propone para el banner: qué mirar hoy, cuánto alimento queda y cuánto deja cada litro | La curva de producción (v1): queda como pestaña de Reportes |
| Reportes | Dos pestañas a pantalla completa: **Producción** (curva, meta, tope del estanque y cambios de dieta) y **Calidad** (análisis fuera de contrato con el "Qué es esto"). Las demás pestañas vuelven con la recaptura (§9) | Cuatro pestañas con pantallas que hoy tienen errores |
| Para quién | Cada tarjeta con la imagen que el análisis asocia a ese público: **Inicio con ingreso y margen** para el dueño, **"Explícame"** para el asesor | Imágenes genéricas |
| Formato | **WebP** de calidad 82, **a la medida de origen** (sin ampliar) | Dejar los JPG |
| Ampliar | Las imágenes, salvo las del banner, se **amplían al hacer clic** con la ampliación (*lightbox*) del bloque `image` del core | Sin ampliar: el texto de las capturas es pequeño |
| Dónde viven | **En el tema**, en `assets/images/sistema/`, **incluidas en git**. Se suben a WordPress junto con el tema (§5.1) | La Biblioteca de medios: el contenido queda en la base y no se reproduce con `bin/setup` (DECISIONS D05) |
| Textos | Se corrigen los que prometen recomendaciones automáticas, cifras sin fuente o datos reales (§7) | Dejar los textos de la spec 02 junto a pantallas que no los respaldan |

### 2.2 Cómo se tomó cada recomendación del análisis

| Recomendación del análisis | Qué hace esta spec |
| --- | --- |
| Reemplazar los reportes de "~2.000 vacas" por imágenes de la demo (§1.2 y §5) | **Se aplica, con prioridad:** es la etapa 2 (§11) |
| No usar capturas de Campo A ni de Campo B, ni la carpeta 5 (§5) | **Se aplica** (§3) |
| No publicar las cifras +12 %, 10 h y 100 % mientras no tengan respaldo (§5) | **Se aplica:** se quitan del banner (§7) |
| La landing promete recomendaciones automáticas y sensores que la app no tiene (§1.3) | **Se aplica:** se corrigen los textos (§7) |
| Imágenes ★★★: `cuanto_queda_alimento` + `compras_cuando_pedir`, `alertas_que_mirar_hoy` + `recetas_vs_habitual`, `kpis_inicio`, `curva_produccion_meta` o la 06 | **Se aplica, salvo dos:** `recetas_vs_habitual` muestra las sales minerales al 5 % de la ración, que el análisis marca como poco realista (§6.1), y `cuanto_queda_alimento` repite lo que ya dicen `compras_cuando_pedir` y la pantalla del banner. Las dos quedan en la lista de recaptura (§9) |
| Imágenes ★★: `explicacion_contrato_planta`, `explicame_modal` | **Se aplica:** la explicación del contrato va dentro de la pantalla 13 (pestaña Calidad), y "Explícame" en la tarjeta de los asesores |
| Imágenes ★★: `hoja_de_carga`, `temporada_otono` + `curvas_partos_servicios`, recortes de los ensayos | **Todavía no:** el propio análisis detecta en ellas datos que un asesor nota de inmediato (§6.1, puntos 1 a 4). Se agregan cuando se corrija la demo (§9) |
| Imágenes ★☆☆: permisos y equipo, agenda y clima, celulares 03 y 05 | **No, o en parte:** los permisos y la promesa "cada uno ve lo suyo" esperan que se configuren las vistas por rol (§3.2 del análisis). La agenda dice "cojas" en lugar de "cojeras" (§6.2), y el clima nombra a su fuente. En el celular 05 un texto se sale de la tarjeta (§6.4). Del celular se usa la pantalla de Inicio |
| Banner con `kpis_inicio` o la 03 en un portátil, más el celular 03 (§4 y §8) | **Se aplica la idea:** la 03 de escritorio en un marco y el celular de **Inicio**, para no repetir el mismo contenido dos veces |
| "Conectamos sus datos de [programa de gestión] y del carro mezclador" (§5 y §8) | **Se adapta:** "Te ayudamos a conectar los datos de tus equipos y del carro mezclador", sin nombrar el programa (D21) |
| Ingreso y margen con el precio de la fuente oficial (§3.1) | **Se adapta:** `kpis_inicio` muestra el ingreso y el margen; el recorte no incluye la línea con el nombre de la fuente, y la web no la nombra (D21) |
| Mensajes en "usted" ("Sepa cuánto le deja…") | **Se adapta a "tú"**, el registro de toda la landing y de la app (análisis, §6.2) |
| Recapturar a 2x, sin cursor ni tooltips de desarrollo (§0 y §4) | **Se aplica como etapa posterior:** esta spec usa las de 1118 px retocadas, con los mismos nombres de archivo, para que la recaptura solo reemplace archivos (§9) |
| Mantener la paleta de la app (verde oscuro, verde de acción y naranja de alerta) | **Pregunta abierta** (P6). La identidad de la landing sale del logo (spec 02, D14). Las capturas conservan sus colores dentro de un marco neutro |
| Nueva estructura (§8): "Ver la demo", "Sus datos son suyos", "En desarrollo", pestañas por persona del campo | **Fuera de alcance:** es una spec aparte. Esta spec mantiene las siete secciones de la spec 02 |
| Mensajes para investigación y universidades (§3.4) | **Fuera de alcance:** la landing es solo para lecherías y asesores (DECISIONS D22) |
| Mejoras de la plataforma (§6 y §7) | **Fuera de alcance:** son de la app. Las que bloquean imágenes están en §9 |

### 2.3 Alcance

**Dentro:**
- procesar las 9 imágenes (§5);
- retirar las capturas de reportes y `panel.svg`;
- cambiar los patrones del banner, Para quién, Cómo funciona, Reportes y Por qué (§6);
- corregir los textos de §7;
- el CSS nuevo (§8);
- `bin/check`, README y DECISIONS (§11 y §13).

**Fuera (no lo hagas):**
- Usar imágenes de `4_datos_reales_censurados/` o de `5_referencia_interna_NO_publicar/`.
- Recapturar pantallas o corregir la demo de la app (§9 lo deja listado para el equipo).
- Cambiar la estructura de secciones, las anclas o el menú: `#reportes` y "Reportes" se quedan (P3).
- La "nueva estructura" del análisis (§8): un botón "Ver la demo", las secciones "Sus datos son suyos" y "En desarrollo", y las pestañas por persona del campo.
- Mensajes sobre vistas por rol o "cada encargado ve lo suyo" (esperan la configuración de la app).
- Escribir textos que no estén en §6, §7 o en las propias imágenes.

---

## 3. Qué se descartó y por qué

| Grupo | Imágenes | Motivo |
| --- | --- | --- |
| **No publicar** | `5_referencia_interna_NO_publicar/` (5) | Lo dice la carpeta y lo confirma el análisis (§0). No se abrieron |
| **Datos reales censurados** | `4_datos_reales_censurados/` (4) | Las curvas y las fechas pueden reconocerse en el rubro, los datos están desactualizados ("Último dato hace 12 meses" y "hace 2 años") y algunos indicadores se ven mal (análisis, §5) |
| **Datos poco realistas** (un asesor los nota) | `hoja_de_carga`, `05_produccion_hoja_de_carga`, `recetas_vs_habitual`, `04_produccion_hoy_recetas_vs_habitual` | Sales minerales al 5 % de la ración (~2 kg por vaca); las vacas con mastitis comen la receta de Secas (análisis, §6.1.1 y §6.1.2) |
| | `temporada_otono`, `curvas_partos_servicios`, `21` a `24` (Reproducción) | El 52,5 % de los partos fuera de temporada, sumisión de 11 a 14 % y una curva de partos que crece hacia el final (§6.1.4) |
| | `ensayo_checklist`, `ensayo_tarjetas_resultado`, `ensayo_indice_grafico`, `30` a `32`, `2_movil_demo/08_ensayos` | La Muestra A es el lote de Secas y "produce" 19 L; el checklist marca "mismo lote" con lotes distintos; recetas idénticas (§6.1.3). Las pantallas, además, traen "Idea" y "Simulado" |
| **Errores de texto** | `agenda_tareas`, `02_inicio_tareas_notas_clima`, `39_calendario`, `2_movil_demo/07_calendario` | "Revisar cojas" en lugar de "cojeras" (§6.2) |
| | `28_analisis_datos_cruzados`, `29_analisis_minimo_30_dias` | "Se mueven juntas: casi nula" se contradice (§6.2) |
| | `14_panel_por_dieta` | Voseo: "Tocá un punto del gráfico" (§6.2) |
| | `2_movil_demo/05_produccion_grafico` | "11 DÍAS CON LA RECETA INCOMPLETA" se sale de la tarjeta (§6.4) |
| **Nombran un tercero** | `01_inicio_resumen`, `02_…`, `39_…`, `pronostico_clima`, `34_mi_predio_mapa` | La fuente de los precios, el servicio de meteorología y un mapa con una planta industrial real (análisis, §0 y §5) |
| **"En construcción" o gráficos débiles** | `25`, `26` y `27` (Rebaño), `09_produccion_mensual`, `rebano_salidas_grafico` | Tooltip de desarrollo, línea plana, tres barras y una cortada, verde saturado (análisis, §5) |
| **Personas, roles y administración** | `36`, `37`, `38`, `permisos_matriz`, `2_movil_demo/02_menu`, `33_mi_predio_configuracion` | La promesa "cada uno ve lo suyo" espera la configuración de las vistas por rol (análisis, §3.2). El menú del celular muestra al superadministrador |
| **Puntero difícil de borrar** | `07`, `08`, `10`, `11`, `12`, `15`, `16`, `17`, `19`, `20` | El puntero cae sobre el texto de una pestaña, un botón o la curva. Van en la recaptura (§9) |
| **Repiten una elegida** | `18_explicame_diagnostico`, `explicacion_contrato_planta`, `curva_produccion_meta`, `meta_produccion`, `cuanto_queda_alimento`, `2_movil_demo/03_produccion_hoy` y `04`, `06`, `35` | El mismo contenido ya está en otra imagen elegida |

---

## 4. Detalle de las 9 imágenes

Las medidas son las de origen. "Retoque" es lo que hay que hacer antes de convertir (§5.3). Los textos alternativos son propuestas.

| # | Archivo final (`assets/images/sistema/`) | Origen | Medidas | Retoque | Texto alternativo |
| --- | --- | --- | --- | --- | --- |
| 1 | `banner-hoy.webp` | `1_escritorio_demo/03_produccion_hoy_que_mirar.jpg` | 1118 × 679 | Borrar el puntero (hacia x 576–598, y 398–426). Pasa sobre el borde vertical de la tarjeta "Silo de ballica": rehacer ese tramo copiando el mismo borde de más arriba o de más abajo | Pantalla Hoy de Producción en CampoData: dos avisos de qué mirar hoy y los días de alimento que quedan |
| 2 | `banner-movil-inicio.webp` | `2_movil_demo/01_inicio.jpg` | 390 × 659 | Ninguno | Inicio de CampoData en el celular: litros totales, litros por cabeza y calidad de la leche |
| 3 | `perfil-lecheria-inicio.webp` | `3_recortes_para_landing/kpis_inicio.jpg` | 1024 × 295 | Borrar el puntero sobre "Margen ($)". Tapa el "($)": rehacerlo copiando el "($)" de "Ingreso por la leche ($)" de la misma imagen (mismos píxeles, misma tipografía) y pintar el resto con el fondo de la tarjeta | Resumen de una lechería en CampoData: litros, sólidos, animales en ordeña, preñez, ingreso por la leche, gasto y margen |
| 4 | `perfil-asesor-explicame.webp` | `3_recortes_para_landing/explicame_modal.jpg` | 859 × 624 | Borrar el puntero y **la franja punteada "DEMO · Simular datos nuevos"** del pie de la ventana, pintando el fondo de la ventana | "Explícame" en CampoData: los kilos bajaron 10 % y la variación se explica por el rebaño, con dos gráficos |
| 5 | `accion-que-mirar-hoy.webp` | `3_recortes_para_landing/alertas_que_mirar_hoy.jpg` | 1004 × 200 | Ninguno | "Qué mirar hoy": un aviso por sobras de 6 % en el comedero y otro por una mezcla imprecisa |
| 6 | `accion-cuando-pedir.webp` | `3_recortes_para_landing/compras_cuando_pedir.jpg` | 1004 × 255 | Ninguno | "Cuánto queda y cuándo pedir": días de alimento por insumo y la fecha para pedir cada uno |
| 7 | `reportes-produccion.webp` | `1_escritorio_demo/06_produccion_curva_meta_y_dietas.jpg` | 1118 × 679 | Borrar el puntero (abajo a la derecha, hacia x 994–1018, y 646–676; fondo plano) | Producción en CampoData: litros por día contra la meta de 8.500 y el tope del estanque, con los siete cambios de dieta marcados |
| 8 | `reportes-calidad.webp` | `1_escritorio_demo/13_calidad_que_es_esto_contrato.jpg` | 1118 × 679 | El puntero tapa el distintivo "2 de 9 análisis fuera del contrato". **Copiar ese distintivo desde `12_calidad_rcs.jpg`**, donde está igual, en la misma posición y sin puntero (hacia x 848–1084, y 132–164). Rehacer el borde superior de la ventana "Qué es esto" que tape la cola del puntero, copiando el mismo borde de al lado | Calidad de la leche en CampoData: grasa, proteína, UFC, RCS y urea, y la explicación de cuándo la leche no cumple el contrato con la planta |
| 9 | `adaptacion-ciclo-reproductivo.webp` | `3_recortes_para_landing/ciclo_reproductivo_selector.jpg` | 495 × 415 | Ninguno | "Cómo trabaja el campo": el ciclo reproductivo se elige entre continuo, estacional y bi-estacional |

---

## 5. Las imágenes finales: carpeta para subir a WordPress

### 5.1 Dónde van

En `wp-content/themes/campodata/assets/images/sistema/`, **versionada en git** (a diferencia de `imagenes-sistema/`, que es local). Son parte del tema, y **desplegar el sitio es copiar la carpeta del tema al servidor** (DECISIONS D01): las imágenes viajan con él y se sirven desde `/wp-content/themes/campodata/assets/images/sistema/…`. No se suben a la Biblioteca de medios (P1).

### 5.2 Cómo se preparan

1. Abre cada imagen de origen (§4) **a tamaño real** y confirma que coincide con lo descrito: medidas, retoque pendiente y ausencia de terceros.
2. Aplica el retoque (§5.3).
3. Convierte a WebP con calidad 82, **sin cambiar las medidas**. Si pasa el peso máximo, baja la calidad de a 4 puntos, hasta un mínimo de 70.
4. Guarda con el **nombre final** de §4: en minúsculas, con guiones, sin espacios ni tildes.
5. Hazlo con Pillow (`PIL`, con soporte WebP), que ya está en el equipo. No se agrega nada al repositorio ni al sitio: los guiones que escribas van en tu carpeta temporal.

**Peso máximo por archivo:** pantallas de escritorio (1, 7 y 8) 90 KB; celular (2) 60 KB; recortes (3 a 6 y 9) 70 KB. `bin/check` falla si alguno lo pasa (§11).

### 5.3 Retoque

- **Fondo plano:** el puntero se borra pintando encima con el color de ese lugar (toma un píxel vecino) o copiando un trozo de fondo limpio de al lado.
- **Puntero sobre texto, un borde o una línea:** solo se rehace con **píxeles idénticos del propio sistema**, como el "($)" de la misma imagen o el distintivo de la pantalla 12. Nunca se escribe texto nuevo. Si no hay de dónde copiar, la imagen queda fuera y se avisa (R2).
- **La franja "DEMO · Simular datos nuevos"** (imagen 4) se cubre con el color de fondo de la ventana.
- Las coordenadas de §4 son aproximadas. Ubica cada puntero en la imagen antes de pintar y comprueba a 400 % de zoom que no quedan sombra, texto cortado ni manchas.
- Guarda una comparación lado a lado de cada imagen retocada con su original, para el informe final.

---

## 6. Qué cambia en cada sección

Los textos que no cambian aquí ni en §7 se mantienen tal cual. Los marcados **(propuesta)** son nuevos y se confirman al revisar la spec.

### 6.1 Banner (`patterns/banner.php`)

- En `.cd-panel`, la ilustración `panel.svg` pasa a ser **la pantalla #1** (`banner-hoy.webp`, 1118 × 679), dentro de un marco de aplicación (`cd-pantalla`, §8).
- **Encima, abajo a la derecha, el celular #2** (`banner-movil-inicio.webp`, 390 × 659), con el marco `cd-telefono`. Mide ~30 % del ancho de la pantalla y sobresale 6 % hacia la derecha y 8 % hacia abajo.
- Las dos imágenes **no se amplían** y **no llevan `loading="lazy"`** (son lo primero que se ve). La pantalla lleva `fetchpriority="high"`.
- Tarjetas flotantes:
  - "Se adapta a la tecnología de tu predio" se queda;
  - "Recomendación de hoy: Baja 2 kg de soya al Lote C hoy." se **reemplaza** por una frase real del sistema, la misma de la pantalla #1: el rótulo "Qué mirar hoy" y el texto "Ordeña primavera-verano: sobró 6 % en el comedero (lo habitual es 3 %)." (**propuesta**). Así la tarjeta dice lo que la app hace: avisar, no recomendar.
- **Se quita la fila de cifras** (+12 %, 10 hrs y 100 %; §7).
- Se conservan la flotación, la inclinación con el mouse (M5) y la entrada al cargar (M4). Las animaciones propias de `panel.svg` desaparecen con él (R3).
- Hasta 781 px, la pantalla va al 100 % y el celular al 34 % del ancho, sin salirse de la columna.

### 6.2 Para quién (`patterns/para-quien.php`)

Cada tarjeta recibe una imagen entre el ícono y el título, a todo el ancho de la tarjeta, con `cd-marco` (§8) y ampliable:

| Tarjeta | Imagen | Pie |
| --- | --- | --- |
| Dueños de lecherías | #3 `perfil-lecheria-inicio.webp` | "Litros, calidad, rebaño, reproducción y margen en una pantalla" (**propuesta**) |
| Asesores | #4 `perfil-asesor-explicame.webp` | "Explícame: por qué cambió un número, en palabras simples" (**propuesta**) |

Los puntos de cada tarjeta cambian según §7.

### 6.3 Cómo funciona (`patterns/como-funciona.php`)

Después de los cuatro pasos, un bloque nuevo (`cd-ejemplo-accion`) con el `h3` **"Así se ve en el sistema"** (**propuesta**). Debajo, dos imágenes apiladas, de 1004 px de ancho como máximo, con `cd-marco`, ampliables y con la aparición escalonada de M1:

- #5 `accion-que-mirar-hoy.webp`, con el pie "Cada mañana, lo que se salió de lo normal." (**propuesta**);
- #6 `accion-cuando-pedir.webp`, con el pie "Cuántos días de alimento te quedan y cuándo pedir." (**propuesta**).

### 6.4 Reportes (`patterns/reportes.php`)

La sección conserva su ancla `#reportes`, su ceja "03 · Reportes" y su lugar. Cambia:

- **`h2`:** "Mira CampoData por dentro" (**propuesta**).
- **Párrafo:** "Así se ve CampoData con los datos de un campo de demostración: la producción contra tu meta, con cada cambio de dieta, y la calidad de la leche explicada según el contrato con la planta." (**propuesta**). Se quita "reportes reales que usamos con nuestros clientes".
- **Barra de la ventana:** el título "CampoData — El sistema" y **una sola píldora, "Datos de demostración"**. Se quitan "Dashboard activo", "Ene 2023 – Ago 2025" y "~2.000 vacas / ejemplo". No se agrega el tamaño del campo de demostración (434 cabezas): no calza con el público de 50 a 200 vacas que declara la landing (análisis, §6.5; P7).
- **Pestañas** (dos, con la misma estructura de `tabs`):

| Pestaña | Imagen | Leyenda (`cd-leyenda`, **propuesta**) |
| --- | --- | --- |
| Producción | #7 `reportes-produccion.webp` | "**Producción:** los litros de cada día contra tu meta y el tope del estanque. Cada cambio de dieta queda marcado, para ver qué comían las vacas cuando cambió la producción." |
| Calidad | #8 `reportes-calidad.webp` | "**Calidad:** grasa, proteína, UFC, RCS y urea, y cuántos análisis quedaron fuera del contrato con la planta, explicado en simple." |

- Las dos pantallas con **proporción fija 1118 / 679**, ampliables, con `loading="lazy"` en la que no se ve al cargar.
- El botón "Quiero ver mis datos así" se queda, a `/#demo`.
- **Sin JS**, siguen viéndose los dos paneles uno debajo del otro (C22 de Siete Colores).
- **Se borran** `assets/images/reportes/` (las cuatro capturas antiguas) y su CSS (`.cd-captura`) en esta misma etapa.

### 6.5 Por qué CampoData (`patterns/por-que.php`)

La imagen #9 `adaptacion-ciclo-reproductivo.webp` (495 × 415) va **debajo de la tarjeta de comparación**, en la columna derecha, con `cd-marco` y ampliable. El pie: "Cada predio trabaja distinto, y CampoData se adapta a cómo trabaja el tuyo." (**propuesta**). Refuerza el mensaje de adaptación (DECISIONS D21).

### 6.6 Beneficios y Solicitar demo

Sin imágenes. Sus textos cambian según §7.

---

## 7. Textos que prometen más de lo que la app hace hoy

El análisis (§1.3 y §5) detectó que la landing promete recomendaciones automáticas, cifras sin fuente y, para la demo, datos del propio predio. Con capturas reales al lado, esa diferencia se nota más. Todos los textos nuevos son **(propuesta)**.

| Dónde | Hoy dice | Pasa a decir |
| --- | --- | --- |
| Banner, párrafo | "…Ordenamos sus datos y te entregamos recomendaciones prácticas y claras para mejorar alimentación, producción y eficiencia diaria." | "Nos adaptamos a la tecnología y la maquinaria que ya tiene tu predio. Ordenamos sus datos y te mostramos, en simple, qué mirar hoy, cuánto alimento te queda y cómo va la producción contra tu meta." |
| Banner, cifras | "+12 % · 10 hrs · 100 %" | Se quitan. Si se consigue respaldo (un caso documentado o una fuente), vuelven con su fuente (P8) |
| Banner, botón | "Ver reportes reales" | "Ver el sistema" |
| Para quién, dueños | "Producción diaria por turno y por lote." · "Dónde se va el gasto en soya, maíz o concentrado." · "Nos adaptamos a los equipos y la maquinaria que ya tienes." | "Producción diaria contra tu meta, con cada cambio de dieta." · "Cuántos días de alimento te quedan y cuándo pedir." · "Nos adaptamos a los equipos y la maquinaria que ya tienes." (este se queda) |
| Para quién, asesores | "Reportes claros para compartir…" · "Recomendaciones accionables, no jerga estadística." · "[Si CampoData permite ver varios predios…]" | "Producción, dieta y calidad en la misma línea de tiempo." · "Explícame: por qué cambió un número, en palabras simples." · "Todos tus predios desde una misma cuenta." (la app tiene un selector de campo; ver P4) |
| Cómo funciona, paso 02 | "CampoData limpia, organiza y cruza la información automáticamente…" | "Ordenamos y cruzamos la información: producción, alimentación, calidad y reproducción, en un solo lugar." |
| Cómo funciona, paso 03 | "Recomendaciones prácticas" · "\"Baja 2 kg de soya al Lote C hoy.\" Mensajes directos y accionables…" | "Te avisamos qué mirar" · "Cada mañana, lo que se salió de lo normal: sobras en el comedero, mezclas imprecisas, recetas incompletas. En palabras simples, no en jerga estadística." |
| Cómo funciona, paso 04 | "…Las mejoras se ven rápido." | "Dashboards visuales claros para ti y tu equipo. Seguimiento diario, semanal y mensual." |
| Beneficios | "Recomendaciones para hoy — No análisis para el mes que viene. Acciones concretas que puedes aplicar ahora mismo." | "Qué mirar hoy — Cada mañana, los avisos de lo que se salió de lo normal, para actuar a tiempo." |
| Beneficios | "Decisiones más inteligentes — …dejas de adivinar y empiezas a decidir con certeza." | "Decisiones con respaldo — Con datos de tu propio predio, y con la advertencia de cuándo el dato no alcanza para concluir." |
| Por qué, lista | "Recomendaciones accionables — No solo datos, sino qué hacer hoy con ellos." | "Te explicamos, no solo te mostramos — Qué mirar hoy y por qué cambió cada número." |
| Por qué, tabla | "Recomendaciones diarias · Sí · Solo reportes" | "Avisos diarios en palabras simples · Sí · Solo reportes" |
| Solicitar demo | "Te hacemos una demo personalizada con los datos de tu propio predio…" | **Pregunta abierta** (P9): el análisis indica que la carga de archivos todavía no escribe en la base. Si hoy no se puede hacer la demo con los datos del cliente: "Te mostramos CampoData con un campo de demostración y vemos juntos cómo conectar los datos de tu predio." |

**Lo que no cambia:** "Nos adaptamos a…" (el mensaje del usuario, D21), la tabla de comparación salvo su segunda fila, y "Diseñado para predios de 50 a 200 vacas" (P7).

**`bin/check`** suma la verificación de que la portada no contenga "Baja 2 kg de soya", "+12%" ni "~2.000 vacas".

---

## 8. CSS (`assets/css/sitio.css`)

Todo con tokens. Clases nuevas:

| Clase | Qué hace |
| --- | --- |
| `cd-marco` | Radio `--wp--custom--radio--tarjeta`, borde de 1px en `borde` (en secciones oscuras, blanco al 12 %), sombra `--wp--custom--brillo--marino` y `overflow: hidden`. La imagen ocupa todo el ancho, con `height: auto` y su `aspect-ratio` de origen |
| `cd-pantalla` | `cd-marco` más una barra superior de 28px con tres puntos (`acento`, `brote` y `cielo`), como la ventana de Reportes. En el banner lleva la sombra honda (`--cd-sombra-honda`) |
| `cd-telefono` | Radio de 26px, borde de 5px en `noche`, sombra honda y `aspect-ratio: 390 / 659` |
| `cd-ejemplo-accion` | Dos imágenes apiladas, centradas, de 1004px como máximo, con `gap` `--wp--preset--spacing--40` |
| `cd-pie-imagen` | Pie de imagen: `small`, en `secundario` (en `bruma` sobre fondo oscuro), con margen superior `--wp--preset--spacing--20` |

- **Ampliación (*lightbox*):** se revisa en los dos fondos y con teclado. Escape la cierra y el foco vuelve a la imagen.
- **Movimiento:** las imágenes aparecen con el *fade* de M1. El foco de luz (M10) no se aplica a las imágenes. Con movimiento reducido, nada se anima.
- Se quita el CSS de `panel.svg` (`.cd-panel-imagen`), de las capturas antiguas (`.cd-captura`) y de la fila de cifras (`.cd-cifras`, `.cd-cifra*`). El contador de `movimiento.js` puede quedar: sin `.cd-contador` no hace nada.
- **Presupuesto:** el CSS no crece más de 2 KB sin minificar.

---

## 9. Lista de recaptura (para el equipo de la app)

Las imágenes de esta spec son de 1118 × 679 px. El análisis recomienda recapturarlas a **doble resolución, en el modo demo, sin cursor y sin tooltips de desarrollo**. Cuando lleguen, **se reemplazan los archivos con el mismo nombre de §4** y no hay que tocar los patrones.

Además, estas imágenes se agregan a la landing **cuando la demo esté corregida**. Cada una, con lo que hay que corregir antes:

| Imagen futura | Dónde iría | Qué corregir antes (análisis) |
| --- | --- | --- |
| Hoja de carga | Cómo funciona ("lista para imprimir") | Sales minerales a 100–250 g por vaca, no al 5 % de la ración. Una receta propia para las vacas con mastitis, que no sea la de Secas (§6.1.1 y §6.1.2) |
| Recetas frente a lo habitual | Cómo funciona | Lo mismo que la hoja de carga |
| Temporadas y curva de partos | Reportes, pestaña "Reproducción" | Partos fuera de temporada, sumisión y forma de la curva realistas para un campo bi-estacional (§6.1.4) |
| Ensayos de alimentación | Para quién, asesores | Muestras del mismo lote, sin Secas, con recetas distintas. Sin "Idea" ni "Simulado" a la vista (§6.1.3) |
| Agenda o calendario | Beneficios, "Mejor gestión diaria" | "Cojeras" en lugar de "cojas" (§6.2), y sin el pronóstico con su fuente |
| Datos cruzados | Reportes, pestaña "Análisis" | Si la correlación es casi nula, el texto dice "no se mueven juntas" (§6.2) |
| Tabla por dieta | Reportes, pestaña "Por dieta" | Solo recapturar sin cursor |
| Calidad, RCS | Reportes | La línea del límite del contrato en el gráfico, y puntos o escalones en vez de curvas suavizadas (§6.3) |
| Producción en el celular | Banner o Reportes | Que el texto de recetas incompletas no se salga de la tarjeta (§6.4) |
| Permisos y equipo | Para quién | Configurar antes las vistas por rol, en especial la del asesor (§3.2 y §3.3) |

---

## 10. Riesgos de ejecución

| # | Riesgo | Plan A | Plan B |
| --- | --- | --- | --- |
| R1 | A 1118 px, las capturas se ven blandas en pantallas de alta densidad | Mostrarlas a su medida de origen como máximo, y ampliarlas con el *lightbox* | La recaptura a 2x (§9), con los mismos nombres. Anotarlo |
| R2 | Un retoque deja marca o necesitaría inventar contenido | Copiar píxeles idénticos del sistema (§5.3) | Dejar esa imagen fuera y avisar. Reservas: para Producción, `curva_produccion_meta` (recorte, sin puntero); para Calidad, `explicacion_contrato_planta`; para el banner, `kpis_inicio` en el marco |
| R3 | Sin `panel.svg`, el banner se ve más quieto | La flotación, la inclinación y la entrada del CSS siguen | Una entrada con revelado (`clip-path`) de la pantalla y del celular, solo con `cd-movimiento`. Anotarlo |
| R4 | Al cambiar de pestaña, el alto de la ventana salta | Proporción fija 1118 / 679 en las dos | Alto mínimo fijo para el panel. Anotarlo |
| R5 | El *lightbox* del core pide recursos externos o pesa más de lo esperado | Es un módulo del propio core, local | Sin ampliación: enlace a la imagen completa (`linkDestination: media`). Anotarlo |
| R6 | El *lightbox* no funciona dentro de las pestañas ocultas | Atributos del bloque `image` | Dentro de las pestañas, enlace a la imagen completa. Anotarlo |
| R7 | Al quitar las cifras, el banner queda con un hueco | Los botones cierran la columna de texto | Bajar el `min-height` del banner. Anotarlo |
| R8 | El encabezado o la página se desbordan por algún cambio | No cambia ningún texto del menú | Medir de a 1px entre 320 y 1500 px, como en la spec 02 |

---

## 11. Orden de ejecución

Al cerrar cada etapa, deja los cambios sin commit y sugiere el mensaje (Conventional Commits, en español y sin tildes).

0. **Verificar sin cambiar nada:** la rama es `dev`; avisa si hay cambios sin commit. Confirma que existen las 9 imágenes de origen y `ANALISIS_LANDING.md`.
1. **Preparar las imágenes** (§5): las 9 WebP en `assets/images/sistema/`, con su retoque y la comparación con el original. Agrega a `bin/check` sus archivos y pesos máximos. Mensaje: `feat(tema): imagenes del sistema para la landing`.
2. **Reportes, con prioridad** (§6.4): las dos pestañas nuevas, la barra de la ventana y el párrafo. **Borra `assets/images/reportes/`** y su CSS. `bin/check` falla si esa carpeta existe o si la portada dice "~2.000 vacas". Mensaje: `fix(tema): reportes con pantallas de demostracion, sin capturas de un predio`.
3. **CSS** (§8). Mensaje: `feat(tema): marcos y telefono para las imagenes del sistema`.
4. **Banner** (§6.1): la pantalla, el celular, la tarjeta flotante y el retiro de las cifras. Borra `panel.svg`. Mensaje: `feat(tema): banner con pantallas del sistema`.
5. **Para quién, Cómo funciona y Por qué** (§6.2, §6.3 y §6.5). Mensaje: `feat(tema): imagenes del sistema en las secciones`.
6. **Textos** (§7) y la verificación de `bin/check` de §7. Mensaje: `fix(tema): textos alineados con lo que hace la app`.
7. **Verificación** (§12) y **documentación** (§13). Mensaje: `docs: imagenes del sistema y analisis de administracion`.

---

## 12. Criterios de aceptación

- [ ] Se trabajó en `dev` y la IA no hizo commits ni cambió de rama. `imagenes-sistema/` quedó sin cambios.
- [ ] `git status` muestra las 9 imágenes en `assets/images/sistema/` y **ninguna** de `imagenes-sistema/`. `git check-ignore imagenes-sistema/` confirma que está ignorada.
- [ ] Cada imagen está en la sección que dice la tabla del Resumen, con su `alt`. No se usa ninguna de las carpetas 4 ni 5.
- [ ] `assets/images/reportes/` y `panel.svg` ya no existen y nada hace referencia a ellos. La portada no dice "~2.000 vacas".
- [ ] Ninguna imagen publicada muestra un puntero, la franja "DEMO · Simular datos nuevos", "Idea", "Simulado", un aviso de "en construcción" ni el nombre de un tercero. Se revisaron a 400 % de zoom, una por una, contra su original.
- [ ] Ningún retoque escribió texto nuevo: lo que se rehízo salió de píxeles idénticos del sistema.
- [ ] La portada no dice que las pantallas sean de clientes: dice que son de un campo de demostración.
- [ ] La portada no promete recomendaciones automáticas, sensores ni carga de archivos por cuenta propia, ni muestra cifras sin fuente. `bin/check` no encuentra "Baja 2 kg de soya", "+12%", "~2.000 vacas", DairyPlan, Power BI, Excel ni WATTS.
- [ ] El banner muestra la pantalla de Hoy con el celular encima y la tarjeta "Qué mirar hoy". Se ve bien entre 320 y 1500 px.
- [ ] Reportes tiene dos pestañas (Producción y Calidad), se usan con mouse y con teclado, y el alto no salta al cambiar.
- [ ] Las imágenes se amplían al hacer clic y con el teclado, y el foco vuelve a la imagen al cerrar. Las del banner no se amplían.
- [ ] Con el JS bloqueado se ven las dos pantallas de Reportes una debajo de la otra (se verifica el atributo `hidden`) y el resto de las imágenes.
- [ ] Con movimiento reducido no se anima nada.
- [ ] **El encabezado no se desborda entre 320 y 1500 px**, medido de a 1 px, y no hay scroll horizontal en ningún ancho.
- [ ] **La primera pantalla** (sin bajar) pesa menos de 1 MB transferido, y **la página completa**, menos de 1,3 MB. Ningún archivo de `assets/images/sistema/` pasa su peso máximo.
- [ ] El editor valida todos los patrones, plantillas y partes, sin bloques inválidos.
- [ ] `bin/check` pasa con las verificaciones nuevas, `bin/reset --yes` deja todo en pie sin pasos manuales, y `composer lint` pasa sin errores ni advertencias.
- [ ] El usuario revisó las capturas de escritorio (1440 px) y de móvil (390 px) y las aprobó.
- [ ] `README.md` y `docs/DECISIONS.md` están al día (§13).

---

## 13. Documentación

**`README.md`:**
- una sección "Imágenes del sistema" con la tabla del Resumen, qué es `imagenes-sistema/` (local) y qué es `assets/images/sistema/` (versionada, viaja con el tema), y cómo reemplazar una imagen: mismo nombre, WebP, sin punteros, sin terceros y sin datos poco realistas, dentro de su peso máximo;
- la lista de recaptura de §9, o un enlace a ella;
- actualizar "Dónde va cada cosa" y la sección de Reportes de "La landing".

**`docs/DECISIONS.md`:**
- **D23**, imágenes del sistema: las decisiones de §2.1 y el peso final de cada imagen;
- **D24**, textos alineados con lo que hace la app: los cambios de §7 y por qué;
- una entrada por cada riesgo de §10 que se haya materializado;
- marcar D17 como reemplazada;
- en el historial de la spec 02, una fila v4 que remita a esta spec.

---

## 14. Supuestos y preguntas abiertas

| # | Tema | Supuesto de esta spec | Qué cambia si es distinto |
| --- | --- | --- | --- |
| P1 | Cómo se suben a WordPress | Viajan con el tema, en `assets/images/sistema/` (incluida en git), porque así se despliega el sitio | Si prefieren la Biblioteca de medios, las imágenes pasan a `uploads` y los patrones las referencian por su ID. Se pierde la reproducibilidad con `bin/setup` (D05) |
| P2 | Pantallas de demostración | Todas son del "Campo Demostración", con datos ficticios (análisis, §0) | Si alguna tiene datos de un cliente, hace falta su permiso |
| P3 | Nombre de la sección | `#reportes`, "Reportes" y el patrón `reportes` se quedan | Si prefieren "El sistema", cambian el menú, el pie, el botón del banner, `ANCLAS` en `bin/check` y el nombre del patrón |
| P4 | "Todos tus predios desde una misma cuenta" | La app tiene un selector de campo (análisis, §3.3) | Si el asesor todavía no ve sus predios así (hoy su vista por rol muestra solo Inicio), ese punto vuelve a ser un texto guía hasta configurar la vista |
| P5 | Nombres de personas en las capturas | Las elegidas no muestran nombres de personas | — |
| P6 | Paleta de la app frente a la de la landing | La landing mantiene la paleta del logo; las capturas, sus colores, dentro de un marco neutro | Si administración quiere la paleta de la app (verde oscuro y naranja), es un cambio de identidad para otra spec |
| P7 | "Diseñado para predios de 50 a 200 vacas" | Se mantiene, y por eso la landing no muestra el tamaño del campo de demostración (434 cabezas) | El análisis sugiere que la demo muestre un campo del tamaño del cliente objetivo. Si se ajusta la demo, se puede mostrar |
| P8 | Cifras del banner | Se quitan hasta tener respaldo | Si hay un caso documentado, vuelven con su fuente |
| P9 | Demo "con los datos de tu propio predio" y "14 días gratis" | Pendiente de confirmar con administración: el análisis dice que la carga de archivos todavía no escribe en la base | Si la demo con datos propios es posible (por ejemplo, porque el equipo los carga), el texto actual se queda. Si no, va el texto alternativo de §7 |
| P10 | Recaptura | Las imágenes de 1118 px alcanzan para esta versión | Si se ven blandas, se adelanta la recaptura a 2x (§9) |
