<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enviar correos - Curso LaTeX/Overleaf 2026</title>
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
        .form-group {
            margin-bottom: 1.5rem;
        }
        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
            color: #333;
        }
        input[type="text"],
        input[type="password"],
        textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
            box-sizing: border-box;
        }
        textarea {
            min-height: 200px;
            font-family: inherit;
        }
        .checkbox-group {
            background: #fff3cd;
            padding: 1rem;
            border-radius: 4px;
            border: 1px solid #ffc107;
            margin-bottom: 1.5rem;
        }
        .checkbox-group label {
            display: inline;
            font-weight: normal;
        }
        fieldset {
            border: 1px solid #ddd;
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1.5rem;
        }
        legend {
            font-weight: bold;
            padding: 0 0.5rem;
        }
        .radio-option {
            margin: 0.5rem 0;
        }
        .radio-option label {
            display: inline;
            font-weight: normal;
            margin-left: 0.5rem;
        }
        button[type="submit"] {
            background: #007bff;
            color: white;
            padding: 1rem 2rem;
            border: none;
            border-radius: 4px;
            font-size: 1.1rem;
            cursor: pointer;
            transition: background 0.3s;
        }
        button[type="submit"]:hover {
            background: #0056b3;
        }
        .alert {
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1rem;
        }
        .alert-success {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }
        .alert-danger {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }
        .alert-info {
            background: #cce5ff;
            border: 1px solid #b8daff;
            color: #004085;
        }
        .login-form {
            max-width: 400px;
            margin: 4rem auto;
        }
        .correo-enviado {
            padding: 0.25rem 0.5rem;
            background: #d4edda;
            margin: 0.25rem 0;
            border-radius: 4px;
        }
        .lista-alumnos {
            max-height: 200px;
            overflow-y: auto;
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1.5rem;
        }
        .lista-alumnos ul {
            margin: 0;
            padding-left: 1.5rem;
        }
        .volver {
            display: inline-block;
            margin-top: 1rem;
            color: #007bff;
            text-decoration: none;
        }
        .volver:hover {
            text-decoration: underline;
        }
        h1 {
            color: #333;
            border-bottom: 3px solid #007bff;
            padding-bottom: 0.5rem;
        }
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
$clave = $token; // Compatibilidad con enlaces existentes

if (!empty($token) && verificar_acceso($token)) {
    $acceso = true;
}

