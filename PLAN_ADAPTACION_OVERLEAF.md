# Plan de Adaptación: De LaTeX Local a Overleaf

## 🎯 Objetivo General

Transformar los **archivos HTML del curso** para que enseñen a usar **Overleaf** en lugar de herramientas locales (TeXstudio, JabRef, Git desde terminal).

## 📊 Cambios principales por archivo

### clase1.html - "Introducción a Git y LaTeX"

#### Cambios necesarios:

**ANTES (Local)**:
- ✅ Instalar Git en tu ordenador
- ✅ Instalar LaTeX (MiKTeX, MacTeX, TeX Live)
- ✅ Instalar TeXstudio
- ✅ Usar Git desde terminal
- ✅ Crear repositorio local

**DESPUÉS (Overleaf)**:
- ✅ Instalar Git en tu ordenador (opcional - para sincronización con GitHub)
- ✅ Crear cuenta en Overleaf
- ✅ Crear repositorio en GitHub
- ✅ **Crear proyecto en Overleaf**
- ✅ **Sincronizar Overleaf con GitHub (opcional pero recomendado)**
- ✅ **Usar Git integrado en Overleaf (si licencia de campus)**

#### Secciones a reemplazar:

1. **Instalación de LaTeX** → "Crear cuenta en Overleaf"
2. **Instalación de TeXstudio** → "Interfaz de Overleaf"
3. **Git desde terminal** → "Git integrado en Overleaf + GitHub"
4. **Crear local repository** → "Sincronización Overleaf-GitHub"

---

### clase2.html - "Fundamentos de LaTeX"

#### Cambios necesarios:

**ANTES**:
- Abrir TeXstudio
- Crear archivo .tex local
- Compilar localmente

**DESPUÉS**:
- Crear nuevo proyecto en Overleaf
- Editor online con previsualización en tiempo real
- Compilación automática en servidores de Overleaf
- Compartir proyecto con compañeros mediante URL

#### Secciones a reemplazar:

1. Introducción → "Usando Overleaf para crear tu primer documento"
2. "Crear estructura local" → "Estructura en Overleaf"
3. "Compilar en TeXstudio" → "Compilación automática en Overleaf"

---

### clase3.html - "Elementos básicos en LaTeX"

#### Cambios necesarios:

**ANTES**:
- Trabajar localmente en TeXstudio
- Compilar y ver cambios

**DESPUÉS**:
- Usar editor de Overleaf
- Vista dual: código + previsualización en tiempo real
- Colaborar con compañeros en Overleaf

#### Secciones a reemplazar:

1. Agregar: "Compartir proyecto en Overleaf para colaborar"
2. Agregar: "Track Changes en Overleaf"

---

### clase4.html - "Fórmulas matemáticas y bibliografía"

#### Cambios principales:

**ANTES**:
- Usar JabRef para gestionar referencias
- Archivo .bib local
- Compilar LaTeX + BibTeX localmente

**DESPUÉS**:
- **Usar Zotero integrado con Overleaf** (alternativa a JabRef)
- **O: Usar Mendeley integrado con Overleaf**
- **O: Subir .bib directamente a Overleaf**
- Compilación automática con BibTeX en Overleaf
- Compartir bibliografía con el equipo

#### Secciones a reemplazar:

1. "Instalación de JabRef" → "Integración Zotero/Mendeley con Overleaf"
2. "Gestionar referencias locales" → "Gestionar referencias en Overleaf"
3. "Compilación local" → "Compilación automática de bibliografía"

---

### clase5.html - "Elementos avanzados y personalización"

#### Cambios necesarios:

**ANTES**:
- Trabajar localmente
- Git desde terminal para resolución de conflictos

**DESPUÉS**:
- Colaboración en tiempo real en Overleaf
- Comentarios integrados en Overleaf
- Historial de cambios en Overleaf
- Git via GitHub sincronizado automáticamente

#### Secciones a reemplazar:

1. "Git desde terminal" → "Colaboración y conflictos en Overleaf"
2. Agregar: "Cómo comentar cambios en Overleaf"
3. Agregar: "Track changes - Sugerencias y revisión"

---

### clase6.html - "Estructuración de la tesis"

#### Cambios necesarios:

**ANTES**:
- Trabajar en TeXstudio
- Sincronizar cambios con Git manualmente

**DESPUÉS**:
- Usar Overleaf para proyecto grande
- Archivos separados (input/include) en Overleaf
- Sincronización automática con GitHub
- Compartir proyecto con director/director de tesis

#### Nuevas secciones:

1. "Estructurar proyecto grande en Overleaf"
2. "Collaborative editing en tesis"
3. "Sincronización automática del proyecto con GitHub"

