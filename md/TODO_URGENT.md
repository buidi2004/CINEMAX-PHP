# ⚡ TODO URGENT - TÍNH NĂNG CẦN LÀM GẤP

**Cập nhật**: 2024
**Priority**: 🔴 HIGH → 🟡 MEDIUM → 🟢 LOW

---

## 🔴 PRIORITY 1: CINEMA SYSTEM (CẦN LÀM NGAY)

### Task 1.1: Database Migration
**File**: `migrations/009_create_cinemas.sql`
**Thời gian**: 30 phút

```sql
CREATE TABLE cinemas (
    id SERIAL PRIMARY KEY,
    name VARCHAR(200) NOT NULL,
    slug VARCHAR(200) NOT NULL UNIQUE,
    province VARCHAR(100) NOT NULL,
    district VARCHAR(100) NOT NULL,
    address VARCHAR(500) NOT NULL,
    phone VARCHAR(20),
    email VARCHAR(256),
    latitude DECIMAL(10,8),
    longitude DECIMAL(11,8),
    image_url VARCHAR(512),
    opening_hours VARCHAR(100) DEFAULT '08:00 - 23:30',
    description TEXT,
    facilities TEXT[],
    is_active BOOLEAN NOT NULL DEFAULT TRUE,
    created_at TIMESTAMP NOT NULL DEFAULT NOW()
);

CREATE UNIQUE INDEX ux_cinemas_slug ON cinemas(slug);
CREATE INDEX ix_cinemas_province ON cinemas(province);
CREATE INDEX ix_cinemas_active ON cinemas(is_active) WHERE is_active = TRUE;
```

**File**: `migrations/010_add_cinema_id_to_rooms.sql`
```sql
ALTER TABLE rooms
    ADD COLUMN cinema_id INT REFERENCES cinemas(id) ON DELETE SET NULL;

CREATE INDEX ix_rooms_cinema_id ON rooms(cinema_id);
```

**File**: `migrations/011_seed_cinemas.sql`
```sql
-- Insert 10 cinemas (xem 07_Extended_Features_and_Screens.md)
INSERT INTO cinemas (name, slug, province, ...) VALUES (...);
```

---

### Task 1.2: Domain Model
**File**: `app/Models/Domain/Cinema.php`
**Thời gian**: 15 phút

```php
<?php
namespace App\Models\Domain;

class Cinema extends BaseModel
{
    public int     $id;
    public string  $name;
    public string  $slug;
    public string  $province;
    public string  $district;
    public string  $address;
    public ?string $phone;
    public ?string $email;
    public ?float  $latitude;
    public ?float  $longitude;
    public ?string $imageUrl;
    public string  $openingHours;
    public ?string $description;
    public array   $facilities;  // ['IMAX', '4DX', ...]
    public bool    $isActive;
    public string  $createdAt;
    
    public static function fromArray(array $data): self
    {
        $cinema = new self();
        $cinema->id = (int) $data['id'];
        $cinema->name = $data['name'];
        $cinema->slug = $data['slug'];
        $cinema->province = $data['province'];
        $cinema->district = $data['district'];
        $cinema->address = $data['address'];
        $cinema->phone = $data['phone'] ?? null;
        $cinema->email = $data['email'] ?? null;
        $cinema->latitude = isset($data['latitude']) ? (float) $data['latitude'] : null;
        $cinema->longitude = isset($data['longitude']) ? (float) $data['longitude'] : null;
        $cinema->imageUrl = $data['image_url'] ?? null;
        $cinema->openingHours = $data['opening_hours'] ?? '08:00 - 23:30';
        $cinema->description = $data['description'] ?? null;
        // PostgreSQL array to PHP array
        $cinema->facilities = $data['facilities'] ? json_decode($data['facilities'], true) : [];
        $cinema->isActive = (bool) $data['is_active'];
        $cinema->createdAt = $data['created_at'];
        return $cinema;
    }
}
```

---

### Task 1.3: Repository Interface
**File**: `app/Models/Repository/Interfaces/ICinemaRepository.php`
**Thời gian**: 10 phút

```php
<?php
namespace App\Models\Repository\Interfaces;

use App\Models\Domain\Cinema;

interface ICinemaRepository
{
    public function findAll(?string $province = null): array;
    public function findById(int $id): ?Cinema;
    public function findBySlug(string $slug): ?Cinema;
    public function getAllProvinces(): array;
    public function getRoomsByCinema(int $cinemaId): array;
    public function create(array $data): int;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
}
```

