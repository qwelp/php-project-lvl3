<?php

namespace App\Http\Controllers\Url;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ShowController extends Controller
{
    public function __invoke(int $id)
    {
        $url = DB::table('urls')->find($id);

        return view('urls.show', compact('url'));
    }
}
