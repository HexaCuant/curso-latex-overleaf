<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de alumnos - Curso LaTeX/Overleaf</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 2rem;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1, h2 {
            color: #333;
            border-bottom: 3px solid #007bff;
            padding-bottom: 0.5rem;
        }
        h2 { font-size: 1.3rem; margin-top: 2rem; }
        
        /* Tabla */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
            font-size: 0.9rem;
        }
        th, td {
            padding: 0.6rem;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th { background: #f8f9fa; font-weight: bold; }
        tr:hover { background: #f1f3f5; }
        
        /* Badges */
        .badge {
            display: inline-block;
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
            font-size: 0.8rem;
        }
        .badge-success { background: #d4edda; color: #155724; }
        .badge-danger { background: #f8d7da; color: #721c24; }
        .badge-warning { background: #fff3cd; color: #856404; }
        .badge-secondary { background: #e9ecef; color: #495057; }
        
        /* Botones */
        .btn {
            display: inline-block;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            font-size: 0.9rem;
            margin-right: 0.25rem;
        }
        .btn-sm { padding: 0.25rem 0.5rem; font-size: 0.8rem; }
        .btn-primary { background: #007bff; color: white; }
        .btn-success { background: #28a745; color: white; }
        .btn-warning { background: #ffc107; color: #333; }
        .btn-danger { background: #dc3545; color: white; }
        .btn-secondary { background: #6c757d; color: white; }
        .btn-info { background: #17a2b8; color: white; }
        
        /* Estadísticas */
        .stats {
            display: flex;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }
        .stat-box {
            background: #f8f9fa;
            padding: 1rem 1.5rem;
            border-radius: 8px;
            text-align: center;
            min-width: 100px;
        }
        .stat-box .numero { font-size: 1.8rem; font-weight: bold; color: #007bff; }
        .stat-box .texto { color: #666; font-size: 0.85rem; }
        
        /* Formularios */
        .form-group { margin-bottom: 1rem; }
        label { display: block; margin-bottom: 0.3rem; font-weight: bold; font-size: 0.9rem; }
        input[type="text"], input[type="email"], input[type="number"], input[type="password"], select, textarea {
            width: 100%;
            padding: 0.6rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
            box-sizing: border-box;
        }
        select { background: white; }
        
        /* Filtros */
        .filtros {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            display: flex;
            gap: 1rem;
            align-items: end;
            flex-wrap: wrap;
        }
        .filtros .form-group { margin-bottom: 0; min-width: 150px; }
        .filtros label { font-size: 0.85rem; }
        
        /* Modal / Panel */
        .panel {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .panel h3 { margin-top: 0; color: #333; }
        .panel-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }
        
        /* Alertas */
        .alert {
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1rem;
        }
        .alert-success { background: #d4edda; border: 1px solid #c3e6cb; color: #155724; }
        .alert-danger { background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; }
        .alert-info { background: #cce5ff; border: 1px solid #b8daff; color: #004085; }
        
        /* Login */
        .login-form { max-width: 400px; margin: 4rem auto; }
        
        /* Email link */
        .email-link { color: #007bff; text-decoration: none; }
        .email-link:hover { text-decoration: underline; }
        
        /* Acciones en fila */
        .acciones { display: flex; gap: 0.25rem; flex-wrap: wrap; }
        
        /* Login form mejorado */
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

if (!empty($token) && verificar_acceso($token)) {
    $acceso = true;
}

// Mantener compatibilidad con variable $clave para los enlaces
$clave = $token;

// Procesar solicitud de acceso
$mensaje_login = '';
$tipo_mensaje = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['solicitar_acceso'])) {
    $email_solicitado = $_POST['email'] ?? '';
    $resultado = solicitar_acceso($email_solicitado);
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
        
        <form method="post" action="alumnos.php">
            <div class="form-group">
                <label for="email">Correo electrónico</label>
                <input type="email" id="email" name="email" required autofocus placeholder="tu.correo@ugr.es">
            </div>
            <button type="submit" name="solicitar_acceso" value="1" class="btn btn-primary">Solicitar acceso</button>
        </form>
        
        <p style="margin-top: 2rem; font-size: 0.85rem; color: #666;">
            <strong>Nota:</strong> El enlace de acceso expira en 1 hora y solo puede usarse una vez.
        </p>
    </div>
    <?php
    exit;
}

$pdo = conecta();
$mensaje = '';

// Mostrar archivados o no
$ver_archivados = isset($_GET['archivados']);

// Obtener ediciones disponibles (de la tabla ediciones)
if ($ver_archivados) {
    $ediciones = $pdo->query('SELECT * FROM ediciones ORDER BY anio DESC, edicion DESC')->fetchAll(PDO::FETCH_ASSOC);
} else {
    $ediciones = $pdo->query('SELECT * FROM ediciones WHERE archivado = 0 ORDER BY anio DESC, edicion DESC')->fetchAll(PDO::FETCH_ASSOC);
}

// Edición actual (parámetros o la más reciente)
$anio_sel = $_GET['anio'] ?? ($ediciones[0]['anio'] ?? date('Y'));
$edicion_sel = $_GET['edicion'] ?? ($ediciones[0]['edicion'] ?? 1);

// ========== PROCESAR ACCIONES ==========

// Archivar/Desarchivar edición
if (isset($_GET['archivar'])) {
    $pdo->prepare('UPDATE ediciones SET archivado = 1 WHERE anio = ? AND edicion = ?')
        ->execute([$_GET['archivar_anio'], $_GET['archivar_ed']]);
    $mensaje = "<div class='alert alert-success'>✓ Edición archivada</div>";
    // Refrescar ediciones
    $ediciones = $pdo->query('SELECT * FROM ediciones WHERE archivado = 0 ORDER BY anio DESC, edicion DESC')->fetchAll(PDO::FETCH_ASSOC);
    if (!empty($ediciones)) {
        $anio_sel = $ediciones[0]['anio'];
        $edicion_sel = $ediciones[0]['edicion'];
    }
}

if (isset($_GET['desarchivar'])) {
    $pdo->prepare('UPDATE ediciones SET archivado = 0 WHERE anio = ? AND edicion = ?')
        ->execute([$_GET['desarchivar_anio'], $_GET['desarchivar_ed']]);
    $mensaje = "<div class='alert alert-success'>✓ Edición desarchivada</div>";
    $ediciones = $pdo->query('SELECT * FROM ediciones WHERE archivado = 0 ORDER BY anio DESC, edicion DESC')->fetchAll(PDO::FETCH_ASSOC);
}

// Crear nueva edición
if (isset($_POST['crear_edicion'])) {
    try {
        // Generar nombre automáticamente: "Edición X - YYYY"
        $nombre_auto = 'Edición ' . $_POST['nueva_edicion'] . ' - ' . $_POST['nuevo_anio'];
        
        $stmt = $pdo->prepare('INSERT INTO ediciones (anio, edicion, nombre, archivado) VALUES (?, ?, ?, 0)');
        $stmt->execute([$_POST['nuevo_anio'], $_POST['nueva_edicion'], $nombre_auto]);
        $mensaje = "<div class='alert alert-success'>✓ Nueva edición creada</div>";
        $anio_sel = $_POST['nuevo_anio'];
        $edicion_sel = $_POST['nueva_edicion'];
        $ediciones = $pdo->query('SELECT * FROM ediciones WHERE archivado = 0 ORDER BY anio DESC, edicion DESC')->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        $mensaje = "<div class='alert alert-danger'>Error: " . htmlspecialchars($e->getMessage()) . "</div>";
    }
}

// Editar edición
if (isset($_POST['editar_edicion'])) {
    try {
        $stmt = $pdo->prepare('UPDATE ediciones SET anio = ?, edicion = ?, nombre = ? WHERE id = ?');
        $stmt->execute([$_POST['edit_anio'], $_POST['edit_edicion'], $_POST['edit_nombre'], $_POST['edit_id']]);
        
        // Actualizar también los alumnos de esa edición
        $stmt = $pdo->prepare('UPDATE alumnos SET anio = ?, edicion = ? WHERE anio = ? AND edicion = ?');
        $stmt->execute([$_POST['edit_anio'], $_POST['edit_edicion'], $_POST['old_anio'], $_POST['old_edicion']]);
        
        $mensaje = "<div class='alert alert-success'>✓ Edición actualizada</div>";
        $anio_sel = $_POST['edit_anio'];
        $edicion_sel = $_POST['edit_edicion'];
        $ediciones = $pdo->query('SELECT * FROM ediciones WHERE archivado = 0 ORDER BY anio DESC, edicion DESC')->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        $mensaje = "<div class='alert alert-danger'>Error: " . htmlspecialchars($e->getMessage()) . "</div>";
    }
}

// Eliminar edición
if (isset($_GET['eliminar_edicion'])) {
    $ed_id = (int)$_GET['eliminar_edicion'];
    try {
        // Obtener datos de la edición para eliminar alumnos
        $ed_data = $pdo->prepare('SELECT anio, edicion FROM ediciones WHERE id = ?');
        $ed_data->execute([$ed_id]);
        $ed = $ed_data->fetch(PDO::FETCH_ASSOC);
        
        if ($ed) {
            // Eliminar alumnos de esa edición
            $pdo->prepare('DELETE FROM alumnos WHERE anio = ? AND edicion = ?')->execute([$ed['anio'], $ed['edicion']]);
            // Eliminar la edición
            $pdo->prepare('DELETE FROM ediciones WHERE id = ?')->execute([$ed_id]);
            $mensaje = "<div class='alert alert-success'>✓ Edición y sus alumnos eliminados</div>";
            
            // Refrescar y seleccionar otra edición
            $ediciones = $pdo->query('SELECT * FROM ediciones WHERE archivado = 0 ORDER BY anio DESC, edicion DESC')->fetchAll(PDO::FETCH_ASSOC);
            if (!empty($ediciones)) {
                $anio_sel = $ediciones[0]['anio'];
                $edicion_sel = $ediciones[0]['edicion'];
            }
        }
    } catch (Exception $e) {
        $mensaje = "<div class='alert alert-danger'>Error: " . htmlspecialchars($e->getMessage()) . "</div>";
    }
}

// Agregar alumno
if (isset($_POST['agregar_alumno'])) {
    try {
        $stmt = $pdo->prepare('INSERT INTO alumnos (nombre, apellidos, email, programa, observaciones, activo, anio, edicion) VALUES (?, ?, ?, ?, ?, 1, ?, ?)');
        $stmt->execute([
            $_POST['nombre'],
            $_POST['apellidos'],
            $_POST['email'],
            $_POST['programa'] ?? '',
            $_POST['observaciones'] ?? '',
            $_POST['anio'],
            $_POST['edicion']
        ]);
        $mensaje = "<div class='alert alert-success'>✓ Alumno agregado correctamente</div>";
        $anio_sel = $_POST['anio'];
        $edicion_sel = $_POST['edicion'];
        
        // Refrescar ediciones
        $ediciones = $pdo->query('SELECT DISTINCT anio, edicion FROM alumnos ORDER BY anio DESC, edicion DESC')->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        $mensaje = "<div class='alert alert-danger'>Error al agregar alumno: " . htmlspecialchars($e->getMessage()) . "</div>";
    }
}

// Cambiar estado
if (isset($_GET['accion']) && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $accion = $_GET['accion'];
    
    try {
        switch ($accion) {
            case 'activar':
                $pdo->prepare('UPDATE alumnos SET activo = 1 WHERE id = ?')->execute([$id]);
                $mensaje = "<div class='alert alert-success'>✓ Alumno activado</div>";
                break;
            case 'desactivar':
                $pdo->prepare('UPDATE alumnos SET activo = 0 WHERE id = ?')->execute([$id]);
                $mensaje = "<div class='alert alert-success'>✓ Alumno desactivado</div>";
                break;
            case 'superado':
                $pdo->prepare('UPDATE alumnos SET calificacion = "superado" WHERE id = ?')->execute([$id]);
                $mensaje = "<div class='alert alert-success'>✓ Calificación: Superado</div>";
                break;
            case 'no_superado':
                $pdo->prepare('UPDATE alumnos SET calificacion = "no_superado" WHERE id = ?')->execute([$id]);
                $mensaje = "<div class='alert alert-success'>✓ Calificación: No superado</div>";
                break;
            case 'pendiente':
                $pdo->prepare('UPDATE alumnos SET calificacion = NULL WHERE id = ?')->execute([$id]);
                $mensaje = "<div class='alert alert-success'>✓ Calificación: Pendiente</div>";
                break;
            case 'eliminar':
                $pdo->prepare('DELETE FROM alumnos WHERE id = ?')->execute([$id]);
                $mensaje = "<div class='alert alert-success'>✓ Alumno eliminado</div>";
                break;
        }
    } catch (Exception $e) {
        $mensaje = "<div class='alert alert-danger'>Error: " . htmlspecialchars($e->getMessage()) . "</div>";
    }
}

// Descargar CSV
if (isset($_GET['descargar'])) {
    $stmt = $pdo->prepare('SELECT nombre, apellidos, email, programa, calificacion FROM alumnos WHERE anio = ? AND edicion = ? AND calificacion = "superado" ORDER BY apellidos, nombre');
    $stmt->execute([$anio_sel, $edicion_sel]);
    $superados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="alumnos_superados_' . $anio_sel . '_ed' . $edicion_sel . '.csv"');
    
    $output = fopen('php://output', 'w');
    fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF)); // BOM UTF-8
    fputcsv($output, ['Nombre', 'Apellidos', 'Email', 'Programa', 'Calificación'], ';');
    
    foreach ($superados as $a) {
        fputcsv($output, [
            $a['nombre'],
            $a['apellidos'],
            $a['email'],
            $a['programa'],
            'Superado'
        ], ';');
    }
    
    fclose($output);
    exit;
}

// ========== ESTADÍSTICAS ==========

$stmt = $pdo->prepare('SELECT COUNT(*) FROM alumnos WHERE anio = ? AND edicion = ?');
$stmt->execute([$anio_sel, $edicion_sel]);
$total = $stmt->fetchColumn();

$stmt = $pdo->prepare('SELECT COUNT(*) FROM alumnos WHERE anio = ? AND edicion = ? AND activo = 1');
$stmt->execute([$anio_sel, $edicion_sel]);
$activos = $stmt->fetchColumn();

$stmt = $pdo->prepare('SELECT COUNT(*) FROM alumnos WHERE anio = ? AND edicion = ? AND calificacion = "superado"');
$stmt->execute([$anio_sel, $edicion_sel]);
$superados = $stmt->fetchColumn();

$stmt = $pdo->prepare('SELECT COUNT(*) FROM alumnos WHERE anio = ? AND edicion = ? AND calificacion = "no_superado"');
$stmt->execute([$anio_sel, $edicion_sel]);
$no_superados = $stmt->fetchColumn();

$pendientes = $total - $superados - $no_superados;

// ========== LISTA DE ALUMNOS ==========

$mostrar_todos = isset($_GET['todos']);
$stmt = $pdo->prepare('SELECT * FROM alumnos WHERE anio = ? AND edicion = ? ' . ($mostrar_todos ? '' : 'AND activo = 1') . ' ORDER BY apellidos, nombre');
$stmt->execute([$anio_sel, $edicion_sel]);
$alumnos = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<?php echo $mensaje; ?>

<h1>👨‍🎓 Gestión de alumnos</h1>

<!-- Selector de edición con combo box -->
<div class="selector-edicion" style="display: flex; gap: 1rem; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap;">
    <div style="display: flex; align-items: center; gap: 0.5rem;">
        <label for="sel_edicion" style="margin: 0; white-space: nowrap;">📅 Edición:</label>
        <select id="sel_edicion" onchange="cambiarEdicion(this.value)" style="padding: 0.5rem; font-size: 1rem; border-radius: 4px; border: 1px solid #ddd; min-width: 200px;">
            <?php foreach ($ediciones as $ed): ?>
                <option value="<?php echo $ed['anio'] . '-' . $ed['edicion']; ?>" 
                        <?php echo ($ed['anio'] == $anio_sel && $ed['edicion'] == $edicion_sel) ? 'selected' : ''; ?>>
                    <?php echo $ed['nombre'] ?: ($ed['anio'] . ' - Edición ' . $ed['edicion']); ?>
                    <?php echo $ed['archivado'] ? ' (archivada)' : ''; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    
    <button onclick="document.getElementById('panel-nueva-edicion').style.display='block';" class="btn btn-success btn-sm">➕ Nueva edición</button>
    
    <?php 
    // Obtener info de la edición actual
    $ed_actual = $pdo->prepare('SELECT * FROM ediciones WHERE anio = ? AND edicion = ?');
    $ed_actual->execute([$anio_sel, $edicion_sel]);
    $ed_info = $ed_actual->fetch(PDO::FETCH_ASSOC);
    ?>
    
    <?php if ($ed_info && !$ed_info['archivado']): ?>
        <a href="alumnos.php?k=<?php echo htmlspecialchars($clave); ?>&archivar=1&archivar_anio=<?php echo $anio_sel; ?>&archivar_ed=<?php echo $edicion_sel; ?>" 
           class="btn btn-secondary btn-sm" onclick="return confirm('¿Archivar esta edición? No aparecerá en el selector normal.')">📦 Archivar</a>
    <?php elseif ($ed_info && $ed_info['archivado']): ?>
        <a href="alumnos.php?k=<?php echo htmlspecialchars($clave); ?>&desarchivar=1&desarchivar_anio=<?php echo $anio_sel; ?>&desarchivar_ed=<?php echo $edicion_sel; ?>" 
           class="btn btn-info btn-sm">📤 Desarchivar</a>
    <?php endif; ?>
    
    <?php if ($ed_info): ?>
        <button onclick="document.getElementById('panel-editar-edicion').style.display='block';" class="btn btn-warning btn-sm">✏️ Editar edición</button>
        <a href="alumnos.php?k=<?php echo htmlspecialchars($clave); ?>&eliminar_edicion=<?php echo $ed_info['id']; ?>" 
           class="btn btn-danger btn-sm" onclick="return confirm('¿ELIMINAR esta edición y TODOS sus alumnos? Esta acción no se puede deshacer.')">🗑️ Eliminar</a>
    <?php endif; ?>
    
    <?php if ($ver_archivados): ?>
        <a href="alumnos.php?k=<?php echo htmlspecialchars($clave); ?>" class="btn btn-warning btn-sm">Ocultar archivadas</a>
    <?php else: ?>
        <a href="alumnos.php?k=<?php echo htmlspecialchars($clave); ?>&archivados=1" class="btn btn-secondary btn-sm">👁️ Ver archivadas</a>
    <?php endif; ?>
</div>

<script>
function cambiarEdicion(valor) {
    var partes = valor.split('-');
    window.location.href = 'alumnos.php?k=<?php echo htmlspecialchars($clave); ?>&anio=' + partes[0] + '&edicion=' + partes[1] + '<?php echo $ver_archivados ? "&archivados=1" : ""; ?>';
}
</script>

<!-- Panel editar edición -->
<?php if ($ed_info): ?>
<div id="panel-editar-edicion" class="panel" style="display: none; background: #fff3cd;">
    <h3>✏️ Editar edición</h3>
    <form method="post" action="alumnos.php?k=<?php echo htmlspecialchars($clave); ?>">
        <input type="hidden" name="edit_id" value="<?php echo $ed_info['id']; ?>">
        <input type="hidden" name="old_anio" value="<?php echo $ed_info['anio']; ?>">
        <input type="hidden" name="old_edicion" value="<?php echo $ed_info['edicion']; ?>">
        <div class="panel-grid" style="max-width: 600px;">
            <div class="form-group">
                <label for="edit_anio">Año *</label>
                <input type="number" id="edit_anio" name="edit_anio" value="<?php echo $ed_info['anio']; ?>" required min="2020" max="2050">
            </div>
            <div class="form-group">
                <label for="edit_edicion">Nº Edición *</label>
                <input type="number" id="edit_edicion" name="edit_edicion" value="<?php echo $ed_info['edicion']; ?>" required min="1" max="10">
            </div>
            <div class="form-group" style="grid-column: span 2;">
                <label for="edit_nombre">Nombre</label>
                <input type="text" id="edit_nombre" name="edit_nombre" value="<?php echo htmlspecialchars($ed_info['nombre']); ?>">
            </div>
        </div>
        <button type="submit" name="editar_edicion" class="btn btn-warning">Guardar cambios</button>
        <button type="button" onclick="document.getElementById('panel-editar-edicion').style.display='none';" class="btn btn-secondary">Cancelar</button>
    </form>
</div>
<?php endif; ?>

<!-- Panel crear nueva edición -->
<?php 
// Calcular valores por defecto para nueva edición
$anio_actual = date('Y');
$ultima_ed_anio = $pdo->prepare('SELECT MAX(edicion) FROM ediciones WHERE anio = ?');
$ultima_ed_anio->execute([$anio_actual]);
$ultima_edicion = $ultima_ed_anio->fetchColumn() ?: 0;
$nueva_edicion_num = $ultima_edicion + 1;
?>
<div id="panel-nueva-edicion" class="panel" style="display: none; background: #e8f4f8;">
    <h3>➕ Crear nueva edición</h3>
    <form method="post" action="alumnos.php?k=<?php echo htmlspecialchars($clave); ?>">
        <div style="display: flex; gap: 1rem; align-items: end;">
            <div class="form-group" style="margin-bottom: 0;">
                <label for="nuevo_anio">Año</label>
                <input type="number" id="nuevo_anio" name="nuevo_anio" value="<?php echo $anio_actual; ?>" required min="2020" max="2050" style="width: 100px;">
            </div>
            <div class="form-group" style="margin-bottom: 0;">
                <label for="nueva_edicion">Nº Edición</label>
                <input type="number" id="nueva_edicion" name="nueva_edicion" value="<?php echo $nueva_edicion_num; ?>" required min="1" max="10" style="width: 80px;">
            </div>
            <button type="submit" name="crear_edicion" class="btn btn-success">Crear</button>
            <button type="button" onclick="document.getElementById('panel-nueva-edicion').style.display='none';" class="btn btn-secondary">Cancelar</button>
        </div>
        <p style="margin-top: 0.5rem; color: #666; font-size: 0.9rem;">Se creará como: <strong>Edición <span id="preview_ed"><?php echo $nueva_edicion_num; ?></span> - <span id="preview_anio"><?php echo $anio_actual; ?></span></strong></p>
    </form>
    <script>
    document.getElementById('nuevo_anio').addEventListener('input', function() { document.getElementById('preview_anio').textContent = this.value; });
    document.getElementById('nueva_edicion').addEventListener('input', function() { document.getElementById('preview_ed').textContent = this.value; });
    </script>
</div>

<!-- Estadísticas -->
<div class="stats">
    <div class="stat-box">
        <div class="numero"><?php echo $total; ?></div>
        <div class="texto">Total</div>
    </div>
    <div class="stat-box">
        <div class="numero"><?php echo $activos; ?></div>
        <div class="texto">Activos</div>
    </div>
    <div class="stat-box">
        <div class="numero" style="color: #28a745;"><?php echo $superados; ?></div>
        <div class="texto">Superados</div>
    </div>
    <div class="stat-box">
        <div class="numero" style="color: #dc3545;"><?php echo $no_superados; ?></div>
        <div class="texto">No superados</div>
    </div>
    <div class="stat-box">
        <div class="numero" style="color: #ffc107;"><?php echo $pendientes; ?></div>
        <div class="texto">Pendientes</div>
    </div>
</div>

<!-- Acciones principales -->
<div style="margin-bottom: 1.5rem;">
    <a href="correos.php?k=<?php echo htmlspecialchars($clave); ?>" class="btn btn-primary">📧 Enviar correos</a>
    <button onclick="document.getElementById('panel-agregar').style.display='block';" class="btn btn-success">➕ Agregar alumno</button>
    <a href="importar.php?k=<?php echo htmlspecialchars($clave); ?>" class="btn btn-info">📤 Importar Excel</a>
    <?php if ($mostrar_todos): ?>
        <a href="alumnos.php?k=<?php echo htmlspecialchars($clave); ?>&anio=<?php echo $anio_sel; ?>&edicion=<?php echo $edicion_sel; ?>" class="btn btn-secondary">Mostrar solo activos</a>
    <?php else: ?>
        <a href="alumnos.php?k=<?php echo htmlspecialchars($clave); ?>&anio=<?php echo $anio_sel; ?>&edicion=<?php echo $edicion_sel; ?>&todos=1" class="btn btn-warning">Mostrar todos</a>
    <?php endif; ?>
    <?php if ($superados > 0): ?>
        <a href="alumnos.php?k=<?php echo htmlspecialchars($clave); ?>&anio=<?php echo $anio_sel; ?>&edicion=<?php echo $edicion_sel; ?>&descargar=1" class="btn btn-info">📥 Descargar superados (CSV)</a>
    <?php endif; ?>
</div>

<!-- Panel agregar alumno (oculto por defecto) -->
<div id="panel-agregar" class="panel" style="display: none;">
    <h3>➕ Agregar nuevo alumno</h3>
    <form method="post" action="alumnos.php">
        <input type="hidden" name="k" value="<?php echo htmlspecialchars($clave); ?>">
        <div class="panel-grid">
            <div class="form-group">
                <label for="nombre">Nombre *</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="apellidos">Apellidos *</label>
                <input type="text" id="apellidos" name="apellidos" required>
            </div>
            <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="programa">Programa de doctorado</label>
                <input type="text" id="programa" name="programa">
            </div>
            <div class="form-group">
                <label for="anio">Año *</label>
                <input type="number" id="anio" name="anio" value="<?php echo $anio_sel; ?>" required min="2020" max="2050">
            </div>
            <div class="form-group">
                <label for="edicion">Edición *</label>
                <input type="number" id="edicion_input" name="edicion" value="<?php echo $edicion_sel; ?>" required min="1" max="10">
            </div>
        </div>
        <div class="form-group">
            <label for="observaciones">Observaciones</label>
            <textarea id="observaciones" name="observaciones" rows="2"></textarea>
        </div>
        <button type="submit" name="agregar_alumno" class="btn btn-success">Agregar</button>
        <button type="button" onclick="document.getElementById('panel-agregar').style.display='none';" class="btn btn-secondary">Cancelar</button>
    </form>
</div>

<!-- Tabla de alumnos -->
<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Programa</th>
            <th>Estado</th>
            <th>Calificación</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
    <?php if (empty($alumnos)): ?>
        <tr><td colspan="7" style="text-align:center; padding:2rem; color:#666;">No hay alumnos en esta edición</td></tr>
    <?php else: ?>
        <?php $n = 1; foreach ($alumnos as $a): ?>
        <tr>
            <td><?php echo $n++; ?></td>
            <td><strong><?php echo htmlspecialchars($a['apellidos'] . ', ' . $a['nombre']); ?></strong></td>
            <td><a href="mailto:<?php echo htmlspecialchars($a['email']); ?>" class="email-link"><?php echo htmlspecialchars($a['email']); ?></a></td>
            <td style="font-size:0.85rem; max-width:200px;"><?php echo htmlspecialchars($a['programa'] ?? '-'); ?></td>
            <td>
                <?php if ($a['activo']): ?>
                    <span class="badge badge-success">Activo</span>
                <?php else: ?>
                    <span class="badge badge-danger">Inactivo</span>
                <?php endif; ?>
            </td>
            <td>
                <?php 
                switch ($a['calificacion']) {
                    case 'superado':
                        echo '<span class="badge badge-success">✓ Superado</span>';
                        break;
                    case 'no_superado':
                        echo '<span class="badge badge-danger">✗ No superado</span>';
                        break;
                    default:
                        echo '<span class="badge badge-warning">⏳ Pendiente</span>';
                }
                ?>
            </td>
            <td>
                <div class="acciones">
                    <!-- Calificación -->
                    <?php if ($a['calificacion'] !== 'superado'): ?>
                        <a href="alumnos.php?k=<?php echo htmlspecialchars($clave); ?>&anio=<?php echo $anio_sel; ?>&edicion=<?php echo $edicion_sel; ?>&accion=superado&id=<?php echo $a['id']; ?><?php echo $mostrar_todos ? '&todos=1' : ''; ?>" 
                           class="btn btn-sm btn-success" title="Marcar como superado">✓</a>
                    <?php endif; ?>
                    <?php if ($a['calificacion'] !== 'no_superado'): ?>
                        <a href="alumnos.php?k=<?php echo htmlspecialchars($clave); ?>&anio=<?php echo $anio_sel; ?>&edicion=<?php echo $edicion_sel; ?>&accion=no_superado&id=<?php echo $a['id']; ?><?php echo $mostrar_todos ? '&todos=1' : ''; ?>" 
                           class="btn btn-sm btn-danger" title="Marcar como no superado">✗</a>
                    <?php endif; ?>
                    <?php if ($a['calificacion'] !== null): ?>
                        <a href="alumnos.php?k=<?php echo htmlspecialchars($clave); ?>&anio=<?php echo $anio_sel; ?>&edicion=<?php echo $edicion_sel; ?>&accion=pendiente&id=<?php echo $a['id']; ?><?php echo $mostrar_todos ? '&todos=1' : ''; ?>" 
                           class="btn btn-sm btn-warning" title="Marcar como pendiente">⏳</a>
                    <?php endif; ?>
                    
                    <!-- Estado -->
                    <?php if ($a['activo']): ?>
                        <a href="alumnos.php?k=<?php echo htmlspecialchars($clave); ?>&anio=<?php echo $anio_sel; ?>&edicion=<?php echo $edicion_sel; ?>&accion=desactivar&id=<?php echo $a['id']; ?><?php echo $mostrar_todos ? '&todos=1' : ''; ?>" 
                           class="btn btn-sm btn-secondary" title="Desactivar">🚫</a>
                    <?php else: ?>
                        <a href="alumnos.php?k=<?php echo htmlspecialchars($clave); ?>&anio=<?php echo $anio_sel; ?>&edicion=<?php echo $edicion_sel; ?>&accion=activar&id=<?php echo $a['id']; ?><?php echo $mostrar_todos ? '&todos=1' : ''; ?>" 
                           class="btn btn-sm btn-success" title="Activar">✓</a>
                    <?php endif; ?>
                    
                    <!-- Eliminar -->
                    <a href="alumnos.php?k=<?php echo htmlspecialchars($clave); ?>&anio=<?php echo $anio_sel; ?>&edicion=<?php echo $edicion_sel; ?>&accion=eliminar&id=<?php echo $a['id']; ?><?php echo $mostrar_todos ? '&todos=1' : ''; ?>" 
                       class="btn btn-sm btn-danger" title="Eliminar" onclick="return confirm('¿Eliminar permanentemente a este alumno?')">🗑️</a>
                </div>
            </td>
        </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>

<hr style="margin: 2rem 0;">
<p style="color: #666; font-size: 0.9rem;">
    <strong>Leyenda acciones:</strong> 
    ✓ Superado | ✗ No superado | ⏳ Pendiente | 🚫 Desactivar | 🗑️ Eliminar
</p>

    </div>
</body>
</html>
