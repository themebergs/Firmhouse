<!-- Modal -->
<div id="edit_income_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            {!! Form::open(['action'=>'IncomeController@update','method'=>'POST', 'id'=>'income_update']) !!}

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Expense</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="income_id" id="income_id" value="">
                <div class=" row form-group">
                    {!! Form::label('date', 'Date ',['class'=>'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {{Form::date('date',null,['class' => 'form-control', 'id'=>'date'])}}
                    </div>
                </div>

                <div class=" row form-group">
                    {!! Form::label('amount', 'Amount ',['class'=>'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {{Form::number('amount',null,['class' => 'form-control', 'id'=>'amount','required'])}}
                    </div>
                </div>

                <div class="row form-group">
                    {!! Form::label('description', 'Description ',['class'=>'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {{Form::textarea('description',null,['class' => 'form-control', 'id'=>'description', 'rows'=>'5'])}}
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                {{Form::submit('Save', ['class'=>'btn btn-info'])}}
            </div>
            {!! Form::close() !!}
        </div>

    </div>
</div>


<script>
    $(document).on('click', '.edit_income', function () {
        var id = $(this).data('id');
        var amount = $(this).data('amount');
        var description = $(this).data('description');
        var date = $(this).data('date');
        var category = $(this).data('category');
        $(".modal-body #income_id").val(id);
        $(".modal-body #amount").val(amount);
        $(".modal-body #date").val(date);
        $(".modal-body #description").val(description);
        $(".modal-body #category").val(category);
    });

    $(document).on('submit', '#income_update', function (e) {
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

                    $('#edit_income_modal').modal('hide');
                    var category_id = data.category;
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });
                    $.ajax({
                        method: 'post',
                        url: '/admin/income/find_sub_category/',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            category_id: category_id
                        },
                        dataType: "json",
                        success: function (data) {
                            $('#sub_categories').prop('disabled', false);
                            $('#sub_categories').html(data.sub_categories);
                            $('#show_income').html(data.show_income);
                            $('#sector_name').text(data.sector_name);
                            $('#category_name').text(data.category_name);
                            $('#edit_url').text(data.edit_url);
                            document.getElementById("all_history").href = data.edit_url;
                            document.getElementById("income_history").style.display = "block";
                        }
                    })
                    setTimeout(function() 
                    {
                        location.reload();  //Refresh page
                    }, 1000);
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
