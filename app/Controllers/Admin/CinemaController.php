<?php

namespace App\Controllers\Admin;

use App\Models\Services\Interfaces\ICinemaService;
use App\Models\Repository\Interfaces\ICinemaRepository;

use App\Core\Container;

class CinemaController extends BaseAdminController
{
    private ICinemaService $cinemaService;
    private ICinemaRepository $cinemaRepo;

    public function __construct(Container $container)
    {
        parent::__construct($container);
        $this->cinemaService = $container->make(ICinemaService::class);
        $this->cinemaRepo = $container->make(ICinemaRepository::class);
    }

    public function index(): void
    {
        $province = $_GET['province'] ?? null;
        $cinemas = $this->cinemaService->getAll($province);
        $provinces = $this->cinemaService->getAllProvinces();
        
        $this->render('admin.cinemas.index', [
            'title' => 'Quáº£n lĂ½ Ráº¡p chiáº¿u',
            'cinemas' => $cinemas,
            'provinces' => $provinces,
            'selectedProvince' => $province
        ]);
    }

    public function create(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'] ?? '',
                'slug' => $this->generateSlug($_POST['name'] ?? ''),
                'province' => $_POST['province'] ?? '',
                'district' => $_POST['district'] ?? '',
                'address' => $_POST['address'] ?? '',
                'phone' => $_POST['phone'] ?? '',
                'email' => $_POST['email'] ?? '',
                'latitude' => !empty($_POST['latitude']) ? (float)$_POST['latitude'] : null,
                'longitude' => !empty($_POST['longitude']) ? (float)$_POST['longitude'] : null,
                'image_url' => $_POST['image_url'] ?? '/assets/images/cinemas/default.jpg',
                'opening_hours' => $_POST['opening_hours'] ?? '08:00 - 23:00',
                'description' => $_POST['description'] ?? '',
                'facilities' => !empty($_POST['facilities']) ? explode(',', $_POST['facilities']) : []
            ];

            try {
                $this->cinemaRepo->create($data);
                $_SESSION['flash_success'] = 'Táº¡o ráº¡p chiáº¿u thĂ nh cĂ´ng!';
                header('Location: /admin/cinemas');
                exit;
            } catch (\Exception $e) {
                $_SESSION['flash_error'] = 'Lá»—i: ' . $e->getMessage();
            }
        }

        $this->render('admin.cinemas.create', [
            'title' => 'ThĂªm Ráº¡p chiáº¿u má»›i'
        ]);
    }

    public function edit(int $id): void
    {
        $cinema = $this->cinemaService->getById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'] ?? '',
                'slug' => $this->generateSlug($_POST['name'] ?? ''),
                'province' => $_POST['province'] ?? '',
                'district' => $_POST['district'] ?? '',
                'address' => $_POST['address'] ?? '',
                'phone' => $_POST['phone'] ?? '',
                'email' => $_POST['email'] ?? '',
                'latitude' => !empty($_POST['latitude']) ? (float)$_POST['latitude'] : null,
                'longitude' => !empty($_POST['longitude']) ? (float)$_POST['longitude'] : null,
                'image_url' => $_POST['image_url'] ?? $cinema->image_url,
                'opening_hours' => $_POST['opening_hours'] ?? '08:00 - 23:00',
                'description' => $_POST['description'] ?? '',
                'facilities' => !empty($_POST['facilities']) ? explode(',', $_POST['facilities']) : [],
                'is_active' => isset($_POST['is_active'])
            ];

            try {
                $this->cinemaRepo->update($id, $data);
                $_SESSION['flash_success'] = 'Cáº­p nháº­t ráº¡p chiáº¿u thĂ nh cĂ´ng!';
                header('Location: /admin/cinemas');
                exit;
            } catch (\Exception $e) {
                $_SESSION['flash_error'] = 'Lá»—i: ' . $e->getMessage();
            }
        }

        $this->render('admin.cinemas.edit', [
            'title' => 'Sá»­a Ráº¡p chiáº¿u',
            'cinema' => $cinema
        ]);
    }

    public function delete(int $id): void
    {
        try {
            // Soft delete
            $this->cinemaRepo->softDelete($id);
            $_SESSION['flash_success'] = 'XĂ³a ráº¡p chiáº¿u thĂ nh cĂ´ng!';
        } catch (\Exception $e) {
            $_SESSION['flash_error'] = 'Lá»—i: ' . $e->getMessage();
        }

        header('Location: /admin/cinemas');
        exit;
    }

    public function rooms(int $cinemaId): void
    {
        $cinema = $this->cinemaService->getById($cinemaId);
        $rooms = $this->cinemaService->getRoomsByCinema($cinemaId);

        $this->render('admin.cinemas.rooms', [
            'title' => 'PhĂ²ng chiáº¿u - ' . $cinema->name,
            'cinema' => $cinema,
            'rooms' => $rooms
        ]);
    }

    private function generateSlug(string $name): string
    {
        $slug = strtolower($name);
        $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
        $slug = preg_replace('/[\s-]+/', '-', $slug);
        $slug = trim($slug, '-');
        
        // Remove Vietnamese accents
        $vietnamese = ['Ă ','Ă¡','áº¡','áº£','Ă£','Ă¢','áº§','áº¥','áº­','áº©','áº«','Äƒ','áº±','áº¯','áº·','áº³','áºµ','Ă¨','Ă©','áº¹','áº»','áº½','Ăª','á»','áº¿','á»‡','á»ƒ','á»…','Ă¬','Ă­','á»‹','á»‰','Ä©','Ă²','Ă³','á»','á»','Ăµ','Ă´','á»“','á»‘','á»™','á»•','á»—','Æ¡','á»','á»›','á»£','á»Ÿ','á»¡','Ă¹','Ăº','á»¥','á»§','Å©','Æ°','á»«','á»©','á»±','á»­','á»¯','á»³','Ă½','á»µ','á»·','á»¹','Ä‘'];
        $latin = ['a','a','a','a','a','a','a','a','a','a','a','a','a','a','a','a','a','e','e','e','e','e','e','e','e','e','e','e','i','i','i','i','i','o','o','o','o','o','o','o','o','o','o','o','o','o','o','o','o','o','u','u','u','u','u','u','u','u','u','u','u','y','y','y','y','y','d'];
        
        return str_replace($vietnamese, $latin, $slug);
    }
}

