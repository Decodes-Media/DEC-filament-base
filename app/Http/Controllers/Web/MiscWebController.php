<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\View\View;

class MiscWebController extends Controller
{
    public function index(): Response
    {
        return Response(__('base.welcome'));
    }

    public function empty(): View
    {
        return view('empty');
    }
}
