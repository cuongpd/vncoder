$(function() {
    "use strict";
    $(document).on('click', 'button.mediaInsertBtn', function (e) {
        e.preventDefault();
        const $media = $('a.last-selected-media');
        if ($media.length) {
            const media_info = JSON.parse($media.attr('data-media-info'));
            const file_manager_input = $('#file_manager_input').val();
            if(file_manager_input && file_manager_input !== 'summernote'){
                $('input[name="'+ file_manager_input +'"]').val(media_info.photo);
            }
            removeModal();
        } else {
            $('#statusMsg').html('<p class="alert alert-info mt-2">Please select a media</p>');
        }
    });

    $(document).on('click', '.filemanager-pagination-wrap a', function(e) {
        e.preventDefault();
        $('#modal-filemanager').load($(this).attr('href'));
    });

    $(document).on('click', '#button-refresh', function(e) {
        e.preventDefault();
        $('#modal-filemanager').load($(this).attr('href'));
    });

    $(document).on('keydown', 'input[name="filemanager-search"]', function(e) {
        if (e.which === 13) {
            $('#button-search').trigger('click');
        }
    });

    $(document).on('click', '#button-search', function(e) {
        let url = MEDIA_LOADER_URL + '?action=' + $('input[name="filemanager-action"]').val();;
        const filter_name = $('input[name="filemanager-search"]').val();
        if (filter_name) {
            url += '&_query=' + encodeURIComponent(filter_name);
        }
        $('#modal-filemanager').load(url);
    });

    $(document).on('click', '#button-upload', function() {
        $('#form-upload').remove();
        $('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="hidden" name="_token" value="'+CSRF_TOKEN+'" /><input type="file" name="files[]" value="" multiple="multiple" /></form>');
        $("#form-upload input[name='files[]']").trigger('click');
        if (typeof timer != 'undefined') {
            clearInterval(timer);
        }
        var timer = setInterval(function() {
            if ($("#form-upload input[name='files[]']").val() !== '') {
                clearInterval(timer);
                $.ajax({
                    url:  MEDIA_LOADER_URL,
                    type: 'post',
                    data: new FormData($('#form-upload')[0]),
                    cache: false,
                    contentType: false,
                    processData: false,
                    xhr: function () {
                        let xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function (evt) {
                            if (evt.lengthComputable) {
                                let percentComplete = (evt.loaded / evt.total) * 100;
                                percentComplete = Math.round(percentComplete);
                                $('#statusMsg').html('<div class="progress"> <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="'+percentComplete+'" aria-valuemin="0" aria-valuemax="100" style="width: '+percentComplete+'%">'+percentComplete+'% Uploaded </div> </div>');
                            }
                        }, false);
                        return xhr;
                    },
                    success: function(json) {
                        if (json.success){
                            $('#statusMsg').html('<p class="alert alert-success">'+json.msg+'</p>');
                            $('#modal-filemanager').load(MEDIA_LOADER_URL + '?action=' + $('#file_manager_input').val());
                        }else {
                            $('#statusMsg').html('<p class="alert alert-danger">'+json.msg+'</p>');
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        $('#statusMsg').html('<p class="alert alert-warning">'+thrownError+'</p>');
                    }
                });
            }
        }, 500);
    });

    $(document).on('click', '#media-info-modal-trash-btn', function(e) {
        if (!confirm('Bạn có muốn xoá File vừa chọn không?')) {
            return false;
        }
        const $that = $(this);
        const media_id = $that.closest('#adminFileManagerModal').attr('data-media-id');
        $.ajax({
            url: MEDIA_LOADER_URL,
            type: 'POST',
            data: {media_ids : media_id, type : 'delete'},
            beforeSend: function() {
                $('#adminFileManagerModal').modal('hide');
                $('#media-grid-id-'+media_id).remove();
            }
        });
    });

    $(document).on('click', 'a.media-modal-thumbnail', function(e){
        e.preventDefault();
        $('a.media-modal-thumbnail').removeClass('selected last-selected-media');
        $(this).addClass('selected last-selected-media');
        const info = JSON.parse($(this).attr('data-media-info'));
        mediaModalLoader(info);
    });

    $(document).on('click', '[data-toggle="sc-modal"]', function(e){
        e.preventDefault();
        const modalID = $(this).attr('data-target');
        const info = JSON.parse($(this).attr('data-media-info'));
        mediaModalLoader(info);
        $(modalID).attr('data-media-id', info.ID).modal('show');
    });

    $(document).on('change', 'form#adminMediaManagerModalForm', function(){
        const inputData = $(this).serialize();
        inputData.type = 'update';
        $.ajax({
            type: 'POST',
            url : MEDIA_LOADER_URL,
            data: inputData,
            beforeSend : function(){
                $('#formWorkingIconWrap').html('<i class="icon-loader spin"></i>');
            },
            success: function(data){},
            complete: function(){
                $('#formWorkingIconWrap').html('');
            }
        });
    });
    $('#modal-filemanager').on('hidden.bs.modal',function(e){
        $('#modal-filemanager').remove();
    });
});

function removeModal() {
    $('#file_manager_input').val('');
    $('#modal-filemanager').modal('hide').remove();
}

function loadMedia(input_name) {
    $('#modal-filemanager').remove();
    $('#file_manager_input').val(input_name);
    $.ajax({
        url: MEDIA_LOADER_URL,
        data: {action : input_name},
        dataType: 'html',
        success: function (html) {
            $('body').append('<div id="modal-filemanager" class="modal modal-upload id-'+ Math.floor(Math.random() * 100) +'" tabindex="-1">' + html + '</div>');
            $('#modal-filemanager').modal({backdrop: 'static', keyboard: false});
        }
    });
}

function mediaModalLoader(info) {
    $('#sc_modal_info_media_id').val(info.ID);
    $('#mediaManagerPreviewScreen').attr('src', info.photo);
    $('#mediaModalFileID').find('span').text(info.ID);
    $('#mediaModalFileName').find('span').text(info.name);
    $('#mediaModalFileType').find('span').text(info.type);
    $('#mediaModalFileUploadedOn').find('span').text(info.time);
    $('#mediaModalFileSize').find('span').text(info.size);
}