<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

use App\Task;
use Illuminate\Http\Request;

Route::group(['middleware' => ['web', 'auth']], function () {
    /**
     * Show All High Priority Tasks
     */
    Route::get('/high-priority-tasks', function () {
        return view('high-priority-tasks', [
            'tasks' => Task::where('priority', Task::PRIORITY_HIGH)
                ->orderBy('created_at', 'asc')
                ->get(),
            'taskPriorities' => Task::getPriorityOptions()
        ]);
    });

    /**
     * Show Task Dashboard
     */
    Route::get('/', function () {
        return view('tasks', [
            'tasks' => Task::where('user_id', '=', Auth::id())
                ->orWhere('priority', Task::PRIORITY_HIGH)
                ->orderBy('created_at', 'asc')
                ->get(),
            'taskPriorities' => Task::getPriorityOptions()
        ]);
    });

    /**
     * Add New Task
     */
    Route::post('/task', function (Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'priority' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect('/')
                ->withInput()
                ->withErrors($validator);
        }

        $task = new Task;
        $task->name = $request->name;
        $task->priority = $request->priority;
        $task->user_id = Auth::id();
        $task->save();

        return redirect('/');
    });

    /**
     * Delete Task
     */
    Route::delete('/task/{id}', function ($id) {
        Task::findOrFail($id)->delete();

        return redirect('/');
    });
});

Route::group(['middleware' => 'web'], function () {
    Route::auth();

    Route::get('/home', 'HomeController@index');
});
