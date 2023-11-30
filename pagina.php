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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Tu Página</title>
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
        <div class="cart-button">
            <button class="cart-icon" onclick="showCart()">🛒</button>
            <span id="cart-count">0</span>
        </div>
    </header>
    <main>
    <?php
if ($result->num_rows > 0) {
    // Mostrar los productos en tu página
    while($row = $result->fetch_assoc()) {
        echo "<div class='producto'>";
        echo "<img src='" . $row['imagen'] . "' alt='" . $row['NombreProducto'] . "'>";
        echo "<h3>" . $row['NombreProducto'] . "</h3>";
        echo "<p>Precio: $" . $row['Precio'] . "</p>";
        echo "<p>Stock: " . $row['Stock'] . "</p>";
        echo "<button onclick='addToCart(\"" . $row['NombreProducto'] . "\", " . $row['Precio'] . ")'>Agregar al carrito</button>";
        echo "</div>";
    }
} else {
    echo "No hay productos en la base de datos.";
}
$conn->close();
?>
    </main>
    
    <script>
        function addToCart(productName, price, stock) {
            if (stock > 0) {
                // Implementa la lógica para agregar al carrito
                alert('Agregado al carrito: ' + productName + ' - $' + price.toFixed(2));
            } else {
                alert('El producto "' + productName + '" está agotado.');
            }
        }
    </script>

    
    <footer>
        <div class="social-media">
            <a href="http://www.facebook.com" target="_blank"><img src="logof.png" alt="Facebook"></a>
            <a href="http://www.twitter.com" target="_blank"><img src="x.png" alt="Twitter" class="twitter"></a>
            <a href="http://www.instagram.com" target="_blank"><img src="instagram.png" alt="Instagram" class="instagram"></a>
        </div>
    </footer>

    <div id="cart-modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeCartModal()">&times;</span>
            <h2>Carrito de Compras</h2>
            <ul id="cart-items-list"></ul>
            <p>Total: $<span id="cart-total">0</span></p>
            <button onclick="continueToPayment()">Continuar</button>
        </div>
    </div>

    <script src="script.js"></script>

</body>
</html>
