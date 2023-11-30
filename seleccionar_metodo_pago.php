<?php
session_start();

if (isset($_SESSION['email'])) {
    $userLoggedIn = true;
} else {
    $userLoggedIn = false;
}

if (isset($_POST['cerrar_sesion'])) {
    session_destroy();
    header("location: pagina.php");
    exit();
}

$servername = "localhost";
$username = "root";
$passworddb = "";
$dbname = "registro";

$conn = new mysqli($servername, $username, $passworddb, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Selección de Método de Pago</title>
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
                <li><a href="detalle_compra.php">Detalle de Compra</a></li>
        </ul>
        </nav>
        <?php
                // Mostrar botones según el estado de inicio de sesión
                if ($userLoggedIn) {
                    echo '<ul><form method="post" action=""><input type="submit" name="cerrar_sesion" class="cerrar_sesion" value="Cerrar Sesión"></form></ul>';
                } else {
                    echo '<li><a href="signup.php" class="signup-link">Sign Up</a></li>';
                    echo '<li><a href="login.php" class="login-link">Login</a></li>';
                }
                ?>
</header>
    <!-- Contenido de la página de selección de método de pago -->

    <main>
        <h2>Seleccionar Método de Pago</h2>
        <form action="procesar_pago.php" method="post">
            <!-- Información de la tarjeta -->
            <label for="numero_tarjeta">Número de Tarjeta:</label>
            <input type="text" id="numero_tarjeta" name="numero_tarjeta" required>

            <label for="nombre_tarjeta">Nombre en la Tarjeta:</label>
            <input type="text" id="nombre_tarjeta" name="nombre_tarjeta" required>

            <label for="fecha_expiracion">Fecha de Expiración:</label>
            <input type="text" id="fecha_expiracion" name="fecha_expiracion" placeholder="MM/AA" required>

            <label for="codigo_seguridad">Código de Seguridad:</label>
            <input type="text" id="codigo_seguridad" name="codigo_seguridad" required>

            <!-- Información de la dirección de envío -->
            <h3>Dirección de Envío</h3>

            <label for="direccion">Dirección:</label>
            <input type="text" id="direccion" name="direccion" required>

            <label for="ciudad">Ciudad:</label>
            <input type="text" id="ciudad" name="ciudad" required>

            <label for="codigo_postal">Código Postal:</label>
            <input type="text" id="codigo_postal" name="codigo_postal" required>

            <button type="submit">Realizar Pago</button>
        </form>
    </main>

    <footer>
        <div class="social-media">
            <a href="http://www.facebook.com" target="_blank"><img src="logof.png" alt="Facebook"></a>
            <a href="http://www.twitter.com" target="_blank"><img src="x.png" alt="Twitter" class="twitter"></a>
            <a href="http://www.instagram.com" target="_blank"><img src="instagram.png" alt="Instagram"></a>
        </div>
    </footer>

</body>
</html>
