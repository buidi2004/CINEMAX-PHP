<?php
namespace App\Controllers\Admin;

use App\Core\Container;
use App\Models\Services\Interfaces\IMovieService;

class DashboardController extends BaseAdminController
{
    private IMovieService $movieService;

    public function __construct(Container $container)
    {
        parent::__construct($container);
        $this->movieService = $container->make(IMovieService::class);
    }

    // GET /admin/dashboard
    public function index(): void
    {
        $stats = $this->movieService->getDashboardStats();
        $this->render('admin.dashboard', ['stats' => $stats]);
    }
}
