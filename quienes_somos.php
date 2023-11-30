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

// Consulta para obtener productos desde la base de datos
$sql = "SELECT * FROM productos";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Quiénes Somos</title>
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
                <li><a href="quienes_somos.php">Quiénes Somos</a></li>
                <li><a href="alta_productos.php">Alta de Productos</a></li>
                <li><a href="mostrar_tabla.php">Tabla de Productos</a></li>
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

    <section class="quienes-somos-content">
        <h2>Quiénes Somos</h2>
        <p>Somos [Nombre de la Empresa], tu destino definitivo para la belleza y la expresión personal. Nos especializamos en ofrecer una amplia gama de productos de maquillaje de alta calidad, diseñados para resaltar tu singularidad y realzar tu confianza. En [Nombre de la Empresa], fusionamos la innovación con la pasión, brindándote no solo productos excepcionales, sino también una experiencia que celebra la diversidad y fomenta la creatividad. Descubre un mundo de colores vibrantes, texturas lujosas y resultados impactantes mientras te unes a nosotros en el emocionante viaje de explorar y expresar tu auténtica belleza.</p>
        <!-- Agrega más contenido sobre tu empresa aquí -->
    </section>

    <footer>
        <div class="social-media">
            <a href="http://www.facebook.com" target="_blank"><img src="logof.png" alt="Facebook"></a>
            <a href="http://www.twitter.com" target="_blank"><img src="x.png" alt="Twitter" class="twitter"></a>
            <a href="http://www.instagram.com" target="_blank"><img src="instagram.png" alt="Instagram"></a>
        </div>
    </footer>
</body>
</html>
