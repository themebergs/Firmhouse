@section('admin_header')

<li><a href="/admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
<li><a href="/admin/all_admin">All Admins</a></li>
<li class="active">{{ $User->name }}</li>

@endsection

<section class="profile-section">
    <div class="col-md-3">
        <div class="box box-primary">
            <div class="box-body box-profile">
                <div class="box-header with-border text-center">
                    <h3 class="box-title">Name</h3>
                </div>
                <div class="box-body">
                    <div class="d-flex justify-content-center">
                        {{-- ========================================== --}}
                        {{-- Image Upload/ Update :Start --}}
                        {{-- ========================================== --}}
                        {!! Form::model($User, ['enctype' => 'multipart/form-data','method' => 'PUT', 'action' =>
                        ['UserController@update',$User->id]]) !!}
                        <div class="image">

                            @if($User->user_image)

                            <img id="output" class="img-responsive" src="{{ asset('laravel/public/images/user/'.$User->user_image) }}">
                                @if(auth()->user()->id == $User->id)
                                <div class="photo_post">
                                    {{Form::file('user_image', ['class'=>'file', 'id'=>'f02','placeholder'=>'Insert Image', 'onchange'=>'loadFile(event)'])}}
                                    {!! Form::label('f02', 'Change Image', ['class'=>'change_image']) !!}
                                </div>
                                @else
                                    @can('isSuperAdmin')
                                    <div class="photo_post">
                                        {{Form::file('user_image', ['class'=>'file', 'id'=>'f02','placeholder'=>'Insert Image', 'onchange'=>'loadFile(event)'])}}
                                        {!! Form::label('f02', 'Change Image', ['class'=>'change_image']) !!}
                                    </div>
                                    @endcan
                                @endif
                            
                            @else
                            <img id="output" class="img-responsive" src="{{ asset('images/avater.png') }}">
                                @if(auth()->user()->id == $User->id)
                                <div class="photo_post">
                                    {{Form::file('user_image', ['class'=>'file', 'id'=>'f02','placeholder'=>'Insert Image', 'onchange'=>'loadFile(event)'])}}
                                    {!! Form::label('f02', 'Upload Photo', ['class'=>'change_image']) !!}
                                </div>
                                @else
                                    @can('isSuperAdmin')
                                    <div class="photo_post">
                                        {{Form::file('user_image', ['class'=>'file', 'id'=>'f02','placeholder'=>'Insert Image', 'onchange'=>'loadFile(event)'])}}
                                        {!! Form::label('f02', 'Upload Photo', ['class'=>'change_image']) !!}
                                    </div>
                                    @endcan
                                @endif
                            @endif

                        </div>
                        {{Form::submit('Submit', ['class'=>'btn btn-info', 'id'=>'upload_btn'])}}
                        {!! Form::close() !!}
                        {{-- ========================================== --}}
                        {{-- Image Upload/ Update :End --}}
                        {{-- ========================================== --}}
                    </div>
                </div>
            </div>
        </div>

    </div>


    <div class="col-md-9">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#info" data-toggle="tab">Info</a></li>
                @if(auth()->user()->id == $User->id)
                <li class=""><a href="#update" data-toggle="tab">Update Information</a></li>
                @else
                    @can('isSuperAdmin')
                    <li class=""><a href="#update" data-toggle="tab">Update Information</a></li>
                    @endcan
                @endif
                @can('isSuperAdmin')
                <li class="pull-right d-flex justify-conter-end align-items-center">
                    @include ('admin.snippets.role_modal')
                </li>
                @endcan
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="info">
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Name:</td>
                                    <td>{{ $User->name }}</td>
                                </tr>
                                <tr>
                                    <td>Username:</td>
                                    <td>{{ $User->username }}</td>
                                </tr>
                                <tr>
                                    <td>Email:</td>
                                    <td>{{ $User->email }}</td>
                                </tr>
                                <tr>
                                    <td>NID:</td>
                                    <td>{{ $User->nid }}</td>
                                </tr>
                                <tr>
                                    <td>Phone:</td>
                                    <td>{{ $User->phone }}</td>
                                </tr>
                                @if(!empty($User->role_id))
                                <tr>
                                    <td>Salary:</td>
                                    <td>{{ $User->Salary->amount }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <td>Status:</td>
                                    <td id="user_role">
                                        @if($User->admin_role == 'super_admin')
                                        Super Admin
                                        @elseif($User->admin_role == 'admin')
                                        Admin
                                        @elseif($User->admin_role == 'investor')
                                        Investor
                                        @else
                                        User
                                        @endif
                                        @if (!empty($User->role_id))
                                        , {{ $User->Role->name }}
                                        @endif
                                        @if ($User->investor == '1')
                                        , Investor
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Address:</td>
                                    <td>{{ $User->address }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>

                <!-- /.tab-pane -->
                @if(auth()->user()->id == $User->id)
                    @include('admin/snippets/user_update')
                @else
                    @can('isSuperAdmin')
                    @include('admin/snippets/user_update')
                    @endcan
                @endif
               
                <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
        </div>
    </div>

</section>


