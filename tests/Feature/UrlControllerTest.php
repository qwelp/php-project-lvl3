<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UrlControllerTest extends TestCase
{
    use RefreshDatabase;

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
        $response = $this->get(route('url.index'));
        $response->assertOk();
    }

    public function testStore()
    {
        $response = $this->followingRedirects()->get(route('url.show', $this->id));
        $response->assertSessionHasNoErrors();
        $response->assertOk();
        $response->assertSeeText($this->data['name']);
        $this->assertDatabaseHas('urls', $this->data);
    }

    public function testShow()
    {
        $response = $this->get(route('url.show', ['id' => $this->id]));
        $response->assertOk();
        $response->assertSeeText($this->data['name']);
    }
}
