<?php
/**
 * Theater Aurora - Main Application Entry Point
 * 
 * @package TheaterAurora
 * @version 1.0.0
 * @author SyncFocus17
 * @created 2025-05-09
 */

// Define application start time for performance monitoring
define('APP_START', microtime(true));

// Set default timezone to UTC
date_default_timezone_set('UTC');

// Environment Configuration
require_once __DIR__ . '/../config/bootstrap.php';

// Autoloader
require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Application;
use App\Core\Database;
use App\Core\Router;
use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Core\Security;
use App\Middleware\{
    AuthMiddleware,
    CsrfMiddleware,
    RateLimitMiddleware,
    SecurityHeadersMiddleware
};

// Error Handling
set_error_handler(['\App\Core\ErrorHandler', 'handleError']);
set_exception_handler(['\App\Core\ErrorHandler', 'handleException']);

// Initialize the application
try {
    // Create new application instance
    $app = new Application([
        'env' => $_ENV['APP_ENV'] ?? 'production',
        'debug' => $_ENV['APP_DEBUG'] ?? false,
        'url' => $_ENV['APP_URL'] ?? 'http://localhost',
        'timezone' => $_ENV['APP_TIMEZONE'] ?? 'UTC'
    ]);

    // Initialize core components
    $request = new Request();
    $response = new Response();
    $router = new Router($request, $response);
    $session = new Session();
    $security = new Security();

    // Database connection
    $database = new Database([
        'host' => $_ENV['DB_HOST'],
        'name' => $_ENV['DB_NAME'],
        'user' => $_ENV['DB_USER'],
        'pass' => $_ENV['DB_PASS'],
        'charset' => 'utf8mb4'
    ]);

    // Register global middleware
    $app->registerMiddleware(new SecurityHeadersMiddleware());
    $app->registerMiddleware(new CsrfMiddleware($session));
    $app->registerMiddleware(new RateLimitMiddleware());

    // Define routes
    require_once __DIR__ . '/../routes/web.php';
    require_once __DIR__ . '/../routes/api.php';
    require_once __DIR__ . '/../routes/staff.php';
    require_once __DIR__ . '/../routes/admin.php';

    // Public Routes
    $router->get('/', 'HomeController@index');
    $router->get('/shows', 'ShowController@index');
    $router->get('/show/{id}', 'ShowController@show');
    $router->get('/about', 'PageController@about');
    $router->get('/contact', 'PageController@contact');

    // Authentication Routes
    $router->group(['prefix' => 'auth'], function($router) {
        $router->get('/login', 'AuthController@loginForm');
        $router->post('/login', 'AuthController@login');
        $router->get('/register', 'AuthController@registerForm');
        $router->post('/register', 'AuthController@register');
        $router->post('/logout', 'AuthController@logout');
        $router->get('/forgot-password', 'AuthController@forgotForm');
        $router->post('/forgot-password', 'AuthController@forgotPassword');
        $router->get('/reset-password/{token}', 'AuthController@resetForm');
        $router->post('/reset-password', 'AuthController@resetPassword');
    });

    // Protected Customer Routes
    $router->group(['middleware' => ['auth']], function($router) {
        $router->get('/profile', 'ProfileController@show');
        $router->post('/profile', 'ProfileController@update');
        $router->get('/bookings', 'BookingController@index');
        $router->post('/bookings', 'BookingController@store');
        $router->get('/tickets', 'TicketController@index');
    });

    // Staff Routes
    $router->group(['prefix' => 'staff', 'middleware' => ['auth:staff']], function($router) {
        $router->get('/dashboard', 'Staff\DashboardController@index');
        $router->get('/shows/manage', 'Staff\ShowController@index');
        $router->get('/tickets/scan', 'Staff\TicketController@scanForm');
        $router->post('/tickets/validate', 'Staff\TicketController@validate');
    });

    // Admin Routes
    $router->group(['prefix' => 'admin', 'middleware' => ['auth:admin']], function($router) {
        $router->get('/dashboard', 'Admin\DashboardController@index');
        $router->resource('users', 'Admin\UserController');
        $router->resource('staff', 'Admin\StaffController');
        $router->resource('shows', 'Admin\ShowController');
        $router->get('/reports', 'Admin\ReportController@index');
        $router->get('/settings', 'Admin\SettingController@index');
    });

    // API Routes
    $router->group(['prefix' => 'api', 'middleware' => ['api']], function($router) {
        $router->get('/shows', 'Api\ShowController@index');
        $router->get('/shows/{id}', 'Api\ShowController@show');
        $router->post('/tickets/verify', 'Api\TicketController@verify');
    });

    // Handle the request
    $response = $app->handle($request);
    $response->send();

} catch (\Throwable $e) {
    if (isset($app) && $app->isDebug()) {
        throw $e;
    }
    
    error_log($e->getMessage());
    http_response_code(500);
    
    if (!headers_sent()) {
        header('Content-Type: text/html; charset=UTF-8');
    }
    
    require __DIR__ . '/../views/errors/500.php';
}

// Performance monitoring
if (isset($app) && $app->isDebug()) {
    $executionTime = (microtime(true) - APP_START) * 1000;
    $memoryUsage = memory_get_peak_usage(true) / 1024 / 1024;
    
    error_log(sprintf(
        'Request completed in %.2fms using %.2fMB memory',
        $executionTime,
        $memoryUsage
    ));
}