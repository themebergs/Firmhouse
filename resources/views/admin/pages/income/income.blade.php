<div class="col-md-6">
        <div class="box box-warning">
            {!!Form::open(['action' => 'IncomeController@store','method' => 'POST' ,'id'=>'income_store'])!!}
            <div class="box-header with-border">
                <h3 class="box-title">Add in Income list</h3>
                <div class="input-group pull-right">
                    {{ Form::date('date',null,['id'=>'amount']) }}
                </div>
            </div>
            <div class="box-body">
                <div class="form-group">
                    <label for="">Select Category</label>
                    {{ Form::select('category_id', $categories, null, array('id'=>'category_input','class'=>'form-control', 'placeholder'=>'Please select ...', 'required')) }}
                </div>
                <div class="form-group">
                    <label for="">Select SubCategory</label>
                    <select name="subcategory_id" class="form-control" id="sub_categories" disabled
                        title="please Select Sub Category" required></select>
                </div>
                <div class="form-group">
                    <label for="">Amount</label>
                    {{Form::number('amount',null,['class' => 'form-control', 'required', 'min'=>'0'])}}
                </div>
                <div class="form-group">
                    <label for="">Description</label>
                    {{Form::textarea('description',null,['class' => 'form-control'])}}
                </div>
                {{Form::submit('Add in Income', ['class'=>'btn btn-info', 'id'=>'upload_btn'])}}
                <input type="reset" value="reset">
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="box box-info" id="income_history" style="display:none">
            <div class="box-header with-border">
                <h3 class="box-title float-left">Income History(current month): &nbsp; <span id="sector_name"></span> >
                    <span id="category_name"></span></h3>
            </div>
            <div class="box-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 150px">Date</th>
                            <th>SubCategory</th>
                            <th>Amount</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="show_income"></tbody>
                </table>
            </div>
        </div>
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Recent Income Inputs</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Sub Category</th>
                            <th>Amount</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="latest_date">
                        @foreach($incomes as $income)
                        <tr>
                            <td>{{ $income->date }}</td>
                            <td>{{ $income->SubCategory->name }}</td>
                            <td>{{ $income->amount }}</td>
                            <td>{{ $income->description }}</td>
                            <td>
                                <button data-toggle="modal" 
                                    class="edit_income btn btn-info btn-sm" 
                                    data-target="#edit_income_modal"
                                    data-id="{{$income->id}}"
                                    data-amount="{{ $income->amount }}" 
                                    data-date="{{$income->date}}"
                                    data-description="{{$income->description}}">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <a href="/admin/income_del/{{$income->id}}" onclick="return ConfirmDelete()"
                                    class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
    
    
    @include ('admin.pages.income.edit_modal')
    
    <script type="text/javascript">
        $('#category_input').on('change', function () {
            var category_id = $(this).val();
            // console.log(category_id);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                method: 'get',
                url: '/admin/find_income_sub_category/' + category_id,
    
                dataType: "json",
                success: function (data) {
                    $('#sub_categories').prop('disabled', false);
                    $('#sub_categories').html(data.sub_categories);
                    $('#show_income').html(data.show_income);
                    $('#sector_name').text(data.sector_name);
                    $('#category_name').text(data.category_name);
                    $('#edit_url').text(data.edit_url);
                    // document.getElementById("all_history").href = data.edit_url;
                    document.getElementById("income_history").style.display = "block";
                }
            })
        });
    

        // Store Data
        //=====================================================
        $(document).on('submit', '#income_store', function (e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
    
            $.ajax({
                method: $(this).attr('method'),
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                success: function (data) {
                    if (data.ajax_status == 'success') {
                        $('#ajax_status').html(data.ajax_status);
                        $('#ajax_message').html(data.ajax_message);
                        document.getElementById("ajax-success").style.display = "block";
    
                        $('#sub_categories').prop('disabled', false);
                        $('#sub_categories').html(data.sub_categories);
                        $('#show_income').html(data.show_income);
                        $('#latest_date').html(data.latest_date);
                        $('#sector_name').text(data.sector_name);
                        $('#category_name').text(data.category_name);
                        $('#edit_url').text(data.edit_url);
                        document.getElementById("all_history").href = data.edit_url;
                        document.getElementById("income_history").style.display = "block";

    
                    }
                    if (data.errors) {
                        $('#success').html('');
                        $('#errors').html('');
                        $.each(data.errors, function (key, value) {
                            $('#errors').append('<p>' + value + '</p>');
                        });
                    }
    
                }
            })
        });
    
    </script>
    