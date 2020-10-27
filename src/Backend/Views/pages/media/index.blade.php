<div id="statusMsg"></div>
<div class="row gutters-tiny">
    <div class="col-2" id="media-grid-upload">
        <a href="javascript:void(0);" class="media-modal" id="button-upload">
            <img src="{{core_assets('images/upload-media.png')}}" alt="Upload Media" class="img-fluid" />
        </a>
    </div>
    @if($medias->count())
        @foreach($medias as $media)
            <div class="col-2" id="media-grid-id-{{$media->id}}">
                <div id="media-grid-id-{{$media->id}}" class="media-manager-single-grid text-center">
                    <a href="javascript:;" data-toggle="sc-modal" data-target="#adminFileManagerModal" data-media-info="{{json_encode($media->media_info)}}" >
                        <img class="card-img-top" src="{{$media->thumbnail}}" alt="{{$media->name}}" title="{{$media->name}}" />
                        <b>{{$media->name}}</b>
                    </a>
                </div>
            </div>
        @endforeach
    @else
        <div class="col-12" id="media-grid-no-data">
            <p>Không tìm thấy media, vui lòng kiểm tra lại</p>
        </div>
    @endif
</div>
<div class="row gutters-tiny filemanager-pagination-wrap mt-2">
    <div class="col-12">
        {!! $medias->appends(['_query' => getParam('_query')])->links() !!}
    </div>
</div>

@push('footer')
<div class="modal fade" id="adminFileManagerModal" tabindex="-1" role="dialog" aria-labelledby="adminFileManagerModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="footerCenterIconsModalLabel">Media Manager</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <img id="mediaManagerPreviewScreen" src="{{core_assets('images/no-image.png')}}" class="mediaManagerPreviewScreen img-fluid" />
                    </div>
                    <div class="col-md-6">
                        <div class="adminMediaModalInfoSide">
                            <p id="mediaModalFileID" class="m-1"><strong>ID:</strong> #<span></span></p>
                            <p id="mediaModalFileName" class="m-1"><strong>File name:</strong> <span></span></p>
                            <p id="mediaModalFileType" class="m-1"><strong>File Type:</strong> <span></span></p>
                            <p id="mediaModalFileUploadedOn" class="m-1"><strong>Uploaded:</strong> <span></span></p>
                            <p id="mediaModalFileSize" class="m-1"><strong>File Size:</strong> <span></span></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer text-right">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="icon-close"></i> Đóng</button>
                <button type="button" id="media-info-modal-trash-btn" class="btn btn-danger"><i class="icon-delete"></i> Xoá vĩnh viễn</button>
            </div>
        </div>
    </div>
</div>
@endpush