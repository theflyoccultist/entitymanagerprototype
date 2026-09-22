<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

$app->get('/characters', function (Request $request, Response $response, $args) use ($entity) {
  $view = Twig::fromRequest($request);

  $characters = $entity->findAll();
  $decodedCharacters = [];
  foreach ($characters as $character) {
    $decodedCharacters[] = json_decode($character['data']);
  }

  return $view->render($response, 'characters.html.twig', [
    'characters' => $decodedCharacters,
  ]);
});

$app->get('/characters/{id}', function (Request $request, Response $response, $args) use ($entity) {
  $view = Twig::fromRequest($request);
  $id = $args['id'];

  $characters = $entity->find($id);
  $decodedCharacter = json_decode($characters['data']);

  return $view->render($response, 'characters.html.twig', [
    'characters' => $decodedCharacter,
  ]);
});

$app->post('/characters', function (Request $request, Response $response, $args) use ($entity) {
  $entity->createOne($args['data']);
});

$app->put('/characters/{id}', function (Request $request, Response $response, $args) use ($entity) {
  $id = $args['id'];

  $entity->updateOne($id, $args['data']);
});

$app->delete('/characters/{id}', function (Request $request, Response $response, $args) use ($entity) {
  $id = $args['id'];

  $entity->deleteOne($id);
});
