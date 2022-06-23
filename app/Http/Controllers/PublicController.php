<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index() {
        $faker = \Faker\Factory::create('es_ES');
        return view('public.index', compact('faker'));
    }
}
