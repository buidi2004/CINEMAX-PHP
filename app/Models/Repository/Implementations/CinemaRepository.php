<?php
namespace App\Models\Repository\Implementations;

use App\Models\Repository\Interfaces\ICinemaRepository;
use App\Models\Domain\Cinema;
use App\Models\Domain\Room;
use PDO;

class CinemaRepository implements ICinemaRepository
{
    public function __construct(private readonly PDO $pdo) {}
    
    public function findAll(?string $province = null): array
    {
        $sql = 'SELECT * FROM cinemas WHERE is_active = TRUE';
        $params = [];
        
        if ($province) {
            $sql .= ' AND province = ?';
            $params[] = $province;
        }
        
        $sql .= ' ORDER BY province, name';
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        $rows = $stmt->fetchAll();
        
        return array_map(fn($row) => Cinema::fromArray($row), $rows);
    }
    
    public function findNearest(float $lat, float $lng, int $limit = 3): array
    {
        $sql = "
            SELECT *,
            ( 6371 * acos( cos( radians(:lat) ) * cos( radians( latitude ) ) 
            * cos( radians( longitude ) - radians(:lng) ) + sin( radians(:lat) ) 
            * sin( radians( latitude ) ) ) ) AS distance
            FROM cinemas
            WHERE is_active = TRUE AND latitude IS NOT NULL AND longitude IS NOT NULL
            ORDER BY distance
            LIMIT :limit
        ";
        
        $stmt = $this->pdo->prepare($sql);
        // PDO bindParam is needed for LIMIT integer
        $stmt->bindValue(':lat', $lat);
        $stmt->bindValue(':lng', $lng);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        $rows = $stmt->fetchAll();
        return array_map(fn($row) => Cinema::fromArray($row), $rows);
    }
    
    public function findById(int $id): ?Cinema
    {
        $stmt = $this->pdo->prepare('SELECT * FROM cinemas WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        
        return $row ? Cinema::fromArray($row) : null;
    }
    
    public function findBySlug(string $slug): ?Cinema
    {
        $stmt = $this->pdo->prepare('SELECT * FROM cinemas WHERE slug = ?');
        $stmt->execute([$slug]);
        $row = $stmt->fetch();
        
        return $row ? Cinema::fromArray($row) : null;
    }
    
    public function getAllProvinces(): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT DISTINCT province FROM cinemas 
             WHERE is_active = TRUE 
             ORDER BY province'
        );
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
    
    public function getRoomsByCinema(int $cinemaId): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM rooms WHERE cinema_id = ? ORDER BY name'
        );
        $stmt->execute([$cinemaId]);
        $rows = $stmt->fetchAll();
        
        return array_map(fn($row) => Room::fromArray($row), $rows);
    }
    
    public function create(array $data): int
    {
        // Convert facilities array to PostgreSQL array format
        if (isset($data['facilities']) && is_array($data['facilities'])) {
            $data['facilities'] = '{' . implode(',', $data['facilities']) . '}';
        }
        
        $stmt = $this->pdo->prepare(
            'INSERT INTO cinemas (name, slug, province, district, address, phone, email, 
             latitude, longitude, image_url, opening_hours, description, facilities, is_active)
             VALUES (:name, :slug, :province, :district, :address, :phone, :email,
             :latitude, :longitude, :image_url, :opening_hours, :description, :facilities, :is_active)
             RETURNING id'
        );
        
        $stmt->execute($data);
        return (int) $stmt->fetchColumn();
    }
    
    public function update(int $id, array $data): bool
    {
        // Convert facilities array to PostgreSQL array format
        if (isset($data['facilities']) && is_array($data['facilities'])) {
            $data['facilities'] = '{' . implode(',', $data['facilities']) . '}';
        }
        
        // Build dynamic UPDATE query
        $fields = [];
        foreach (array_keys($data) as $key) {
            $fields[] = "$key = :$key";
        }
        
        $sql = 'UPDATE cinemas SET ' . implode(', ', $fields) . ' WHERE id = :id';
        $data['id'] = $id;
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
        
        return $stmt->rowCount() > 0;
    }
    
    public function softDelete(int $id): bool
    {
        $stmt = $this->pdo->prepare('UPDATE cinemas SET is_active = FALSE WHERE id = ?');
        $stmt->execute([$id]);
        
        return $stmt->rowCount() > 0;
    }
    
    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM cinemas WHERE id = ?');
        $stmt->execute([$id]);
        
        return $stmt->rowCount() > 0;
    }
}