---

### Task 1.4: Repository Implementation
**File**: `app/Models/Repository/Implementations/CinemaRepository.php`
**Thời gian**: 30 phút

```php
<?php
namespace App\Models\Repository\Implementations;

use App\Models\Repository\Interfaces\ICinemaRepository;
use App\Models\Domain\Cinema;
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
        return array_map(fn($row) => Cinema::fromArray($row), $stmt->fetchAll());
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
            'SELECT DISTINCT province FROM cinemas WHERE is_active = TRUE ORDER BY province'
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
        return $stmt->fetchAll();
    }
    
    public function create(array $data): int
    {
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
        // Dynamic update based on provided fields
        $fields = [];
        foreach ($data as $key => $value) {
            $fields[] = "$key = :$key";
        }
        $sql = 'UPDATE cinemas SET ' . implode(', ', $fields) . ' WHERE id = :id';
        $data['id'] = $id;
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
        return $stmt->rowCount() > 0;
    }
    
    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM cinemas WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->rowCount() > 0;
    }
}
```

---

### Task 1.5: Service Interface
**File**: `app/Models/Services/Interfaces/ICinemaService.php`
**Thời gian**: 10 phút

```php
<?php
namespace App\Models\Services\Interfaces;

use App\Models\Domain\Cinema;

interface ICinemaService
{
    public function getAll(?string $province = null): array;
    public function getBySlug(string $slug): Cinema;
    public function getAllProvinces(): array;
    public function getRoomsByCinema(int $cinemaId): array;
    public function getTodayShowtimes(int $cinemaId): array;
}
```

---

### Task 1.6: Service Implementation
**File**: `app/Models/Services/Implementations/CinemaService.php`
**Thời gian**: 30 phút

```php
<?php
namespace App\Models\Services\Implementations;

use App\Models\Services\Interfaces\ICinemaService;
use App\Models\Repository\Interfaces\ICinemaRepository;
use App\Models\Repository\Interfaces\IShowtimeRepository;
use App\Models\Domain\Cinema;
use App\Core\Exceptions\NotFoundException;

class CinemaService implements ICinemaService
{
    public function __construct(
        private readonly ICinemaRepository $cinemaRepo,
        private readonly IShowtimeRepository $showtimeRepo
    ) {}
    
    public function getAll(?string $province = null): array
    {
        return $this->cinemaRepo->findAll($province);
    }
    
    public function getBySlug(string $slug): Cinema
    {
        $cinema = $this->cinemaRepo->findBySlug($slug);
        if (!$cinema) {
            throw new NotFoundException("Rạp không tồn tại.");
        }
        return $cinema;
    }
    
    public function getAllProvinces(): array
    {
        return $this->cinemaRepo->getAllProvinces();
    }
    
    public function getRoomsByCinema(int $cinemaId): array
    {
        return $this->cinemaRepo->getRoomsByCinema($cinemaId);
    }
    
    public function getTodayShowtimes(int $cinemaId): array
    {
        // Get all rooms in this cinema
        $rooms = $this->getRoomsByCinema($cinemaId);
        $roomIds = array_map(fn($r) => $r['id'], $rooms);
        
        if (empty($roomIds)) {
            return [];
        }
        
        // Get today's showtimes for these rooms
        return $this->showtimeRepo->findByRoomsAndDate($roomIds, date('Y-m-d'));
    }
}
```

---

### Task 1.7: Register DI Container
**File**: `config/app.php`
**Thời gian**: 10 phút

**Thêm vào**:
```php
// Cinema bindings
$container->bind(ICinemaRepository::class,
    fn($c) => new CinemaRepository($c->make(Database::class)->getInstance()));

$container->bind(ICinemaService::class,
    fn($c) => new CinemaService(
        $c->make(ICinemaRepository::class),
        $c->make(IShowtimeRepository::class)
    ));
```

---

### Task 1.8: Update CinemaController
**File**: `app/Controllers/CinemaController.php`
**Thời gian**: 20 phút

