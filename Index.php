<?php
session_start(); // Iniciar sesión al principio del archivo
include 'conexion/conexion.php'; // Incluir la conexión a la base de datos

$error = ""; // Variable para almacenar mensajes de error

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['correo']) && isset($_POST['password'])) {
    $correo = $_POST['correo'];
    $pass = $_POST['password'];

    // Buscar al usuario por su correo
    $sql = "SELECT * FROM docentes WHERE correo = :correo";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':correo', $correo);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar la contraseña
        if (password_verify($pass, $row['password'])) {
            // Almacenar datos en la sesión
            $_SESSION['usuario_id'] = $row['id'];
            $_SESSION['correo'] = $correo;
            $_SESSION['rol'] = $row['rol'];

            // Redirigir según el rol
            if ($row['rol'] == 'administrador') {
                header("Location: administrador/admin/admin_dashboard.php");
            } else {
                header("Location: docente/docente.php");
            }
            exit();
        } else {
            $error = "Correo o contraseña incorrectos.";
        }
    } else {
        $error = "Correo o contraseña incorrectos.";
    }
}
?>


<!-- HTML para mostrar el formulario de inicio de sesión -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>   
    /* Estilos CSS */
        body {
            font-family: sans-serif;
            background-color: #e9f1fb;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 170vh;
            text-align: center;
            background: url('imagenes/tic.png') no-repeat center center/cover;
            background-attachment: fixed;
            backdrop-filter: blur(4px); /* Efecto de desenfoque */
            margin: 0;
        }
        .login-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 100%;
            margin: 20px;
        }
        .error-message {
            color: red;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .logo {
            max-width: 100%;
            height: auto;
        }

        @media (max-width: 768px) {
            body {
                background-size: cover;
                justify-content: center;
                align-items: center;
            }
            .login-container {
                margin: 0 20px;
            }
        }
        
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="login-container">
        <img src="imagenes/logocarrera.jpeg" alt="Logo Carrera" class="logo mb-4">
            <h2 class="mb-4">Sistema de Gestión de Tutorías</h2>


            <!-- Formulario de inicio de sesión -->
            <form action="index.php" method="POST">
                <div class="mb-3">
                    <label for="correo" class="form-label">Correo:</label>
                    <div class="input-group">
                        <span class="input-group-text">👤</span>
                        <input type="email" class="form-control" id="correo" name="correo" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña:</label>
                    <div class="input-group">
                        <span class="input-group-text">🔒</span>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                   
                </div>
                <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
            </form>

            <div class="mt-3">
                <a href="solicita_cuenta/solicitar_cuenta.php">Solicitar una cuenta o cambiar contraseña</a>
            </div>
            <br>
            <br>
            <footer>
                <p>Copyright © 2025 UNESUM - Tecnologias de la Informacion.</p>
            </footer>
        </div>
    </div>
<script>
    function togglePassword() {
        const passwordField = document.getElementById("password");
        passwordField.type = passwordField.type === "password" ? "text" : "password";
    }
</script>

    
</body>
</html>