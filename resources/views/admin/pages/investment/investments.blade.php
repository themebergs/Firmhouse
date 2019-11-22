<div class="col-md-6">
        <div class="box box-info">
                {!!Form::open(['action' => 'InvestmentController@store','method' => 'POST','id'=>'investment_form'])!!}
    
                <div class="box-header with-border">
                    <h3 class="box-title">Add Investment</h3>
                    <span id="error"></span>
                    <div class="input-group pull-right">
                        {{ Form::date('date',null,['id'=>'amount']) }}
                    </div>
                </div>
    
                <div class="box-body">
                    <div class="row select_search">
                        {!! Form::label('select_user_for_investment', 'Select User',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {{ Form::select('user_id', $Users, null, array('class'=>'form-control selectpicker', 'data-live-search'=>'true', 'data-width='=>'auto', 'title'=>'Select Investor', 'id'=>'select_user_for_investment','required')) }}
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
                        <b>User Role:</b> <span class="pull-right" id="user_role"></span>
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
                <h3 class="box-title">Investment History</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <strong><i class="fa fa-book margin-r-5"></i> Total Investment This Month: </strong>
    
                <p class="text-muted" id="total_investment"></p>
    
                <hr>
                <strong><i class="fa fa-book margin-r-5"></i> Last Investment <span id="last_investment"></span> on <span id="last_investment_date">27/03/2019</span>: </strong>
    
                <hr>
    
                <a href="" id="history_link" class="btn btn-info btn-block">View History</a>
    
            </div>
            <!-- /.box-body -->
        </div>
    </div>
    
    
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).on('submit', '#investment_form', function(e) {     
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                method: $(this).attr('method'),
                url: '/admin/investment/store',
                data: $(this).serialize(),
                dataType: "json",
                success: function(data) {
                    if(data.ajax_status == 'success'){
                        $('#error').text('');
                        $( '#ajax_status' ).html(data.ajax_status);
                        $( '#ajax_message' ).html(data.ajax_message);
                        $('#total_investment').text(data.total_investment);
                        $('#last_investment').text(data.last_investment);
                        $('#last_investment_date').text(data.last_investment_date);
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
    