**Thay thế code hiện tại**:
```php
<?php
namespace App\Controllers;

use App\Core\Container;
use App\Models\Services\Interfaces\ICinemaService;

class CinemaController extends BaseController
{
    private ICinemaService $cinemaService;

    public function __construct(Container $container)
    {
        parent::__construct($container);
        $this->cinemaService = $container->make(ICinemaService::class);
    }

    // GET /cinemas
    public function index(): void
    {
        $province = $_GET['province'] ?? null;
        $cinemas = $this->cinemaService->getAll($province);
        $provinces = $this->cinemaService->getAllProvinces();

        $this->render('cinemas.index', [
            'cinemas' => $cinemas,
            'provinces' => $provinces,
            'selectedProvince' => $province,
            'pageTitle' => 'Hệ thống rạp CinemaX',
        ]);
    }

    // GET /cinemas/{slug}
    public function detail(string $slug): void
    {
        $cinema = $this->cinemaService->getBySlug($slug);
        $rooms = $this->cinemaService->getRoomsByCinema($cinema->id);
        $showtimes = $this->cinemaService->getTodayShowtimes($cinema->id);

        $this->render('cinemas.detail', [
            'cinema' => $cinema,
            'rooms' => $rooms,
            'showtimes' => $showtimes,
            'pageTitle' => $cinema->name . ' — CinemaX',
        ]);
    }
}
```

---

### Task 1.9: Test
**Thời gian**: 30 phút

1. Chạy migrations
2. Seed dữ liệu cinemas
3. Test route `/cinemas`
4. Test route `/cinemas/cinemax-nguyen-hue`
5. Kiểm tra UI hiển thị đúng

---

## 🔴 PRIORITY 2: PAYMENT INTEGRATION (CẦN LÀM SAU CINEMA)

### Task 2.1: Payment Service Interface
**File**: `app/Models/Services/Interfaces/IPaymentService.php`
**Thời gian**: 15 phút

```php
<?php
namespace App\Models\Services\Interfaces;

use App\Core\ValueObjects\PaymentRequest;
use App\Core\ValueObjects\PaymentResult;

interface IPaymentService
{
    public function process(string $method, PaymentRequest $request): PaymentResult;
    public function verifyCallback(array $data): PaymentResult;
}
```

---

### Task 2.2: Payment Strategies
**File**: `app/Models/Services/Implementations/PaymentStrategies/`
**Thời gian**: 2-3 giờ

**IPaymentStrategy.php**:
```php
<?php
namespace App\Models\Services\Implementations\PaymentStrategies;

use App\Core\ValueObjects\PaymentRequest;
use App\Core\ValueObjects\PaymentResult;

interface IPaymentStrategy
{
    public function process(PaymentRequest $request): PaymentResult;
    public function verifyCallback(array $data): PaymentResult;
}
```

**VNPayStrategy.php**:
```php
// Tích hợp VNPay API
// See: https://sandbox.vnpayment.vn/apis/docs/huong-dan-tich-hop/
```

**MoMoStrategy.php**:
```php
// Tích hợp MoMo API
// See: https://developers.momo.vn/
```

**CashStrategy.php**:
```php
// Thanh toán tại quầy - chỉ tạo transaction record
```

---

### Task 2.3: Payment Service Implementation
**File**: `app/Models/Services/Implementations/PaymentService.php`
**Thời gian**: 1 giờ

```php
<?php
namespace App\Models\Services\Implementations;

use App\Models\Services\Interfaces\IPaymentService;
use App\Models\Services\Implementations\PaymentStrategies\*;

class PaymentService implements IPaymentService
{
    private array $strategies = [];

    public function __construct()
    {
        $this->strategies['vnpay'] = new VNPayStrategy();
        $this->strategies['momo'] = new MoMoStrategy();
        $this->strategies['cash'] = new CashStrategy();
    }

    public function process(string $method, PaymentRequest $request): PaymentResult
    {
        if (!isset($this->strategies[$method])) {
            throw new BusinessException("Phương thức thanh toán '$method' không hỗ trợ.");
        }
        return $this->strategies[$method]->process($request);
    }

    public function verifyCallback(array $data): PaymentResult
    {
        $method = $data['method'] ?? '';
        if (!isset($this->strategies[$method])) {
            throw new BusinessException("Invalid payment method.");
        }
        return $this->strategies[$method]->verifyCallback($data);
    }
}
```

---

