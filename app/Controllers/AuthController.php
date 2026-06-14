<?php
namespace App\Controllers;

use App\Core\Container;
use App\Models\Services\Interfaces\IUserService;
use App\Models\Services\OAuthService;
use App\ViewModels\LoginViewModel;
use App\ViewModels\RegisterViewModel;
use App\Core\Exceptions\BusinessException;
use App\Core\Session;

class AuthController extends BaseController
{
    private IUserService $userService;
    private OAuthService $oauthService;

    public function __construct(Container $container)
    {
        parent::__construct($container);
        $this->userService = $container->make(IUserService::class);
        $this->oauthService = new OAuthService();
    }

    // GET /login
    public function loginForm(): void
    {
        if ($this->getCurrentUserId()) $this->redirect('/');
        $vm = new LoginViewModel();
        $this->render('auth.login', ['vm' => $vm]);
    }

    // POST /login
    public function login(): void
    {
        $this->validateCsrf();

        $vm           = new LoginViewModel();
        $vm->email    = trim($_POST['email']    ?? '');
        $vm->password = trim($_POST['password'] ?? '');

        if (!$vm->validate()) {
            $this->render('auth.login', ['vm' => $vm]);
            return;
        }

        try {
            $user = $this->userService->authenticate($vm->email, $vm->password);
            Session::set('user_id',   $user->id);
            Session::set('user_role', $user->role);
            Session::regenerate();

            $redirect = $_GET['redirect'] ?? '/';
            $this->redirect($redirect);

        } catch (BusinessException $e) {
            $vm->errors['general'] = $e->getMessage();
            $this->render('auth.login', ['vm' => $vm]);
        }
    }

    // GET /register
    public function registerForm(): void
    {
        if ($this->getCurrentUserId()) $this->redirect('/');
        $vm = new RegisterViewModel();
        $this->render('auth.register', ['vm' => $vm]);
    }

    // POST /register
    public function register(): void
    {
        $this->validateCsrf();

        $vm = new RegisterViewModel();
        $vm->username        = trim($_POST['username'] ?? '');
        $vm->email           = trim($_POST['email'] ?? '');
        $vm->password        = trim($_POST['password'] ?? '');
        $vm->confirmPassword = trim($_POST['confirm_password'] ?? '');

        if (!$vm->validate()) {
            $this->render('auth.register', ['vm' => $vm]);
            return;
        }

        try {
            $user = $this->userService->register($vm->username, $vm->email, $vm->password);
            Session::set('user_id',   $user->id);
            Session::set('user_role', $user->role);
            Session::regenerate();

            $this->redirect('/');

        } catch (BusinessException $e) {
            $vm->errors['general'] = $e->getMessage();
            $this->render('auth.register', ['vm' => $vm]);
        }
    }

    // POST /logout
    public function logout(): void
    {
        $this->validateCsrf();
        Session::destroy();
        $this->redirect('/login');
    }

    // GET /forgot-password
    public function forgotPasswordForm(): void
    {
        if ($this->getCurrentUserId()) $this->redirect('/');
        $this->render('auth.forgot_password', [
            'vm'        => (object)['email' => '', 'errors' => []],
            'pageTitle' => 'Quên mật khẩu — CinemaX',
        ]);
    }

