# CampoData: recorrido de la plataforma para la nueva landing

**Fecha:** 7 de noviembre de 2026
**Sitio revisado:** campodata-front.vercel.app, con sesión de superadmin, en modo demostración y con datos reales de Campo A y Campo B.
**Comparado con:** campodata.cl, la landing actual.

---

## 0. Cómo leer este paquete

| Carpeta | Contenido | ¿Se puede publicar? |
|---|---|---|
| `1_escritorio_demo/` | 39 pantallas completas del **modo demostración**, ordenadas según el menú | Sí. Son datos ficticios |
| `2_movil_demo/` | 8 pantallas en formato celular (390 px de ancho) | Sí |
| `3_recortes_para_landing/` | 20 recortes de tarjetas y gráficos, listos para maquetar | Sí. Son las imágenes que recomiendo |
| `4_datos_reales_censurados/` | 4 capturas de Campo A y Campo B con desenfoque | Solo como referencia interna. Ver sección 5 |
| `5_referencia_interna_NO_publicar/` | Pantallas de superadmin, el roadmap y notas internas | **No** |

**Resolución.** La herramienta de captura entrega 1118 × 679 px. Sirve para armar bocetos y elegir pantallas. Para la versión final conviene volver a tomar en el modo demo, a 2x, las pantallas de la sección 4. Todas tienen nombre de archivo para encontrarlas rápido.

**Privacidad aplicada:**

- **Datos reales.** Desenfoqué el selector de campo, la fecha de corte, todos los KPI (litros, vacas, sólidos y preñez), los ingresos en pesos, los valores del eje Y y los conteos de preñeces y servicios.
- **Demo, pantalla de Compras.** Desenfoqué también los nombres de los proveedores ("Molino del Sur", "Agrícola Rupanco"). Pueden coincidir con empresas reales.
- **Mapas.** No incluí la demo de Potreros como imagen publicable. Su mapa muestra La Unión y la Planta Industrial Colún, una empresa real.

**Estado en que dejé el sitio:** demo apagada, Campo A seleccionado y período "Todo el historial", igual que al empezar. No guardé cambios de configuración. Solo probé "Ver como Dueño" y salí de esa vista.

---

## 1. Resumen ejecutivo

1. **La plataforma ya es mucho más que la landing actual.** campodata.cl muestra paneles de Power BI. La app nueva tiene una lógica propia, en lenguaje simple, y está pensada para decidir: "qué mirar hoy", "cuánto queda", "cuándo pedir" y "Explícame".
2. **Riesgo de privacidad en la landing actual.** Los reportes de Power BI usan un "ejemplo de ~2.000 vacas". Campo A tiene 2.116 vacas en ordeña. Si ese ejemplo sale de Campo A, el predio podría reconocerse. Recomiendo reemplazar esas imágenes por las de la demo.
3. **La landing actual promete más de lo que la app hace hoy.** No vi integración con sensores ni recomendaciones automáticas del tipo "ajuste de soya por lote". La pantalla interna "Lo que falta" dice además que *"Cargar un archivo todavía no escribe nada"*. Las cifras +12 % y 10 h/semana no tienen fuente. Esto choca con la política de no ofrecer más de lo que se puede dar.
4. **Los diferenciadores reales y fuertes son estos:**
   - días de alimento restantes por insumo;
   - alertas diarias del carro (sobras y mezcla imprecisa);
   - la curva de producción enlazada con los cambios de dieta;
   - la calidad de la leche explicada según el contrato con la planta;
   - los indicadores de temporada reproductiva con metas;
   - los ensayos de alimentación ciegos con checklist de diseño;
   - una honestidad estadística poco común: "moverse juntas no es causarse" y "hacen falta 30 días".
5. **Antes de mostrar la demo a asesores e investigadores hay que corregir datos poco realistas** (sección 6). Un asesor los nota en segundos y eso le resta credibilidad al producto.

---

## 2. Mapa de la plataforma

