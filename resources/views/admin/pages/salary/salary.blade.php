
<div class="col-md-6">
    <div class="box box-info">
            {!!Form::open(['action' => 'SalaryController@store','method' => 'POST','id'=>'salary_form'])!!}
            <input type="hidden" name="salary">

            <div class="box-header with-border">
                <h3 class="box-title">{{ $title }} Salary</h3>
                <span id="error"></span>
                <div class="input-group pull-right">
                    {{ Form::date('date',null,['id'=>'amount']) }}
                </div>
            </div>

            <div class="box-body">
                <div class="row select_search">
                    {!! Form::label('select_user_for_salary', 'Select '.$title ,['class'=>'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {{ Form::select('user_id', $Users, null, array('class'=>'form-control selectpicker', 'data-live-search'=>'true', 'data-size='=>'15', 'title'=>'Select Staff', 'id'=>'select_user_for_salary','required')) }}
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

                <div class="button-group  pull-right">
                    {{Form::reset('Reset', ['class'=>'btn btn-default'])}}
                    {{Form::submit('Save', ['class'=>'btn btn-info'])}}
                </div>
            </div>

            {!! Form::close() !!}
    </div>
</div>

<div class="col-md-3" id="user_info" style="display:none">
    <div class="box box-primary">
        <div class="box-body box-profile">

            <img id="user_image" class="profile-user-img img-responsive img-circle"
                src="{{ asset('images/avater.png') }}" alt="User profile picture">

            <h3 class="profile-username text-center" id="username">Nina Mcintire</h3>

            <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                    <b>Employee Role:</b> <span class="pull-right" id="user_role"></span>
                </li>
                <li class="list-group-item">
                    <b>Email:</b> <span class="pull-right" id="user_email"></span>
                </li>
                <li class="list-group-item">
                    <b>Phone:</b> <span class="pull-right" id="user_phone"></span>
                </li>
                <li class="list-group-item">
                    <b>Address:</b> <span class="pull-right" id="user_address"></span>
                </li>
                <li class="list-group-item">
                    <b>Member Since:</b> <span class="pull-right" id="user_member"></span>
                </li>

            </ul>

            <a id="user_link" href="#" class="btn btn-primary btn-block"><b>View Profile</b></a>
        </div>
        <!-- /.box-body -->
    </div>
</div>

<div class="col-md-3"  id="user_history" style="display:none">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{ $title }} History</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <strong><i class="fa fa-book margin-r-5"></i> Monthly Salary: </strong>

            <p class="text-muted" id="monthly_salary"></p>

            <hr>
            <strong><i class="fa fa-book margin-r-5"></i> Total Received This Month: </strong>

            <p class="text-muted" id="total"></p>

            <hr>
            <strong><i class="fa fa-book margin-r-5"></i> Last Received on <span id="last_date">27/03/2019</span>: </strong>

            <p class="text-muted" id="last_received"></p>

            <hr>

            <strong><i class="fa fa-map-marker margin-r-5"></i> Can Receive</strong>

            <p class="text-muted" id="due_amount"></p>

            <hr>

            <a href="" id="history_link" class="btn btn-info btn-block">View History</a>

        </div>
        <!-- /.box-body -->
    </div>
</div>






<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script type="text/javascript">
    $(document).on('submit', '#salary_form', function(e) {     
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            method: $(this).attr('method'),
            url: '/admin/salary/store',
            data: $(this).serialize(),
            dataType: "json",
            success: function(data) {
                if(data.ajax_status == 'success'){
                    $('#error').text('');
                    $( '#ajax_status' ).html(data.ajax_status);
                    $( '#ajax_message' ).html(data.ajax_message);
                    $('#total').text(data.total);
                    $('#last_received').text(data.last_received);
                    $('#last_date').text(data.last_date);
                    $('#due_amount').text(data.due_amount);
                    document.getElementById("ajax-failed").style.display = "none";
                    document.getElementById("ajax-success").style.display = "block";
                }
               if(data.ajax_status == 'Failed'){
                    document.getElementById("ajax-failed").style.display = "block";
                    document.getElementById("ajax-success").style.display = "none";
                    $( '#ajax_error' ).html(data.ajax_status);
                    $('#error_message').text(data.ajax_message);
               }
                
            }
        })
    });
</script>