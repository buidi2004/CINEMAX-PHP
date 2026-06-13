<?php
namespace App\Controllers\Admin;

use App\Core\Container;
use App\Models\Services\Interfaces\ITicketService;

class TicketController extends BaseAdminController
{
    private ITicketService $ticketService;

    public function __construct(Container $container)
    {
        parent::__construct($container);
        $this->ticketService = $container->make(ITicketService::class);
    }

    public function index(): void
    {
        $tickets = $this->ticketService->getAllTicketsAdmin();
        $this->render('admin.tickets.index', compact('tickets'));
    }
}