    // POST /forgot-password
    public function forgotPassword(): void
    {
        $this->validateCsrf();
        $email = trim($_POST['email'] ?? '');

        $db = \App\Core\Database::getInstance();
        $stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user) {
            $token = bin2hex(random_bytes(32));
            $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));
            $db->prepare("UPDATE users SET reset_token = ?, reset_token_expiry = ? WHERE id = ?")
               ->execute([$token, $expiry, $user['id']]);
            
            // Generate link
            $resetLink = 'http://localhost:8080/reset-password?token=' . $token;
            // Write to mock email log
            @mkdir(ROOT_PATH . '/logs', 0777, true);
            file_put_contents(ROOT_PATH . '/logs/emails.log', "[" . date('Y-m-d H:i:s') . "] Password Reset for $email: $resetLink\n", FILE_APPEND);
        }

        Session::setFlash('success', 'Nếu email tồn tại trong hệ thống, link đặt lại mật khẩu đã được gửi. Vui lòng kiểm tra hộp thư (hoặc file logs/emails.log).');
        $this->redirect('/forgot-password');
    }

    // GET /reset-password
    public function resetPasswordForm(): void
    {
        if ($this->getCurrentUserId()) $this->redirect('/');
        $token = $_GET['token'] ?? '';
        
        $db = \App\Core\Database::getInstance();
        $stmt = $db->prepare("SELECT id FROM users WHERE reset_token = ? AND reset_token_expiry > NOW()");
        $stmt->execute([$token]);
        if (!$stmt->fetch()) {
            Session::setFlash('error', 'Token không hợp lệ hoặc đã hết hạn.');
            $this->redirect('/forgot-password');
            return;
        }

        $this->render('auth.reset_password', [
            'token' => $token,
            'pageTitle' => 'Đặt lại mật khẩu — CinemaX',
        ]);
    }

    // POST /reset-password
    public function resetPassword(): void
    {
        $this->validateCsrf();
        $token = $_POST['token'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';

        if (strlen($password) < 6 || $password !== $confirm) {
            Session::setFlash('error', 'Mật khẩu phải từ 6 ký tự và trùng khớp.');
            $this->redirect('/reset-password?token=' . urlencode($token));
            return;
        }

        $db = \App\Core\Database::getInstance();
        $stmt = $db->prepare("SELECT id FROM users WHERE reset_token = ? AND reset_token_expiry > NOW()");
        $stmt->execute([$token]);
        $user = $stmt->fetch();

        if (!$user) {
            Session::setFlash('error', 'Token không hợp lệ hoặc đã hết hạn.');
            $this->redirect('/forgot-password');
            return;
        }

        $hash = password_hash($password, PASSWORD_BCRYPT);
        $db->prepare("UPDATE users SET password_hash = ?, reset_token = NULL, reset_token_expiry = NULL WHERE id = ?")
           ->execute([$hash, $user['id']]);

        Session::setFlash('success', 'Đặt lại mật khẩu thành công. Vui lòng đăng nhập.');
        $this->redirect('/login');
    }

    // ============ GOOGLE OAUTH ============

    // GET /auth/google
    public function googleAuth(): void
    {
        $authUrl = $this->oauthService->getGoogleAuthUrl();
        header('Location: ' . $authUrl);
        exit;
    }

    // GET /auth/google/callback
    public function googleCallback(): void
    {
        if (!isset($_GET['code'])) {
            Session::setFlash('error', 'Đăng nhập Google thất bại.');
            $this->redirect('/login');
            return;
        }

        try {
            $code = $_GET['code'];
            $userInfo = $this->oauthService->getGoogleUserInfo($code);
            
            // Authenticate or create user
            $user = $this->userService->authenticateWithOAuth('google', $userInfo);
            
            Session::set('user_id', $user->id);
            Session::set('user_role', $user->role);
            Session::set('oauth_provider', 'google');
            Session::regenerate();

            $this->redirect('/');

        } catch (BusinessException $e) {
            Session::setFlash('error', $e->getMessage());
            $this->redirect('/login');
        }
    }

    // ============ ZALO OAUTH ============

    // GET /auth/zalo
    public function zaloAuth(): void
    {
        $authUrl = $this->oauthService->getZaloAuthUrl();
        header('Location: ' . $authUrl);
        exit;
    }

    // GET /auth/zalo/callback
    public function zaloCallback(): void
    {
        if (!isset($_GET['code'])) {
            Session::setFlash('error', 'Đăng nhập Zalo thất bại.');
            $this->redirect('/login');
            return;
        }

        try {
            $code = $_GET['code'];
            $userInfo = $this->oauthService->getZaloUserInfo($code);
            
            // Authenticate or create user
            $user = $this->userService->authenticateWithOAuth('zalo', $userInfo);
            
            Session::set('user_id', $user->id);
            Session::set('user_role', $user->role);
            Session::set('oauth_provider', 'zalo');
            Session::regenerate();

            $this->redirect('/');

        } catch (BusinessException $e) {
            Session::setFlash('error', $e->getMessage());
            $this->redirect('/login');
        }
    }
}
