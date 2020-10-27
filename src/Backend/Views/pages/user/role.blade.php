@push('topMenu')
    <a href="{{$linkAdd}}" class="icon red" data-toggle="tooltip" data-placement="top" title="Thêm mới">
        <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i> Thêm quyền mới</button>
    </a>
@endpush

<div class="table-responsive">
    <table class="table table-striped table-vcenter">
        <thead>
        <tr>
            <th></th>
            <th>Name</th>
            <th>Description</th>
            <th>Permission</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($roleData as $item)
            <tr>
                <td>{{$item->id}}</td>
                <td><b>{{$item->name}}</b></td>
                <td>{{$item->description}}</td>
                <td>
                    @if($item->id == 1)
                        User có toàn quyền quản trị
                    @else
                        {{$item->permission}}
                    @endif
                </td>
                <td>
                    <div class="td-actions">
                        <a href="{{$linkEdit}}?id={{$item->id}}" class="icon green" data-toggle="tooltip" data-placement="top" title="Edit Role">
                            <button type="button" class="btn btn-sm btn-primary">
                                <i class="fa fa-pencil"></i>
                            </button>
                        </a>
                        <a href="{{$linkPermission}}?id={{$item->id}}" class="icon blue" data-toggle="tooltip" data-placement="top" title="Phân quyền">
                            <button type="button" class="btn btn-sm btn-info">
                                <i class="fa fa-magnet"></i>
                            </button>
                        </a>
                        <a href="{{$linkDelete}}?id={{$item->id}}" class="icon red" data-toggle="tooltip" data-placement="top" title="Khoá quyền">
                            <button type="button" class="btn btn-sm btn-danger">
                                <i class="fa fa-remove"></i>
                            </button>
                        </a>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>