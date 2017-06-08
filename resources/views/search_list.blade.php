@extends('main')

@section('css')
    @parent
    <link href="bower_components/datatables/media/css/dataTables.bootstrap.css" rel="stylesheet">
@stop

@section('body')
    <div class="row">
        <div class="col-sm-12">
            <table id='searchTable' class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{trans('main.table.repo_search')}}</th>
                    <th>{{trans('main.table.date')}}</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($data as $row)
                        <tr>
                            <td>{{$row->id}}</td>
                            <td><a href="{!! route('index', ['repo_search' => $row->repo_search])!!}">{{$row->repo_search}}</a></td>
                            <td>{{$row->created_at->format('Y-m-d H:i:s')}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('js')
    @parent
    <script src="bower_components/datatables/media//js/jquery.dataTables.js"></script>
    <script src="bower_components/datatables/media//js/dataTables.bootstrap.js"></script>
    <script>
        var table = $('#searchTable').DataTable({"order": [[0, "desc"]],});
    </script>
@stop
