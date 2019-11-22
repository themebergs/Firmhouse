@section('admin_header')

<li><a href="/admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
<li class="active">All {{ $title }}s</li>

@endsection

<div class="box">
    <div class="box-header">
        <h3 class="box-title"><strong>{{ $title }} List:</strong> Total {{ $AllAdmin->total() }}</h3>
        @can('isSuperAdmin')
        <div class="pull-right">
            @include ('admin.snippets.registration_modal')
        </div>
        @endcan
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div id="table_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
            <div class="row">
                <div class="col-sm-12">
                    <div class="d-flex justify-content-between align-items-center">
                        Showing {{ $AllAdmin->count() }} of {{ $AllAdmin->total() }} &nbsp;{{ $AllAdmin->links() }} 
                    </div>
                    <div class="table-responsive">
                    <table id="admin_table" class="table table-bordered table-striped dataTable" role="grid"
                        aria-describedby="table_info">
                        <thead>
                            <tr>
                                <th class="image">Image</th>
                                <th class="id"> ID</th>
                                <th>Name </th>
                                <th>Role</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Phone No.</th>
                                <th>Member Since </th>
                                @can('isSuperAdmin')
                                <th style="min-width:60px;"> Action</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody id="admin_list">
                            @foreach($AllAdmin as $admin)
                            <tr>
                                <td class="image">
                                    @if($admin->user_image)
                                    <img src="{{ asset('laravel/public/images/user/'.$admin->user_image) }}" alt="">
                            @endif
                            </td>
                            <td>{{ $admin->id }}</td>
                            <td>{{ $admin->name }}</td>
                            <td>
                                @if($admin->admin_role == 'super_admin')
                                Super Admin
                                @elseif($admin->admin_role == 'admin')
                                Admin
                                @elseif($admin->admin_role == 'user')
                                User
                                @elseif($admin->admin_role == 'investor')
                                Investor
                                @endif
                                @if($admin->role_id != '')
                                {{ $admin->Role->name }}
                                @endif
                                @if ($admin->investor == '1')
                                , Investor
                                @endif
                            </td>
                            <td>
                                {{ $admin->username }}
                            </td>
                            <td>{{ $admin->email }}</td>
                            <td>{{ $admin->phone }}</td>
                            <td>{{ $admin->created_at->format('d/m/Y') }}</td>
                            <td>
                            @can('isSuperAdmin')
                                {!!Form::open(['route' => ['all_admin.destroy', $admin->id], 'method' =>
                                'DELETE'])!!}
                            @endcan

                                {!! Html::decode(link_to_route('all_admin.edit', '<i
                                    class="fa fa-eye"></i>',[$admin->id], ['class' => 'btn btn-info',
                                'title'=>'View/Edit'])) !!}
                                
                            @can('isSuperAdmin')
                                <button type="submit" class="btn btn-danger" onclick="return ConfirmDelete()">
                                    <i class="fa fa-trash"></i>
                                </button>

                                {!!Form::close()!!}
                            @endcan
                            </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        Showing {{ $AllAdmin->count() }} of {{ $AllAdmin->total() }} &nbsp;{{ $AllAdmin->links() }} 
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
