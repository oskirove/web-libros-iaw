<?php
session_start();

// Verificar si el usuario inició sesión
if (!isset($_SESSION['nombreUsuario'])) {
    header("Location: inicio_sesion.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "Prueba_123";
$database = "Catálogo";

$message = "";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Función para sanear los datos del formulario
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Chequear si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = test_input($_POST["nombre"]);
    $direccion = test_input($_POST["direccion"]);
    $telefono = test_input($_POST["telefono"]);
    $nifdni = test_input($_POST["nifdni"]);

    // Preparar la sentencia SQL para actualizar los datos
    $stmt = $conn->prepare("UPDATE usuario SET nome=?, direccion=?, telefono=?, nifdni=? WHERE usuario=?");
    $stmt->bind_param("ssiss", $nombre, $direccion, $telefono, $nifdni, $_SESSION['nombreUsuario']);

    // Ejecutar y verificar si fue exitoso
    if ($stmt->execute()) {
        $message = "Datos actualizados con éxito.";
    } else {
        $message = "Error al actualizar los datos: " . $stmt->error;
    }

    $stmt->close();
}

// Obtener los datos del usuario
$sql = "SELECT * FROM usuario WHERE usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $_SESSION['nombreUsuario']);
$stmt->execute();
$result = $stmt->get_result();
$userData = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Datos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #eae0d5;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: #fff;
            padding: 20px;
            width: 30%;
            max-width: 600px;
            border-radius: 40px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin: 10px 0 5px;
        }
        input[type="text"], input[type="number"] {
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 40px;
        }
        input[type="submit"] {
            padding: 15px;
            font-size: 1em;
            background-color: #141414;
            color: #fff;
            border: none;
            border-radius: 40px;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: block;
            width: 100%;
            text-align: center;
            margin: 0 auto;
        }
        input[type="submit"]:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
        .message {
            text-align: center;
            margin: 15px 0;
        }
        a {
            padding: 15px;
            font-size: 1em;
            color: #000;
            border: none;
            cursor: pointer;
            display: block;
            text-align: center;
            margin: 1px auto 0; 
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Modificar Datos</h2>
    <?php if ($message): ?>
        <p class="message"><?= $message; ?></p>
    <?php endif; ?>
    <form method="post" action="modificar_datos.php">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?= $userData['nome'] ?>" required>

        <label for="direccion">Dirección:</label>
        <input type="text" id="direccion" name="direccion" value="<?= $userData['direccion'] ?>" required>

        <label for="telefono">Teléfono:</label>
        <input type="number" id="telefono" name="telefono" value="<?= $userData['telefono'] ?>" required>

        <label for="nifdni">NIF/DNI:</label>
        <input type="text" id="nifdni" name="nifdni" value="<?= $userData['nifdni'] ?>" required>

        <input type="submit" value="Modificar">

        <a href="catalogo.php">Volver</a>

    </form>
</div>

</body>
</html>