## 🟡 PRIORITY 3: ADMIN ENHANCEMENTS

### Task 3.1: Admin Promotion Management
**Files**:
- `app/Controllers/Admin/PromotionController.php`
- `views/admin/promotions/index.php`
- `views/admin/promotions/create.php`
- `views/admin/promotions/edit.php`

**Thời gian**: 2-3 giờ

---

### Task 3.2: Admin Cinema Management
**Files**:
- `app/Controllers/Admin/CinemaController.php`
- `views/admin/cinemas/index.php`
- `views/admin/cinemas/create.php`
- `views/admin/cinemas/edit.php`

**Thời gian**: 2-3 giờ

---

### Task 3.3: Statistics Dashboard
**Files**:
- `app/Controllers/Admin/StatisticsController.php`
- `app/Models/Services/Interfaces/IStatisticsService.php`
- `app/Models/Services/Implementations/StatisticsService.php`
- `views/admin/statistics/index.php`

**Thời gian**: 3-4 giờ

---

## 🟢 PRIORITY 4: ENHANCEMENTS

### Task 4.1: QR Code Generation
**Library**: `phpqrcode` hoặc `endroid/qr-code`
**Files**:
- Update `views/movie/ticket_detail.php`
- Add QR generation logic

**Thời gian**: 1-2 giờ

---

### Task 4.2: Email Service
**Library**: `PHPMailer`
**Files**:
- `app/Models/Services/Interfaces/IEmailService.php`
- `app/Models/Services/Implementations/EmailService.php`
- Email templates

**Thời gian**: 2-3 giờ

---

### Task 4.3: Image Upload & Optimization
**Library**: `Intervention/Image`
**Files**:
- `app/Models/Services/Implementations/ImageUploadService.php`
- Update Admin/MovieController

**Thời gian**: 2-3 giờ

---

## 📊 TỔNG HỢP THỜI GIAN

| Priority | Tasks | Thời gian ước tính |
|----------|-------|---------------------|
| 🔴 P1: Cinema | 9 tasks | **3-4 giờ** |
| 🔴 P2: Payment | 3 tasks | **4-6 giờ** |
| 🟡 P3: Admin | 3 tasks | **7-10 giờ** |
| 🟢 P4: Enhancement | 3 tasks | **5-8 giờ** |
| **TỔNG** | **18 tasks** | **19-28 giờ** |

**Ước tính**: **3-5 ngày làm việc** (8h/ngày)

---

## ✅ CHECKLIST HOÀN THÀNH

### Cinema System
- [ ] Migration cinemas table
- [ ] Migration cinema_id to rooms
- [ ] Seed cinemas data
- [ ] Cinema Model
- [ ] ICinemaRepository
- [ ] CinemaRepository
- [ ] ICinemaService
- [ ] CinemaService
- [ ] Update CinemaController
- [ ] Register DI bindings
- [ ] Test frontend

### Payment Integration
- [ ] IPaymentService
- [ ] PaymentService
- [ ] VNPayStrategy (sandbox)
- [ ] MoMoStrategy (sandbox)
- [ ] CashStrategy
- [ ] Payment callbacks
- [ ] Test payment flows

### Admin Enhancements
- [ ] Promotion CRUD
- [ ] Cinema CRUD
- [ ] Statistics dashboard

### Enhancements
- [ ] QR Code
- [ ] Email service
- [ ] Image upload

---

## 🚀 BẮT ĐẦU TỪ ĐÂU?

**KHUYẾN NGHỊ**: Bắt đầu từ **Priority 1 - Cinema System**

Lý do:
1. Nhanh nhất (3-4 giờ)
2. Ít rủi ro nhất
3. Frontend đã sẵn sàng
4. Tác động lớn đến UX

**Lệnh bắt đầu**:
```bash
# 1. Tạo migration files
# 2. Chạy migrations
psql -U postgres -d cinema_db -f migrations/009_create_cinemas.sql
psql -U postgres -d cinema_db -f migrations/010_add_cinema_id_to_rooms.sql
psql -U postgres -d cinema_db -f migrations/011_seed_cinemas.sql

# 3. Tạo các files backend (theo thứ tự trên)
# 4. Test
php -S localhost:8000 -t public
```

---

**CẬP NHẬT**: Check off tasks khi hoàn thành!
