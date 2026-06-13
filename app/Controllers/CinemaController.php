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
        $selectedProvince = $_GET['province'] ?? null;
        $cinemas = $this->cinemaService->getAll($selectedProvince);
        $provinces = $this->cinemaService->getAllProvinces();

        $this->render('cinemas.index', [
            'cinemas' => $cinemas,
            'selectedProvince' => $selectedProvince,
            'provinces' => $provinces,
            'pageTitle' => 'Hệ thống rạp - CinemaX'
        ]);
    }

    // GET /api/cinemas/nearest
    public function nearest(): void
    {
        header('Content-Type: application/json');
        
        $lat = isset($_GET['lat']) ? (float) $_GET['lat'] : null;
        $lng = isset($_GET['lng']) ? (float) $_GET['lng'] : null;

        if (!$lat || !$lng) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing lat or lng parameters']);
            return;
        }

        try {
            $cinemas = $this->cinemaService->findNearest($lat, $lng, 3);
            
            $result = array_map(function($cinema) {
                return [
                    'id' => $cinema->id,
                    'name' => $cinema->name,
                    'slug' => $cinema->slug,
                    'province' => $cinema->province,
                    'address' => $cinema->getFullAddress(),
                    'distance' => round($cinema->distance, 1), // round to 1 decimal place
                    'image_url' => $cinema->imageUrl
                ];
            }, $cinemas);

            echo json_encode([
                'success' => true,
                'data' => $result
            ]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Server error while finding nearest cinemas']);
        }
    }

    // GET /cinemas/{slug}
    public function detail(string $slug): void
    {
        try {
            $cinema = $this->cinemaService->getBySlug($slug);
            $rooms = $this->cinemaService->getRoomsByCinema($cinema->id);
            $showtimes = $this->cinemaService->getTodayShowtimes($cinema->id);

            $this->render('cinemas.detail', [
                'cinema' => $cinema,
                'rooms' => $rooms,
                'showtimes' => $showtimes,
                'pageTitle' => $cinema->name . ' - CinemaX'
            ]);
        } catch (\App\Core\Exceptions\NotFoundException $e) {
            $this->renderError(404, 'Rạp không tồn tại');
        }
    }
}
