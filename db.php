<?php

$host= "localhost";
$username = "root";
$password ="";

try{

    $pdo = new PDO("mysql:host=$host;dbname=projetBootcamp_db;", $username, $password);

    // $sql = "CREATE TABLE Produits(
    //     id INT AUTO_INCREMENT PRIMARY KEY,
    //     nom VARCHAR (225),
    //     prix DECIMAL (10, 2),
    //     quantite INT
    // )";

    // $pdo->exec($sql);

    // echo "Réussit";

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    echo "Erreur de connexion" . $e->getMessage();
}