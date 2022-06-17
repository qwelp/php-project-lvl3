<?php

namespace Tests\Feature;

use App\Models\Url;
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
        $name = 'https://hexlet.io';
        $data = [
            'url' => [
                'name' => $name
            ]
        ];

        $dataValid = [
            'name' => $name
        ];

        $response = $this->post(route('urls.store'), $data);
        $element = DB::table('urls')->where('name', $name)->first();
        $response->assertRedirect(route('urls.show', ['url' => $element->id]));
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('urls', $dataValid);
    }

    public function testShow()
    {
        $response = $this->get(route('urls.show', ['url' => $this->id]));
        $response->assertOk();
        $response->assertSeeText($this->data['name']);
    }
}
