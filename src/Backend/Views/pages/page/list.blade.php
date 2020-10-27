@push('topMenu')
    <a href="{{$linkEdit}}" title="Thêm trang mới">
        <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i> Thêm trang mới</button>
    </a>
@endpush

<table class="table table-vcenter table-hover">
    <thead>
    <tr>
        <th class="text-center" style="width: 50px;">#</th>
        <th>Name</th>
        <th class="d-none d-sm-table-cell" style="width:40%;">Code</th>
        <th class="text-center" style="width: 120px;">Actions</th>
    </tr>
    </thead>
    <tbody>
    @foreach($postData as $item)
        <tr>
            <td class="text-center">{{$loop->iteration}}</td>
            <td>{{$item->title}}</td>
            <td class="vn-copy" data-clipboard-target="#code-{{$item->id}}"><code id="code-{{$item->id}}">&#123;&#33;&#33; getPage('{{$item->slug}}') &#33;&#33;&#125;</code></td>
            <td class="text-center">
                <a href="{{$linkEdit}}?id={{$item->id}}" title="Sửa danh mục {{$item->title}}">
                    <button type="button" class="btn btn-sm btn-primary">
                        <i class="fa fa-pencil"></i>
                    </button>
                </a>
                <a href="{{$linkDelete}}?id={{$item->id}}" onclick="return confirm('Bạn xoá danh mục cha, toàn bộ danh mục con sẽ mất.Bạn có muốn xoá danh mục này không?');" title="Xoá danh mục {{$item->title}}">
                    <button type="button" class="btn btn-sm btn-danger">
                        <i class="fa fa-times"></i>
                    </button>
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <th colspan="4">
            {!! $postData->appends(request()->except('page'))->links() !!}
        </th>
    </tr>
    </tfoot>
</table>
@push('footer')
    <script>new ClipboardJS('.vn-copy');</script>
@endpush