| Módulo (menú) | Pestañas o funciones | Público principal |
|---|---|---|
| **Inicio** | KPI de producción, calidad, rebaño y reproducción · Ingreso y margen (precio Odepa por región + "Mis cifras") · Hoy (tareas) · Notas · Pronóstico de la DMC | Dueño, administrador |
| **Producción** | **Hoy** (qué mirar, cuánto queda, recetas frente a lo habitual, hoja de carga imprimible) · **Producción** (curva diaria, meta, tope del estanque, cambios de dieta, días con receta incompleta) · **Calidad** (grasa, proteína, UFC, RCS, urea; análisis fuera de contrato) · **Panel** (producción por lote según la dieta que comió) · **Plan de alimentación** (qué receta come cada lote) · **Historial** (línea de tiempo de recetas por lote) · **Entregas** (kilos del carro, balanza, incidencias, "Explícame") · **Compras** (cuándo pedir, gasto, $/litro). Vistas Gráficos / Mensual / Tabla | Jefe de alimentación, dueño, asesor |
| **Reproducción** | Todo el campo (embudo inseminación → parto y proyección de partos) · **Temporadas** (estacional, bi-estacional o continuo; % de partos en 3 y 6 semanas, sumisión, concepción y preñez cada 21 días, con metas) · Por grupo y lote | Jefe de reproducción, asesor, veterinario |
| **Rebaño** | Existencias por grupo y lote · Sanidad (mastitis y cojera) · Salidas (venta y muerte, con motivo y destino) | Administrador, dueño |
| **Análisis** | **Datos cruzados** (dos variables con correlación y advertencias) · **Ensayos de alimentación** (diseño ciego, control, checklist y resultados) | Asesor, investigador |
| **Mi predio** | Ubicación y clima · Ciclo reproductivo · Capacidad del estanque · Grupos y lotes · Equipo, roles y permisos por módulo | Dueño, administrador |
| **Calendario** | Agenda con tareas atrasadas, de hoy y próximas, responsables, eventos y notas | Todos |
| **Ideas y propuestas** | Solo superadmin: Potreros (demo), catálogo de APIs, terreno sin señal, individualización, primera carga | Interno |
| **Configuración** | Sumario · Nombres de lotes (DairyPlan / carro) · Ajustes por módulo · Vistas por rol · Administración · "Lo que falta" | Superadmin |
| **Modo demo** | Botón en el menú. Dentro de "Explícame" permite *simular datos nuevos* (+1 día, rebaño +10 %, 3 días fuera de lo normal) | Ventas, presentaciones |

---

## 3. Análisis por rol

### 3.1 Productor o dueño

**Lo que le sirve hoy:**

- **Ingreso y margen en Inicio**, con el precio Odepa de su región. Es el único lugar donde la plataforma habla en pesos, y para un dueño es lo más atractivo (`01_inicio_resumen`, recorte `kpis_inicio`).
- **"Cuánto queda" y "Cuándo pedir".** Muestra los días de concentrado, silo y heno, con la fecha para pedir. Es concreto, se entiende sin capacitación y evita quiebres de stock (`cuanto_queda_alimento`, `compras_cuando_pedir`).
- **La meta de litros por día con barra de cumplimiento** (`meta_produccion`).
- **El calendario con responsables** (`agenda_tareas`) y el **pronóstico de la DMC** (`pronostico_clima`).

**Lo que falta o hay que mejorar:**

- **El margen depende de que el dueño escriba su gasto en "Mis cifras".** En los campos reales aparece vacío ("—"). Hace falta un costo por litro que se calcule solo, al menos con el gasto de alimento que ya está en Compras ($142/L en la demo).
- **No hay comparación con el mismo período del año anterior** ni tendencia en los KPI (flechas ↑↓). Un dueño pregunta primero "¿voy mejor o peor?".
- **No hay resumen semanal ni avisos** por correo, WhatsApp o celular. Hoy el dueño tiene que entrar a mirar.
- **El dueño no recibe ninguna recomendación accionable.** La landing actual la promete, pero la app solo explica lo que pasó; no dice qué hacer.

**Mensaje para la landing:** *"Sepa cuánto le deja cada litro, cuánto alimento le queda y qué revisar hoy, sin planillas."*

### 3.2 Jefaturas de área

La plataforma ya tiene la estructura: 8 vistas por rol y 5 perfiles de permisos (Jefe de lechería, Encargado de alimentación, Veterinario/inseminador, Encargado de recría y Visor). Pero **las vistas por rol están casi sin configurar.** Jefe de lechería, Jefe de reproducción, Jefe de crianza y recría e Investigador ven solo "Inicio", con el indicador "Total litros" repetido tres veces (`5_referencia_interna/vistas_por_rol_2`).

