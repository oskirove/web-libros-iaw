<?php
// Configuración de la base de datos
$servername = "localhost";
$username = "root";
$password = "Prueba_123";
$dbname = "Catálogo";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$message = ""; // Variable para almacenar mensajes

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $new_username = $_POST["new_username"];
    $new_password = $_POST["new_password"];
    $new_name = $_POST["new_name"]; 
    $new_telefono = $_POST["new_telefono"];
    $new_direccion = isset($_POST["new_direccion"]) ? $_POST["new_direccion"] : "";
    $new_nifdni = $_POST["new_nifdni"];

    $sql = "SELECT * FROM usuario WHERE usuario = '$new_username'";
    $result = $conn->query($sql);

    if ($result === false) {
        $message = "Error en la consulta: " . $conn->error;
    } elseif ($result->num_rows > 0) {
        $message = "El nombre de usuario ya está en uso. Por favor, elige otro.";
    } else {
        // Si el usuario no existe, insertar el nuevo usuario en la base de datos
        $insert_sql = "INSERT INTO usuario (usuario, contrasinal, nome, direccion, telefono, nifdni) VALUES ('$new_username', '$new_password', '$new_name', '$new_direccion', '$new_telefono', '$new_nifdni')";        
        if ($conn->query($insert_sql) === TRUE) {
            $message = "Registro exitoso. ¡Bienvenido!";
        } else {
            $message = "Error al registrar el usuario: " . $conn->error;
        }
    }
}

// Cerrar la conexión a la base de datos
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #eae0d5;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        header {
            background-color: #141414;
            color: #fff;
            padding: 1em;
            text-align: center;
        }

        header img {
            max-width: 200px;
            height: auto;
            display: block;
            margin: 0 auto;
            filter: brightness(0) invert(1);
        }

        main {
            flex: 1;
            max-width: 400px;
            margin: 50px auto;
            padding: 70px;
            background-color: #fff;
            border-radius: 40px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            text-align: center;
            padding-top: 30px;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        input {
            padding: 10px;
            margin-bottom: 20px;
            width: 100%;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 20px;
        }

        button {
            font-size: 15px;
            padding: 15px;
            background-color: #141414;
            color: #fff;
            border: none;
            cursor: pointer;
            border-radius: 40px;
            width: 100%;
            margin-bottom: 10px;
        }

        button:hover {
            background-color: #eae0d5;
            color: #0a0908;
        }

        footer {
            background-color: #141414;
            color: #fff;
            padding: 2em;
            text-align: center;
            margin-top: auto;
        }
    </style>
</head>

<body>

    <header>
        <img src="/imagenes/BookPlanet.png" alt="Logo de Planeta del libro">
    </header>

    <main>
        <h1>Registro</h1>
        <?php echo $message; ?>
        <form action="registro.php" method="POST">
            <input type="text" id="new_username" name="new_username" placeholder="Nuevo Nombre de Usuario" required>

            <input type="password" id="new_password" name="new_password" placeholder="Nueva Contraseña" required>

            <input type="text" id="new_name" name="new_name" placeholder="Nombre" required>

            <input type="text" id="new_direccion" name="new_direccion" placeholder="Dirección">

            <input type="text" id="new_telefono" name="new_telefono" placeholder="Teléfono">

            <input type="text" id="new_nifdni" name="new_nifdni" placeholder="NIF/DNI">

            <button type="submit">Registrarse</button>
            
            <button type="button" onclick="window.location.href='inicio_sesion.php'">Iniciar Sesión</button>
        </form>
    </main>

    <footer>
    </footer>

</body>

</html>
