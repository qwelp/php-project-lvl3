<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Tests\TestCase;
use Exception;

class UrlCheckControllerTest extends TestCase
{
    private array $data;
    private int $id;

    protected function setUp(): void
    {
        parent::setUp();

        $this->data = [
            'name' => 'https://mvideo.ru',
            'created_at' => Carbon::now(),
        ];

        $this->id = DB::table('urls')->insertGetId($this->data);
    }

    public function testStore()
    {
        $pathToHtml = __DIR__ . '/../Fixtures/fake.html';
        $content = file_get_contents($pathToHtml);
        if ($content === false) {
            throw new Exception('Something wrong with fixtures file');
        }

        Http::fake([$this->data['name'] => Http::response($content, 200)]);

        $response = $this->post(route('urls.checks.store', $this->id));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $expectedData = [
            'url_id' => $this->id,
            'status_code' => 200,
            'h1' => 'header',
            'title' => 'example',
            'description' => 'description',
            'created_at' => Carbon::now()
        ];
        $this->assertDatabaseHas('url_checks', $expectedData);
    }
}
