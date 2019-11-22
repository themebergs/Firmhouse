<button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal-default">
    Change User Roles
</button>


<div class="modal fade" id="modal-default" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Change Role</h4>
            </div>
            <div class="modal-body">
                {!! Form::model($User, ['method' => 'PUT', 'action' => ['AdminController@update',$User->id]]) !!}
                <div class="form-group">
                    <label for="">Admin Role</label>
                    <select name="admin_role" class="form-control" title="Admin Role">
                        <option value="super_admin" @if($User->admin_role == 'super_admin')
                            selected @endif >Super Admin</option>
                        <option value="admin" @if($User->admin_role == 'admin') selected
                            @endif>Admin</option>
                        <option value="user" @if($User->admin_role == 'user') selected
                        @endif>User</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Employee Role</label>
                    <select name="role_id" class="form-control" title="Employee Role">
                        <option value="" @if(empty($User->role_id)) selected @endif>None</option>
                        @foreach ($role_menu as $role)
                        <option value="{{ $role->id }}" @if($User->role_id == $role->id) selected @endif>
                            {{ $role->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="checkbox " id="set_investor">
                    <label>
                      <input type="checkbox" id="set_investor" @if($User->investor == 1) checked @endif> Investor
                    </label>
                </div>
                {{Form::submit('Save', ['class'=>'btn btn-info pull-right'])}}
                {!! Form::close() !!}
                <div class="clearfix"></div>
            </div>

        </div>
    </div>
</div>
