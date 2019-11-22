<!-- Modal -->
<div id="edit_sector" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            {!! Form::open(['action'=>'SectorController@update','method'=>'POST', 'id'=>'expense_update']) !!}

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Sector Details</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="sector_id" id="sector_id" value="">
                <div class=" row form-group">
                    {!! Form::label('name', 'Name ',['class'=>'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {{Form::text('name',null,['class' => 'form-control', 'id'=>'Name','required'])}}
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

$(document).on('submit', '#sector_edit_form', function (e) {
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

                    $('#edit_sector').modal('hide');
                    
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