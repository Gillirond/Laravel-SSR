<?php

namespace App\Http\Controllers;

use App\Task;
use App\TaskPriority;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * @group Task management
 *
 * API for managing tasks
 *
 */
class TaskController extends Controller
{
    public function __construct()
    {

    }

    /**
     * View tasks list
     *
     * Get task list by search value, sort them by order and paginate(10 tasks per page maximum).
     *
     * @param Request $request
     * @queryParam search string The string to search in title field. Example: mytask1
     * @queryParam order_by string To sort by this field. Example: due_date
     * @queryParam order_dir string To set direction of sorting. Example: desc
     * @queryParam page To redirect to current page. Example: 2
     * @return \Illuminate\Http\Response Return html view with paginated tasks, tasksPriorities, now (current time), params (input params)
     */
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

        $tasks = $tasks->paginate(10);

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

    /**
     * Adds new task
     *
     * Adds new task to tasks list and redirects to unsorted page #1 of tasks
     *
     * @param Request $request
     * @bodyParam title string required The title of added task. Example: added task title
     * @bodyParam due_date timestamp required The due date of added task. Example: 2019-12-17 20:11:07
     * @bodyParam priority_id int required The id of priority of added task. Example: 2
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector redirect to /
     */
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

    /**
     * Edit task by id
     *
     * Edit task by id. On success redirects to paginated, sorted view of tasks
     *
     * @param Request $request
     * @urlParam id required The id of the task. Example: 12
     * @bodyParam title string required The title of edited task. Example: editedtasktitle
     * @bodyParam due_date timestamp required The due date of edited task. Example: 2019-12-17 20:11:07
     * @bodyParam priority_id int required The id of priority of edited task. Example: 3
     * @queryParam order_by string To sort by this field. Example: priority
     * @queryParam order_dir string To set direction of sorting. Example: asc
     * @queryParam page int To redirect to current page. Example: 3
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector redirect to /? with query string of order_by, order_dir and page
     */
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

    /**
     * Delete task by id
     *
     * Deletes task by id. On success redirects to page1 unsorted tasks list
     *
     * @param Request $request
     * @urlParam id required The id of the task. Example: 4
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector redirect to /
     */
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
