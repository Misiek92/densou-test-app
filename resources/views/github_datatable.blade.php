@extends('main')

@section('css')
    @parent
    <link href="bower_components/datatables/media/css/dataTables.bootstrap.css" rel="stylesheet">
@stop

@section('body')
    <div class="row">
        <div class="col-sm-12">
            <div id='errorSearch' class="alert alert-danger" style="display: none">
                <strong>{{trans('main.error.wrong_data')}}</strong> {{trans('main.error.repo_does_not_exis')}}
            </div>
            <div id='errorAddSearch' class="alert alert-danger" style="display: none">
                <strong>{{trans('main.error.database')}}</strong> <span></span>
            </div>

            <form id="githubSearch" role="form" class="well">
                <legend>{{trans('main.form.legend')}}</legend>

                <div class="form-group">
                    <label for="repo_search">{{trans('main.form.label')}}: </label>
                    <input type="text" class="form-control" name="repo_search" id="repo_search" placeholder="{{trans('main.form.placeholder')}}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </div>
                <button type="submit" class="btn btn-primary">{{trans('main.search')}}</button>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <table id='githubTable' class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>{{trans('main.table.picture')}}</th>
                    <th>{{trans('main.table.name')}}</th>
                    <th>{{trans('main.table.number_of_contributions')}}</th>
                </tr>
                </thead>
                <tbody>

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
        var searchAddUrl = '{{ route("search_store")}}';
    </script>
    <script src="js/github_datatable.js"></script>
@stop
