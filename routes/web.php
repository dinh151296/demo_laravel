<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
use App\Task;
use Illuminate\Http\Request;

//Route::get('/', function () {
//    return view('welcome');
//});

//show task dashboard

Route::get('/', function (){
    $tasks  = Task::orderBy('created_at', 'desc')->get();

 return view('task', [
     'tasks' => $tasks
 ]);
});

//add new task

Route::post('/task', function (Request $request){
    $validate = Validator::make($request->all(), ['name' => 'required|max:255',]);
    if ($validate->fails()){
        return redirect('/')
        ->withInput()
        ->withErrors($validate);
    }

    $task = new Task();
    $task->name = $request->name;
    $task->save();

    return redirect('/');
});

//delete task

Route::delete('/task/{task}', function ($id){
    Task::findOrFail($id)->delete();
    return redirect('/');
});