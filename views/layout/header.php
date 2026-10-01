<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clinica Health</title>
    <link rel="stylesheet" href="css/global.css">
</head>
<body>

<?php

session_start();

$tipo_usuario = $_SESSION['usuario_tipo'] ?? '';

switch ($tipo_usuario) {
    case 'admin':
        header("Location: menu_admin.php");
        exit();

    case 'medico':
        header("Location: menu_medico.php");
        exit();

    case 'cliente':
        header("Location: menu_logado.php");
        exit();

    default:
        session_destroy();
        header("Location: login.php?erro=acesso_negado");
        exit();
}
