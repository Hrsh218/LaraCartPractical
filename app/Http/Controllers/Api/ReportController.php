<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ReportService;

class ReportController extends Controller
{
    private $service;

    public function __construct(ReportService $service)
    {
        $this->service = $service;
    }

    public function MinSellingProduct()
    {
        $data = $this->service->MinSellingProduct();
        return ['product' => $data];
    }
}
