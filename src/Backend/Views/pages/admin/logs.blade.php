@if($current_file)
    @push('topMenu')
        <a href="{{$logs_url}}?dl={{$logs_data}}" class="log-action"><button type="button" class="btn btn-info"><i class="fa fa-download"></i> Download</button></a>
        <a href="{{$logs_url}}?clean={{$logs_data}}" class="log-action"><button type="button" class="btn btn-secondary"><i class="fa fa-remove"></i> Clean</button></a>
        <a href="{{$logs_url}}?delall=true{{ ($current_folder) ? '&f=' . encrypt($current_folder) : '' }}" class="log-action"><button type="button" class="btn btn-success"><i class="fa fa-trash"></i> Delete</button></a>
        @if(count($files) > 1)
            <a href="{{$logs_url}}?dl={{$logs_data}}" class="log-action"><button type="button" class="btn btn-danger"><i class="fa fa-trash-o"></i> Delete All</button></a>
        @endif
    @endpush
@endif

@if ($logs === null)
    <div>
        Log file >50M, please download it.
    </div>
@else
    <div class="table-container">
        <div class="table-responsive">
            <table class="table table-sm dataTable custom-table m-0 info-order" id="logData">
                <thead>
                <tr>
                    @if ($standardFormat)
                        <th style="width:80px;">Level</th>
                        <th style="width:150px;">Context</th>
                        <th style="width:200px;">Date</th>
                    @else
                        <th>Line number</th>
                    @endif
                    <th>Content</th>
                </tr>
                </thead>
                <tbody>
                @if($logs)
                @foreach($logs as $key => $log)
                    @if($log['level'])
                    <tr data-display="stack{{{$key}}}">
                        @if ($standardFormat)
                            <td class="nowrap td-top text-{{{$log['level_class']}}}">{{$log['level']}}</td>
                            <td class="text td-top">{{$log['context']}}</td>
                        @endif
                        <td class="date td-top">{{{$log['date']}}}</td>
                        <td class="text td-top" onclick="loadStackInfo('stack_{{{$key}}}');">
                            @if ($log['stack']) <span class="fa fa-search"></span> @endif {{{$log['text']}}}
                            @if (isset($log['in_file']))
                                <br/>{{{$log['in_file']}}}
                            @endif
                            @if ($log['stack'])
                                <div class="stack stack-info" id="stack_{{{$key}}}" style="display: none; white-space: pre-wrap;">{{{ trim($log['stack']) }}}</div>
                            @endif
                        </td>
                    </tr>
                    @endif
                @endforeach
                @endif
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>

@push('footer')
    <script>
        function loadStackInfo(stack_id){
            const stack = $("#" + stack_id);
            if(stack.is(":visible")){
                $(".stack-info").hide();
                stack.hide();
            } else{
                $(".stack-info").hide();
                stack.show();
            }
        }
        $(document).ready(function () {
            $('#logData').DataTable({
                "lengthMenu": [20], "bLengthChange": false, "searching": false, "ordering": true
            });
            $('.log-action').click(function () {
                return confirm('Bạn có muốn xóa Logs không?');
            });
        });
    </script>
@endpush