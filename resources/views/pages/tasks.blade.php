@extends('home')

@section('content')
    {{--Right panel - Add new task--}}
    <div class="col-xs-12 col-sm-12 col-md-4 col-md-push-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h2>Add new task:</h2>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" action="{{url('tasks/')}}" method="POST">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="title">Title:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="title" id="title" required=""
                                   placeholder="Enter title" minlength="2" maxlength="255">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="due_date">Due date:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="due_date" id="due_date"
                                   placeholder="Enter due date (format 2019-12-31 00:00)"
                                   pattern="20[0-9]{2}-(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[01]) ([01][0-9]|2[0123]):([012345][0-9])(:([012345][0-9]))?"
                                   required="" value="{{$now}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="priority">Priority:</label>
                        <div class="col-sm-10">
                            <select class="form-control" required="" name="priority_id" id="priority">
                                @foreach($taskPriorities as $key => $taskPriority)
                                    <option value="{{ $taskPriority['id'] }}"
                                            @if ($key == 0) selected="selected" @endif>{{$taskPriority['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-success">
                                <span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;Add task
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{--Left panel - Tasks list--}}
    <div class="col-xs-12 col-sm-12 col-md-8 col-md-pull-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="col-sm-3 vcenter">
                    <h1>Tasks:</h1>
                </div>
                <div class="col-sm-6 vcenter">
                    <form action="{{url('/')}}" method="GET">
                        <div class="input-group">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-primary">
                                    <i class="glyphicon glyphicon-search"></i>
                                </button>
                            </span>
                            <input type="text" class="form-control" name="search" id="searchTasks" placeholder="Search:"
                                   aria-label="Search:" value="{{isset($params['search']) ? $params['search'] : ''}}"/>
                        </div>
                        {{csrf_field()}}
                        <input type="hidden" name="order_by"
                               value="{{isset($params['order_by']) && $params['order_by']!='' ? $params['order_by'] : ''}}">
                        <input type="hidden" name="order_dir"
                               value="{{isset($params['order_dir']) && $params['order_dir']!='' ? $params['order_dir'] : ''}}">
                        <input type="hidden" name="page"
                               value="{{isset(Request()->page) && Request()->page!='' ? Request()->page : ''}}">
                    </form>
                </div>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>
                                Title
                                <span class="sorting">
                                    @if(!(isset($params['order_by']) && $params['order_by'] == 'title' && isset($params['order_dir']) && $params['order_dir'] =='asc'))
                                        <a class="sorting-arrow glyphicon glyphicon-chevron-up"
                                           href="{{url('/?' . (isset($params['search']) ? ('search='.$params['search'].'&') : ('')) . http_build_query(['order_by' => 'title', 'order_dir' => 'asc']))}}"
                                           target="_self" title="sort ascending"></a>
                                    @endif
                                    @if(!(isset($params['order_by']) && $params['order_by'] == 'title' && isset($params['order_dir']) && $params['order_dir'] =='desc'))
                                        <a class="sorting-arrow glyphicon glyphicon-chevron-down"
                                           href="{{url('/?' . (isset($params['search']) ? ('search='.$params['search'].'&') : ('')) . http_build_query(['order_by' => 'title', 'order_dir' => 'desc']))}}"
                                           target="_self" title="sort descending"></a>
                                    @endif
                                </span>
                            </th>
                            <th>
                                Priority
                                <span class="sorting">
                                    @if(!(isset($params['order_by']) && $params['order_by'] == 'priority' && isset($params['order_dir']) && $params['order_dir'] =='asc'))
                                        <a class="sorting-arrow glyphicon glyphicon-chevron-up"
                                           href="{{url('/?' . (isset($params['search']) ? ('search='.$params['search'].'&') : ('')) . http_build_query(['order_by' => 'priority', 'order_dir' => 'asc']))}}"
                                           target="_self" title="sort ascending"></a>
                                    @endif
                                    @if(!(isset($params['order_by']) && $params['order_by'] == 'priority' && isset($params['order_dir']) && $params['order_dir'] =='desc'))
                                        <a class="sorting-arrow glyphicon glyphicon-chevron-down"
                                           href="{{url('/?' . (isset($params['search']) ? ('search='.$params['search'].'&') : ('')) . http_build_query(['order_by' => 'priority', 'order_dir' => 'desc']))}}"
                                           target="_self" title="sort descending"></a>
                                    @endif
                                </span>
                            </th>
                            <th>
                                Due date
                                <span class="sorting">
                                    @if(!(isset($params['order_by']) && $params['order_by'] == 'due_date' && isset($params['order_dir']) && $params['order_dir'] =='asc'))
                                        <a class="sorting-arrow glyphicon glyphicon-chevron-up"
                                           href="{{url('/?' . (isset($params['search']) ? ('search='.$params['search'].'&') : ('')) . http_build_query(['order_by' => 'due_date', 'order_dir' => 'asc']))}}"
                                           target="_self" title="sort ascending"></a>
                                    @endif
                                    @if(!(isset($params['order_by']) && $params['order_by'] == 'due_date' && isset($params['order_dir']) && $params['order_dir'] =='desc'))
                                        <a class="sorting-arrow glyphicon glyphicon-chevron-down"
                                           href="{{url('/?' . (isset($params['search']) ? ('search='.$params['search'].'&') : ('')) . http_build_query(['order_by' => 'due_date', 'order_dir' => 'desc']))}}"
                                           target="_self" title="sort descending"></a>
                                    @endif
                                </span>
                            </th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($tasks->count())
                            @foreach($tasks as $task)
                                <tr>
                                    <td>{{$task['title']}}</td>
                                    <td>{{$taskPriorities[array_search($task['priority_id'], array_map(function($item) {return $item['id'];}, $taskPriorities))]['name']}}</td>
                                    <td>{{$task['due_date']}}</td>
                                    <td>
                                        <button class="btn btn-default col-sm-5" type="button" data-toggle="modal"
                                                data-target="#editTaskModal"
                                                onclick="appTasks.initEditTaskForm({{$task}});">
                                            <span class="glyphicon glyphicon-edit">&nbsp;Edit</span>
                                        </button>
                                        <form class="col-sm-5 col-sm-offset-2" action="{{url('tasks/'.$task['id'])}}"
                                              method="POST">
                                            {{csrf_field()}}
                                            {{method_field('DELETE')}}

                                            <button type="submit" id="delete-task-{{$task['id']}}"
                                                    class="btn btn-danger">
                                                <span class="glyphicon glyphicon-remove-circle"></span>&nbsp;&nbsp;Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="panel-footer tasks-pagination">
                {{$tasks->links()}}
            </div>
        </div>
    </div>
    {{--Edit task modal--}}
    <div id="editTaskModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form name="editTaskForm" id="editTaskForm" action="{{url('tasks/')}}" method="POST">
                    {{csrf_field()}}
                    {{method_field('PUT')}}
                    <input type="hidden" name="order_by"
                           value="{{isset($params['order_by']) && $params['order_by']!='' ? $params['order_by'] : ''}}">
                    <input type="hidden" name="order_dir"
                           value="{{isset($params['order_dir']) && $params['order_dir']!='' ? $params['order_dir'] : ''}}">
                    <input type="hidden" name="page"
                           value="{{isset(Request()->page) && Request()->page!='' ? Request()->page : ''}}">

                    <div class="modal-header">
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h2>Edit task data:</h2>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="editTitle">Title:</label>
                            <input class="form-control" id="editTitle" type="text" name="title"
                                   placeholder="Enter title" minlength="2" maxlength="255" required="">
                        </div>
                        <div class="form-group">
                            <label for="editDueDate">Due date:</label>
                            <input type="text" class="form-control" name="due_date" id="editDueDate"
                                   placeholder="Enter due date (format 2019-12-31 00:00)"
                                   pattern="20[0-9]{2}-(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[01]) ([01][0-9]|2[0123]):([012345][0-9])(:([012345][0-9]))?"
                                   required="">
                        </div>
                        <div class="form-group">
                            <label for="editPriority">Title:</label>
                            <select class="form-control" required="" name="priority_id" id="editPriority">
                                @foreach($taskPriorities as $key => $taskPriority)
                                    <option value="{{ $taskPriority['id'] }}"
                                            @if ($key == 0) selected="selected" @endif>{{$taskPriority['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success" type="submit">Save</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

@endsection