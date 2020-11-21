<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class UserController extends Controller
{
    /**
     * Show the users dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::query()
            ->where('role', User::ROLE_USER)
            ->paginate(config('app.usersPerPage', 10));

        return View::make('admin.user.index', compact('users'));

    }
}