| Jefatura | Lo que ya tiene | Lo que falta |
|---|---|---|
| **Alimentación** (la más completa) | Hoja de carga imprimible por receta · sobras frente a lo habitual · mezcla imprecisa · receta incompleta con motivo (p. ej. "descompuesto o con hongos, se descartó") · entregas con o sin balanza · plan por lote · historial de recetas · "Explícame" | Materia seca (kg MS/vaca) y costo por ración · registro desde el celular en terreno (está en propuesta "Terreno sin señal") · ajuste de la ración por condición corporal o por pradera disponible |
| **Lechería / ordeña** | Calidad frente al contrato (UFC, RCS, urea) con explicación · tabla por dieta con sólidos | Producción por vaca, curva de lactancia, vacas problema. Todo depende de la "Individualización" (propuesta) |
| **Reproducción** | Embudo, proyección de partos, temporadas con metas, curva de partos, servicios por semana, preñez cada 21 días | Días abiertos, intervalo entre partos, días a primer servicio, detección de celo, resultados por toro o inseminador. **La propia app reconoce que necesita registros por vaca** |
| **Crianza y recría** | Hay rol y perfil, y el calendario muestra tareas como "Vacunar terneras" o "Pesaje de terneras" | **No hay módulo.** Faltan terneras y vaquillas, pesos, ganancia diaria, calostro (existe como variable en Datos cruzados, pero no tiene pantalla), mortalidad de terneros y edad al primer parto. Es el vacío más grande para esta jefatura |
| **Sanidad** (veterinario) | Conteo diario de mastitis y cojera; salidas por muerte | Tratamientos, **períodos de resguardo de leche por antibióticos** (crítico para la calidad), vacunas como plan sanitario |
| **Administración** | Equipo, roles, permisos por módulo y campo, grupos y lotes, salidas con motivo | Bitácora de quién cargó qué (existe en Compras: "nada se borra"; conviene extenderlo a toda la app) |

**Mensaje para la landing:** *"Cada encargado ve lo suyo: el de alimentación su hoja de carga, el de reproducción sus temporadas y el dueño su margen."* Recomiendo publicarlo **solo después de configurar las vistas por rol**. Si no, la promesa no se cumple en la primera demo.

### 3.3 Asesor (veterinario o nutricionista)

**Lo que le sirve hoy:**

- **La tabla por dieta** (`10_produccion_tabla`): litros, L/cabeza, grasa, proteína, RCS, UFC y urea en una sola fila por dieta. Es lo que un nutricionista arma a mano en Excel.
- **La curva de producción enlazada con los cambios de dieta** (`07_produccion_tramo_dieta_seleccionado`): ve qué comían cuando cayó la producción.
- **"Explícame"** (`explicame_modal`): separa si la caída es de ración o de número de animales. Es un razonamiento de asesor, automatizado.
- **Datos cruzados** y **Temporadas**, con metas estándar (60 %/90 % de partos en 3/6 semanas, sumisión 90 %, concepción 50 %).
- **El selector multi-campo**, las notas ("Tomás sugiere subir el concentrado…") y el evento "Visita del asesor".

**Lo que falta o hay que mejorar:**

- **En "Vistas por rol", el asesor ve solo Inicio.** Es lo primero que hay que corregir para venderle a un asesor.
- **No hay vista multi-cliente** con comparación entre predios (benchmark anónimo). Para un asesor con 10 a 20 lecherías, ese es el gancho principal.
- **Falta un informe de visita** exportable a PDF y con su marca, y comentarios anclados en un gráfico ("aquí bajó por el cambio de silo").
- **Tiene que poder confiar en los datos de la demo.** Ver la sección 6.

**Mensaje para la landing:** *"Llegue a la visita sabiendo qué pasó: producción, dieta y calidad en la misma línea de tiempo."*

### 3.4 Investigador o universidad

**Lo que le sirve hoy:**

- **Ensayos de alimentación con diseño ciego** (`30`, `31`, `32`): muestras por letra con "clave" oculta, grupo control, línea base de 21 días, semana de adaptación y un **checklist de diseño** ("Lo que pide el diseño · 4 de 5"). Para una universidad es lo más diferenciador de la plataforma.
- **Honestidad metodológica explícita:**
  - "Moverse juntas no es causarse";
  - "con 9 días medidos no alcanza para decirlo (hacen falta 30)";
  - "Un grupo por receta: el resultado orienta, no prueba";
  - "Simulado" cuando los sólidos se estiman desde el estanque.

  Encaja muy bien con la imagen de no exagerar y es un argumento potente frente a académicos.