---

### clase7.html - (Necesito ver su contenido)

---

## 🔧 Cambios Técnicos Específicos

### 1. Remover instrucciones de instalación local

**Archivos afectados**: Todos los HTML

**Cambios**:
- ❌ Eliminar: Pasos de instalación de MiKTeX/MacTeX/TeX Live
- ❌ Eliminar: Pasos de instalación de TeXstudio
- ❌ Eliminar: Pasos de instalación de JabRef (opcional: reemplazar)
- ✅ Mantener: Instalación de Git (para sincronización)
- ✅ Mantener: Creación de GitHub (integración con Overleaf)

### 2. Agregar instrucciones de Overleaf

**Archivos a crear/modificar**:

1. **Nueva sección en clase1**: "Usar Overleaf en el curso"
   - Crear cuenta Overleaf
   - Crear primer proyecto
   - Interfaz básica
   - Compilación automática

2. **Nueva sección en clase4**: "Bibliografía en Overleaf"
   - Opciones: Zotero, Mendeley, .bib directo
   - Integración paso a paso
   - Comparación con JabRef

3. **Nueva sección en clase5**: "Colaboración en Overleaf"
   - Compartir proyectos
   - Comentarios y revisiones
   - Track changes
   - Integración con GitHub

### 3. Cambios en código de ejemplo

**Archivos afectados**: Todos los que contengan ejemplos

**Cambios**:
- Considerar agregar enlaces a proyectos de ejemplo en Overleaf
- Botones "Abrir en Overleaf" si es posible
- Capturas de pantalla de Overleaf en lugar de TeXstudio

## 📋 Checklist de adaptación por archivo

### clase1.html
- [ ] Reemplazar "Instalación de LaTeX" con "Crear cuenta Overleaf"
- [ ] Reemplazar "Instalación de TeXstudio" con "Interfaz de Overleaf"
- [ ] Actualizar diagrama de flujo (de local a cloud)
- [ ] Agregar: "Sincronización Overleaf-GitHub"
- [ ] Agregar: "Crear proyecto en Overleaf"

### clase2.html
- [ ] Actualizar ejemplos: usar Overleaf editor
- [ ] Reemplazar capturas de TeXstudio por Overleaf
- [ ] Agregar: "Compilación automática"
- [ ] Agregar: "Compartir proyecto"

### clase3.html
- [ ] Actualizar ejemplos: usar Overleaf
- [ ] Agregar: "Colaboración en tiempo real"
- [ ] Agregar: "Comentarios en Overleaf"

### clase4.html
- [ ] Reemplazar "Instalación JabRef" con "Integración Zotero/Mendeley"
- [ ] Agregar: "Subir .bib a Overleaf"
- [ ] Actualizar flujo de bibliografía

### clase5.html
- [ ] Reemplazar "Git desde terminal" con "Colaboración Overleaf"
- [ ] Agregar: "Resolución de conflictos en Overleaf"
- [ ] Agregar: "Track changes"

### clase6.html
- [ ] Agregar: "Estructurar proyecto grande"
- [ ] Agregar: "Sincronización automática"
- [ ] Agregar: "Compartir con director"

### clase7.html
- [ ] (Pendiente análisis)

## 🎓 Recursos de referencia para adaptación

**Documentación Overleaf**:
- https://www.overleaf.com/learn
- https://www.overleaf.com/learn/how-to/Sharing_a_project
- https://www.overleaf.com/learn/how-to/Integrations

**Integraciones**:
- Zotero + Overleaf: https://www.overleaf.com/learn/how-to/Zotero
- Mendeley + Overleaf: https://www.overleaf.com/learn/how-to/Mendeley
- GitHub + Overleaf: https://www.overleaf.com/learn/how-to/Sharing_a_project#GitHub

## 💡 Consideraciones especiales

1. **Licencia de Campus**: Si la universidad tiene licencia de Overleaf Campus:
   - Los estudiantes acceden gratuitamente
   - Tiene más funcionalidades premium
   - Integración Git directa
   - Más colaboradores por proyecto

2. **Usuarios gratuitos**: Si no tienen licencia:
   - Limitado a 1 colaborador por proyecto
   - Pueden usar URL compartida para edición
   - GitHub sync limitado

3. **Estructura web**: Los HTML deben mantener:
   - Mismo formato visual y estructura
   - Enlaces internos entre clases
   - Compatibilidad con style.css existente
   - Accesibilidad educativa

---

**Estado**: Plan listo para implementación  
**Próximo paso**: Comenzar con adaptación de clase1.html
