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

            <p class="text-muted text-center">{{ $user->Role->name }}</p>

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
            <h3 class="box-title">Salay History </h3>
            <div class="form-group pull-right">
                <label for="month_input">Select Month</label>
                <input type="month" id="month_input" value="{{ date('Y-m') }}">
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th width="150px">Date</th>
                        <th width="150px">Amount</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody id="history_data">
                    @foreach($salaries as $salary)
                    <tr>
                        <td>{{ $salary->created_at->format('d/m/Y') }}</td>
                        <td>{{ $salary->amount }}/=</td>
                        <td>{{ $salary->description }}</td>
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
            url: '/admin/salary/filter',
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
</script>