- **Las tablas descargables** (Entregas → "Descargar").

**Lo que falta o hay que mejorar:**

- **Exportar el dataset completo** (CSV o Excel con diccionario de variables) y acceso por API para investigación.
- **Estadística real:** intervalos de confianza, réplicas entre grupos o campos y prueba de hipótesis cuando hay más de un grupo por tratamiento.
- **Datos por vaca.** Sin individualización, la unidad experimental es el lote y casi ningún ensayo publicable funciona así.
- **Un protocolo de consentimiento y anonimización** para estudios con varios predios. Es coherente con la política de privacidad de CampoData y es un argumento de venta en sí mismo.
- **Inconsistencias del ensayo de ejemplo** (sección 6). Un investigador las detecta al tiro.

**Mensaje para la landing o la presentación en la universidad:** *"Ensayos de alimentación en predios comerciales, con grupo control, diseño ciego y la advertencia de cuándo el dato no alcanza."*

---

## 4. Qué usar en la landing

Elegí las imágenes por tres razones: **se entienden en 3 segundos**, **muestran algo que la competencia (Power BI o planillas) no hace** y **son 100 % ficticias**.

| Prioridad | Imagen (carpeta 3 salvo indicación) | Por qué me llamó la atención | Texto sugerido |
|---|---|---|---|
| ★★★ | `cuanto_queda_alimento` + `compras_cuando_pedir` | Es lo más concreto y útil de toda la app. Un número grande, en días, con alerta naranja | "Sepa cuántos días de alimento le quedan y cuándo pedir" |
| ★★★ | `alertas_que_mirar_hoy` + `recetas_vs_habitual` | Convierte los datos del carro en dos frases accionables | "Cada mañana, lo que se salió de lo normal" |
| ★★★ | `kpis_inicio` | Litros, sólidos, vacas, preñez **y margen en $** en una pantalla | "Su lechería en una pantalla, en pesos y en litros" |
| ★★★ | `curva_produccion_meta` (o `1_escritorio/06`) | Curva, meta, tope del estanque, cambios de dieta y días con problemas en un mismo gráfico | "Vea qué comían sus vacas cuando cambió la producción" |
| ★★☆ | `explicacion_contrato_planta` | El "Qué es esto" en lenguaje de campo explica la diferencia con un BI | "Explicado en simple: cuándo la planta le paga menos y por qué" |
| ★★☆ | `explicame_modal` | Diagnóstico automático: "la variación se explica por el rebaño" | "No solo gráficos: le explicamos la curva" |
| ★★☆ | `hoja_de_carga` | Muestra que también sirve al operario (imprimible) | "La hoja de carga del día, lista para imprimir" |
| ★★☆ | `temporada_otono` + `curvas_partos_servicios` | Indicadores de temporada con metas. Los asesores del sur los usan | "Sus temporadas de encaste medidas contra la meta" |
| ★★☆ | `ensayo_tarjetas_resultado` + `ensayo_indice_grafico` + `ensayo_checklist` | Diferenciador único para universidades e investigadores | "Pruebe una dieta en su campo, con grupo control" |
| ★☆☆ | `permisos_matriz` + `1_escritorio/36` | Muestra que cada persona ve lo suyo | "Cada encargado con su acceso" |
| ★☆☆ | `agenda_tareas` + `pronostico_clima` | Cercanía con la operación diaria | "Tareas del equipo y el clima del campo" |
| ★☆☆ | `2_movil_demo/03` y `05` | Prueban que funciona en el celular | "En la oficina o en el patio" |

**Sugerencias de uso:**

- **Hero:** el recorte `kpis_inicio` o la pantalla `03_produccion_hoy_que_mirar` en un mockup de laptop, más el celular `2_movil_demo/03` al lado.
- **Antes de recapturar a 2x, conviene limpiar en la demo los tooltips de desarrollo** ("En construcción…") y el cursor.
- **Mantener la paleta de la app** (verde oscuro del menú, verde de acción, naranja de alerta). Se ve sobria y "de campo".

---

## 5. Qué NO usar

