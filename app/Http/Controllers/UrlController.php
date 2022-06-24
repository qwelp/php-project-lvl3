<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class UrlController extends Controller
{
    public function index()
    {
        $urls = DB::table('urls')->paginate(15);
        $lastChecks = DB::table('url_checks')
            ->orderBy('url_id')
            ->latest()
            ->distinct('url_id')
            ->get()
            ->keyBy('url_id');

        return view('urls.index', compact('urls', 'lastChecks'));
    }

    public function store(Request $request)
    {
        $rules = ['url.name' => 'required|max:255|active_url'];
        $messages = [
            'required' => __('messages.required'),
            'active_url' => __('messages.active_url'),
            'max' => __('messages.max_string')
        ];
        Validator::make($request->all(), $rules, $messages)->validate();
        $parsedUrl = parse_url($request['url.name']);
        $normalizedUrl = strtolower("{$parsedUrl['scheme']}://{$parsedUrl['host']}");
        $url = DB::table('urls')->where('name', $normalizedUrl)->first();

        if (is_null($url)) {
            $urlId = DB::table('urls')->insertGetId(['name' => $normalizedUrl, 'created_at' => Carbon::now()]);
            flash(__('messages.The page has been added successfully'))->success();
        } else {
            $urlId = $url->id;
            flash(__('messages.The page has already been added'))->info();
        }
        return redirect()->route('urls.show', ['url' => $urlId]);
    }

    public function show(int $id)
    {
        $url = DB::table('urls')->find($id);
        $messageError = (string) __('messages.Page not found');
        abort_unless($url, 404, $messageError);

        $urlChecks = DB::table('url_checks')
            ->where('url_id', $id)
            ->latest()
            ->paginate(50);

        return view('urls.show', compact('url', 'urlChecks'));
    }
}