// Procesar solicitud de acceso
$mensaje_login = '';
$tipo_mensaje = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['solicitar_acceso'])) {
    $email_solicitado = $_POST['email'] ?? '';
    $resultado = solicitar_acceso($email_solicitado, 'correos.php');
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
        
        <form method="post" action="correos.php">
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
} else {
    // Usuario autenticado
    $prueba = false;
    $correo_prueba = "gregor.mendle@gmail.com";
    
    if (isset($_POST['enviar'])) {
        // Procesar envío de correos
        echo "<h1>📧 Enviando correos...</h1>";
        
        if (isset($_POST['correoprueba'])) {
            $prueba = true;
            echo "<div class='alert alert-info'>⚠️ Modo prueba: Todos los correos se enviarán a $correo_prueba</div>";
        }
        
        $destinatarios = $_POST['destinatarios'] ?? 'todos';
        $asunto = "[Curso LaTeX/Overleaf] " . $_POST['asunto'];
        $cuerpo_base = $_POST['cuerpo'];
        
        // Obtener alumnos según selección
        $pdo = conecta();
        
        if ($destinatarios == "todos") {
            $stmt = $pdo->query('SELECT id, nombre, apellidos, email FROM alumnos WHERE activo = 1');
        } elseif ($destinatarios == "programa") {
            $programa = $_POST['programa'] ?? '';
            $stmt = $pdo->prepare('SELECT id, nombre, apellidos, email FROM alumnos WHERE activo = 1 AND programa LIKE ?');
            $stmt->execute(["%$programa%"]);
        } else {
            // Selección individual
            $ids = $_POST['alumnos_sel'] ?? [];
            if (empty($ids)) {
                echo "<div class='alert alert-danger'>No se seleccionaron alumnos</div>";
                $stmt = null;
            } else {
                $placeholders = implode(',', array_fill(0, count($ids), '?'));
                $stmt = $pdo->prepare("SELECT id, nombre, apellidos, email FROM alumnos WHERE id IN ($placeholders)");
                $stmt->execute($ids);
            }
        }
        
        $enviados = 0;
        $errores = 0;
        
        if ($stmt) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $nombre_completo = $row['nombre'] . ' ' . $row['apellidos'];
                $email = $row['email'];
                
                // Personalizar mensaje
                $saludo = "Hola " . $row['nombre'] . ":\n\n";
                $cuerpo = $saludo . $cuerpo_base . "\n\n--\nCurso de LaTeX/Overleaf 2026\nUniversidad de Granada";
                
                $email_destino = $prueba ? $correo_prueba : $email;
                
                if (correo($asunto, $cuerpo, $email_destino)) {
                    echo "<div class='correo-enviado'>✓ Enviado a: $nombre_completo ($email)</div>";
                    $enviados++;
                } else {
                    echo "<div class='alert alert-danger'>✗ Error al enviar a: $nombre_completo ($email)</div>";
                    $errores++;
                }
            }
        }
        
        echo "<div class='alert alert-success'><strong>Resumen:</strong> $enviados correos enviados";
        if ($errores > 0) echo ", $errores errores";
        echo "</div>";
        
        echo "<a href='correos.php?k=$clave' class='volver'>← Volver al formulario</a>";
        
    } else {
        // Mostrar formulario de envío
        $alumnos = obtener_alumnos();
        ?>
        <div style="margin-bottom: 1rem;">
            <a href="alumnos.php?k=<?php echo htmlspecialchars($clave); ?>" class="btn btn-secondary">← Volver a alumnos</a>
        </div>
        
        <h1>📧 Enviar correos a alumnos</h1>
        <p>Curso de LaTeX/Overleaf 2026 - <strong><?php echo count($alumnos); ?></strong> alumnos registrados</p>
        
        <form method="post" action="correos.php?k=<?php echo htmlspecialchars($clave); ?>" onsubmit="return validarFormulario()">
            
            <div class="checkbox-group">
                <input type="checkbox" id="correoprueba" name="correoprueba" value="1">
                <label for="correoprueba">🧪 Modo prueba (enviar solo a <?php echo $correo_prueba; ?>)</label>
            </div>
            
            <fieldset>
                <legend>Destinatarios</legend>
                <div class="radio-option">
                    <input type="radio" id="dest_todos" name="destinatarios" value="todos" checked>
                    <label for="dest_todos">Todos los alumnos (<?php echo count($alumnos); ?>)</label>
                </div>
                <div class="radio-option">
                    <input type="radio" id="dest_seleccion" name="destinatarios" value="seleccion">
                    <label for="dest_seleccion">Selección manual</label>
                </div>
            </fieldset>
            
            <div id="lista-seleccion" class="lista-alumnos" style="display:none;">
                <p><strong>Selecciona los alumnos:</strong></p>
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 0.5rem;">
                <?php foreach ($alumnos as $a): ?>
                    <label style="display: flex; align-items: center; gap: 0.5rem; padding: 0.3rem; cursor: pointer; border-radius: 4px;" 
                           onmouseover="this.style.background='#e9ecef'" onmouseout="this.style.background='transparent'">
                        <input type="checkbox" name="alumnos_sel[]" value="<?php echo $a['id']; ?>" id="al_<?php echo $a['id']; ?>">
                        <span><?php echo htmlspecialchars($a['apellidos'] . ', ' . $a['nombre']); ?></span>
                    </label>
                <?php endforeach; ?>
                </div>
            </div>
            
            <div class="form-group">
                <label for="asunto">Asunto <span style="color:red">*</span></label>
                <input type="text" id="asunto" name="asunto" required placeholder="Ej: Recordatorio clase de mañana">
            </div>
            
            <div class="form-group">
                <label for="cuerpo">Mensaje <span style="color:red">*</span></label>
                <textarea id="cuerpo" name="cuerpo" required placeholder="Escribe aquí el cuerpo del mensaje...

El saludo 'Hola [Nombre]:' se añade automáticamente."></textarea>
            </div>
            
            <button type="submit" name="enviar">📤 Enviar correos</button>
        </form>
        
        <script>
            // Mostrar/ocultar lista de selección
            document.querySelectorAll('input[name="destinatarios"]').forEach(function(radio) {
                radio.addEventListener('change', function() {
                    var lista = document.getElementById('lista-seleccion');
                    lista.style.display = (this.value === 'seleccion') ? 'block' : 'none';
                });
            });
            
            // Validar formulario
            function validarFormulario() {
                var asunto = document.getElementById('asunto').value.trim();
                var cuerpo = document.getElementById('cuerpo').value.trim();
                
                if (asunto === '' || cuerpo === '') {
                    alert('El asunto y el mensaje son obligatorios');
                    return false;
                }
                
                var destSeleccion = document.getElementById('dest_seleccion').checked;
                if (destSeleccion) {
                    var seleccionados = document.querySelectorAll('input[name="alumnos_sel[]"]:checked');
                    if (seleccionados.length === 0) {
                        alert('Selecciona al menos un alumno');
                        return false;
                    }
                }
                
                return confirm('¿Enviar correo a los destinatarios seleccionados?');
            }
        </script>
        <?php
    }
}
?>
    </div>
</body>
</html>
