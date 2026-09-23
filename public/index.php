<?php

namespace Rin\Entitymanagerprototype;

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

// basicCRUD function used for debug
function basicCRUD(EntityManager $entity)
{
  /* $entity->updateOne( */
  /*   7, */
  /*   [ */
  /*     "name" => "Kurata", */
  /*     "class" => "mage", */
  /*     "stats" => [ */
  /*       "strength" => 14, */
  /*       "intelligence" => 19, */
  /*       "agility" => 8 */
  /*     ], */
  /*     "equipment" => [ */
  /*       "shiso", */
  /*       "shamisen" */
  /*     ] */
  /*   ] */
  /* ); */

  print_r($entity->findAll());
  /* print_r($entity->find(7)); */
  /* print_r($entity->getOne(7)); */
  /* $entity->deleteOne(16); */
}

/* basicCRUD($entity); */

$app = AppFactory::create();

$twig = Twig::create(__DIR__ . '/../templates', ['cache' => false]);

$app->add(TwigMiddleware::create($app, $twig));

$app->addRoutingMiddleware();

/**
 * Add Error Middleware
 *
 * @param bool                  $displayErrorDetails -> Should be set to false in production
 * @param bool                  $logErrors -> Parameter is passed to the default ErrorHandler
 * @param bool                  $logErrorDetails -> Display error details in error log
 * @param LoggerInterface|null  $logger -> Optional PSR-3 Logger  
 *
 * Note: This middleware should be added last. It will not handle any exceptions/errors
 * for middleware added after it.
 */
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

require 'characters.php';
require 'edit.php';

$app->run();
