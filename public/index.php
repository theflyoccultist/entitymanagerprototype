<?php

namespace Rin\Entitymanagerprototype;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
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

$twig = Twig::create(__DIR__ . '/../templates', ['cache' => false]);

$app->add(TwigMiddleware::create($app, $twig));

$app->get('/characters', function (Request $request, Response $response, $args) use ($entity) {
  $view = Twig::fromRequest($request);

  $characters = $entity->findAll();
  $json_array = [];
  foreach ($characters as $character) {
    $json_array[] = json_decode($character['data']);
  }

  return $view->render($response, 'characters.html.twig', [
    'characters' => $json_array,
  ]);
});

$app->get('/characters/{id}', function (Request $request, Response $response, $args) use ($entity) {
  $view = Twig::fromRequest($request);
  $id = $args['id'];

  $characters = $entity->find($id);
  $json_array = json_decode($characters['data']);

  return $view->render($response, 'characters.html.twig', [
    'characters' => $json_array,
  ]);
});

$app->post('/characters', function (Request $request, Response $response, $args) use ($entity) {
  $createdId = $entity->createOne($args['data']);

  $response->getBody()->write(
    json_encode($createdId)
  );

  return $response
    ->withHeader('Content-Type', 'application/json');
});

$app->put('/characters/{id}', function (Request $request, Response $response, $args) use ($entity) {
  $id = $args['id'];

  $entity->updateOne($id, $args['data']);
});

$app->delete('/characters/{id}', function (Request $request, Response $response, $args) use ($entity) {
  $id = $args['id'];

  $entity->deleteOne($id);
});

$app->run();
