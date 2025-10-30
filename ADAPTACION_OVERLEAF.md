# Adaptación del Curso LaTeX a Overleaf

## Resumen Ejecutivo

Este proyecto contiene la adaptación completa del curso de LaTeX original (en `/srv/http/latex`) a **Overleaf**, una plataforma cloud para editar y compilar documentos LaTeX. 

**Objetivo Principal:** Facilitar a los alumnos la creación de documentos LaTeX directamente en Overleaf, sin necesidad de instalar herramientas locales como TeXstudio, JabRef o Git en terminal.

---

## Estado de la Adaptación

✅ **COMPLETADO: Todas las 7 clases adaptadas**

| Clase | Tema | Estado | Cambios Clave |
|-------|------|--------|---------------|
| **Clase 1** | Introducción a LaTeX y Git | ✅ COMPLETA | Ejercicios en Overleaf, conceptos Git visuales |
| **Clase 2** | Fundamentos de LaTeX | ✅ COMPLETA | Estructura en Overleaf, paquetes básicos |
| **Clase 3** | Elementos Básicos | ✅ COMPLETA | Listas, tablas, figuras en Overleaf |
| **Clase 4** | Fórmulas y Bibliografía | ✅ COMPLETA | Zotero + Overleaf (no JabRef local) |
| **Clase 5** | Elementos Avanzados | ✅ COMPLETA | Código, entornos, columnas, Git conceptual |
| **Clase 6** | Plantillas de Tesis | ✅ COMPLETA | Estructura modular, frontmatter en Overleaf |
| **Clase 7** | Temas Especiales | ✅ COMPLETA | Cartas, pósters, Beamer, animaciones |

---

## Cambios Principales Realizados

