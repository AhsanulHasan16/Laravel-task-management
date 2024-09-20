<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:Pending,In Progress,Completed',
            'due_date' => 'required|date',
        ]);

        $task = Task::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'] ?? '',
            'status' => $validatedData['status'],
            'due_date' => $validatedData['due_date'],
            'user_id' => Auth::id(),
        ]);

        return response()->json([
            'message' => 'Task created successfully',
            'task' => $task
        ], 201);
    }

    public function index(Request $request)
    {
        $query = Task::where('user_id', Auth::id());

        if ($request->has('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->has('sort') && in_array($request->input('sort'), ['asc', 'desc'])) {
            $query->orderBy('due_date', $request->input('sort'));
        } else {
            $query->orderBy('due_date', 'asc');
        }

        $tasks = $query->get();

        return response()->json($tasks);
    }

    public function show($id)
    {

        $task = Task::where('id', $id)
                    ->where('user_id', Auth::id())
                    ->first();

        if (!$task) {
            return response()->json([
                'message' => 'Task not found or you do not have permission to view it'
            ], 404);
        }

        return response()->json($task);
    }


    public function update(Request $request, Task $task)
    {
        
        $validatedData = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:Pending,In Progress,Completed',
            'due_date' => 'required|date',
        ]);

        $task = Task::where('id', $id)
                    ->where('user_id', Auth::id())
                    ->first();

        if (!$task) {
            return response()->json([
                'message' => 'Task not found or you do not have permission to update it'
            ], 404);
        }

        $task->update($validatedData);

        return response()->json([
            'message' => 'Task updated successfully',
            'task' => $task
        ]);
    }


    public function destroy(Task $task)
    {
    
        $task = Task::where('id', $id)
                    ->where('user_id', Auth::id())
                    ->first();

        if (!$task) {
            return response()->json([
                'message' => 'Task not found or you do not have permission to delete it'
            ], 404);
        }
        
        $task->delete();

        return response()->json([
            'message' => 'Task deleted successfully'
        ]);

    }


}
