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
        $domain = 'https://hexlet.io';
        $data = [
            'url' => [
                'name' => $domain
            ]
        ];

        $response = $this->post(route('urls.store'), $data);
        $response->assertSessionHasNoErrors();

        $queryDomain = DB::table('urls')->where('name', $domain);

        if (!$queryDomain->exists()) {
            throw new \Exception('There is no such record!');
        }

        $id = $queryDomain->value('id');
        $response->assertRedirect(route('urls.show', ['url' => $id]));
        $this->assertDatabaseHas('urls', ['name' => $domain]);
    }

    public function testShow(): void
    {
        $response = $this->get(route('urls.show', ['url' => $this->id]));
        $response->assertOk();
        $response->assertSeeText($this->data['name']);
    }
}
