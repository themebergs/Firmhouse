<div class="col-md-3">
        <!-- Profile Image -->
        <div class="box box-primary">
            <div class="box-body box-profile">
                @if(isset($user->user_image))
                <img class="profile-user-img img-responsive img-circle" src="{{ asset('laravel/public/images/user/'.$user->user_image) }}" alt="User profile picture">
                @else
                <img class="profile-user-img img-responsive img-circle" src="{{ asset('images/avater.png') }}" alt="User profile picture">
                @endif
    
                <h3 class="profile-username text-center">{{ $user->name }}</h3>
    
                <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                        <b>Email</b> <a class="pull-right">{{ $user->email }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>Phone</b> <a class="pull-right">{{ $user->phone }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>Address: </b> <a class="pull-right">{{ $user->address }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>Member Since: </b> <a class="pull-right">{{ $user->created_at->format('d/m/Y') }}</a>
                    </li>
                </ul>
    
                <a href="/admin/member/{{ $user->id }}" class="btn btn-primary btn-block"><b>View Profile</b></a>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    
    <div class="col-md-9">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Investment History (Current Month) </h3>
                <div class="form-group pull-right">
                    <label for="month_input">Select Month</label>
                    <input type="month" id="month_input" value="{{ date('Y-m') }}">
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body  table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th width="150px">Date</th>
                            <th width="150px">Amount</th>
                            <th>Description</th>
                            @can('isSuperAdmin')
                            <th>Action</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody id="history_data">
                        @foreach($investments as $investment)
                        <tr>
                            <td>{{ $investment->date }}</td>
                            <td>{{ $investment->amount }}/=</td>
                            <td>{{ $investment->description }}</td>
                            @can('isSuperAdmin')
                            <td>
                                <button  data-toggle="modal"
                                         data-target="#edit_investment_modal"
                                         data-id= "{{ $investment->id }}"
                                         data-amount="{{ $investment->amount }}"
                                         data-description="{{ $investment->description }}"
                                         class="edit_investment btn btn-info btn-sm">
                                    <i class="fa fa-edit"></i>
                                </button>
                            <a href="{{ url('admin/investment_del/'.$investment->id) }}" class="btn btn-danger btn-sm" onclick="return ConfirmDelete()">
                                <i class="fa fa-trash"></i>
                            </a>
                            </td>
                            @endcan
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td><strong id="total">Total: {{ $total_received }}/=</strong></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    
    <div class="clearfix"></div>
    
    <div class="col-md-3">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Investment History (All): <strong>Total: {{ $total_received_all }}/=</strong></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive" style="max-height: 500px; overflow-y: scroll;">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th width="150px">Date</th>
                            <th width="150px">Amount</th>
                        </tr>
                    </thead>
                    <tbody id="history_data">
                        @foreach($all_investments as $investment)
                        <tr>
                            <td>{{ $investment->date }}</td>
                            <td>{{ $investment->amount }}/=</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include ('admin.snippets.investment_edit')
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script type="text/javascript">
        $('#month_input').on('change', function() { 
            var date = $(this).val();
            var id = {{ $user->id }};
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                method: $(this).attr('method'),
                url: '/admin/investment/filter',
                data: {
                    date: date,
                    id: id
                },
                dataType: "json",
                success: function(data) {
                    $('#history_data').html(data.history_data);
                    $('#total').text(data.total);
                }
            })
        });

        $(document).on('click', '.edit_investment', function (e) {
            var id = $(this).data('id');
            var amount = $(this).data('amount');
            var description = $(this).data('description');
            $(".modal-body #invest_id").val(id);
            $(".modal-body #amount").val(amount);
            $(".modal-body #description").val(description);
        });
    </script>