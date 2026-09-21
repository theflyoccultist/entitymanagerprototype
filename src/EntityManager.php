<?php

namespace Rin\Entitymanagerprototype;

use PDO;

class EntityManager
{
  public function __construct(private PDO $pdo) {}

  public function createOne(array $data): int
  {
    $stmt = $this->pdo->prepare("
      INSERT INTO schema.characterinfo (data)
      VALUES (:data)
      RETURNING id
    ");

    $stmt->execute([
      'data' => json_encode($data) // Convert PHP array to JSONB
    ]);

    return $stmt->fetchColumn();
  }

  public function getAll(): array
  {
    $stmt = $this->pdo->query("
      SELECT id, data
      FROM schema.characterinfo
    ");

    $result = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $result[] = [
        "id" => $row['id'],
        "data" => json_decode($row['data'], true)
      ];
    }

    return $result;
  }

  public function getOne(int $id): array
  {
    $stmt = $this->pdo->prepare("
      SELECT data
      FROM schema.characterinfo
      WHERE ID = ?
      ");

    $stmt->execute(array($id));

    return array_map(function ($row) {
      $row['data'] = json_decode($row['data'], true);
      return $row;
    }, $stmt->fetchAll());
  }

  public function updateOne(int $id, array $data)
  {
    $stmt = $this->pdo->prepare("
      UPDATE schema.characterinfo
      SET data = (:data)
      WHERE ID = (:id)
    ");

    $stmt->execute([
      'id' => $id,
      'data' => json_encode($data)
    ]);
  }

  public function deleteOne(int $id)
  {
    $stmt = $this->pdo->prepare("
      DELETE FROM schema.characterinfo
      WHERE ID = (:id)
    ");

    $stmt->execute([
      'id' => $id
    ]);
  }

  // utility function
  // to be used only during testing and development
  public function deleteAll()
  {
    $stmt = $this->pdo->prepare("
      DELETE FROM schema.characterinfo
      ");

    $stmt->execute();
  }
}
