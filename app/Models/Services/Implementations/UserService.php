<?php
namespace App\Models\Services\Implementations;

use App\Models\Services\Interfaces\IUserService;
use App\Models\Repository\Interfaces\IUserRepository;
use App\Models\Domain\User;
use App\Core\Exceptions\BusinessException;

class UserService implements IUserService
{
    public function __construct(private readonly IUserRepository $userRepo) {}

    public function authenticate(string $email, string $password): User
    {
        $user = $this->userRepo->findByEmail($email);
        if (!$user) {
            throw new BusinessException('Email hoặc mật khẩu không chính xác.');
        }

        if (!password_verify($password, $user->passwordHash)) {
            throw new BusinessException('Email hoặc mật khẩu không chính xác.');
        }

        return $user;
    }

    public function register(string $username, string $email, string $password): User
    {
        $existing = $this->userRepo->findByEmail($email);
        if ($existing) {
            throw new BusinessException('Email đã được sử dụng.');
        }

        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        $id = $this->userRepo->create([
            'username'      => $username,
            'email'         => $email,
            'password_hash' => $passwordHash,
            'role'          => 'user'
        ]);

        return $this->userRepo->findById($id);
    }

    public function authenticateWithOAuth(string $provider, array $oauthData): User
    {
        // Try to find existing OAuth user
        $user = $this->userRepo->findByOAuth($provider, $oauthData['oauth_id']);
        
        if ($user) {
            // User exists, return it
            return $user;
        }

        // Check if email already exists (user might have registered with password)
        $existingByEmail = $this->userRepo->findByEmail($oauthData['email']);
        if ($existingByEmail) {
            throw new BusinessException('Email đã được sử dụng với phương thức đăng nhập khác. Vui lòng đăng nhập bằng mật khẩu.');
        }

        // Create new OAuth user
        $id = $this->userRepo->create([
            'username'       => $oauthData['username'],
            'email'          => $oauthData['email'],
            'password_hash'  => null, // OAuth users don't have password
            'oauth_provider' => $provider,
            'oauth_id'       => $oauthData['oauth_id'],
            'avatar_url'     => $oauthData['avatar_url'] ?? null,
            'role'           => 'user'
        ]);

        return $this->userRepo->findById($id);
    }

    public function getAllUsers(): array
    {
        return $this->userRepo->getAll();
    }

    public function updateUserRole(int $id, string $role): bool
    {
        if (!in_array($role, ['admin', 'user'])) {
            throw new BusinessException('Vai trò không hợp lệ.');
        }
        return $this->userRepo->updateRole($id, $role);
    }

    public function deleteUser(int $id): bool
    {
        return $this->userRepo->delete($id);
    }

    public function createPasswordResetToken(string $email): string
    {
        $user = $this->userRepo->findByEmail($email);
        if (!$user) {
            // We still return a "fake" success or generic message in the controller to prevent email enumeration,
            // but we throw an exception here if we want to stop. However, for security, throwing BusinessException
            // might reveal if the email exists or not. Let's throw it, and let AuthController handle it gracefully.
            throw new BusinessException('Email không tồn tại trong hệ thống.');
        }

        // Check if OAuth user
        if ($user->oauthProvider) {
            throw new BusinessException('Tài khoản này đăng nhập bằng ' . ucfirst($user->oauthProvider) . '. Không thể đổi mật khẩu.');
        }

        $token = bin2hex(random_bytes(32));
        $expiresAt = date('Y-m-d H:i:s', strtotime('+15 minutes'));

        $this->userRepo->updateResetToken($user->id, $token, $expiresAt);

        return $token;
    }

    public function resetPasswordWithToken(string $token, string $newPassword): bool
    {
        $user = $this->userRepo->findByResetToken($token);

        if (!$user) {
            throw new BusinessException('Đường dẫn không hợp lệ hoặc đã hết hạn.');
        }

        if (strtotime($user->resetTokenExpiresAt) < time()) {
            // Token expired
            $this->userRepo->updateResetToken($user->id, null, null);
            throw new BusinessException('Đường dẫn đổi mật khẩu đã hết hạn. Vui lòng yêu cầu lại.');
        }

        $newPasswordHash = password_hash($newPassword, PASSWORD_BCRYPT);
        
        return $this->userRepo->updatePassword($user->id, $newPasswordHash);
    }
}
