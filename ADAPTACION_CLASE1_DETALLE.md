# Adaptación de Clase 1 - Guía Detallada

## 🎯 Objetivo

Cambiar clase1.html para que enseñe a los estudiantes a **usar Overleaf** en lugar de instalar herramientas locales.

## 📋 Secciones de clase1.html que MANTIENEN contenido similar

### ✅ Mantener (con ajustes):

1. **Introducción a Git** - Concepto es el mismo
2. **Instalación de Git** - Se mantiene (necesario para sincronización con GitHub)
3. **Crear cuenta GitHub** - Se mantiene igual
4. **Crear primer repositorio** - Se mantiene igual
5. **Comandos básicos de Git** - Se mantiene (ahora via Overleaf o terminal)
6. **Alternativas a GitHub** - Se mantiene igual

## ❌ Reemplazar completamente:

### Sección: "Instalación de LaTeX"
**Reemplazar por**: "Crear Cuenta en Overleaf"

**Contenido nuevo**:
- ¿Qué es Overleaf y ventajas sobre instalación local?
- Crear cuenta en Overleaf
- Verificar cuenta
- Familiarizarse con la interfaz

**Estructura**:
```
3.1 ¿Por qué Overleaf en lugar de instalación local?
    - Sin instalación necesaria
    - Editor online colaborativo
    - Compilación automática
    - Acceso desde cualquier dispositivo
    - Plantillas predefinidas

3.2 Crear cuenta en Overleaf
    - Ir a https://www.overleaf.com
    - Método 1: Email + contraseña
    - Método 2: Cuenta Google/GitHub (recomendado)
    - Verificar email
    - Pasos con capturas de pantalla

3.3 Primer acceso a Overleaf
    - Panel de proyectos
    - Crear nuevo proyecto
    - Opciones: Blank, Template, Upload
    - Interfaz principal
```

---

### Sección: "Instalación de TeXstudio"
**Reemplazar por**: "Interfaz de Overleaf"

**Contenido nuevo**:
- Tour de la interfaz de Overleaf
- Panel izquierdo: estructura del proyecto
- Panel central: editor de código LaTeX
- Panel derecho: previsualización en tiempo real
- Botón de compilación
- Menú y opciones

**Estructura**:
```
3.4 Interfaz de Overleaf - Guía Visual
    - Pantalla principal después de crear proyecto
    - Panel de proyecto (left sidebar)
    - Editor de código (center)
    - Visor PDF (right preview)
    - Botones principales y atajos
    - Búsqueda y reemplazo
    - Control de cambios
```

---

### Sección: "Instalación de LaTeX" (Linux/Mac/Windows)
**Reemplazar por**: "Crear tu Primer Proyecto en Overleaf"

**Contenido nuevo**:
- Pasos para crear proyecto en blanco
- Usar una plantilla
- Cargar proyecto existente
- Estructura básica de un documento
- Compilar y ver resultado

**Estructura**:
```
3.5 Crear tu primer proyecto en Overleaf
    Paso 1: Ir a "New Project"
    - Opción "Blank Project"
    - Opción "From Template"
    - Opción "Upload Project"
    
    Paso 2: Estructura básica
    - Archivo main.tex predefinido
    - Primer documento simple
    - Comando \document, \begin, \end
    
    Paso 3: Compilar
    - Botón "Compile" (verde)
    - Ver resultado en PDF
    - Entender mensajes de error/warning
```

---

### Sección: "Comandos básicos de Git desde el terminal"
**Cambiar enfoque a**: "Git en el contexto de Overleaf"

