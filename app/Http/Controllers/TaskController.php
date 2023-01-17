<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Faker\Provider\ar_EG\Person;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tasks.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Log::debug($request);

        $task = new Task;
        $task->name = $request->input('task_name');
        $task->user_id = Auth::user()->id;
        $task->save();
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = Task::find($id);
        return view('tasks.edit2', compact('task'));
        Log::debug($task);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Log::debug($request);
        Log::debug($request->input('task_name'));

        $task = Task::find($id);

        $task->name = $request->input('task_name');

        $task->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Task::where('id', $id)->delete();

        return redirect('/');
    }

    public function select_delete(Request $request)
    {
        log::debug($request->select_data);

        foreach($request->select_data as $val)
        {
            Task::where('id', $val)->delete();
        }

        Task::where('id', $request->id)->delete();

        return redirect('/');
    }

    
    public function comp($id)
    {
        $param = [
         'status' => true,
        ];
        Task::where('id', $id)
        ->update($param);
    }

    public function comp_tasks()
    {
        if(Auth::check()) {
            $tasks = Task::where('status', true)->where('user_id', Auth::user()->id)->get();
            return $tasks;
        }
    }

}