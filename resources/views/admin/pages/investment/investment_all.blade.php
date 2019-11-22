<div class="col-md-12">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">All Investments </span> (Total: {{$total_investment}})</h3>
            @can('isSuperAdmin')
            <a href="/admin/investment/add" class="btn btn-sm btn-primary pull-right">Add New</a>
            @endcan
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="col-sm-12 table-responsive">
                <table id="investmebt_all_table" class="table table-bordered table-hover dataTable" role="grid"
                    aria-describedby="example2_info">
                    <thead>
                        <tr role="row">
                            <th>User Id</th>
                            <th>Investor Name</th>
                            <th>Amount</th>
                            <th>Percentage on Total</th>
                            <th>View History</th>
                        </tr>
                    </thead>
                    <tbody>
                       {!! $output !!}
                    </tbody>
                    
                </table>
            </div>
        </div>
    </div>    
</div>
