<?php

namespace Rin\Entitymanagerprototype;

use PDO;
use PDOException;
use Dotenv;

require 'vendor/autoload.php';
require 'src/EntityManager.php';

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

  basicCRUD($entity);
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage() . "\n";
}

function basicCRUD(EntityManager $entity)
{
  $entity->createOne(
    [
      "profile" => [
        "name" => "Goofy",
        "species" => "Dog",
        "age" => 58,
        "location" => [
          "country" => "USA",
          "city" => "Kentucky"
        ]
      ],
      "preferences" => [
        "favorite food" => "Burgers",
        "least favorite food" => "Hot Dogs"
      ]
    ]
  );
  print_r($entity->getAll());

  $entity->updateOne(
    1,
    [
      "profile" => [
        "name" => "Pwat",
        "species" => "Cat",
        "age" => 11,
        "location" => [
          "country" => "South Korea",
          "city" => "Busan"
        ]
      ],
      "preferences" => [
        "favorite food" => "Kimbap",
        "least favorite food" => "None"
      ]
    ]
  );

  print_r($entity->getOne(1));
  /* $entity->deleteOne(16); */
  /* print_r($entity->getOne(16)); */
}
