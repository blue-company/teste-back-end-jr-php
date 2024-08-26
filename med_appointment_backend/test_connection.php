<?php

try {
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=blue-backend-test", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexão bem-sucedida!";
} catch (PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
}
?>