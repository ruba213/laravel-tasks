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
     $tasks=$request->user()->tasks()->with('classification')->with('attachments')->get();
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
    $data = $request->validate([
        'title' => 'required|string',
        'description' => 'nullable|string',
        'status' => 'required|in:pending,completed',
        'classification_id' => 'required|exists:classifications,id',
        'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
    ]);

    $task = $request->user()->tasks()->create([
        'title' => $data['title'],
        'description' => $data['description'] ?? null,
        'status' => $data['status'],
        'classification_id' => $data['classification_id'],
    ]);

    if ($request->hasFile('attachment')) {
        $path = $request->file('attachment')->store('attachments', 'public');

        $task->attachments()->create([
            'attachment' => $path,
        ]);
    }

    $task->load(['classification', 'attachments']);

    return response()->json($task, 201);
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
//dd($request->all());

    $task = $request->user()->tasks()->findOrFail($id);


    $data = $request->validate([
        'title' => 'string',
        'description' => 'nullable|string',
        'status' => 'required|in:pending,completed',
        'classification_id' => 'required|exists:classifications,id',
        'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
    ]);


    $task->update([
        'title' => $data['title'],
        'description' => $data['description'] ?? null,
        'status' => $data['status'],
        'classification_id' => $data['classification_id'],
    ]);


    if ($request->hasFile('attachment')) {
        $file = $request->file('attachment');
        $path = $file->store('attachments', 'public');


        $task->attachments()->create([
            'attachment' => $path,
        ]);
    }


    $task->load(['classification', 'attachments']);

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
