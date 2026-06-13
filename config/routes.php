<?php
// config/routes.php

use App\Core\Router;

$router = new Router($container);

$router->get('/',                         'HomeController@index');
$router->get('/movies',                   'MovieController@index');
$router->get('/movies/{id}',              'MovieController@detail');
$router->get('/booking/{showtimeId}',     'BookingController@seatMap');
$router->post('/booking/hold',            'BookingController@holdSeats');
$router->post('/booking/apply-promo',     'BookingController@applyPromo');
$router->get('/payment',                  'PaymentController@index');
$router->post('/payment/confirm',         'PaymentController@confirm');
$router->get('/payment/success',          'PaymentController@success');
$router->post('/reviews',                 'ReviewController@submit');

$router->get('/login',                    'AuthController@loginForm');
$router->post('/login',                   'AuthController@login');
$router->get('/register',                 'AuthController@registerForm');
$router->post('/register',                'AuthController@register');
$router->post('/logout',                  'AuthController@logout');

// ── OAuth ──────────────────────────────────────
$router->get('/auth/google',              'AuthController@googleAuth');
$router->get('/auth/google/callback',     'AuthController@googleCallback');
$router->get('/auth/zalo',                'AuthController@zaloAuth');
$router->get('/auth/zalo/callback',       'AuthController@zaloCallback');

$router->get('/my-tickets',               'MovieController@myTickets');
$router->get('/my-tickets/{id}',          'TicketController@ticketDetail');

// ── Rạp phim ──────────────────────────────────
$router->get('/api/cinemas/nearest',      'CinemaController@nearest');
$router->get('/cinemas',                  'CinemaController@index');
$router->get('/cinemas/{slug}',           'CinemaController@detail');

// ── Hồ sơ khách hàng ──────────────────────────
$router->get('/profile',                  'ProfileController@index');
$router->get('/profile/edit',             'ProfileController@editForm');
$router->post('/profile/edit',            'ProfileController@update');
$router->get('/profile/transactions',     'ProfileController@transactions');
$router->get('/profile/change-password',  'ProfileController@changePasswordForm');
$router->post('/profile/change-password', 'ProfileController@changePassword');

// ── Tìm kiếm ──────────────────────────────────
$router->get('/search',                   'SearchController@index');

// ── Khuyến mãi ─────────────────────────────────
$router->get('/promotions',               'PromotionController@index');
$router->get('/promotions/{id}',          'PromotionController@detail');

// ── Tin tức ────────────────────────────────────
$router->get('/news',                     'NewsController@index');
$router->get('/news/{slug}',              'NewsController@detail');

// ── Liên hệ ────────────────────────────────────
$router->get('/contact',                  'ContactController@index');
$router->post('/contact',                 'ContactController@submit');

// ── Quên mật khẩu ──────────────────────────────
$router->get('/forgot-password',          'AuthController@forgotPasswordForm');
$router->post('/forgot-password',         'AuthController@forgotPassword');

// ── Trang tĩnh (Static Pages) ────────────────
$router->get('/careers',                  'PageController@careers');
$router->get('/partners',                 'PageController@partners');
$router->get('/terms',                    'PageController@terms');
$router->get('/terms-transaction',        'PageController@termsTransaction');
$router->get('/payment-policy',           'PageController@paymentPolicy');
$router->get('/privacy-policy',           'PageController@privacyPolicy');
$router->get('/cinema-rules',             'PageController@cinemaRules');
$router->get('/faq',                      'PageController@faq');

$router->get('/admin/dashboard',          'Admin\DashboardController@index');
$router->get('/admin/movies',             'Admin\MovieController@index');
$router->post('/admin/movies',            'Admin\MovieController@store');
$router->post('/admin/movies/update',     'Admin\MovieController@update');
$router->post('/admin/movies/delete',     'Admin\MovieController@delete');
$router->get('/admin/rooms',              'Admin\RoomController@index');
$router->post('/admin/rooms',             'Admin\RoomController@store');
$router->post('/admin/rooms/update',      'Admin\RoomController@update');
$router->post('/admin/rooms/delete',      'Admin\RoomController@delete');