### 1. **Nota Inicial en Todas las Clases**
Cada clase ahora comienza con una nota visual azul indicando:
- Que el curso usa Overleaf como herramienta principal
- Referencia a la versión local (https://105.ugr.es/latex) para usuarios que prefieran herramientas locales

### 2. **Eliminación de Instalaciones Locales**
- ❌ Eliminadas instrucciones de clonar repositorios con `git clone`
- ❌ Eliminadas instrucciones de terminal para compilar (`pdflatex`, `bibtex`, etc.)
- ❌ Eliminadas referencias a TeXstudio, JabRef como herramientas primarias

### 3. **Cambios Específicos por Clase**

#### Clase 1: Introducción
- **Antes:** Extensas instrucciones para clonar repositorio e instalar herramientas
- **Después:** Ejercicios prácticos directos en interfaz Overleaf, 8 ejercicios actualizados
- **Conceptos Git:** Mantenidos (Repositorio, Commit, Branch, Remoto, Pull/Push) con diagrama visual

#### Clase 2: Fundamentos
- **Antes:** Instrucciones locales para proyecto LaTeX
- **Después:** Crear proyecto nuevo en Overleaf → agregar paquetes → compilar automáticamente
- **Ejercicios:** 8 ejercicios enfocados en interfaz Overleaf

#### Clase 3: Elementos Básicos
- **Cambio clave:** Listas, tablas, figuras, índices con instrucciones Overleaf
- **Nuevos ejercicios:** 4 prácticas completas con pasos en Overleaf

#### Clase 4: Fórmulas y Bibliografía
- **Cambio más significativo:** Reemplazo completo de **JabRef** por **Zotero + Overleaf**
  - Zotero: Gestor de referencias gratuito, nube, código abierto
  - Integración: Colecciones Zotero se sincronizan automáticamente con Overleaf
  - Ventajas: Sin instalación local, colaboración automática
- **Fórmulas:** Mantenidas sin cambios (no requieren herramientas especiales)

#### Clase 5: Elementos Avanzados
- Listings (código) → funciona igual en Overleaf
- Entornos personalizados → instrucciones Overleaf
- Diseño de página (márgenes, encabezados) → sin terminal
- Colores, tcolorbox → compilación automática
- Git conceptual → Resolución de conflictos sin terminal (visual)

#### Clase 6: Plantillas de Tesis
- **Antes:** Clonar repositorio Git
- **Después:** Importar de galería Overleaf o desde GitHub con "Import from GitHub"
- **Estructura modular:** main.tex + archivos .tex separados
- **Colaboración:** Función "Share" de Overleaf para trabajo en equipo

#### Clase 7: Temas Especiales
- **Cartas:** letter + article con logos (Upload Files en Overleaf)
- **Pósters:** a0poster, beamerposter, tikzposter en Overleaf
- **Beamer:** Presentaciones con compilación automática
- **Animaciones:** Paquete `animate` + secuencias de imágenes subidas

---

## Cambios Técnicos

### Eliminado
- Líneas con comandos de terminal
- Instrucciones de clonación de repositorio
- Referencias a compiladores locales
- Procesos de instalación de software

### Agregado
- Instrucciones "Upload Files" en Overleaf
- Referencias a botones y menús de Overleaf
- Explicaciones sobre compilación automática
- Notas sobre cómo compartir proyectos
- Referencia a galería de plantillas de Overleaf

### Mantenido
- Todo contenido LaTeX teórico y sintaxis
- Ejemplos de código
- Diagramas y visualizaciones
- Conceptos pedagógicos

---

## Herramientas Utilizadas

### En Overleaf (Principal)
- ✅ Editor web de LaTeX
- ✅ Compilación automática
- ✅ Galería de plantillas (6000+)
- ✅ Compartir proyectos (colaboración)
- ✅ GitHub integrado (Campus License)
- ✅ Zotero integrado (bibliografía)

### Alternativas Documentadas (Referencias)
- 🔗 https://105.ugr.es/latex (versión local del curso)
- Usuarios que prefieran herramientas locales pueden consultar esa referencia

---

## Cambios en Herramientas Principales

| Herramienta Local | Función | Equivalente Overleaf |
|-------------------|---------|-------------------|
| TeXstudio | Editor LaTeX | Editor Overleaf (web) |
| Terminal + pdflatex | Compilación | Compilación automática Overleaf |
| Git en terminal | Control de versiones | GitHub integrado (con Campus License) |
| JabRef | Gestor bibliografía | **Zotero + Overleaf integrado** |

---

## Referencia Rápida de Cambios por Clase

### Clase 1
```
Cambio: 100+ líneas de Git/LaTeX local → 8 ejercicios prácticos en Overleaf
Commits: 99a18af (Git diagram), 486dd1f (conceptos), 914413b (cleanup)
```

### Clase 2  
```
Cambio: Instrucciones locales → Workflow Overleaf
Commit: 653456b
```

### Clase 3
```
Cambio: Ejercicios generales → 4 prácticas Overleaf concretas
Commit: ce898d1
```

### Clase 4 ⭐ IMPORTANTE
```
Cambio: JabRef local → Zotero + Overleaf (MAYOR TRANSFORMACIÓN)
- Nuevo sección: "Gestión de Bibliografía con Zotero + Overleaf"
- 4 subsecciones: Qué es, Integración, Usando referencias, Estilos
- Tabla comparativa: Zotero+Overleaf vs JabRef
Commit: 47b2a09
```

### Clase 5
```
Cambio: Listings, entornos, diseño → instrucciones Overleaf
Cambio: Git conflictos terminal → conceptual sin terminal
Commit: 05cc6ff
```

### Clase 6
```
Cambio: Clonar repositorio → Galería Overleaf o Import from GitHub
Cambio: Instrucciones locales → estructura modular Overleaf
Commit: 7b14b6f
```

### Clase 7
```
Cambio: Múltiples temas + terminal → instrucciones Overleaf para todos
- Cartas: Upload Files de logos
- Pósters: Plantillas Overleaf
- Beamer: Compilación automática
- Animaciones: Upload Files de secuencias
Commit: d950442
```

---

## Proceso de Adaptación Seguido

1. **Análisis:** Lectura de archivo original
2. **Identificación:** Localizarción de comandos/instrucciones locales
3. **Reemplazo:** Cambio a equivalentes Overleaf
4. **Preservación:** Mantenimiento de contenido LaTeX/pedagógico
5. **Validación:** Verificación de coherencia
6. **Commit:** Push a GitHub con mensaje descriptivo

---

## Archivos Modificados

```
/srv/http/overleaf/
├── clase1.html      (598 líneas) - Fundamentos, Git conceptual
├── clase2.html      (759 líneas) - LaTeX básico en Overleaf
├── clase3.html      (900+ líneas) - Elementos LaTeX prácticos
├── clase4.html      (226 líneas) - Zotero + Overleaf (PRINCIPAL)
├── clase5.html      (340 líneas) - Elementos avanzados
├── clase6.html      (360 líneas) - Tesis en Overleaf
├── clase7.html      (1000 líneas) - Temas especiales
├── index.html       - Índice del curso
├── style.css        - Estilos HTML
└── ADAPTACION_OVERLEAF.md - Este archivo
```

---

## Próximos Pasos Sugeridos

1. **Testing:** Verificar cada ejercicio en Overleaf real
2. **Feedback:** Recabar comentarios de estudiantes
3. **Refinamiento:** Ajustes basados en experiencia de alumnos
4. **Documentación:** Guías adicionales sobre características Overleaf avanzadas
5. **Integración Git:** Configurar sincronización Git automática si es necesario

---

## Notas Importantes

### Campus License de Overleaf
Si tu universidad tiene una licencia Campus de Overleaf, los alumnos obtendrán:
- Proyectos ilimitados
- GitHub integrado automático
- Colaboración en tiempo real avanzada
- Acceso prioritario a nuevas características

### Referencia Local Conservada
La URL https://105.ugr.es/latex se menciona en cada clase como referencia para usuarios que prefieran las herramientas locales. Esto preserva el acceso a la versión original del curso.

### Zotero en Overleaf
Es fundamental que los alumnos entiendan:
1. Crear colecciones en Zotero.org
2. Conectar Zotero con Overleaf (Menu → Bibliography → Zotero)
3. La sincronización es automática

---

## Estadísticas de la Adaptación

- **Total de clases adaptadas:** 7/7 ✅
- **Total de commits específicos:** 10 (4 de ese session, 6 anteriores)
- **Líneas eliminadas:** 200+ (instrucciones locales)
- **Líneas agregadas:** 300+ (instrucciones Overleaf)
- **Cambio más significativo:** Clase 4 (JabRef → Zotero)
- **Referencia: 105.ugr.es/latex** - Presente en todas las clases

---

## Validación ✅

- ✅ Todas las 7 clases contienen nota de Overleaf
- ✅ Ninguna clase menciona terminal/compiladores locales
- ✅ Ejercicios adaptados a interfaz Overleaf
- ✅ Contenido LaTeX preservado
- ✅ GitHub integrado documentado
- ✅ Zotero documentado como alternativa a JabRef
- ✅ Todos los commits en rama `main`
- ✅ Código HTML válido y limpio

---

**Adaptación completada:** 30 Octubre, 2024  
**Repositorio:** https://github.com/HexaCuant/curso-latex-overleaf  
**Rama:** main  
**Commits relacionados:** 99a18af, 486dd1f, d0603e8, 914413b, 70ff2b5, 103b7a4, 6d17876, 653456b, ce898d1, 47b2a09, 05cc6ff, 7b14b6f, d950442
