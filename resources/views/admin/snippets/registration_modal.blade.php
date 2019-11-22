<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#registration_modal">
    Add {{ $title }}
</button>

<div class="modal fade" id="registration_modal" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">{{ $title }} Registration: &nbsp;<span id="success"></span></h4>
                <div id="errors"></div>
            </div>
            <div class="modal-body">
                <form id="formRegister" method="POST" action="{{ route('admin.register') }}">
                    @include ('forms.registration_form')

                    @can('isSuperAdmin')
                    @if(request()->is('*/all_admin'))
                    <div class="form-group row">
                        <label for="role" class="col-md-4 col-form-label text-md-right">{{ __('Admin Role') }}</label>
                        <div class="col-md-8">
                            <select name="admin_role" id="role">
                                <option value="{{ encrypt('admin') }}" selected>Admin</option>
                                <option value="{{ encrypt('super_admin') }}">Super Admin</option>
                            </select>
                        </div>
                    </div>
                    @endif
                    @endcan

                    @if(request()->is('*/investors'))
                        <input type="hidden" name="investor" value="1">
                    @endif

                    @if(request()->is('*/users/*'))
                    <div class="form-group row">
                        <label for="role" class="col-md-4 col-form-label text-md-right">{{ $title }} Role</label>
                        <div class="col-md-8">
                            <select name="employee_role" id="role">
                                @foreach($roles as $role)
                                    <option value="{{ encrypt($role->id) }}" @if(request()->route('id') == $role->id) selected @endif>{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="role" class="col-md-4 col-form-label text-md-right">{{ $title }} Salary</label>
                        <div class="col-md-6">
                            <input type="number" min="0" name="salary" class="form-control" required>
                        </div>
                    </div>
                    @endif

                    <div class="form-group row mb-0">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary pull-right">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>



<script src="{{ asset('AdminLTE/bower_components/jquery/dist/jquery.min.js') }}"></script>
<script type="text/javascript">
    $(document).on('submit', '#formRegister', function (e) {
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
                    console.log(data.role);
                    $('#errors').html('');

                    $('#ajax_status').html(data.ajax_status);
                    $('#ajax_message').html(data.ajax_message);
                    document.getElementById("ajax-success").style.display = "block";

                    $('#registration_modal').modal('hide');

                    $('#admin_list').prepend(
                        `<tr><td></td><td>` + data.id + `</td><td>` + data.name + `</td><td>` +
                        data.admin_role + `</td><td>`+ data.username +`</td><td>` + data.email +
                        `</td><td></td><td>` + data.created_at +
                        `</td><td><form method="POST" action="/admin/all_admin/` + data.id +
                        `"> {!! csrf_field() !!} {{ method_field('DELETE') }} <a href="/admin/all_admin/` +
                        data.id +
                        `/edit" class="btn btn-info" title="View/Edit"><i class="fa fa-edit"></i></a>  <button type="submit" class="btn btn-danger" onclick="return ConfirmDelete()"> <i class="fa fa-trash"></i></button> {!!Form::close()!!}</td></tr>`
                    );
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
