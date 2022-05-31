<?php

namespace App\Http\Controllers\Url;

use App\Http\Controllers\Controller;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use DiDom\Document;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use GuzzleHttp\Exception\RequestException;

class CheckController extends Controller
{
    public function __invoke(int $id)
    {
        $url = DB::table('urls')->find($id);
        abort_unless($url, 404);

        try {
            $response = Http::get($url->name);
            $document = new Document($response->body());
            $h1 = optional($document->first('h1'))->text();
            $title = optional($document->first('title'))->text();
            $description = optional($document->first('meta[name=description]'))->getAttribute('content');

            DB::table('url_checks')->insert([
                'url_id' => $id,
                'created_at' => Carbon::now(),
                'status_code' => $response->status(),
                'h1' => $h1,
                'title' => $title,
                'description' => $description,
            ]);
            flash(__('messages.Page has been checked successfully'))->success();
        } catch (RequestException | HttpClientException | ConnectionException $exception) {
            flash(message: $exception->getMessage())->error();
        }
        return redirect()->route('url.show', ['id' => $id]);
    }
}
