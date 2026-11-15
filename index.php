
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Biblioteca García Sevilla</title>

<style>
body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: #f1f0fa;
    color: #333;
}

header {
    background: #625a9c;
    color: white;
    padding: 30px 15px;
    text-align: center;
}

header h1 {
    margin: 0;
    font-size: 28px;
}

.contenedor {
    max-width: 420px;
    margin: 45px auto;
    padding: 25px;
    background: white;
    border-radius: 15px;
    text-align: center;
    box-shadow: 0 4px 15px #0002;
}

input {
    width: 90%;
    padding: 13px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 8px;
}

button {
    background: #625a9c;
    color: white;
    border: none;
    padding: 13px;
    width: 100%;
    border-radius: 8px;
    font-size: 16px;
}

footer {
    text-align: center;
    color: #777;
    margin-top: 30px;
}
</style>
</head>

<body>

<header>
    <h1>📚 Biblioteca García Sevilla</h1>
    <p>Sistema de gestión bibliotecaria</p>
</header>

<div class="contenedor">
    <h2>Bienvenido</h2>
    <p>Inicia sesión para ingresar al sistema</p>

    <form action="validar.php" method="POST">
        <input type="text" name="matricula"
        placeholder="Número de matrícula" required>

        <input type="password" name="password"
        placeholder="Contraseña" required>

        <button type="submit">Iniciar sesión</button>
    </form>
</div>

<footer>
    Biblioteca García Sevilla © 2026
</footer>

</body>
</html>
