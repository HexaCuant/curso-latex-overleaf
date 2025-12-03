## Plantilla - Flujo recomendado para bibliografías (tesis)

Breve guía para mantener una bibliografía reproducible y segura cuando usas Overleaf y Zotero (Better BibTeX, BBT).

1. Flujo general
   - Asegura que la copia canónica de <code>references.bib</code> esté en el repositorio (por ejemplo: GitHub).
   - Configura Better BibTeX (BBT) en Zotero para exportar automáticamente la colección de la tesis a <code>references.bib</code> en la carpeta del proyecto local.
   - Haz commit y push de <code>references.bib</code> al repo; opcionalmente automatiza el deploy a Overleaf desde CI.

2. .gitignore recomendado (ejemplo)
```
# Archivos de salida y temporales de LaTeX
*.pdf
*.aux
*.log
*.out
*.toc
*.synctex.gz
*.fls
*.fdb_latexmk
*.bbl
*.blg

# Adjuntos de Zotero / PDF personales
data/**/attachments/**

# Metadatos del sistema
.DS_Store
# Carpeta build si la usas
build/
```

3. Integración segura con Overleaf
   - No subas credenciales al repo. Para automatizaciones CI almacena la URL de Overleaf con token en un secret (ej. <code>OVERLEAF_GIT_URL</code> en GitHub Secrets).
   - Considera que Overleaf también acepta editar/actualizar desde su interface web: revisa siempre el <code>references.bib</code> antes de publicar en producción.

4. Ejemplo mínimo de comando a ejecutar localmente tras actualización de BBT
```
git pull origin main
git add references.bib
git commit -m "BBT: actualizar references"
git push origin main
# Opcional: git push overleaf main (si usas remoto overleaf)
```

5. Recomendaciones
   - Si trabajáis varios en la bib, usar Pull Requests para revisar cambios en <code>references.bib</code>.
   - Mantener un formato de claves estable en BBT para evitar colisiones.

Más detalles y ejemplos avanzados (scripts, CI) en: <code>git-faq.html#bbt-git-overleaf</code>
