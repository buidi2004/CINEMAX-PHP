<?php
namespace App\Models\Services\Interfaces;

use App\Models\Domain\User;

interface IUserService
{
    public function authenticate(string $email, string $password): User;
    public function register(string $username, string $email, string $password): User;
    public function authenticateWithOAuth(string $provider, array $oauthData): User;
    public function getAllUsers(): array;
    public function updateUserRole(int $id, string $role): bool;
    public function deleteUser(int $id): bool;
    public function createPasswordResetToken(string $email): string;
    public function resetPasswordWithToken(string $token, string $newPassword): bool;
}
