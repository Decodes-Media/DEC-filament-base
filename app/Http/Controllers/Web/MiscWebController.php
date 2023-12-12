<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class MiscWebController extends Controller
{
    public function index(): Response
    {
        return Response(__('admin.welcome'));
    }
}
