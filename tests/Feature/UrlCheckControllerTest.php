<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Tests\TestCase;

class UrlCheckControllerTest extends TestCase
{
    private function getFilePath(string $name): string
    {
        return __DIR__ . '/../fixtures/' . $name;
    }

    public function testStore()
    {
        $name = 'https://ru.hexlet.io';
        $urlId = DB::table('urls')->insertGetId(
            [
                'name' => $name,
                'created_at' => Carbon::now()
            ]
        );

        $expectedData = json_decode(file_get_contents($this->getFilePath('testStoreDescription.json')), true);

        if (!$expectedData) {
            return;
        }

        $response = $this->post(route('urls.checks.store', $urlId));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('url_checks', $expectedData);
    }
}
