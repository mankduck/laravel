<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\UserServiceInterface as UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    protected $userService;

    public function __construct(
        UserService $userService
    ) {
        $this->userService = $userService;
    }
    public function index(Request $request)
    {
        // $user = $this->userService->paginate($request);
        $user = Auth::user();
        return view('backend.dashboard.home.index', compact('user'));
    }
}
