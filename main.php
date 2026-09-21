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
  /* $entity->createOne( */
  /*   [ */
  /*     "name" => "Murasaki", */
  /*     "class" => "mage", */
  /*     "stats" => [ */
  /*       "strength" => 8, */
  /*       "intelligence" => 17, */
  /*       "agility" => 12 */
  /*     ], */
  /*     "equipment" => [ */
  /*       "staff", */
  /*       "cloak" */
  /*     ] */
  /*   ] */
  /* ); */

  $entity->updateOne(
    7,
    [
      "name" => "Kurata",
      "class" => "mage",
      "stats" => [
        "strength" => 14,
        "intelligence" => 19,
        "agility" => 8
      ],
      "equipment" => [
        "shiso",
        "shamisen"
      ]
    ]
  );

  print_r($entity->getAll());
  /* print_r($entity->getOne(7)); */
  /* $entity->deleteOne(16); */
}
