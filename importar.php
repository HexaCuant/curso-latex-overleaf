<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Importar alumnos desde Excel - Curso LaTeX/Overleaf</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            border-bottom: 3px solid #007bff;
            padding-bottom: 0.5rem;
        }
        .form-group { margin-bottom: 1.5rem; }
        label { display: block; margin-bottom: 0.5rem; font-weight: bold; }
        input[type="file"], select, input[type="number"] {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
            box-sizing: border-box;
        }
        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            font-size: 1rem;
            margin-right: 0.5rem;
        }
        .btn-primary { background: #007bff; color: white; }
        .btn-secondary { background: #6c757d; color: white; }
        .btn-success { background: #28a745; color: white; }
        .alert {
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1rem;
        }
        .alert-success { background: #d4edda; border: 1px solid #c3e6cb; color: #155724; }
        .alert-danger { background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; }
        .alert-info { background: #cce5ff; border: 1px solid #b8daff; color: #004085; }
        .alert-warning { background: #fff3cd; border: 1px solid #ffc107; color: #856404; }
        .info-box {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1.5rem;
        }
        .preview-table {
            width: 100%;
            border-collapse: collapse;
            margin: 1rem 0;
            font-size: 0.9rem;
        }
        .preview-table th, .preview-table td {
            padding: 0.5rem;
            border: 1px solid #ddd;
            text-align: left;
        }
        .preview-table th { background: #f8f9fa; }
        .preview-table tr:nth-child(even) { background: #f8f9fa; }
        /* Login form */
        .login-form { max-width: 400px; margin: 2rem auto; }
        .login-info {
            background: #e7f5ff;
            border: 1px solid #74c0fc;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
        }
        .login-success {
            background: #d3f9d8;
            border: 1px solid #69db7c;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
        }
        .login-error {
            background: #ffe3e3;
            border: 1px solid #ff8787;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="container">
<?php
require_once "funciones.php";

// Limpiar tokens expirados ocasionalmente
if (rand(1, 10) === 1) {
    limpiar_tokens_expirados();
}

// Verificar acceso por token
$acceso = false;
$token = $_GET['k'] ?? $_POST['k'] ?? '';
$clave = $token; // Compatibilidad con enlaces existentes

if (!empty($token) && verificar_acceso($token)) {
    $acceso = true;
}

// Procesar solicitud de acceso
$mensaje_login = '';
$tipo_mensaje = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['solicitar_acceso'])) {
    $email_solicitado = $_POST['email'] ?? '';
    $resultado = solicitar_acceso($email_solicitado, 'importar.php');
    $mensaje_login = $resultado['mensaje'];
    $tipo_mensaje = $resultado['ok'] ? 'success' : 'error';
}

if (!$acceso) {
    ?>
    <div class="login-form">
        <h1>🔐 Acceso restringido</h1>
        <div class="login-info">
            <p><strong>Sistema de acceso por enlace seguro</strong></p>
            <p>Introduce tu dirección de correo electrónico. Si está autorizada, recibirás un enlace temporal para acceder.</p>
        </div>
        
        <?php if ($mensaje_login): ?>
        <div class="login-<?= $tipo_mensaje ?>">
            <?= htmlspecialchars($mensaje_login) ?>
        </div>
        <?php endif; ?>
        
        <form method="post" action="importar.php">
            <div class="form-group">
                <label for="email">Correo electrónico</label>
                <input type="email" id="email" name="email" required autofocus placeholder="tu.correo@ugr.es">
            </div>
            <button type="submit" name="solicitar_acceso" value="1" class="btn btn-primary">Solicitar acceso</button>
        </form>
        
        <p style="margin-top: 2rem; font-size: 0.85rem; color: #666;">
            <strong>Nota:</strong> El enlace de acceso expira en 1 hora.
        </p>
    </div>
    <?php
    exit;
}

$pdo = conecta();

// Obtener ediciones disponibles
$ediciones = $pdo->query('SELECT * FROM ediciones WHERE archivado = 0 ORDER BY anio DESC, edicion DESC')->fetchAll(PDO::FETCH_ASSOC);

$mensaje = '';
$preview = [];
$importados = 0;

// Procesar importación
if (isset($_POST['importar']) && isset($_FILES['excel'])) {
    $anio = $_POST['anio'];
    $edicion = $_POST['edicion'];
    $archivo = $_FILES['excel']['tmp_name'];
    $nombre_archivo = $_FILES['excel']['name'];
    
    if (!$archivo || !file_exists($archivo)) {
        $mensaje = "<div class='alert alert-danger'>No se ha subido ningún archivo</div>";
    } else {
        // Verificar extensión
        $ext = strtolower(pathinfo($nombre_archivo, PATHINFO_EXTENSION));
        if ($ext !== 'xlsx') {
            $mensaje = "<div class='alert alert-danger'>Solo se permiten archivos .xlsx (Excel 2007+)</div>";
        } else {
            // Leer Excel usando Python (openpyxl)
            $temp_json = tempnam(sys_get_temp_dir(), 'excel_') . '.json';
            $cmd = escapeshellcmd("python3 -c \"
import openpyxl
import json
import sys

try:
    wb = openpyxl.load_workbook('$archivo')
    ws = wb.active
    
    # Leer cabeceras
    headers = [str(cell.value).lower() if cell.value else '' for cell in ws[1]]
    
    # Buscar columnas relevantes
    col_map = {}
    for i, h in enumerate(headers):
        if 'nombre' in h and 'apellido' not in h:
            col_map['nombre'] = i
        elif 'apellido' in h:
            col_map['apellidos'] = i
        elif 'correo' in h or 'email' in h or 'mail' in h:
            col_map['email'] = i
        elif 'programa' in h or 'doctorado' in h:
            col_map['programa'] = i
        elif 'observ' in h or 'comentario' in h:
            col_map['observaciones'] = i
    
    # Leer datos
    alumnos = []
    for row in ws.iter_rows(min_row=2, values_only=True):
        if row[col_map.get('nombre', 0)]:  # Si tiene nombre
            alumno = {
                'nombre': str(row[col_map.get('nombre', 0)] or ''),
                'apellidos': str(row[col_map.get('apellidos', 1)] or ''),
                'email': str(row[col_map.get('email', 2)] or ''),
                'programa': str(row[col_map.get('programa', 6)] or ''),
                'observaciones': str(row[col_map.get('observaciones', 7)] or '')
            }
            if alumno['nombre'] and alumno['email']:
                alumnos.append(alumno)
    
    print(json.dumps({'ok': True, 'alumnos': alumnos, 'columnas': col_map}))
except Exception as e:
    print(json.dumps({'ok': False, 'error': str(e)}))
\"");
            
            $output = shell_exec($cmd);
            $result = json_decode($output, true);
            
            if (!$result || !$result['ok']) {
                $error = $result['error'] ?? 'Error desconocido al leer el archivo';
                $mensaje = "<div class='alert alert-danger'>Error: $error</div>";
            } else {
                $alumnos_excel = $result['alumnos'];
                
                if (empty($alumnos_excel)) {
                    $mensaje = "<div class='alert alert-warning'>No se encontraron alumnos en el archivo</div>";
                } else {
                    // Insertar alumnos
                    $stmt = $pdo->prepare('INSERT INTO alumnos (nombre, apellidos, email, programa, observaciones, activo, anio, edicion) VALUES (?, ?, ?, ?, ?, 1, ?, ?)');
                    
                    $insertados = 0;
                    $duplicados = 0;
                    
                    foreach ($alumnos_excel as $a) {
                        // Verificar si ya existe (por email y edición)
                        $check = $pdo->prepare('SELECT COUNT(*) FROM alumnos WHERE email = ? AND anio = ? AND edicion = ?');
                        $check->execute([$a['email'], $anio, $edicion]);
                        
                        if ($check->fetchColumn() == 0) {
                            try {
                                $stmt->execute([
                                    $a['nombre'],
                                    $a['apellidos'],
                                    $a['email'],
                                    $a['programa'],
                                    $a['observaciones'],
                                    $anio,
                                    $edicion
                                ]);
                                $insertados++;
                            } catch (Exception $e) {
                                // Ignorar errores individuales
                            }
                        } else {
                            $duplicados++;
                        }
                    }
                    
                    $mensaje = "<div class='alert alert-success'>✓ Importación completada: <strong>$insertados</strong> alumnos añadidos";
                    if ($duplicados > 0) {
                        $mensaje .= " ($duplicados duplicados omitidos)";
                    }
                    $mensaje .= "</div>";
                }
            }
        }
    }
}

?>

<a href="alumnos.php?k=<?php echo htmlspecialchars($clave); ?>" class="btn btn-secondary">← Volver a alumnos</a>

<h1>📤 Importar alumnos desde Excel</h1>

<?php echo $mensaje; ?>

<div class="info-box">
    <p><strong>Formato esperado:</strong> Archivo Excel (.xlsx) con las siguientes columnas:</p>
    <ul>
        <li><strong>Nombre</strong> - Nombre del alumno</li>
        <li><strong>Apellidos</strong> - Apellidos del alumno</li>
        <li><strong>Email / Correo electrónico</strong> - Dirección de correo</li>
        <li><strong>Programa / Doctorado</strong> (opcional) - Programa de doctorado</li>
        <li><strong>Observaciones</strong> (opcional) - Comentarios</li>
    </ul>
    <p><em>El sistema detectará automáticamente las columnas por sus nombres en la primera fila.</em></p>
</div>

<form method="post" enctype="multipart/form-data">
    <input type="hidden" name="k" value="<?php echo htmlspecialchars($clave); ?>">
    
    <div class="form-group">
        <label for="excel">Archivo Excel (.xlsx)</label>
        <input type="file" id="excel" name="excel" accept=".xlsx" required>
    </div>
    
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
        <div class="form-group">
            <label for="anio">Año</label>
            <input type="number" id="anio" name="anio" value="<?php echo date('Y'); ?>" required min="2020" max="2050">
        </div>
        <div class="form-group">
            <label for="edicion">Edición</label>
            <select id="edicion" name="edicion" required>
                <?php foreach ($ediciones as $ed): ?>
                    <option value="<?php echo $ed['edicion']; ?>" data-anio="<?php echo $ed['anio']; ?>">
                        <?php echo $ed['nombre'] ?: ($ed['anio'] . ' - Edición ' . $ed['edicion']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    
    <div class="alert alert-warning">
        ⚠️ Los alumnos con el mismo email que ya existan en la edición seleccionada serán omitidos (no se duplican).
    </div>
    
    <button type="submit" name="importar" class="btn btn-success">📥 Importar alumnos</button>
</form>

<script>
// Sincronizar año con la edición seleccionada
document.getElementById('edicion').addEventListener('change', function() {
    var option = this.options[this.selectedIndex];
    document.getElementById('anio').value = option.dataset.anio;
});
// Inicializar
document.getElementById('edicion').dispatchEvent(new Event('change'));
</script>

    </div>
</body>
</html>
