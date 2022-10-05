<?php

namespace Tests\Feature;

use App\Models\TodoList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TodoListTest extends TestCase
{
    use RefreshDatabase;

    private mixed $todoList;

    function setUp(): void
    {
        parent::setUp();
        $this->todoList = TodoList::factory()->create(['name' => 'my list']);
    }

    public function test_get_all_todo_list()
    {
        $response = $this->getJson(route('todo-list.index'));

        $this->assertEquals(1, count($response->json()));
        $this->assertEquals('my list', $response->json()[0]['name']);
    }

    public function test_get_single_todo_list()
    {
        $response = $this->getJson(route('todo-list.show', $this->todoList))->assertOk()->json();

        $this->assertEquals($response['name'], $this->todoList->name);
    }
}
