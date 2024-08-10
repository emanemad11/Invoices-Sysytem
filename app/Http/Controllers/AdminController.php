<?php

namespace App\Http\Controllers;


class AdminController extends Controller
{
    public function index($id)
    {
        return view()->exists($id) ? view($id) : view('404');
    }
}