**Nuevo contenido**:
```
4. Git y Overleaf: Dos formas de trabajar

4.1 Opción A: Git Local + GitHub (Recomendado para comenzar)
    - Trabajas en Overleaf
    - Descargas proyecto regularmente
    - Subes cambios a GitHub desde tu ordenador
    - Pasos: Download → git add → git commit → git push

4.2 Opción B: Sincronización directa Overleaf-GitHub (Con licencia campus)
    - Sincronización automática
    - Necesita licencia Overleaf de la universidad
    - Sin necesidad de descargar/subir archivos

4.3 Comandos Git básicos (ahora en contexto de Overleaf)
    Los mismos comandos, pero aplicados cuando:
    - Descargas proyecto de Overleaf
    - Subes cambios desde local
    - Colaboras en repositorio compartido
    
4.4 Flujo de trabajo recomendado
    Overleaf → Descargar → Git Add/Commit/Push
    GitHub → Git Pull/Clone → Subir a Overleaf (si necesario)
```

---

## 📊 Mapa de cambios sección por sección

| Sección Original | Acción | Nueva Sección |
|---|---|---|
| Instalación de Git | ✅ MANTENER | Instalación de Git |
| Crear GitHub | ✅ MANTENER | Crear GitHub |
| Primer repositorio | ✅ MANTENER | Primer repositorio |
| Clonar repositorio | ✅ MANTENER (con notas sobre Overleaf) | Clonar repositorio |
| Comandos Git | ⚠️ ADAPTAR | Comandos Git + contexto Overleaf |
| Instalación LaTeX | ❌ REEMPLAZAR | Crear cuenta Overleaf |
| Instalación TeXstudio | ❌ REEMPLAZAR | Interfaz de Overleaf |
| Alternativas LaTeX | ⚠️ ADAPTAR | Destacar Overleaf como principal |
| Limitaciones Overleaf | ✅ MANTENER | Limitaciones Overleaf gratuita |
| Alternativas GitHub | ✅ MANTENER | Alternativas GitHub |

---

## 🎓 Nuevo flujo educativo de clase1

### Antes (Local):
1. ✅ Entender Git
2. ✅ Crear GitHub
3. ✅ Instalar LaTeX localmente
4. ✅ Instalar TeXstudio
5. ✅ Crear repo local
6. ⚠️ Compilar LaTeX desde TeXstudio
7. ⚠️ Usar Git desde terminal

### Después (Overleaf):
1. ✅ Entender Git
2. ✅ Crear GitHub
3. ✅ **Crear cuenta Overleaf**
4. ✅ **Crear proyecto en Overleaf**
5. ✅ **Conocer interfaz Overleaf**
6. ✅ **Usar Overleaf editor + compilación automática**
7. ⚠️ **Descargar proyecto desde Overleaf**
8. ✅ **Usar Git para sincronizar con GitHub**

---

## 🔧 Cambios técnicos en el HTML

### Elementos visuales a actualizar:

1. **Imágenes/Capturas de pantalla**:
   - ❌ Screenshots de MiKTeX installer
   - ❌ Screenshots de TeXstudio
   - ✅ Screenshots de Overleaf interface
   - ✅ Diagrama: Overleaf → Download → Git → GitHub

2. **Enlaces**:
   - ❌ Links a descargas de LaTeX
   - ❌ Links a TeXstudio
   - ✅ Links a Overleaf
   - ✅ Links a Overleaf learn

3. **Código de ejemplo**:
   - ✅ Mismo código LaTeX
   - ⚠️ Pero ahora en editor Overleaf (cambiar contexto)

---

## 📝 Template HTML para nuevas secciones

```html
<h3>Crear Cuenta en Overleaf</h3>
<ol>
    <li>Instrucción clara</li>
    <li>Con enlace/referencias</li>
    <li>Pasos numerados</li>
    <li>Capturas de pantalla</li>
    <li>Notas adicionales en <strong> or emphasis</strong></li>
</ol>
```

---

## 🚀 Próximos pasos

1. ✅ **Analizar estructura actual** → HECHO
2. ⏳ **Crear clase1-adaptada.html** con cambios
3. ⏳ **Revisar y validar** estructura
4. ⏳ **Subir a GitHub**
5. ⏳ **Validar en navegador**
6. ⏳ **Repetir para otras clases**

---

**Estado**: Plan detallado completado
**Siguiente acción**: ¿Quieres que comience la adaptación de clase1.html?
