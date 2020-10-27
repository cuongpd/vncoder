<input type="hidden" id="file_manager_input" name="file_manager_input" value="" />
{!! $__extraFooterJS !!}
{!! $__extraFooter !!}
@stack('footer')

@if (session('message'))
    <script>jQuery(function(){
        Codebase.helpers('notify', {
            align: 'right',from: 'bottom', type: 'danger', icon: 'fa fa-info mr-5',
            message: '{{session('message')}}'
        });
    });</script>

@endif
