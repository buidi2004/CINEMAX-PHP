<?php
namespace App\Models\Repository\Implementations;

use App\Models\Repository\Interfaces\IRoomRepository;
use App\Models\Domain\Room;
use PDO;

class RoomRepository implements IRoomRepository
{
    public function __construct(private readonly PDO $pdo) {}

    public function getAll(): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM rooms ORDER BY id DESC');
        $stmt->execute();
        $rows = $stmt->fetchAll();
        return array_map(fn($row) => Room::fromArray($row), $rows);
    }

    public function findById(int $id): ?Room
    {
        $stmt = $this->pdo->prepare('SELECT * FROM rooms WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ? Room::fromArray($row) : null;
    }

    public function create(array $data): int
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO rooms (name, total_rows, seats_per_row) VALUES (:name, :total_rows, :seats_per_row)'
        );
        $stmt->execute($data);
        return (int) $this->pdo->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $setParts = [];
        foreach (array_keys($data) as $key) {
            $setParts[] = "$key = :$key";
        }
        $setClause = implode(', ', $setParts);
        
        $sql = "UPDATE rooms SET $setClause WHERE id = :id";
        $data[':id'] = $id;
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
        return $stmt->rowCount() > 0;
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM rooms WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->rowCount() > 0;
    }
}
