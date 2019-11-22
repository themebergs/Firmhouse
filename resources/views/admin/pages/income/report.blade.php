<div class="box">

    @include ('admin.snippets.income_filters')


    <!-- /.box-header -->
    <div class="box-body table-responsive">

        <table id="income_all_table" class="table table-striped table-bordered text-center table-responsive ">
            <thead>
                <tr id="report_cat">
                    <th></th>
                    @foreach($categories as $category)
                    <th colspan="{{ count($category->SubCategory) }}"> {{ $category->name }}</th>
                    @endforeach
                    <th rowspan="2">Total</th>
                </tr>
                <tr id="report_sub">
                    <th style="width: 80px">Date</th>
                    @foreach($categories as $category)
                    @foreach($category->SubCategory as $SubCategories)
                    <th>{{ $SubCategories->name }}</th>
                    @endforeach
                    @endforeach
                </tr>
            </thead>
            <tbody id="all_data">
                {!! $data !!}
            </tbody>
            <tfoot>
                <tr id="report_footer">
                    <th>Total</th>
                    @foreach($total_all as $total)
                    <th class="nowrap">{{ number_format($total, 2) }} tk/=</th>
                    @endforeach
                </tr>
            </tfoot>
        </table>

    </div>

</div>
