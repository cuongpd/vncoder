$.extend($.summernote.plugins, {
    'upload': function (context) {
        const self = this;
        const ui = $.summernote.ui;
        context.memo('button.upload', function () {
            const button = ui.button({
                contents: '<i class="fa fa-cloud-upload"/>',
                tooltip: 'Upload Image',
                click: function () {
                    $('#modal-filemanager').remove();
                    $('#file_manager_input').val('summernote');
                    $.ajax({
                        url: MEDIA_LOADER_URL,
                        data: {action: 'summernote'},
                        dataType: 'html',
                        success: function (html) {
                            $('body').append('<div id="modal-filemanager" class="modal modal-upload" tabindex="-1">' + html + '</div>');
                            $('#modal-filemanager').modal({backdrop: 'static', keyboard: false});
                        }
                    });
                    $(document).on('click', 'button.mediaInsertSummernote', function (e) {
                        e.preventDefault();
                        const $media = $('a.last-selected-media');
                        if ($media.length) {
                            const media_info = JSON.parse($media.attr('data-media-info'));
                            const file_manager_input = $('#file_manager_input').val();
                            if (file_manager_input === 'summernote') {
                                context.invoke('editor.pasteHTML', "<p><img src='" + media_info.photo + "' alt='" + media_info.name + "' class='image-responsive' /></p>");
                            }
                            removeModal();
                        } else {
                            $('#statusMsg').html('<p class="alert alert-info mt-2">Please select a media</p>');
                        }
                    });
                }
            });
            return button.render();
        });
    }
});

jQuery(function(){ Codebase.helpers(['summernote']); });