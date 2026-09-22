<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

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
  $character = json_decode($characters['data']);

  return $view->render($response, 'characters.html.twig', [
    'characters' => $character,
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
