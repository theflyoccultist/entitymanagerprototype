<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

$app->get('/form', function (Request $request, Response $response, $args) {
  $view = Twig::fromRequest($request);

  return $view->render($response, 'form.html.twig', []);
});

$app->get('/form/{id}', function (Request $request, Response $response, $args) use ($entity) {
  $view = Twig::fromRequest($request);
  $id = $args['id'];

  $characters = $entity->find($id);
  $decodedCharacter = json_decode($characters['data']);

  return $view->render($response, 'formedit.html.twig', [
    'characters' => $decodedCharacter,
  ]);
});


$app->post('/form', function (Request $request, Response $response, $args) use ($entity) {
  $data = [
    "name" => htmlspecialchars($_POST['name']),
    "class" => htmlspecialchars($_POST['class']),
    "stats" => ["agility" => htmlspecialchars($_POST['agility']), 
                "strength" => htmlspecialchars($_POST['strength']), 
                "intelligence" => htmlspecialchars($_POST['intelligence'])],
    "equipment" => array_map('htmlspecialchars', $_POST['equipment'])
  ];

  $entity->createOne($data);
  
  return $response->withStatus(302)->withHeader('Location', 'characters');
});
