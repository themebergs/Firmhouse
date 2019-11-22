<div class="col-md-6">
    <div class="box box-warning">
        {!!Form::open(['action' => 'ExpenseController@store','method' => 'POST' ,'id'=>'expense_store'])!!}
        <div class="box-header with-border">
            <h3 class="box-title">Add in expense list</h3>
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
            {{Form::submit('Add in Expense', ['class'=>'btn btn-info', 'id'=>'upload_btn'])}}
            <input type="reset" value="reset">
        </div>
        {!! Form::close() !!}
    </div>
</div>

<div class="col-md-6">
    <div class="box box-info" id="expense_history" style="display:none">
        <div class="box-header with-border">
            <h3 class="box-title float-left">Expense History(current month): &nbsp; <span id="sector_name"></span> >
                <span id="category_name"></span></h3>

            <!--<div style="float:right">-->
            <!--    <a href="" id="all_history">View History</a>-->
            <!--</div>-->
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
                <tbody id="show_expense"></tbody>
            </table>
        </div>
    </div>
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Recent Expense Inputs</h3>
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
                <tbody>
                    @foreach($expenses as $expense)
                    <tr>
                        <td>{{ $expense->date }}</td>
                        <td>{{ $expense->SubCategory->name }}</td>
                        <td>{{ $expense->amount }}</td>
                        <td>{{ $expense->description }}</td>
                        <td>
                            <button data-toggle="modal" 
                                class="edit_expense btn btn-info btn-sm" 
                                data-target="#edit_expense_modal"
                                data-id="{{$expense->id}}" 
                                data-amount="{{$expense->amount}}" 
                                data-date="{{$expense->date}}"
                                data-description="{{$expense->description}}">
                                <i class="fa fa-edit"></i>
                            </button>
                        <a href="/admin/expense_del/{{$expense->id}}" onclick="return ConfirmDelete()"
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


@include ('admin.pages.expense.edit_modal')

<script type="text/javascript">
    $('#category_input').on('change', function () {
        var category_id = $(this).val();
        console.log(category_id);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            method: 'get',
            url: '/admin/find_expense_sub_category/' + category_id,

            dataType: "json",
            success: function (data) {
                $('#sub_categories').prop('disabled', false);
                $('#sub_categories').html(data.sub_categories);
                $('#show_expense').html(data.show_expense);
                $('#sector_name').text(data.sector_name);
                $('#category_name').text(data.category_name);
                $('#edit_url').text(data.edit_url);
                // document.getElementById("all_history").href = data.edit_url;
                document.getElementById("expense_history").style.display = "block";
            }
        })
    });


    // Get Expense data
    //-------------------------------------------------
    $("#sub_categories").change(function () {
        // alert($(this).val());
        var id = $(this).val();
        $.ajax({
            url: "/admin/expense_history",
            method: 'GET',
            data: {
                id: id,
            },
            dataType: 'json',
            success: function (data) {
                //
            }
        })
    });

    // Store Data
    //=====================================================
    // $(document).on('submit', '#expense_store', function (e) {
    //     e.preventDefault();
    //     $.ajaxSetup({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    //         }
    //     });

    //     $.ajax({
    //         method: $(this).attr('method'),
    //         url: $(this).attr('action'),
    //         data: $(this).serialize(),
    //         dataType: "json",
    //         success: function (data) {
    //             if (data.ajax_status == 'success') {
    //                 $('#ajax_status').html(data.ajax_status);
    //                 $('#ajax_message').html(data.ajax_message);
    //                 document.getElementById("ajax-success").style.display = "block";

    //                 $('#sub_categories').prop('disabled', false);
    //                 $('#sub_categories').html(data.sub_categories);
    //                 $('#show_expense').html(data.show_expense);
    //                 $('#sector_name').text(data.sector_name);
    //                 $('#category_name').text(data.category_name);
    //                 $('#edit_url').text(data.edit_url);
    //                 document.getElementById("all_history").href = data.edit_url;
    //                 document.getElementById("expense_history").style.display = "block";
                    

    //             }
    //             if (data.errors) {
    //                 $('#success').html('');
    //                 $('#errors').html('');
    //                 $.each(data.errors, function (key, value) {
    //                     $('#errors').append('<p>' + value + '</p>');
    //                 });
    //             }

    //         }
    //     })
    // });

</script>