- **Ninguna captura de Campo A o Campo B**, aunque esté censurada (carpeta 4). Hay tres razones:
  1. la forma de las curvas y las fechas de los cambios de dieta pueden reconocerse dentro del rubro;
  2. los datos están **desactualizados**: la app misma muestra "Último dato hace 12 meses" (A) y "hace 2 años" (B);
  3. algunos indicadores reales se ven mal: la preñez cada 21 días cae a 0,3 % por falta de datos desde mayo de 2025.

  Las dejo solo como referencia de cómo se ve el producto con historial largo (3 años y 8 cambios de dieta). La demo podría generar un historial así de largo.
- **Los paneles de Power BI de la landing actual** ("~2.000 vacas"), por el posible riesgo de reconocer el predio.
- **El contenido de "Ideas y propuestas"** (Potreros, Terreno sin señal, Individualización, Primera carga, catálogo de APIs) **como si ya fueran funciones.** Si se quiere mostrar, que sea en una sección "En desarrollo" claramente rotulada.
- **"Importa tus Excel / DairyPlan / sensores" como autoservicio.** Hoy la carga de archivos no escribe en la base y no vi sensores. Mejor decir "le ayudamos a conectar sus datos de DairyPlan y del carro mezclador", que sí es real (existe el mapeo de nombres de lotes).
- **Las cifras "+12 % de producción", "10 horas ahorradas" y "100 % adaptable"**, mientras no tengan respaldo (caso documentado o fuente).
- **Mapas** (`34_mi_predio_mapa` y la demo de Potreros): muestran La Unión y la planta de Colún, y el pin del demo cae en plena ciudad.
- **Pantallas con texto interno:** tooltips "En construcción…", "PARA EL EQUIPO · SERIES QUE LA IA NECESITA", "Lo que pide registros por vaca · La API da conteos por día…", "Lo que falta" y Configuración superadmin (carpeta 5).
- **Gráficos que hoy se ven débiles:**
  - Rebaño > Existencias: la línea es plana;
  - Producción > Mensual: solo 3 barras y una cortada;
  - Sanidad: escalones "redondeados" por el suavizado;
  - Salidas: verde muy saturado.

---

## 6. Mejoras detectadas en la plataforma

### 6.1 Realismo de la demo (prioridad alta antes de mostrar a asesores o a la universidad)

1. **Sales minerales al 5 % de la ración:** 666 kg/día para unas 320 vacas, unos 2 kg/vaca, cuando lo normal es 100 a 250 g. Un nutricionista lo nota de inmediato (`hoja_de_carga`).
2. **Las vacas con mastitis comen la receta de Secas** y el grupo "Enfermería" está clasificado como **"Descarte"**. Las vacas con mastitis siguen en lactancia; enfermería no es descarte.
3. **Ensayo de ejemplo:**
   - la Muestra A es el lote de **Secas** y "produce" 19 L/vaca/día;
   - el checklist marca ✓ "Grupos sacados del mismo lote", pero las tres muestras son de lotes distintos;
   - las tres recetas tienen exactamente 42,1 kg/vaca.
4. **Temporadas en un campo configurado como bi-estacional:**
   - el 52,5 % de los partos cae fuera de temporada;
   - la sumisión es de 11 a 14 %;
   - la curva de partos de otoño *crece* hacia el final, cuando una temporada sana concentra los partos al inicio.

   Así la demo cuenta la historia de un campo mal manejado. Si es intencional, que sea evidente. Si no, conviene ajustar la simulación.
5. **Rebaño estable** (433 → 434) mientras hay 89 partos en 3 meses, y no existe ningún grupo de terneras o recría.
6. **El pin del campo demo** está en Los Ríos (centro de La Unión), pero la región elegida es Los Lagos. La propia app lo advierte en pantalla.

### 6.2 Textos e idioma

- **Voseo argentino** "Tocá un punto del gráfico…" (Producción > Panel). El resto usa "tú" (tócalos, toca, escribe). Hay que unificar al registro chileno.
- **"Revisar cojas del lote de ordeña"**: debería decir "cojeras".
- **Datos cruzados:** "Se mueven juntas: casi nula (0,09) · cuando una sube, la otra también". Es contradictorio. Con una correlación cercana a 0 el texto debería decir "no se mueven juntas".
- **Campo A real:** el título "Los últimos 126 días, en bloques de 21" no calza con un gráfico que abarca de noviembre de 2024 a octubre de 2025.
- **Nombres inconsistentes entre menú, URL y permisos:**
  - Producción = `/alimentacion`;
  - Calendario = `/equipo`;
  - en Permisos aparecen "Dashboard" e "Inventario", que en el menú son Inicio y Rebaño.

