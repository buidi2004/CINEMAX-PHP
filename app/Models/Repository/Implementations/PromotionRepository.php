<?php
namespace App\Models\Repository\Implementations;

use App\Models\Repository\Interfaces\IPromotionRepository;
use App\Models\Domain\Promotion;
use PDO;

class PromotionRepository implements IPromotionRepository
{
    public function __construct(private readonly PDO $pdo) {}

    public function findByCode(string $code): ?Promotion
    {
        $stmt = $this->pdo->prepare('SELECT * FROM promotions WHERE code = ?');
        $stmt->execute([$code]);
        $row = $stmt->fetch();
        if (!$row) return null;

        $promo = new Promotion();
        $promo->id = $row['id'];
        $promo->code = $row['code'];
        $promo->discountType = $row['discount_type'];
        $promo->discountValue = (float)$row['discount_value'];
        $promo->maxUses = $row['max_uses'] !== null ? (int)$row['max_uses'] : null;
        $promo->usedCount = (int)$row['used_count'];
        $promo->expiresAt = $row['expires_at'];
        $promo->isActive = (bool)$row['is_active'];

        return $promo;
    }

    public function incrementUsedCount(string $code): void
    {
        $stmt = $this->pdo->prepare(
            'UPDATE promotions SET used_count = used_count + 1 WHERE code = ?'
        );
        $stmt->execute([$code]);
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM promotions ORDER BY expires_at DESC');
        $rows = $stmt->fetchAll();
        
        $promotions = [];
        foreach ($rows as $row) {
            $promo = new Promotion();
            $promo->id = $row['id'];
            $promo->code = $row['code'];
            $promo->discountType = $row['discount_type'];
            $promo->discountValue = (float)$row['discount_value'];
            $promo->maxUses = $row['max_uses'] !== null ? (int)$row['max_uses'] : null;
            $promo->usedCount = (int)$row['used_count'];
            $promo->expiresAt = $row['expires_at'];
            $promo->isActive = (bool)$row['is_active'];
            $promotions[] = $promo;
        }
        
        return $promotions;
    }

    public function findById(int $id): ?Promotion
    {
        $stmt = $this->pdo->prepare('SELECT * FROM promotions WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        if (!$row) return null;

        $promo = new Promotion();
        $promo->id = $row['id'];
        $promo->code = $row['code'];
        $promo->discountType = $row['discount_type'];
        $promo->discountValue = (float)$row['discount_value'];
        $promo->maxUses = $row['max_uses'] !== null ? (int)$row['max_uses'] : null;
        $promo->usedCount = (int)$row['used_count'];
        $promo->expiresAt = $row['expires_at'];
        $promo->isActive = (bool)$row['is_active'];

        return $promo;
    }

    public function create(array $data): int
    {
        $stmt = $this->pdo->prepare('
            INSERT INTO promotions (code, discount_type, discount_value, max_uses, expires_at, description, is_active)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ');
        
        $stmt->execute([
            strtoupper($data['code']),
            $data['discount_type'] ?? 'percentage',
            $data['discount_value'],
            $data['usage_limit'] ?? null,
            $data['valid_to'] ?? null,
            $data['description'] ?? '',
            $data['is_active'] ?? true
        ]);
        
        return (int)$this->pdo->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->pdo->prepare('
            UPDATE promotions 
            SET code = ?, discount_type = ?, discount_value = ?, max_uses = ?, 
                expires_at = ?, description = ?, is_active = ?
            WHERE id = ?
        ');
        
        return $stmt->execute([
            strtoupper($data['code']),
            $data['discount_type'] ?? 'percentage',
            $data['discount_value'],
            $data['usage_limit'] ?? null,
            $data['valid_to'] ?? null,
            $data['description'] ?? '',
            $data['is_active'] ?? true,
            $id
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM promotions WHERE id = ?');
        return $stmt->execute([$id]);
    }
}
