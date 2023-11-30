<?php
session_start();

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "con_db.php"; // Reemplaza por el nombre de tu archivo de conexión

    $email = $_POST["email"];
    $password = $_POST["contrasena"];

    // Obtener el hash de la contraseña desde la base de datos
    $stmt = $conn->prepare("SELECT email, password_hashed FROM datos WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($db_email, $db_password_hashed);
    $stmt->fetch();
    $stmt->close();

    // Verificar si el correo electrónico existe y la contraseña es válida
    if ($db_email && password_verify($password, $db_password_hashed)) {
        $_SESSION["email"] = $email;
        header("Location: pagina.php"); // Redirigir a la página después del inicio de sesión
        exit();
    } else {
        $mensaje_error = "Credenciales incorrectas";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
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
        </ul>
    </header>

    <section class="form-register">
        <h2>Iniciar Sesión</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="email" name="email" placeholder="Correo Electrónico" required><br>
            <input type="password" name="contrasena" placeholder="Contraseña" required><br>
            <input type="submit" value="Iniciar Sesión">
        </form>
        <?php if (isset($mensaje_error)) { echo '<p class="mensaje-error">' . $mensaje_error . '</p>'; } ?>
        <p>¿Aún no tienes cuenta? <a href="signup.php">Regístrate aquí</a></p>
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