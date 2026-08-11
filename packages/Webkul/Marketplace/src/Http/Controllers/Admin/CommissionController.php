<?php

namespace Webkul\Marketplace\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Webkul\Marketplace\Repositories\CommissionRepository;

class CommissionController extends Controller
{
    public function __construct(protected CommissionRepository $commissionRepository)
    {
    }

    public function index(): View
    {
        $commissions = $this->commissionRepository->paginateForAdmin();

        return view('marketplace::admin.commissions.index', compact('commissions'));
    }
}
