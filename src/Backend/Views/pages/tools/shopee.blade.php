<div class="row gutters">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="table-container">
            <div class="table-responsive">
                <table id="shopeeData" class="table table-striped table-bordered" style="width:100%" data-order='[[5, "desc"],[3,"desc"]]' >
                    <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Sale</th>
                        <th>Price</th>
                        <th>Deal</th>
                        <th>Discount</th>
                        <th>Total</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

@push('footer')
    <script>
        $(document).ready(function() {
            $('#shopeeData').DataTable({
                ajax: '{{backend('tools/shopee-ajax')}}',
                pageLength: 100
            });
        });
    </script>
@endpush