
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Menú Principal</title>

<style>
body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: #f1f0fa;
}

header {
    background: #625a9c;
    color: white;
    text-align: center;
    padding: 25px;
}

h1 {
    margin: 0;
}

.contenedor {
    max-width: 650px;
    margin: 30px auto;
    padding: 20px;
}

h2 {
    color: #48417d;
    text-align: center;
}

.menu {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
}

.menu a {
    background: white;
    color: #48417d;
    text-decoration: none;
    padding: 25px 10px;
    border-radius: 12px;
    text-align: center;
    font-size: 17px;
    box-shadow: 0 3px 10px #0002;
}

.menu a:hover {
    background: #dedafa;
}

.volver {
    display: block;
    text-align: center;
    margin: 25px;
    color: #625a9c;
}
</style>
</head>

<body>

<header>
    <h1>📚 Biblioteca García Sevilla</h1>
    <p>Menú principal</p>
</header>

<div class="contenedor">

    <h2>Bienvenido al sistema</h2>

    <div class="menu">
        <a href="libros.php">📚<br>Libros</a>
        <a href="autores.php">✍️<br>Autores</a>
        <a href="editoriales.php">🏢<br>Editoriales</a>
        <a href="usuarios.php">👥<br>Usuarios</a>
        <a href="prestamos.php">📖<br>Préstamos</a>
        <a href="consultas.php">🔍<br>Consultas</a>
    </div>

    <a class="volver" href="index.php">
        Cerrar sesión
    </a>

</div>

</body>
</html>
