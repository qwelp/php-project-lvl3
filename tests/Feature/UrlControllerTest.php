<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UrlControllerTest extends TestCase
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

    public function testIndex()
    {
        $response = $this->get(route('urls.index'));
        $response->assertOk();
    }

    public function testStore()
    {
        $domen = 'https://hexlet.io';
        $data = [
            'url' => [
                'name' => $domen
            ]
        ];

        $response = $this->post(route('urls.store'), $data);
        $urlId = DB::table('urls')->where('name', $domen)->first()->id;
        $urlId = $urlId ?? 0;

        $response->assertRedirect(route('urls.show', ['url' => $urlId]));
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('urls', ['name' => $domen]);
    }

    public function testShow(): void
    {
        $response = $this->get(route('urls.show', ['url' => $this->id]));
        $response->assertOk();
        $response->assertSeeText($this->data['name']);
    }
}
