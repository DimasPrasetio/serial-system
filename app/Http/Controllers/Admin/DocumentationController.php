<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class DocumentationController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.docs.index');
    }
}

