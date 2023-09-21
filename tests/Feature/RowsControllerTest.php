<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Row;
use Tests\TestCase;

class RowsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testCanRetrieveRowsGroupedByDate()
    {
        // Создаем тестовые данные
        Row::create(['id' => 1, 'name' => 'Test1', 'date' => '2022-09-20']);
        Row::create(['id' => 2, 'name' => 'Test2', 'date' => '2022-09-21']);
        Row::create(['id' => 3, 'name' => 'Test3', 'date' => '2022-09-20']);

        // Выполняем GET-запрос к контроллеру
        $response = $this->get('/rows');

        // Проверяем статус ответа и структуру данных
        $response->assertStatus(200)
                 ->assertJson([
                     '2022-09-20' => [
                         ['id' => 1, 'name' => 'Test1', 'date' => '2022-09-20'],
                         ['id' => 3, 'name' => 'Test3', 'date' => '2022-09-20'],
                     ],
                     '2022-09-21' => [
                         ['id' => 2, 'name' => 'Test2', 'date' => '2022-09-21'],
                     ],
                 ]);
    }
}
