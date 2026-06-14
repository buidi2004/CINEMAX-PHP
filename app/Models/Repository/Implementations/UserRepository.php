<?php
namespace App\Models\Repository\Implementations;

use App\Models\Repository\Interfaces\IUserRepository;
use App\Models\Domain\User;
use PDO;

class UserRepository implements IUserRepository
{
    public function __construct(private readonly PDO $pdo) {}

    public function findByEmail(string $email): ?User
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);
        $row = $stmt->fetch();
        return $row ? User::fromArray($row) : null;
    }

    public function findById(int $id): ?User
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ? User::fromArray($row) : null;
    }

    public function findByOAuth(string $provider, string $oauthId): ?User
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE oauth_provider = ? AND oauth_id = ?');
        $stmt->execute([$provider, $oauthId]);
        $row = $stmt->fetch();
        return $row ? User::fromArray($row) : null;
    }

    public function create(array $data): int
    {
        // Dynamically build query based on provided fields
        $fields = array_keys($data);
        $placeholders = array_map(fn($f) => ":$f", $fields);
        
        $sql = sprintf(
            'INSERT INTO users (%s) VALUES (%s)',
            implode(', ', $fields),
            implode(', ', $placeholders)
        );
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
        return (int) $this->pdo->lastInsertId();
    }

    public function getAll(): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users ORDER BY id DESC');
        $stmt->execute();
        $rows = $stmt->fetchAll();
        return array_map(fn($row) => User::fromArray($row), $rows);
    }

    public function updateRole(int $id, string $role): bool
    {
        $stmt = $this->pdo->prepare('UPDATE users SET role = ? WHERE id = ?');
        $stmt->execute([$role, $id]);
        return $stmt->rowCount() > 0;
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM users WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->rowCount() > 0;
    }

    public function updateResetToken(int $userId, ?string $token, ?string $expiresAt): bool
    {
        $stmt = $this->pdo->prepare('UPDATE users SET reset_token = ?, reset_token_expires_at = ? WHERE id = ?');
        $stmt->execute([$token, $expiresAt, $userId]);
        return $stmt->rowCount() > 0;
    }

    public function findByResetToken(string $token): ?User
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE reset_token = ?');
        $stmt->execute([$token]);
        $row = $stmt->fetch();
        return $row ? User::fromArray($row) : null;
    }

    public function updatePassword(int $userId, string $newPasswordHash): bool
    {
        $stmt = $this->pdo->prepare('UPDATE users SET password_hash = ?, reset_token = NULL, reset_token_expires_at = NULL WHERE id = ?');
        $stmt->execute([$newPasswordHash, $userId]);
        return $stmt->rowCount() > 0;
    }
}
