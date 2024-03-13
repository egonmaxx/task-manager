<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::with('user')->get();
        return response()->json([
            'tasks'    => $tasks,
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->json([
            'Bad request',
        ], 400);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'userId'        => 'integer|required',
            'estimatedTime'        => 'integer|nullable',
            'usedTime'        => 'integer|nullable',
            'description' => 'max:255|nullable',
            // 'createdAt' => 'date|nullable',
            'completedAt' => 'date|nullable'
        ]);

        $task = Task::create([
            'userId'        => request('userId'),
            'estimatedTime'        => request('estimatedTime'),
            'usedTime'        => request('usedTime'),
            // 'createdAt'        => request('createdAt'),
            'completedAt'        => request('completedAt'),
            'description' => request('description'),
        ]);

        return response()->json([
            'task'    => $task,
            'message' => 'Success'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        return response()->json([
            'Bad request',
        ], 400);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        return response()->json([
            'Bad request',
        ], 400);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $this->validate($request, [
            'userId'        => 'integer|required',
            'estimatedTime' => 'integer|nullable',
            'usedTime' => 'integer|nullable',
            'description' => 'max:255|nullable',
            // 'createdAt' => 'date|nullable',
            'completedAt' => 'date|nullable',
        ]);

        $task->userId = request('userId');
        $task->estimatedTime = request('estimatedTime');
        $task->description = request('description');
        $task->estimatedTime = request('estimatedTime');
        $task->usedTime = request('usedTime');
        // $task->createdAt = request('createdAt');
        $task->completedAt = request('completedAt');
        $task->save();

        return response()->json([
            'message' => 'Task updated successfully!'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json([
            'message' => 'Task deleted successfully!'
        ], 200);
    }

    public function setToDone(Task $task)
    {
        if ($task->done == 1) {
            $task->done = 0;
        } else {
            $task->done = 1;
        }

        $task->save();

        return response()->json([
            'message' => 'Task is set to done status successfully!'
        ], 200);
    }
}
