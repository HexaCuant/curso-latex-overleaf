<?php
/**
 * Funciones auxiliares para el curso de LaTeX/Overleaf
 * 
 * Incluye conexión a base de datos SQLite y envío de correos
 */

require_once __DIR__ . '/PHPMailer/PHPMailer.php';
require_once __DIR__ . '/PHPMailer/SMTP.php';
require_once __DIR__ . '/PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

/**
 * Conecta a la base de datos SQLite de alumnos
 * @return PDO Conexión a la base de datos
 */
function conecta() {
    $dbPath = __DIR__ . '/alumnos.db';
    if (!file_exists($dbPath)) {
        die("Error: No se encuentra la base de datos de alumnos");
    }
    $conn = new PDO('sqlite:' . $dbPath);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $conn;
}

/**
 * Envía un correo electrónico usando PHPMailer
 * @param string $asunto Asunto del correo
 * @param string $cuerpo Cuerpo del mensaje
 * @param string $destinatario Email del destinatario
 * @return bool True si se envió correctamente
 */
function correo($asunto, $cuerpo, $destinatario) {
    date_default_timezone_set('Europe/Madrid');
    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->SMTPDebug  = 0;
        $mail->SMTPAuth   = true;
        $mail->Host       = "smtp.ugr.es";
        $mail->Port       = 587;
        
        // Credenciales - CAMBIAR por las del curso
        $mail->Username   = "mburgos@ugr.es";  // TODO: Configurar usuario SMTP
        $mail->Password   = "ugrctu_32AA"; // TODO: Configurar contraseña SMTP

        $mail->CharSet = 'UTF-8';
        $mail->setFrom('mburgos@ugr.es', 'Curso LaTeX/Overleaf');
        $mail->addReplyTo('mburgos@go.ugr.es', 'Manuel Burgos');  // Respuestas van aquí
        $mail->Subject = $asunto;
        $mail->Body = $cuerpo;
        $mail->addAddress($destinatario);

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Error enviando correo: " . $mail->ErrorInfo);
        return false;
    }
}

/**
 * Email autorizado para acceso
 */
define('EMAIL_AUTORIZADO', 'mburgos@go.ugr.es');

/**
 * Verifica el acceso mediante token temporal
 * @param string $token Token proporcionado
 * @return bool True si el token es válido
 */
function verificar_acceso($token) {
    if (empty($token)) return false;
    
    $pdo = conecta();
    
    // Buscar token válido (no usado y no expirado)
    $stmt = $pdo->prepare('SELECT * FROM tokens_acceso WHERE token = ? AND usado = 0 AND expira > datetime("now")');
    $stmt->execute([$token]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($row) {
        // Marcar como usado (opcional: comentar para permitir múltiples usos hasta expirar)
        // $pdo->prepare('UPDATE tokens_acceso SET usado = 1 WHERE id = ?')->execute([$row['id']]);
        return true;
    }
    
    return false;
}

/**
 * Genera un token de acceso y lo envía por email
 * @param string $email Email del solicitante
 * @param string $pagina_destino Página a la que redirigir (default: alumnos.php)
 * @return array ['ok' => bool, 'mensaje' => string]
 */
function solicitar_acceso($email, $pagina_destino = 'alumnos.php') {
    // Simular proceso para cualquier email (honeypot)
    sleep(2); // Delay para simular envío
    
    // Solo procesar si es el email autorizado
    if (strtolower(trim($email)) !== EMAIL_AUTORIZADO) {
        // No revelar que el email no es válido
        return ['ok' => true, 'mensaje' => 'Si el correo está registrado, recibirás un enlace de acceso.'];
    }
    
    $pdo = conecta();
    
    // Generar token fuerte
    $token = bin2hex(random_bytes(32)); // 64 caracteres hex
    
    // Expiración: 1 hora
    $expira = date('Y-m-d H:i:s', strtotime('+1 hour'));
    
    // Guardar en base de datos
    $stmt = $pdo->prepare('INSERT INTO tokens_acceso (token, email, expira) VALUES (?, ?, ?)');
    $stmt->execute([$token, $email, $expira]);
    
    // Construir enlace (el token funciona para cualquier página)
    $base_url = 'https://a105.ugr.es/overleaf/'; // Ajustar según dominio
    $enlace = $base_url . $pagina_destino . '?k=' . $token;
    
    // Enviar correo
    $asunto = '[Curso LaTeX] Enlace de acceso';
    $cuerpo = "Hola,\n\n";
    $cuerpo .= "Has solicitado acceso al panel de administración del curso de LaTeX.\n\n";
    $cuerpo .= "Haz clic en el siguiente enlace para acceder:\n";
    $cuerpo .= $enlace . "\n\n";
    $cuerpo .= "Este enlace expira en 1 hora.\n\n";
    $cuerpo .= "Si no has solicitado este acceso, ignora este mensaje.\n\n";
    $cuerpo .= "--\nCurso de LaTeX/Overleaf\nUniversidad de Granada";
    
    if (correo($asunto, $cuerpo, $email)) {
        return ['ok' => true, 'mensaje' => 'Si el correo está registrado, recibirás un enlace de acceso.'];
    } else {
        return ['ok' => false, 'mensaje' => 'Error al procesar la solicitud. Inténtalo más tarde.'];
    }
}

/**
 * Limpia tokens expirados
 */
function limpiar_tokens_expirados() {
    $pdo = conecta();
    $pdo->exec('DELETE FROM tokens_acceso WHERE expira < datetime("now")');
}

/**
 * Obtiene todos los alumnos activos
 * @return array Lista de alumnos
 */
function obtener_alumnos() {
    $pdo = conecta();
    $stmt = $pdo->query('SELECT id, nombre, apellidos, email, programa, repositorio FROM alumnos WHERE activo = 1 ORDER BY apellidos, nombre');
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Obtiene un alumno por su ID
 * @param int $id ID del alumno
 * @return array|false Datos del alumno o false si no existe
 */
function obtener_alumno($id) {
    $pdo = conecta();
    $stmt = $pdo->prepare('SELECT * FROM alumnos WHERE id = ? AND activo = 1');
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
