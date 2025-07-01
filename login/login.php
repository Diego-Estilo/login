<?php
session_start();

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "login"; 

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$error = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = isset($_POST['usuario']) ? $conn->real_escape_string($_POST['usuario']) : '';
    $contraseña = isset($_POST['contraseña']) ? $conn->real_escape_string($_POST['contraseña']) : '';

    if ($usuario !== "" && $contraseña !== "") {
        
        $sql = "SELECT * FROM login WHERE usuario='$usuario' AND contraseña='$contraseña'";
        $result = $conn->query($sql);

        if ($result && $result->num_rows === 1) {
            $_SESSION['usuario'] = $usuario;
            header("Location: menu.html");
            exit();
        } else {
            $error = "Usuario o contraseña incorrectos.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>IPSA</title>
    <link rel="stylesheet" type="text/css" href="ligin.css">
</head>
<body>
    <div class="login-container">
        <h2>Iniciar sesión en formularios IPSA</h2>
        <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <form method="post" action="">
            Usuario: <input type="text" name="usuario" required><br>
            Contraseña: <input type="password" name="contraseña" required><br>
            <input type="submit" value="Iniciar sesión">
        </form>
    </div>
</body>
</html>