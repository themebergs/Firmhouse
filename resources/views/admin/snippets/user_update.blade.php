<div class="tab-pane" id="update">
    <div class="clearfix"></div>
    {{-- ========================================== --}}
    {{--  Update :Start --}}
    {{-- ========================================== --}}
    {!! Form::model($User, ['enctype' => 'multipart/form-data','method' => 'PUT', 'action' =>
    ['UserController@update',$User->id]]) !!}

    <div class="form-group">
        {!! Form::label('name', 'Full Name: ',['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
            {{Form::text('name',null,['value'=>'$User->name', 'class' => 'form-control'])}}
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('username', 'Username: ',['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
            {{Form::text('username',null,['value'=>'$User->username','class' => 'form-control'])}}
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('email', 'Email Address: ',['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
            {{Form::text('email',null,['value'=>'$User->email', 'class' => 'form-control'])}}
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('nid', 'NID: ',['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
            {{Form::text('nid',null,['value'=>'$User->nid', 'class' => 'form-control'])}}
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('phone', 'Phone Number: ',['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
            {{Form::text('phone',null,['value'=>'$User->phone', 'class' => 'form-control'])}}
        </div>
    </div>
    @can('isSuperAdmin')
    @if(!empty($User->role_id))
    <div class="form-group">
        {!! Form::label('salary', 'Salary: ',['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
            <input type="number" name="salary" class="form-control" value="{{ $User->Salary->amount }}" required>
        </div>
    </div>
    @endif
    @endcan
    <div class="form-group">
        {!! Form::label('address', 'Detailed Address: ',['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
            {{Form::textarea('address',null,['value'=>'$User->address', 'class' => 'form-control'])}}
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            {{ Form::submit('Submit',['class'=>'btn btn-danger']) }}
        </div>
    </div>
    {{ Form::submit('Submit',['class'=>'btnbtn-info','id'=>'upload_btn']) }}
    {!! Form::close() !!}
    {{-- ========================================== --}}
    {{-- Image Upload/ Update :End --}}
    {{-- ========================================== --}}
</div>