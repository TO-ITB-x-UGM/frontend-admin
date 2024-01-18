<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return redirect()->to(base_url('login'));
    }

    public function dashboard()
    {
        return view('dashboard', [
            'title' => 'Dashboard'
        ]);
    }
}
