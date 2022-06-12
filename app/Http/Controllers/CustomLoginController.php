<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class CustomLoginController extends Controller
{
    public function index()
    {
        return Inertia::render('Login/CustomLogin');
    }

    public function customValidate(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email:rfc,dns'
            
        ]);
    }
}
