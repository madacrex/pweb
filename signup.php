<?php
session_start();

require_once "con_db.php"; // Asegúrate de poner el nombre correcto de tu archivo de conexión

if (isset($_SESSION['email'])) {
    $userLoggedIn = true;
} else {
    $userLoggedIn = false;
}

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $email = $_POST["email"];
    $contrasena = $_POST["contrasena"];

    // Verificar si el correo electrónico ya está registrado
    $stmt = $conn->prepare("SELECT id FROM datos WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->close();
        $conn->close();
        $mensaje_error = "El correo electrónico ya está registrado. Inicia sesión o utiliza otro correo.";
    } else {
        // Insertar el nuevo usuario en la base de datos
        $contrasena_hashed = password_hash($contrasena, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO datos (nombre, email, fecha_reg, password_hashed) VALUES (?, ?, NOW(), ?)");
        $stmt->bind_param("sss", $nombre, $email, $contrasena_hashed);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $_SESSION["email"] = $email;
            header("Location: pagina.php"); // Redirigir a la página después del registro
            exit();
        } else {
            $mensaje_error = "Error al registrar el usuario. Intenta nuevamente.";
        }

        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Procesar Registro</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
        <div class="logo">
            <img src="tu_logo.png" alt="Logo de la Página">
        </div>
        <nav>
        <ul>
                <li><a href="pagina.php">Home</a></li>
                <li><a href="quienes_somos.php">Quienes Somos</a></li>
                <li><a href="alta_productos.php">Alta de Productos</a></li>
                <li><a href="mostrar_tabla.php">Tabla de Productos</a></li>
                <?php
                // Mostrar botones según el estado de inicio de sesión
                if ($userLoggedIn) {
                    echo '<li><form method="post" action=""><input type="submit" name="cerrar_sesion" value="Cerrar Sesión"></form></li>';
                } else {
                    echo '<li><a href="signup.php" class="signup-link">Sign Up</a></li>';
                    echo '<li><a href="login.php" class="login-link">Login</a></li>';
                }
                ?>
        </ul>
    </header>

    <section class="form-register">
        <h2>Registro de Usuario</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" required><br>
            <label for="email">Correo Electrónico:</label>
            <input type="email" name="email" required><br>
            <label for="contrasena">Contraseña:</label>
            <input type="password" name="contrasena" required><br>
            <input type="submit" value="Registrar Usuario">
        </form>
        <?php if (isset($mensaje_error)) { echo '<p class="mensaje-error">' . $mensaje_error . '</p>'; } ?>
    </section>

    <!-- Otro contenido de la página -->

    <footer>
        <div class="social-media">
            <a href="http://www.facebook.com" target="_blank"><img src="logof.png" alt="Facebook"></a>
            <a href="http://www.twitter.com" target="_blank"><img src="x.png" alt="Twitter" class="twitter"></a>
            <a href="http://www.instagram.com" target="_blank"><img src="instagram.png" alt="Instagram"></a>
        </div>
    </footer>
</body>
</html>
