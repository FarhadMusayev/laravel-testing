<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoListRequest;
use App\Models\TodoList;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class TodoListController extends Controller
{
    public function index()
    {
        $lists = TodoList::all();

        return response($lists);
    }

    public function show(TodoList $todoList)
    {
        return response($todoList);
    }

    public function store(TodoListRequest $request)
    {
        return TodoList::create($request->all());
    }

    public function update(TodoListRequest $request, TodoList $todoList)
    {
        $todoList->update($request->all());
        return $todoList;
    }

    public function destroy(TodoList $todoList)
    {
        $todoList->delete();
        return response('', Response::HTTP_NO_CONTENT);
    }
}
