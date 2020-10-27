<div class="row gutters">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="table-responsive">
            <table class="table table-sm dataTable custom-table m-0 info-order">
                <thead>
                <tr>
                    <th class="sorting{{$__orderBy === 'id' ? '_'.$__sortBy : ''}}" onclick="location.href='{{$pageUrl}}?orderBy=id&sortBy={{$__sortBy}}'">#</th>
                    @foreach($keys as $item)
                    <th class="sorting{{$__orderBy === $item ? '_'.$__sortBy : ''}}" onclick="location.href='{{$pageUrl}}?orderBy={{$item}}&sortBy={{$__sortBy}}'">{{ getKeyName($item)}}</th>
                    @endforeach
                    <th class="pull-right">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $item)
                <tr>
                    <td>{{$item->id}}</td>
                    @foreach($keys as $key)
                    <td>{{$item->$key}}</td>
                    @endforeach
                    <td class="pull-right">
                        <button class="btn btn-info btn-sm" type="button" onclick="goto('{{$linkEdit}}?id={{$item->id}}')">
                            <i class="icon-edit"></i> Edit
                        </button>
                        <button class="btn btn-danger btn-sm" type="button" onclick="goto('{{$linkDelete}}?id={{$item->id}}')">
                            <i class="icon-delete"></i> Delete
                        </button>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row gutters mt-3">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        {!! $data->links() !!}
    </div>
</div>

@push('actions')
    <li>
        <button onclick="goto('{{$linkCreate}}');" type="button" class="btn btn-success"> <i class="icon-create_new_folder"></i> Thêm Mới</button>
    </li>
    <li>
        <button onclick="goto('{{$linkExport}}');"  type="button" class="btn btn-info"> <i class="icon-export"></i> Export</button>
    </li>
@endpush