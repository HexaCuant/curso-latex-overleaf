#!/bin/bash
# Script para backup cifrado de la base de datos
# Uso: ./backup-db.sh [backup|restore]

DB_FILE="alumnos.db"
BACKUP_FILE="alumnos.db.enc"
BACKUP_DIR="/srv/http/overleaf/backups"

# Crear directorio de backups si no existe
mkdir -p "$BACKUP_DIR"

# Función para crear backup cifrado
backup() {
    if [ ! -f "$DB_FILE" ]; then
        echo "Error: No se encuentra $DB_FILE"
        exit 1
    fi
    
    # Nombre con fecha
    TIMESTAMP=$(date +%Y%m%d_%H%M%S)
    BACKUP_NAME="alumnos_${TIMESTAMP}.db.enc"
    
    echo "Creando backup cifrado..."
    echo "Introduce la contraseña para cifrar (recuérdala para restaurar):"
    
    # Cifrar con openssl (AES-256-CBC)
    openssl enc -aes-256-cbc -salt -pbkdf2 -in "$DB_FILE" -out "$BACKUP_DIR/$BACKUP_NAME"
    
    if [ $? -eq 0 ]; then
        echo "✅ Backup creado: $BACKUP_DIR/$BACKUP_NAME"
        
        # También crear copia "latest" para el repo
        cp "$BACKUP_DIR/$BACKUP_NAME" "$BACKUP_FILE"
        echo "✅ Copia actualizada: $BACKUP_FILE (para incluir en git)"
        
        # Mostrar últimos backups
        echo ""
        echo "Últimos backups:"
        ls -lht "$BACKUP_DIR" | head -6
    else
        echo "❌ Error al crear backup"
        exit 1
    fi
}

# Función para restaurar desde backup
restore() {
    if [ -z "$1" ]; then
        # Si no se especifica archivo, usar el más reciente
        RESTORE_FILE=$(ls -t "$BACKUP_DIR"/*.enc 2>/dev/null | head -1)
        if [ -z "$RESTORE_FILE" ]; then
            # Intentar con el archivo del repo
            if [ -f "$BACKUP_FILE" ]; then
                RESTORE_FILE="$BACKUP_FILE"
            else
                echo "Error: No hay backups disponibles"
                exit 1
            fi
        fi
    else
        RESTORE_FILE="$1"
    fi
    
    echo "Restaurando desde: $RESTORE_FILE"
    echo "Introduce la contraseña de descifrado:"
    
    # Crear backup del actual antes de sobrescribir
    if [ -f "$DB_FILE" ]; then
        cp "$DB_FILE" "${DB_FILE}.before_restore"
        echo "Backup de seguridad creado: ${DB_FILE}.before_restore"
    fi
    
    # Descifrar
    openssl enc -aes-256-cbc -d -salt -pbkdf2 -in "$RESTORE_FILE" -out "$DB_FILE"
    
    if [ $? -eq 0 ]; then
        echo "✅ Base de datos restaurada correctamente"
        # Restaurar permisos para Apache
        chmod 666 "$DB_FILE"
    else
        echo "❌ Error al restaurar (¿contraseña incorrecta?)"
        # Restaurar el backup previo
        if [ -f "${DB_FILE}.before_restore" ]; then
            mv "${DB_FILE}.before_restore" "$DB_FILE"
            echo "Se ha restaurado la versión anterior de la BD"
        fi
        exit 1
    fi
}

# Función para listar backups
list() {
    echo "Backups disponibles en $BACKUP_DIR:"
    ls -lht "$BACKUP_DIR"/*.enc 2>/dev/null || echo "No hay backups"
    echo ""
    if [ -f "$BACKUP_FILE" ]; then
        echo "Backup en repo: $BACKUP_FILE ($(ls -lh $BACKUP_FILE | awk '{print $5}'))"
    fi
}

# Menú principal
case "$1" in
    backup|b)
        backup
        ;;
    restore|r)
        restore "$2"
        ;;
    list|l)
        list
        ;;
    *)
        echo "Uso: $0 {backup|restore|list}"
        echo ""
        echo "Comandos:"
        echo "  backup, b     - Crear backup cifrado de la BD"
        echo "  restore, r    - Restaurar BD desde backup"
        echo "  list, l       - Listar backups disponibles"
        echo ""
        echo "Ejemplos:"
        echo "  $0 backup                    # Crear nuevo backup"
        echo "  $0 restore                   # Restaurar último backup"
        echo "  $0 restore backups/file.enc  # Restaurar backup específico"
        ;;
esac
