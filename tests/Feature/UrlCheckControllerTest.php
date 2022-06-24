<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Tests\TestCase;
use Exception;

class UrlCheckControllerTest extends TestCase
{
    public function testStore()
    {
        $data = [
            'name' => 'https://ru.hexlet.io',
            'created_at' => Carbon::now(),
        ];

        $id = DB::table('urls')->insertGetId($data);
        $pathToHtml = __DIR__ . '/../Fixtures/fake.html';
        $content = file_get_contents($pathToHtml);
        if ($content === false) {
            throw new Exception('Something wrong with fixtures file');
        }

        Http::fake([$data['name'] => Http::response($content, 200)]);

        $expectedData = [
            'url_id' => $id,
            'status_code' => 200,
            'h1' => 'header',
            'title' => 'example',
            'description' => 'description',
            'created_at' => Carbon::now()
        ];

        $response = $this->post(route('urls.checks.store', $id));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('url_checks', $expectedData);
    }
}
