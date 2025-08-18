<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tasks=$request->user()->tasks;
      return response()->json($tasks);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data=$request->validate(['title'=>'string',
                                'description'=>'nullable|string',
                                'status' => 'required|in:pending,completed',
                                   ]);
              $task = $request->user()->tasks()->create($data);
              return response()->json($task,201);


    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
         $task = $request->user()->tasks()->findOrFail($id);
            $data=$request->validate(['title'=>'string',
                                'description'=>'nullable|string',
                                'status' => 'required|in:pending,completed',
                                   ]);
         $task->update($data);

        return response()->json($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $task = $request->user()->tasks()->findOrFail($id);
        $task->delete();

        return response()->json(['message' => 'Task deleted successfully']);
    }
}
