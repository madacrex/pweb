<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Procesar el formulario

    // Validar si se hizo clic en el botón de cerrar sesión
    if (isset($_POST['cerrar_sesion'])) {
        session_destroy();
        header("Location: pagina.php");
        exit();
    }

    // Procesar la imagen
    $imagen = $_FILES['imagen'];

    if ($imagen['error'] == UPLOAD_ERR_OK) {
        $nombre = $_POST['nombre'];
        $precio = $_POST['precio'];
        $stock = $_POST['stock'];

        $imagen_nombre = $imagen['name'];
        $imagen_temp = $imagen['tmp_name'];
        $ruta_imagen = "Imagenes/" . basename($imagen_nombre);

        if (move_uploaded_file($imagen_temp, $ruta_imagen)) {
            // Insertar datos en la base de datos
            $sql = "INSERT INTO productos (NombreProducto, Precio, Stock, imagen) VALUES ('$nombre', $precio, $stock, '$ruta_imagen')";

            if ($conn->query($sql) === TRUE) {
                echo "Producto agregado exitosamente";
            } else {
                echo "Error al agregar el producto: " . $conn->error;
            }
        } else {
            echo "Error al mover el archivo de imagen.";
        }
    } else {
        echo "Error en la carga de la imagen: " . $imagen['error'];
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Alta de Productos</title>
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
        </nav>
        <form method="post" action="">
            <input type="submit" name="cerrar_sesion" value="Cerrar Sesión" class="cerrar_sesion">
        </form>
    </header>

    <section class="form-register">
        <h2>Alta de Productos</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <label for="nombre">Nombre del Producto:</label>
            <input type="text" name="nombre" required><br>

            <label for="precio">Precio:</label>
            <input type="text" name="precio" required><br>

            <label for="stock">Stock:</label>
            <input type="text" name="stock" required><br>

            <label for="imagen">Imagen:</label>
            <input type="file" name="imagen" accept="image/*" required><br>

            <input type="submit" value="Agregar Producto">
        </form>
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
