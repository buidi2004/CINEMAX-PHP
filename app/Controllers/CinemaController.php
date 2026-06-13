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
