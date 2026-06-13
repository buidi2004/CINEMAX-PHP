<?php
namespace App\Controllers\Admin;
class ReportController extends BaseAdminController {
    public function index() {
        $this->render('admin.reports.index', ['pageTitle' => 'Báo cáo thống kê']);
    }
}
