<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Core\Container;

abstract class BaseAdminController extends BaseController
{
    public function __construct(Container $container)
    {
        parent::__construct($container);
        $this->requireAdmin();
    }
    
    // Helper method for child classes to get services from container
    protected function getService(string $interface)
    {
        return $this->container->make($interface);
    }
}
