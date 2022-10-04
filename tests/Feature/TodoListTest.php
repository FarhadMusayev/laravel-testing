<?php

namespace Tests\Feature;

use App\Models\TodoList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodoListTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_todo_list()
    {
        TodoList::create(['name' => 'Farhad']);

        $response = $this->getJson(route('todo-list.index'));

        $this->assertEquals(1, count($response->json()));
    }
}
