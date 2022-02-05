<?php

namespace App\Http\Controllers;

use App\Task;
use App\TaskStatus;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    //
    public function index()
    {
        $user_id = auth()->user()->id;
        $tasks = TaskStatus::with(['tasks' => function($q) use($user_id) {
            // Query the name field in status table
            $q->where('user_id', '=', $user_id); // '=' is optional
        }])->get();

        return view('tasks.index', compact('tasks'));
    }
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => ['required', 'string', 'max:56'],
            'description' => ['nullable', 'string'],
            'status_id' => ['required', 'exists:task_statuses,id']
        ]);


        return $request->user()
            ->tasks()
            ->create($request->only('title', 'description', 'status_id'));
    }

    public function sync(Request $request)
    {
        $this->validate(request(), [
            'columns' => ['required', 'array']
        ]);

        foreach ($request->columns as $status) {
            foreach ($status['tasks'] as $i => $task) {
                $order = $i + 1;
                if ($task['status_id'] !== $status['id'] || (!empty($task['order']) && $task['order'] != $order)) {
                    request()->user()->tasks()
                        ->find($task['id'])
                        ->update(['status_id' => $status['id'], 'order' => $order]);
                }
            }
        }
        $user_id = auth()->user()->id;
        $tasks = TaskStatus::with(['tasks' => function($q) use($user_id) {
            // Query the name field in status table
            $q->where('user_id', '=', $user_id); // '=' is optional
        }])->get();

        return $tasks;
    }

    public function show($id)
    {
        //
        $task = Task::with('status')->where('id',$id)->where('user_id',auth()->user()->id)->first();
        $status = TaskStatus::get()->toArray();
        $data = json_encode(['task_detail'=>$task,'status'=>$status]);
        //dd($data);
        return view('tasks.show',compact('data'));
    }

    public function edit(Task $task)
    {
        //
    }

    public function update(Request $request, Task $task)
    {
        $this->validate($request, [

            'status' => ['required', 'exists:task_statuses,id']
        ]);
        return  request()->user()->tasks()
            ->find($task->id)
            ->update(['status_id' => $request->input('status')]);
        //
    }

    public function destroy(Task $task)
    {
        //
    }
}
