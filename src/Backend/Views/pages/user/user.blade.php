<div class="table-responsive">
    <table class="table table-striped table-vcenter">
        <thead>
        <tr>
            <th>ID</th>
            <th>Avatar</th>
            <th><i class="si si-user"></i> User</th>
            <th>Email</th>
            <th>Role</th>
            <th>Login</th>
            <th class="text-center" style="width:12%;">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($userData as $item)
            <tr>
                <td>{{$item->id}}</td>
                <td><img src="{{$item->avatar}}" class="img-avatar img-avatar32"></td>
                <th>
                    @if($item->status < 0)
                        <span class="text text-secondary">{!! $item->name !!}</span>
                    @else
                        <span class="text text-dark">{!! $item->name !!}</span>
                    @endif
                </th>
                <td>{!! $item->email !!}</td>
                <td>{!! $item->role_name !!}</td>
                <td>{!! $item->auth !!}</td>
                <td>
                    <div class="td-actions text-center">
                        @if($item->status == 0)
                            Chờ xác nhận
                        @endif

                        @if($item->status > 0)
                            <a href="{{$linkLock}}?id={{$item->id}}" title="Locked User">
                                <button type="button" class="btn btn-sm btn-danger btn-danger">
                                    <i class="si si-lock-open"></i>
                                </button>
                            </a>
                        @endif
                        @if($item->status < 0)
                            <a href="{{$linkUnLock}}?id={{$item->id}}" title="Unlock User">
                                <button type="button" class="btn btn-sm btn-secondary btn-primary">
                                    <i class="si si-ghost"></i>
                                </button>
                            </a>
                        @endif
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td colspan="7">
                {!! $userData->appends(request()->except('page'))->links('core::paginate.bootstrap') !!}
            </td>
        </tr>
        </tfoot>
    </table>
</div>