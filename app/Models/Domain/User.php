<?php
namespace App\Models\Domain;

class User extends BaseModel
{
    public int     $id;
    public string  $username;
    public string  $email;
    public ?string $passwordHash;   // bcrypt — KHÔNG bao giờ expose ra View (NULL cho OAuth users)
    public string  $role;           // 'admin' | 'user'
    public ?string $oauthProvider;  // 'google' | 'zalo' | NULL
    public ?string $oauthId;        // ID từ OAuth provider
    public ?string $avatarUrl;      // URL ảnh đại diện
    public string  $createdAt;
    public string  $updatedAt;

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isOAuthUser(): bool
    {
        return $this->oauthProvider !== null;
    }

    public function getAvatarUrl(): string
    {
        return $this->avatarUrl ?? '/assets/images/default-avatar.png';
    }
}
