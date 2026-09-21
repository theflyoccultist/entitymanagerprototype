<?php

namespace Rin\Entitymanagerprototype;

use PDO;
use PDOException;

require __DIR__ . '/../vendor/autoload.php';

function DBConnect(string $dsn, string $username, string $password): ?PDO
{
  try {
    $pdo = new PDO($dsn, $username, $password, [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    return $pdo;
  } catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage() . "\n";
    return null;
  }
}
