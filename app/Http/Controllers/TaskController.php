<?php

namespace App\Http\Controllers;

use App\Task;
use App\TaskPriority;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function __construct()
    {

    }

    public function view(Request $request)
    {
        $all = $request->all();
        $user = $request->user();
        $user_id = $user->id;

        $tasks = Task::where(['user_id' => $user_id]);

        $params = [];
        $appendsArr = [];
        if (isset($all['search']) && trim($all['search']) != '') {
            $arr = [
                'title'
            ];
            $tasks->where(function ($query) use ($all, $arr) {
                foreach ($arr as $key => $val) {
                    $query->orWhere('tasks.' . $val, 'like', '%' . $all['search'] . '%');
                }
            });
            $params['search'] = $all['search'];
            $appendsArr['search'] = $all['search'];
        }

        if (isset($all['order_by']) && trim($all['order_by']) != '') {
            $orderDir = 'asc';
            if (isset($all['order_dir']) && trim($all['order_dir']) != '') {
                $orderDir = $all['order_dir'] == 'desc' ? 'desc' : 'asc';

                $params['order_dir'] = $all['order_dir'];
                $appendsArr['order_dir'] = $all['order_dir'];
            }
            if($all['order_by'] == 'priority') {
                $tasks->leftJoin('task_priorities', 'tasks.priority_id', '=', 'task_priorities.id')
                    ->select('tasks.*', 'task_priorities.order');
                $tasks->orderBy('task_priorities.order', $orderDir);
            } else {
                $tasks->orderBy($all['order_by'], $orderDir);
            }


            $params['order_by'] = $all['order_by'];
            $appendsArr['order_by'] = $all['order_by'];
        }

        $tasks = $tasks->paginate(2);

        if(count($appendsArr) > 0) {
            $tasks = $tasks->appends($appendsArr);
        }

        $taskPriorities = TaskPriority::get()->toArray();
        $now = Carbon::now()->toDateTimeString();

        return response()->view('pages.tasks', [
            "tasks" => $tasks,
            "taskPriorities" => $taskPriorities,
            "now" => $now,
            "params" => $params
        ]);
    }

    public function add(Request $request)
    {
        $all = $request->all();
        $user = $request->user();
        $user_id = $user->id;

        $validator = Validator::make($all, [
            'title' => 'required|max:255|min:2',
            'due_date' => 'required',
            'priority_id' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        Task::create([
            'user_id' => $user_id,
            'title' => $all['title'],
            'due_date' => $all['due_date'],
            'priority_id' => $all['priority_id'],
            'created_at' => Carbon::now()->toDateTimeString()
        ]);

        return redirect('/'.$this->buildQueryString($all));
    }

    public function edit(Request $request, $id)
    {
        $all = $request->all();
        $user = $request->user();
        $user_id = $user->id;

        $validator = Validator::make($all, [
            'title' => 'required|max:255|min:2',
            'due_date' => 'required',
            'priority_id' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        Task::where([
            'user_id' => $user_id,
            'id' => $id
        ])->update([
            'title' => $all['title'],
            'due_date' => $all['due_date'],
            'priority_id' => $all['priority_id'],
            'updated_at' => Carbon::now()->toDateTimeString()
        ]);

        return redirect('/'.$this->buildQueryString($all));
    }

    public function delete(Request $request, $id)
    {
        $all = $request->all();
        $user = $request->user();
        $user_id = $user->id;

        Task::where([
            'user_id' => $user_id,
            'id' => $id
        ])->delete();

        return redirect('/'.$this->buildQueryString($all));
    }

    private function buildQueryString($all) {
        $arr = [];

        if (isset($all['search']) && trim($all['search']) != '') {
            $arr['search'] = $all['search'];
        }

        if (isset($all['order_by']) && trim($all['order_by']) != '') {
            if (isset($all['order_dir']) && trim($all['order_dir']) != '') {
                $arr['order_dir'] = $all['order_dir'];
            }

            $arr['order_by'] = $all['order_by'];
        }

        if (isset($all['page']) && trim($all['page']) != '') {
            $arr['page'] = $all['page'];
        }

        if(count($arr) > 0) {
            return '?'.http_build_query($arr);
        } else {
            return '';
        }
    }
}
