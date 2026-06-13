<?php
// config/app.php

use App\Core\Container;
use App\Core\Database;

use App\Models\Repository\Interfaces\IUserRepository;
use App\Models\Repository\Implementations\UserRepository;
use App\Models\Repository\Interfaces\IMovieRepository;
use App\Models\Repository\Implementations\MovieRepository;
use App\Models\Repository\Interfaces\IShowtimeRepository;
use App\Models\Repository\Implementations\ShowtimeRepository;
use App\Models\Repository\Interfaces\ITicketRepository;
use App\Models\Repository\Implementations\TicketRepository;
use App\Models\Repository\Interfaces\IPromotionRepository;
use App\Models\Repository\Implementations\PromotionRepository;
use App\Models\Repository\Interfaces\IRoomRepository;
use App\Models\Repository\Implementations\RoomRepository;
use App\Models\Repository\Interfaces\ICinemaRepository;
use App\Models\Repository\Implementations\CinemaRepository;

use App\Models\Services\Interfaces\IUserService;
use App\Models\Services\Implementations\UserService;
use App\Models\Services\Interfaces\IMovieService;
use App\Models\Services\Implementations\MovieService;
use App\Models\Services\Interfaces\ITicketService;
use App\Models\Services\Implementations\TicketService;
use App\Models\Services\Interfaces\IPromotionService;
use App\Models\Services\Implementations\PromotionService;
use App\Models\Services\Interfaces\IPaymentService;
use App\Models\Services\Implementations\PaymentService;
use App\Models\Services\Interfaces\IRoomService;
use App\Models\Services\Implementations\RoomService;
use App\Models\Services\Interfaces\IShowtimeService;
use App\Models\Services\Implementations\ShowtimeService;
use App\Models\Services\Interfaces\ICinemaService;
use App\Models\Services\Implementations\CinemaService;
use App\Models\Services\Interfaces\IEmailService;
use App\Models\Services\Implementations\EmailService;
use App\Models\Services\Interfaces\IStatisticsService;
use App\Models\Services\Implementations\StatisticsService;

// Load environment variables from .env if it exists
if (file_exists(ROOT_PATH . '/.env')) {
    $lines = file(ROOT_PATH . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (str_starts_with(trim($line), '#')) continue;
        if (strpos($line, '=') === false) continue;
        [$name, $value] = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);
        if (!isset($_SERVER[$name]) && !isset($_ENV[$name])) {
            $_ENV[$name] = $value;
        }
    }
}

$container = new Container();

// Bind Database singleton
$container->bind(Database::class, fn() => new Database());

// Bind Repositories
$container->bind(IUserRepository::class,
    fn($c) => new UserRepository(Database::getInstance()));

$container->bind(IMovieRepository::class,
    fn($c) => new MovieRepository(Database::getInstance()));

$container->bind(IShowtimeRepository::class,
    fn($c) => new ShowtimeRepository(Database::getInstance()));

$container->bind(ITicketRepository::class,
    fn($c) => new TicketRepository(Database::getInstance()));

$container->bind(IPromotionRepository::class,
    fn($c) => new PromotionRepository(Database::getInstance()));

$container->bind(IRoomRepository::class,
    fn($c) => new RoomRepository(Database::getInstance()));

$container->bind(ICinemaRepository::class,
    fn($c) => new CinemaRepository(Database::getInstance()));

// Bind Services
$container->bind(IUserService::class,
    fn($c) => new UserService($c->make(IUserRepository::class)));

$container->bind(IMovieService::class,
    fn($c) => new MovieService(
        $c->make(IMovieRepository::class),
        $c->make(IShowtimeRepository::class),
        $c->make(ITicketRepository::class)
    ));

$container->bind(ITicketService::class,
    fn($c) => new TicketService(
        $c->make(ITicketRepository::class),
        $c->make(Database::class)
    ));

$container->bind(IPromotionService::class,
    fn($c) => new PromotionService($c->make(IPromotionRepository::class)));

$container->bind(IPaymentService::class,
    fn() => new PaymentService());

$container->bind(IRoomService::class,
    fn($c) => new RoomService($c->make(IRoomRepository::class)));

$container->bind(IShowtimeService::class,
    fn($c) => new ShowtimeService($c->make(IShowtimeRepository::class)));

$container->bind(ICinemaService::class,
    fn($c) => new CinemaService(
        $c->make(ICinemaRepository::class),
        $c->make(IShowtimeRepository::class)
    ));

$container->bind(IEmailService::class,
    fn() => new EmailService());

$container->bind(IStatisticsService::class,
    fn() => new StatisticsService());

return $container;
