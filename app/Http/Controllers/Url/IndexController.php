<?php

namespace App\Http\Controllers\Url;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function __invoke()
    {
        $urls = DB::table('urls')->paginate(5);

        return view('urls.index', compact('urls'));
    }
}
