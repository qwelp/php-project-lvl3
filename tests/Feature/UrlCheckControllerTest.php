<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Tests\TestCase;
use DiDom\Document;

class UrlCheckControllerTest extends TestCase
{
    public function testStore()
    {
        $name = 'https://hexlet.io';
        $urlId = DB::table('urls')->insertGetId(
            [
                'name' => $name,
                'created_at' => Carbon::now()
            ]
        );

        $response = Http::get($name);
        $document = new Document($response->body());
        $h1 = optional($document->first('h1'))->text();
        $title = optional($document->first('title'))->text();
        $description = optional($document->first('meta[name=description]'))->getAttribute('content');

        $expectedData = [
            'url_id' => $urlId,
            'status_code' => $response->status(),
            'h1' => $h1,
            'title' => $title,
            'description' => $description
        ];

        $response = $this->post(route('urls.checks.store', $urlId));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('url_checks', $expectedData);
    }
}
