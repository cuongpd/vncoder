<div class="modal-dialog modal-xl" role="document" id="filemanager">
    <div class="modal-content">
        <div class="block block-themed block-transparent mb-0">
            <div class="block-header bg-primary-dark">
                <h3 class="block-title">File Manager</h3>
                <div class="block-options">
                    <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close"><i class="si si-close"></i></button>
                </div>
            </div>
            <div class="block-content bg-gray-light mb-0">
                <div class="row gutters">
                    <div class="col-md-9">
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
                                        <a href="javascript:void(0);" class="media-modal-thumbnail" data-media-info="{{json_encode($media->media_info)}}" >
                                            <img src="{{$media->thumbnail}}" alt="{{$media->name}}" title="{{$media->name}}" class="img-fluid" />
                                        </a>
                                    </div>
                                @endforeach
                            @else
                                <div class="col-10" id="media-grid-no-data">
                                    <p>Không tìm thấy media, vui lòng kiểm tra lại</p>
                                </div>
                            @endif
                        </div>
                        <div class="row gutters-tiny filemanager-pagination-wrap mt-2">
                            <div class="col-12">
                            {!! $medias->appends(['_query' => getParam('_query'), 'action' => $action])->links() !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 bg-gray-lighter">
                        <div class="form-group">
                            <div class="input-group mt-2">
                                <input type="hidden" name="filemanager-action" id="filemanager-action" value="{{$action}}">
                                <input type="text" name="filemanager-search" value="{{getParam('_query')}}" placeholder="Tìm kiếm.." class="form-control">
                                <div class="input-group-append">
                                    <span class="input-group-text danger" id="button-search"><i class="fa fa-search"></i> </span>
                                </div>
                            </div>
                        </div>
                        <div class="adminMediaModalInfoSide">
                            <div class="row">
                                <div class="col-12 text-center">
                                    <div class="media-image-center">
                                        <img id="mediaManagerPreviewScreen" src="{{core_assets('images/no-image.png')}}" class="mediaManagerPreviewScreen img-fluid" />
                                    </div>
                                    <div class="adminMediaModalInfoSide text-left">
                                        <p id="mediaModalFileID" class="m-1"><strong>ID:</strong> #<span></span></p>
                                        <p id="mediaModalFileUploadedOn" class="m-1"><strong>Uploaded:</strong> <span></span></p>

                                        <p id="mediaModalFileName" class="m-1"><strong>File name:</strong> <span></span></p>
                                        <p id="mediaModalFileSize" class="m-1"><strong>File Size:</strong> <span></span></p>
                                    </div>
                                    <div class="m-2 text-center">
                                        <button type="button" class="btn btn-danger mr-5 mb-5 mediaInsert{{$action == 'summernote' ? 'Summernote' : 'Btn'}}"><i class="fa fa-send mr-5"></i> Chèn ảnh</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
