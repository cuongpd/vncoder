@extends('backend::layouts.default')

@section('content')

    <section class="panel">
        <div class="row text-sm wrapper">
            <div class="col-sm-5 m-b-xs">
                <select class="input-sm form-control input-s-sm inline">
                    <option value="0">Bulk action</option>
                    <option value="1">Delete selected</option>
                    <option value="2">Bulk edit</option>
                    <option value="3">Export</option>
                </select>
                <button class="btn btn-sm btn-white">Apply</button>
            </div>
            <a href="{{$link_add}}" title="Create new {{$module}}">
                <button class="btn btn-sm btn-danger pull-right m-r-sm"><i class="icon-plus-sign-alt"></i> Create {{$module}}</button>
            </a>
            <div class="col-sm-3 pull-right">
                <form method="put">
                    <div class="input-group">
                        <input type="text" class="input-sm form-control" placeholder="Search" name="_query" value="{{$_query}}">
                        <span class="input-group-btn">
                            <button class="btn btn-sm btn-white" type="button">Go!</button>
                          </span>
                    </div>
                </form>
            </div>
        </div>

        @if (session('message'))
            <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>
                <i class="icon-ban-circle"></i><strong>Oh snap!</strong> {{session('message')}}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-striped" id="table-query">
                <thead>
                    <tr>
                        @foreach($field as $key)
                            @if($key == 'id')
                                <th width="20"><input type="checkbox"></th>
                            @else
                                <th class="th-sortable" data-toggle="class">{{ucname($key)}}</th>
                            @endif
                        @endforeach
                        <th width="120">Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($data as $item)
                    <tr>
                        @foreach($field as $key)
                            @if($key == 'id')
                                <td><input type="checkbox" name="post[]" value="{{$item->id}}"></td>
                            @else
                                <td>{!! $item->$key !!}</td>
                            @endif
                        @endforeach
                        <td>
                            <a href="{{$link_edit}}?id={{$item->id}}" title="Edit"><i class="icon-edit text-info icon-2x"></i></a>
                            <a href="{{$link_delete}}?id={{$item->id}}" title="Delete" onclick="return confirm('Are you sure you want to Remove?');"><i class="icon-trash text-danger icon-2x"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <footer class="panel-footer">
            {!! $data->appends(request()->except('page'))->links('backend::base.paginate.bootstrap') !!}
        </footer>
    </section>

    @if($_query)
        @push('footer')
            <script>
                $(document).ready(function () {
                    $('#table-query').highlight('{{$_query}}');
                });
            </script>

        @endpush
    @endif

@endsection
