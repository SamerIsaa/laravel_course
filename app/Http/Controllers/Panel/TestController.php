<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;

class TestController extends Controller
{
    public function test1()
    {
        $data['title'] = "dashboard";
        $data['range'] = range(10, 1000, 50);
        return view('panel.index', $data);
    }
}
