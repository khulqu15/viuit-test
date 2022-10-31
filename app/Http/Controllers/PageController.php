<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class PageController extends Controller
{
    public function dashboard(): Response
    {
        $counts = [
            'user' => Auth::user()->role == 'admin' ? User::all()->count() : null,
            'product' => Product::all()->count(),
            'transaction' => Transaction::all()->count(),
        ];

        return Inertia::render('Dashboard', ['counts' => $counts]);
    }
}
