<?php

namespace App\Http\Controllers\Api\v2;

use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;

class TaskController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Task::class);
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return TaskResource::collection(auth()->user()->task()->get());
    }

    

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $task = auth()->user()->task()->create($request->validated());

        return TaskResource::make($task);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $this->authorize('view', $task );
        return TaskResource::make($task);
    }

    
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task->update($request->validated());

        return TaskResource::make($task);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return response()->noContent();
    }
}
