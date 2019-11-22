@section('admin_header')

<li><a href="/admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
<li><a href="/admin/sectors"> Sectors</a></li>
<li><a href="/admin/sectors/{{ $Category->Sector->id }}"> {{ $Category->Sector->name }}</a></li>
<li class="active">{{ $Category->name }}</li>

@endsection

<div class="row">
    <div class="col-md-4">

        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Add Sub Category</h3>

                @can('isSuperAdmin')
                    @if (Request::is('*/subcategories/*'))
                        <div class="form-group pull-right">
                            <div class="checkbox m-0">
                                <label>
                                <input type="checkbox" id="salary_field" @if($SubCategory->salary == 1) checked @endif>
                                Salary Field
                                </label>
                            </div>
                        </div>
                    @endif
                @endcan
            </div>
            @if(isset($SubCategory))
            {!! Form::model($SubCategory, ['method' => 'PUT', 'action' =>
            ['SubCategoryController@update',$SubCategory->id]]) !!}
            @else
            {!!Form::open(['action' => 'SubCategoryController@store','method' => 'POST', 'class'=>'form-horizontal'])!!}
            @endif
            <input type="hidden" name="category_id" value="{{ $Category->id }}">
            <div class="box-body">
                <div class="form-group">
                    {!! Form::label('name', 'SubCategory Name: ', ['class'=>'col-sm-3 control-label']) !!}

                    <div class="col-sm-9">
                        {{Form::text('name',null,['value'=>'$SubCategory->name','class' => 'form-control'])}}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('description', 'Description: ', ['class'=>'col-sm-3 control-label']) !!}

                    <div class="col-sm-9">
                        {{Form::textarea('description',null,['value'=>'$SubCategory->description', 'class' => 'form-control', 'rows'=>'4'])}}
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                @if(!isset($SubCategory))
                {{Form::submit('Add Category', ['class'=>'btn btn-info pull-right'])}}
                @else
                <a href="/admin/sectors" class="btn btn-default "><i class="fa fa-arrow-left"></i> Go Back</a>
                {{Form::submit('Update', ['class'=>'btn btn-info pull-right'])}}
                @endif
            </div>
            <!-- /.box-footer -->
            {!! Form::close() !!}
        </div>
    </div>

    <div class="col-md-8">
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">{{ $Category->name }}</h3>
            </div>
            <div class="box-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th style="width: 10px">id</th>
                            <th>Sub Categories</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>

                        @foreach($SubCategoryList as $SubCategory)
                        <tr>
                            <td>{{ $SubCategory->id }}</td>
                            <td>{{ $SubCategory->name }}</td>
                            <td>{{ $SubCategory->description }}</td>
                            <td>
                                {!!Form::open(['route' => ['subcategories.destroy', $SubCategory->id], 'method' =>
                                'DELETE'])!!}

                                {!! Html::decode(link_to_route('subcategories.edit', '<i
                                    class="fa fa-edit"></i>',[$SubCategory->id], ['class' => 'btn btn-info',
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
        </div>
    </div>

</div>

@if (Request::is('*/subcategories/*'))
<script src="{{ asset('AdminLTE/bower_components/jquery/dist/jquery.min.js') }}"></script>

<script>
$(document).ready(function() {
    $('#salary_field').change(function() {
        var x = confirm("Are you sure?");
        if(x){
            if ($('#salary_field').is(":checked")) {
                this.checked = true;
                change_salary();
            } else {
                this.checked = false;
                change_salary();
            } 
        }else{
            if ($('#salary_field').is(":checked")) {
                $("#salary_field").prop("checked", false);
                change_salary();
            } else {
                $("#salary_field").prop("checked", true);
                change_salary();
            } 
        }
    });

    function change_salary(){
        $.ajax({
            url: "/admin/salary_set/{{ $SubCategory->id }}",
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                if (data.ajax_status == 'success') {
                    $('#ajax_status').html(data.ajax_status);
                    $('#ajax_message').html(data.ajax_message);
                    document.getElementById("ajax-success").style.display = "block";
                }
            }
        })
    }

});

</script>
@endif