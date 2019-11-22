<div class="col-md-6">
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Add/Edit Role: </h3>
            <div id="errors"></div>
        </div>
        @if(isset($Role))
        {!! Form::model($Role, ['method' => 'PUT', 'action' => ['RoleController@update',$Role->id]]) !!}
        @else
        {!!Form::open(['action' => 'RoleController@store','method' => 'POST'])!!}
        @endif
        <div class="box-body">
            <div class="form-group">
                {!! Form::label('name', 'Role Name: ',['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {{Form::text('name',null,['value'=>'$Role->name','class' => 'form-control'])}}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('description', 'Description: ',['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {{Form::textarea('description',null,['value'=>'$Role->description','class' => 'form-control','rows'=>'5'])}}
                </div>
            </div>
            <div class="form-group">
                @if(isset($Role))
                <a href="/admin/employee_roles" class="btn btn-danger">New Role</a>
                @endif
                <div class="pull-right">
                    {{ Form::reset('reset',['class'=>'btn btn-default']) }}
                    @if(isset($Role))
                    {{ Form::submit('Update',['class'=>'btn btn-primary']) }}
                    @else
                    {{ Form::submit('Save',['class'=>'btn btn-info']) }}
                    @endif
                </div>
                
                
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
<div class="col-md-6">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Striped Full Width Table</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body no-padding">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Role</th>
                        <th>Description</th>
                        <th style="width: 100px">action</th>
                    </tr>
                </thead>
                <tbody id="role_list">
                    @foreach($roles as $role)
                    <tr>
                        <td>{{ $role->id }}</td>
                        <td>{{ $role->name }}</td>
                        <td>{{ $role->description }}</td>
                        <td>
                            {!!Form::open(['route' => ['employee_roles.destroy', $role->id], 'method' =>
                            'DELETE'])!!}

                            {!! Html::decode(link_to_route('employee_roles.edit', '<i
                                class="fa fa-edit"></i>',[$role->id], ['class' => 'btn btn-info',
                            'title'=>'View/Edit'])) !!}

                            <button type="submit" class="btn btn-danger" onclick="return ConfirmDelete()">
                                <i class="fa fa-trash"></i>
                            </button>

                            {!!Form::close()!!}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.box-body -->
    </div>
</div>

