<?php
namespace App\Models\Repository\Interfaces;

use App\Models\Domain\User;

interface IUserRepository
{
    public function findByEmail(string $email): ?User;
    public function findById(int $id): ?User;
    public function findByOAuth(string $provider, string $oauthId): ?User;
    public function create(array $data): int;
    public function getAll(): array;
    public function updateRole(int $id, string $role): bool;
    public function delete(int $id): bool;
}
