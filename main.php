<?php

namespace Rin\Entitymanagerprototype;

use PDO;
use PDOException;
use Dotenv;

require 'vendor/autoload.php';
require 'EntityManager.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$dsn = "pgsql:host=localhost;port=5432;dbname=gamedb;";
$username = $_ENV['USERNAME'];
$password = $_ENV['PASSWORD'];

try {
  $pdo = new PDO($dsn, $username, $password, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
  ]);

  echo "Connected successflly.\n";
  $entity = new EntityManager($pdo);
  /* $entity->createEntity("dog", "mammal", ["strength" => 11, "HP" => 56]); */
  /* print_r($entity->getAll()); */
  print_r($entity->getOne(16));
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage() . "\n";
}
