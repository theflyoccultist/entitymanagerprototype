<?php

namespace Rin\Entitymanagerprototype;

use PDO;

class EntityManager
{
  public function __construct(private PDO $pdo) {}

  public function createEntity(string $name, string $type, array $components): int
  {
    $stmt = $this->pdo->prepare("
      INSERT INTO schema.entities (name, type, components)
      VALUES (:name, :type, :components)
      RETURNING id
    ");

    $stmt->execute([
      'name' => $name,
      'type' => $type,
      'components' => json_encode($components) // Convert PHP array to JSONB
    ]);

    return $stmt->fetchColumn();
  }

  public function getAll(): array
  {
    $stmt = $this->pdo->query("
      SELECT id, name, type, components
      FROM schema.entities
    ");

    $result = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $result[] = [
        "id" => $row['id'],
        "name" => $row['name'],
        "type" => $row['type'],
        "components" => json_decode($row['components'], true)
      ];
    }

    return $result;
  }

  public function getOne(int $id): array
  {
    $stmt = $this->pdo->prepare("
      SELECT name, type, components
      FROM schema.entities
      WHERE ID = ?
      ");

    $stmt->execute(array($id));

    return array_map(function ($row) {
      $row['components'] = json_decode($row['components'], true);
      return $row;
    }, $stmt->fetchAll());
  }

  public function updateOne(int $id, string $name, string $type, array $components)
  {
    $stmt = $this->pdo->prepare("
      UPDATE schema.entities
      SET name = (:name), 
          type = (:type), 
          components = (:components)
      WHERE ID = (:id)
    ");

    $stmt->execute([
      'id' => $id,
      'name' => $name,
      'type' => $type,
      'components' => json_encode($components)
    ]);
  }
}
