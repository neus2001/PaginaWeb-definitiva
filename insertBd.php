<?php

// Obtener los datos del formulario y escaparlos para evitar inyección SQL
$nombre = htmlspecialchars($_POST['nombre']);
$email = htmlspecialchars($_POST['email']);
$password = htmlspecialchars($_POST['password']);

// Establecer la conexión con la base de datos
$servername = "localhost";
$username = "root";
$password_db = "";
$database = "paginaweb";

$conn = new mysqli($servername, $username, $password_db, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Insertar el usuario en la base de datos de forma segura utilizando consultas preparadas
$sql = "INSERT INTO usuarios (NOMBRE, CORREO, PASSWORD) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $nombre, $email, $password_hash); // Bind de los parámetros y hash de la contraseña
$password_hash = password_hash($password, PASSWORD_DEFAULT); // Hash de la contraseña
if ($stmt->execute()) {
    echo '<script>alert("Registrado correctamente");</script>'; // Mover la impresión del alert aquí
    echo "Usuario insertado correctamente"; // Esto no se mostrará porque ya se redireccionó
    header("Location: ./HTML/menu.html"); // Luego de imprimir el alert, redirigir al usuario
    
} else {
    echo "Error al insertar usuario: " . $stmt->error;
}

// Cerrar la conexión
$stmt->close();
$conn->close();
?>
