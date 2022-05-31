<?php

namespace App\Http\Controllers\Url;

use App\Http\Controllers\Controller;
use App\Http\Requests\Url\StoreRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        $data = array_map(fn ($value) => $value, $request->validated()['url']);
        $data['created_at'] = Carbon::now();

        $parsedUrl = parse_url($data['name']);
        $normalizedUrl = strtolower("{$parsedUrl['scheme']}://{$parsedUrl['host']}");

        $url = DB::table('urls')->where('name', $normalizedUrl)->first();

        if (is_null($url)) {
            $data['name'] = $normalizedUrl;
            $urlId = DB::table('urls')->insertGetId($data);
            flash(__('url.address_added_successfully'))->info();
            return redirect()->route('url.show', ['id' => $urlId]);
        }
        flash(__('Такой адрес уже есть'))->error();
        return redirect()->route('index');
    }
}
