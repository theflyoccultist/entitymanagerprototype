<?php

namespace Rin\Entitymanagerprototype;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Dotenv;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/Database.php';
require __DIR__ . '/../src/EntityManager.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$dsn = "pgsql:host=localhost;port=5432;dbname=gamedb;";
$username = $_ENV['USERNAME'];
$password = $_ENV['PASSWORD'];

$pdo = DBConnect($dsn, $username, $password);
$entity = new EntityManager($pdo);

// basicCRUD function will be deleted soon
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

  print_r($entity->findAll());
  /* print_r($entity->find(7)); */
  /* print_r($entity->getOne(7)); */
  /* $entity->deleteOne(16); */
}

$app = AppFactory::create();

$app->get('/characters/', function (Request $request, Response $response, $args) use ($entity) {
  $characters = $entity->findAll();

  $response->getBody()->write(
    json_encode($characters)
  );

  return $response
    ->withHeader('Content-Type', 'application/json');
});

$app->get('/characters/{id}', function (Request $request, Response $response, $args) use ($entity) {
  $id = $args['id'];

  $character = $entity->find($id);

  $response->getBody()->write(
    json_encode($character)
  );

  return $response
    ->withHeader('Content-Type', 'application/json');
});

$app->run();
