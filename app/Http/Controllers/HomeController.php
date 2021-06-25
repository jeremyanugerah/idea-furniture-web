<?php

namespace App\Http\Controllers;

use App\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // Display the home page
    public function index()
    {
        $productTypes = ProductType::all()->sortBy('name');
        return view('home', compact('productTypes'))->with([
            'message_success' => Session::get('message_success')
        ]);
    }
}
