<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta tu repositorio - Curso LaTeX/Git</title>
    <link rel="icon" type="image/svg+xml" href="favicon.svg">
    <link rel="stylesheet" href="style.css">
    <style>
        .container {
            max-width: 700px;
            margin: 3rem auto;
            padding: 2.5rem;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            border-bottom: 3px solid #007bff;
            padding-bottom: 0.5rem;
            margin-bottom: 1.5rem;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
            color: #555;
        }
        input[type="text"] {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #ddd;
            border-radius: 6px;
            font-size: 1rem;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }
        input[type="text"]:focus {
            outline: none;
            border-color: #007bff;
        }
        button {
            background: #007bff;
            color: white;
            padding: 0.75rem 2rem;
            border: none;
            border-radius: 6px;
            font-size: 1.1rem;
            cursor: pointer;
            transition: background 0.3s;
        }
        button:hover {
            background: #0056b3;
        }
        .resultado {
            margin-top: 2rem;
            padding: 1.5rem;
            border-radius: 8px;
            font-size: 1.1rem;
        }
        .exito {
            background: #d4edda;
            border: 2px solid #28a745;
            color: #155724;
        }
        .exito .icono {
            font-size: 3rem;
            text-align: center;
            margin-bottom: 1rem;
        }
        .error {
            background: #f8d7da;
            border: 2px solid #dc3545;
            color: #721c24;
        }
        .error .icono {
            font-size: 3rem;
            text-align: center;
            margin-bottom: 1rem;
        }
        .info {
            background: #e7f5ff;
            border: 1px solid #74c0fc;
            padding: 1rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
        }
        .repo-link {
            margin-top: 1rem;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 6px;
            word-break: break-all;
        }
        .repo-link a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }
        .repo-link a:hover {
            text-decoration: underline;
        }
        .volver {
            display: inline-block;
            margin-top: 1.5rem;
            color: #6c757d;
            text-decoration: none;
            font-size: 0.9rem;
        }
        .volver:hover {
            color: #007bff;
            text-decoration: underline;
        }
        .ejemplo {
            font-size: 0.85rem;
            color: #666;
            margin-top: 0.25rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 Consulta tu repositorio</h1>
        
        <?php
        require_once "funciones.php";
        
        $buscar = false;
        $resultado = null;
        $usuario_github = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['consultar'])) {
            $buscar = true;
            $usuario_github = trim($_POST['usuario_github']);
            
            if (!empty($usuario_github)) {
                $pdo = conecta();
                
                // Buscar en repositorios que contengan el usuario de GitHub
                // Buscamos tanto github.com/usuario como github.com/usuario/
                $stmt = $pdo->prepare('
                    SELECT nombre, apellidos, email, repositorio 
                    FROM alumnos 
                    WHERE activo = 1 
                    AND repositorio IS NOT NULL 
                    AND repositorio != ""
                    AND (
                        repositorio LIKE ? 
                        OR repositorio LIKE ?
                    )
                    LIMIT 1
                ');
                
                $patron1 = '%github.com/' . $usuario_github . '/%';
                $patron2 = '%github.com/' . $usuario_github;
                
                $stmt->execute([$patron1, $patron2]);
                $alumno = $stmt->fetch(PDO::FETCH_ASSOC);
                
                $resultado = [
                    'encontrado' => $alumno !== false,
                    'alumno' => $alumno,
                    'usuario' => $usuario_github
                ];
            }
        }
        ?>
        
        <?php if (!$buscar): ?>
        <div class="info">
            <strong>ℹ️ ¿Para qué sirve esta página?</strong>
            <p style="margin: 0.5rem 0 0 0;">
                Introduce tu nombre de usuario de GitHub para verificar si has compartido correctamente 
                tu repositorio del curso. Si aparece como compartido, ¡ya está todo listo!
            </p>
        </div>
        <?php endif; ?>
        
        <form method="post" action="consulta-repo.php">
            <div class="form-group">
                <label for="usuario_github">Tu usuario de GitHub</label>
                <input 
                    type="text" 
                    id="usuario_github" 
                    name="usuario_github" 
                    placeholder="Ej: juanperez" 
                    value="<?php echo htmlspecialchars($usuario_github); ?>"
                    required 
                    autofocus
                >
                <div class="ejemplo">
                    Introduce solo tu nombre de usuario, no la URL completa<br>
                    <strong>Ejemplo:</strong> Si tu repositorio es https://github.com/<strong>juanperez</strong>/mi-proyecto, introduce solo <strong>juanperez</strong>
                </div>
            </div>
            
            <button type="submit" name="consultar">🔍 Consultar</button>
        </form>
        
        <?php if ($buscar): ?>
            <?php if ($resultado['encontrado']): ?>
                <div class="resultado exito">
                    <div class="icono">✅</div>
                    <div style="text-align: center;">
                        <strong>¡Repositorio compartido correctamente!</strong>
                    </div>
                    <p style="margin-top: 1rem; margin-bottom: 0;">
                        Hola <strong><?php echo htmlspecialchars($resultado['alumno']['nombre']); ?></strong>, 
                        tu repositorio está registrado en el sistema del curso.
                    </p>
                    
                    <div class="repo-link">
                        <strong>📌 Tu repositorio:</strong><br>
                        <a href="<?php echo htmlspecialchars($resultado['alumno']['repositorio']); ?>" target="_blank">
                            <?php echo htmlspecialchars($resultado['alumno']['repositorio']); ?>
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <div class="resultado error">
                    <div class="icono">❌</div>
                    <div style="text-align: center;">
                        <strong>Repositorio no encontrado</strong>
                    </div>
                    <p style="margin-top: 1rem; margin-bottom: 0;">
                        No se encontró ningún repositorio compartido para el usuario 
                        <strong><?php echo htmlspecialchars($resultado['usuario']); ?></strong>.
                    </p>
                    <div style="margin-top: 1rem; padding: 1rem; background: rgba(255,255,255,0.3); border-radius: 6px;">
                        <strong>Posibles razones:</strong>
                        <ul style="margin: 0.5rem 0 0 1.5rem; text-align: left;">
                            <li>No has compartido tu repositorio con el profesor aún</li>
                            <li>El nombre de usuario no coincide con el registrado</li>
                            <li>Escribiste mal tu nombre de usuario de GitHub</li>
                        </ul>
                        <p style="margin: 1rem 0 0 0;">
                            <strong>¿Qué hacer?</strong> Verifica que hayas compartido tu repositorio y que 
                            el usuario de GitHub sea correcto. Si el problema persiste, contacta con el profesor.
                        </p>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
        
        <a href="index.html" class="volver">← Volver al inicio del curso</a>
    </div>
</body>
</html>
