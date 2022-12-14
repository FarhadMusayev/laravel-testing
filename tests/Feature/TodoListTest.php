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
        $this->todoList = $this->createTodoList(['name' => 'my list']);
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

    public function test_store_new_todo_list()
    {
        $list = TodoList::factory()->make();

        $response = $this->postJson(route('todo-list.store'), ['name' => $list->name])
            ->assertCreated()
            ->json();

        $this->assertEquals($list->name, $response['name']);
        $this->assertDatabaseHas('todo_lists', ['name' => $list->name]);
    }

    public function test_while_storing_todo_list_name_field_is_required()
    {
        $this->withExceptionHandling();

        $this->postJson(route('todo-list.store'))
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['name']);
    }

    public function test_delete_todo_list()
    {
        $this->deleteJson(route('todo-list.destroy', $this->todoList->id))->assertNoContent();

        $this->assertDatabaseMissing('todo_lists', ['name' => $this->todoList->name]);
    }

    public function test_update_todo_list()
    {
        $this->patch(route('todo-list.update', $this->todoList->id), ['name' => 'updated name'])
            ->assertOk();

        $this->assertDatabaseHas('todo_lists', ['id' => $this->todoList->id, 'name' => 'updated name']);
    }

    public function test_while_updating_todo_list_name_field_is_required()
    {
        $this->withExceptionHandling();

        $this->patchJson(route('todo-list.update', $this->todoList->id))
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['name']);
    }

}
