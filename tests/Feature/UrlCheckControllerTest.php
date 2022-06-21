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
        $name = 'https://hexlet.io';
        $urlId = DB::table('urls')->insertGetId(
            [
                'name' => $name,
                'created_at' => Carbon::now('Europe/Moscow')
            ]
        );

        $expectedData = [
            "url_id" => 1,
            "status_code" => 200,
            "h1" => "Онлайн-школа программирования, за выпускниками которой охотятся компании\n",
            "title" => "Хекслет — больше чем школа программирования. Онлайн курсы, сообщество программистов",
            "description" => trim(file_get_contents($this->getFilePath('description.txt')), "\n")
        ];

        $response = $this->post(route('urls.checks.store', $urlId));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        
        $this->assertDatabaseHas('url_checks', $expectedData);
    }
}
