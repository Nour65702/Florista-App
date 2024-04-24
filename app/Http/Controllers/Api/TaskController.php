<?php

namespace App\Http\Controllers\Api;

use App\Contracts\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Tasks\StoreTaskFormRequest;
use App\Http\Resources\Providers\ProviderResource;
use App\Http\Resources\Tasks\TaskResource;
use App\Models\Provider;
use App\Models\Task;


class TaskController extends Controller
{

    public function index()
    {
        $tasks = Task::with('provider')->get();
        return ApiResponse::success([
            'tasks' => TaskResource::collection($tasks)
        ]);
    }


    public function myTasks($id)
    {
        $task = Provider::with('tasks')->findOrFail($id);
        return ApiResponse::success([
            'my tasks' => ProviderResource::make($task)
        ]);
    }


    public function store(StoreTaskFormRequest $request)
    {
        $validateData = $request->validated();
        $task = Task::create($validateData);
        return ApiResponse::success([
            'task' => TaskResource::make($task)
        ]);
    }


    public function show($id)
    {
        $task = Task::with('provider')->findOrFail($id);
        return ApiResponse::success([
            'task' => TaskResource::make($task)
        ]);
    }


    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }


    public function destroy(string $id)
    {
        //
    }
}
