<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Tests\TestCase;

class UrlCheckControllerTest extends TestCase
{
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
            "description" => "Живое онлайн сообщество программистов и разработчиков на JS, Python, Java, PHP, Ruby. Авторские программы обучения с практикой и готовыми проектами в резюме. Помощь в трудоустройстве после успешного окончания обучения"
        ];

        $response = $this->post(route('urls.checks.store', $urlId));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('url_checks', $expectedData);
    }
}
