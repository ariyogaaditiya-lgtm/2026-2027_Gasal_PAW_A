<?php

$host = "localhost";
$port = 3306;
$username = "root";
$password = "";
$database = "databasetp7";

$pdo = new PDO("mysql:host=$host;port=$port;dbname=$database;charset=utf8mb4", $username, $password);