### 6.3 Interfaz

- **Los tooltips del menú muestran notas de desarrollo** a cualquier usuario, por ejemplo: "Producción · En construcción: Datos del carro desde la API (hoy, solo los archivos de un campo)" o "Rebaño · En construcción…".
- **En "Explícame" aparece el bloque "Para el equipo · series que la IA necesita"**, que es contenido interno.
- **El gráfico de RCS no muestra la línea del límite del contrato** (sí lo explica el texto). La línea haría el riesgo evidente.
- **El suavizado de curvas** en Sanidad, RCS y el Panel inventa picos y valles que no existen entre mediciones. Para conteos y análisis puntuales conviene usar escalones o puntos.
- **El eje Y de Producción** tiene valores poco redondos (6.760 / 7.660 / 8.560…).
- **Vistas por rol:** 5 de los 8 roles no están configurados, y el asesor ve solo Inicio.

### 6.4 Celular (capturas en `2_movil_demo`)

- **Las pestañas de Producción se cortan** ("Histo…") y no hay ninguna indicación de que se puedan deslizar.
- **El texto "11 DÍAS CON LA RECETA INCOMPLETA" se sale de la tarjeta**, y queda un fragmento naranja visible a la derecha.
- **Los KPI de Inicio ocupan una tarjeta completa cada uno.** Una grilla de 2 columnas mostraría todo sin tanto desplazamiento.
- **Ensayos tiene doble scroll** (un panel dentro de la página) y deja espacio vacío abajo.
- **Lo positivo:** el menú lateral, el Calendario, "Qué mirar hoy" y la Producción se ven bien.

### 6.5 Landing actual (campodata.cl)

- **El número de WhatsApp del pie (56912345678) parece de relleno** y no coincide con el del botón (56926304489).
- **El público declarado es de 50 a 200 vacas**, pero la demo tiene 434 cabezas y los reportes de ejemplo unas 2.000. Conviene que la demo muestre un campo del tamaño del cliente objetivo.

---

## 7. Qué falta: resumen por impacto comercial

1. **Configurar las vistas por rol**, en especial Asesor, Jefe de reproducción, Jefe de crianza e Investigador. Esto habilita el mensaje "cada uno ve lo suyo".
2. **Módulo de crianza y recría** (terneras, pesos, calostro, mortalidad). Hoy hay rol y tareas, pero no hay pantalla.
3. **Individualización (registro por vaca).** La plataforma ya identifica que es lo que la "convierte en otro sistema". Desbloquea reproducción completa, lactancia, sanidad y ensayos publicables.
4. **Costo por litro automático y tendencias** frente al período anterior, para el dueño.
5. **Avisos** (resumen diario o semanal, alertas de "pedir concentrado").
6. **Vista multi-predio con benchmark anónimo y un informe de visita en PDF**, para el asesor.
7. **Exportar los datos y un protocolo de anonimización y consentimiento**, para la universidad.
8. **Carga de archivos que funcione de punta a punta**, y registro en terreno sin señal.

---

## 8. Propuesta breve de estructura para la nueva landing

1. **Hero:** "Su lechería en una pantalla: qué mirar hoy, cuánto alimento le queda y cuánto le deja cada litro." Imagen: `kpis_inicio` en laptop y `2_movil_demo/03` en celular. CTA: "Ver la demo" (con el modo demostración, sin datos de clientes).
2. **Tres problemas y tres respuestas** (alimentación, calidad, reproducción) con los recortes `cuanto_queda_alimento`, `explicacion_contrato_planta` y `temporada_otono`.
3. **"Para cada persona del campo"**, en pestañas: Dueño · Encargados · Asesor · Investigación. Cada pestaña con 1 o 2 imágenes de la sección 4 y su mensaje de la sección 3.
4. **"Le explicamos, no solo le mostramos"**: `explicame_modal` y las frases de honestidad estadística.
5. **"Sus datos son suyos"**: la política de privacidad total como argumento. Se demuestra usando solo datos ficticios en la web.
6. **"En desarrollo"** (opcional y bien rotulado): registro por vaca, terreno sin señal y potreros.
7. **Cómo empezar**: "Conectamos sus datos de DairyPlan y del carro mezclador" (lo que hoy es cierto) y contacto.
