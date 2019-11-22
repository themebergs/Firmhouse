@section('admin_header')

<li><a href="/admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
<li class="active">{{ $Sector->name }}</li>

@endsection

<div class="row">
    <div class="col-md-4">

        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Add Category</h3>
            </div>
            @if(isset($Catagory))
            {!! Form::model($Catagory, ['method' => 'PUT', 'action' => ['CategoryController@update',$Catagory->id]]) !!}
            @else
            {!!Form::open(['action' => 'CategoryController@store','method' => 'POST', 'class'=>'form-horizontal'])!!}
            @endif
            <input type="hidden" name="sector_id" value="{{ $Sector->id }}">
            <div class="box-body">
                <div class="form-group">
                    {!! Form::label('name', 'Category Name: ', ['class'=>'col-sm-3 control-label']) !!}

                    <div class="col-sm-9">
                        {{Form::text('name',null,['value'=>'$Catagory->name','class' => 'form-control'])}}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('description', 'Description: ', ['class'=>'col-sm-3 control-label']) !!}

                    <div class="col-sm-9">
                        {{Form::textarea('description',null,['value'=>'$Catagory->description', 'class' => 'form-control', 'rows'=>'4'])}}
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                @if(!isset($Catagory))
                {{Form::submit('Add Category', ['class'=>'btn btn-info pull-right'])}}
                @else
                {{-- <a href="/admin/sectors" class="btn btn-default "><i class="fa fa-arrow-left"></i> Go Back</a> --}}
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
                <h3 class="box-title">{{ $Sector->name }}</h3>
            </div>
            <div class="box-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th style="width: 10px">id</th>
                            <th>Categories</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>

                        @foreach($CatagoryList as $Catagory)
                        <tr>
                            <td>{{ $Catagory->id }}</td>
                            <td>{{ $Catagory->name }}</td>
                            <td>{{ $Catagory->description }}</td>
                            <td>
                                {!!Form::open(['route' => ['categories.destroy', $Catagory->id], 'method' =>
                                'DELETE'])!!}

                                {!! Html::decode(link_to_route('categories.show', '<i
                                    class="fa fa-folder-open"></i>',[$Catagory->id], ['class' => 'btn btn-info',
                                'title'=>'View'])) !!}

                                {!! Html::decode(link_to_route('categories.edit', '<i
                                    class="fa fa-edit"></i>',[$Catagory->id], ['class' => 'btn btn-info',
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
