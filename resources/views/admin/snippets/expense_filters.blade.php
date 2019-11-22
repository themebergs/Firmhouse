<div class="box-header with-border">
    <h3 class="box-title"><strong>Expense Report: </strong> <i><span id="sector_name">{{ $sector->name }}</span></i></h3>
    <div class="box-tools">
        <div class="input-group input-group-sm d-flex align-items-center" style="width: 300px;">
            <label for="sector_input" class="nowrap">Select Sector</label>
            {{ Form::select('sector_id', $sectors, null, array('id'=>'sector_input','class'=>'form-control pull-right ml-15', 'placeholder'=>'Please select ...', 'required')) }}
        </div>
    </div>
</div>


<div class="box-header with-border">
    <div class="form-group pull-left category-select" id="sector_categories">
        @foreach($categories as $category)
        <div class="category_check">
            <label>
                <input class="report_checkbox" type="checkbox" name="category[]" value="{{ $category->id }}">
                {{ $category->name }}
            </label>
        </div>
        @endforeach
    </div>
    <div class="form-group pull-right">
        <input type="text" name="daterange" id="report_date" value="{{ date('m/01/Y') }} - {{ date('m/d/Y') }}" />
    </div>
</div>


<script>
    var arr = new Array();
    $(document).on('change', '#sector_input', function () {
        var date = $('#report_date').val();
        var sector = $(this).val();
        ajax_submission_sector(sector, date);

    });

    $(document).on('change', '.report_checkbox', function () {

        if ($(this).prop('checked') == true) {
            var date = $('#report_date').val();
            var sector = $('#sector_input').val();
            arr.push($(this).val());
            ajax_submission(sector, arr, date);
        }

        if ($(this).prop('checked') == false) {
            var date = $('#report_date').val();
            var sector = $('#sector_input').val();
            var del = $(this).val();
            arr.splice($.inArray(del, arr), 1);
            ajax_submission(sector, arr, date);
        }

    });

    $(document).on('change', '#report_date', function () {
        var date = $(this).val();
        var sector = $('#sector_input').val();
        var arr = new Array();

        $('.report_checkbox').each(function () {
            if ($(this).prop('checked') == true) {
                arr.push($(this).val());
            }
        });
        ajax_submission(sector, arr, date);
    });

    function ajax_submission(sector, arr, date) {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        $.ajax({
            method: 'POST',
            url: '/admin/expenseReport/CategoryFilter',
            data: {
                _token: '{{ csrf_token() }}',
                sector: sector,
                id: arr,
                date: date,
            },
            dataType: "json",
            success: function (data) {
                console.log(data.categories);
                $('#all_data').html(data.all_data);
                $('#report_cat').html(data.report_cat);
                $('#report_sub').html(data.report_sub);
                $('#report_footer').html(data.report_footer);
            }
        })
    }

    function ajax_submission_sector(sector, date) {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        $.ajax({
            method: 'POST',
            url: '/admin/expenseReport/SectorFilter',
            data: {
                _token: '{{ csrf_token() }}',
                id: sector,
                date: date,
            },
            dataType: "json",
            success: function (data) {
                console.log(data.categories);
                $('#all_data').html(data.all_data);
                $('#report_cat').html(data.report_cat);
                $('#report_sub').html(data.report_sub);
                $('#sector_categories').html(data.sector_categories);
                $('#sector_name').html(data.sector_name);
                $('#report_footer').html(data.report_footer);
            }   
        })
    }

</script>