$router->get('/admin/showtimes',          'Admin\ShowtimeController@index');
$router->post('/admin/showtimes',         'Admin\ShowtimeController@store');
$router->post('/admin/showtimes/update',  'Admin\ShowtimeController@update');
$router->post('/admin/showtimes/delete',  'Admin\ShowtimeController@delete');

$router->get('/admin/tickets',            'Admin\TicketController@index');

$router->get('/admin/users',              'Admin\UserController@index');
$router->post('/admin/users/role',        'Admin\UserController@updateRole');
$router->post('/admin/users/delete',      'Admin\UserController@delete');

// ── Admin Promotions ───────────────────────────
$router->get('/admin/promotions',                    'Admin\PromotionController@index');
$router->get('/admin/promotions/create',             'Admin\PromotionController@create');
$router->post('/admin/promotions/create',            'Admin\PromotionController@create');
$router->get('/admin/promotions/{id}/edit',          'Admin\PromotionController@edit');
$router->post('/admin/promotions/{id}/edit',         'Admin\PromotionController@edit');
$router->get('/admin/promotions/{id}/delete',        'Admin\PromotionController@delete');
$router->get('/admin/promotions/{id}/toggle',        'Admin\PromotionController@toggle');

// ── Admin Cinemas ──────────────────────────────
$router->get('/admin/cinemas',                       'Admin\CinemaController@index');
$router->get('/admin/cinemas/create',                'Admin\CinemaController@create');
$router->post('/admin/cinemas/create',               'Admin\CinemaController@create');
$router->get('/admin/cinemas/{id}/edit',             'Admin\CinemaController@edit');
$router->post('/admin/cinemas/{id}/edit',            'Admin\CinemaController@edit');
$router->get('/admin/cinemas/{id}/delete',           'Admin\CinemaController@delete');
$router->get('/admin/cinemas/{id}/rooms',            'Admin\CinemaController@rooms');

// ── Admin Mở rộng (Extended Modules) ─────────────
$router->get('/admin/news',                          'Admin\NewsController@index');
$router->get('/admin/news/create',                   'Admin\NewsController@create');
$router->post('/admin/news/create',                  'Admin\NewsController@create');
$router->get('/admin/news/{id}/edit',                'Admin\NewsController@edit');
$router->post('/admin/news/{id}/edit',               'Admin\NewsController@edit');
$router->get('/admin/news/{id}/delete',              'Admin\NewsController@delete');
$router->get('/admin/contacts',                      'Admin\ContactController@index');
$router->get('/admin/contacts/{id}/reply',           'Admin\ContactController@reply');
$router->post('/admin/contacts/{id}/reply',          'Admin\ContactController@reply');
$router->get('/admin/contacts/{id}/delete',          'Admin\ContactController@delete');
$router->get('/admin/food-beverages',                'Admin\FoodBeverageController@index');
$router->get('/admin/food-beverages/create',         'Admin\FoodBeverageController@create');
$router->post('/admin/food-beverages/create',        'Admin\FoodBeverageController@create');
$router->get('/admin/food-beverages/{id}/edit',      'Admin\FoodBeverageController@edit');
$router->post('/admin/food-beverages/{id}/edit',     'Admin\FoodBeverageController@edit');
$router->get('/admin/food-beverages/{id}/delete',    'Admin\FoodBeverageController@delete');
$router->get('/admin/reviews',                       'Admin\ReviewController@index');
$router->post('/admin/reviews/{id}/toggle',          'Admin\ReviewController@toggleStatus');
$router->get('/admin/reviews/{id}/delete',           'Admin\ReviewController@delete');
$router->get('/admin/settings',                      'Admin\SettingController@index');
$router->post('/admin/settings',                     'Admin\SettingController@index');
$router->get('/admin/reports',                       'Admin\ReportController@index');

return $router;
