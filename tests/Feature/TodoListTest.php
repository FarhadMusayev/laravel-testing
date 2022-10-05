<?php

namespace Tests\Feature;

use App\Models\TodoList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TodoListTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_all_todo_list()
    {
        TodoList::factory()->count(2)->create(['name' => 'my list']);

        $response = $this->getJson(route('todo-list.index'));

        $this->assertEquals(2, count($response->json()));
        $this->assertEquals('my list', $response->json()[0]['name']);
    }

    public function test_get_single_todo_list()
    {
        $list = TodoList::factory()->create();

        $response = $this->getJson(route('todo-list.show', $list->id))->assertOk()->json();

        $this->assertEquals($response['name'], $list->name);
    }
}
