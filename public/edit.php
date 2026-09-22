<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

$app->get('/form', function (Request $request, Response $response, $args) {
  $view = Twig::fromRequest($request);

  return $view->render($response, 'form.html.twig', []);
});

$app->post('/form', function (Request $request, Response $response, $args) use ($entity) {
  $createdId = $entity->createOne($args);

  return $response;
});

