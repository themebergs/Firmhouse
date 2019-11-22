@section('admin_header')

<li><a href="/admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
<li class="active">Income Sectors</li>

@endsection

<div class="row">
    <div class="col-md-4">

        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Add Sector For Income</h3>
            </div>
            @if(isset($IncomeSector))
            {!! Form::model($IncomeSector, ['method' => 'PUT', 'action' => ['IncomeController@IncomeSectorUpdate',$IncomeSector->id]]) !!}
            @else
            {!!Form::open(['action' => 'IncomeController@IncomeSectorStore','method' => 'POST', 'class'=>'form-horizontal'])!!}
            @endif
            <div class="box-body">
                <div class="form-group">
                    {!! Form::label('name', 'Sector Name: ', ['class'=>'col-sm-3 control-label']) !!}

                    <div class="col-sm-9">
                        {{Form::text('name',null,['value'=>'$IncomeSector->name','class' => 'form-control'])}}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('description', 'Description: ', ['class'=>'col-sm-3 control-label']) !!}

                    <div class="col-sm-9">
                        {{Form::textarea('description',null,['value'=>'$IncomeSector->description', 'class' => 'form-control', 'rows'=>'4'])}}
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                @if(!isset($IncomeSector))
                {{Form::submit('Add To Expence Category', ['class'=>'btn btn-info pull-right'])}}
                @else
                @if($IncomeSector->type == 1)
                <a href="/admin/income_sectors" class="btn btn-default "><i class="fa fa-arrow-left"></i> Go Back</a>
                @else
                {{-- <a href="/admin/sectors" class="btn btn-default "><i class="fa fa-arrow-left"></i> Go Back</a> --}}
                @endif
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
                <h3 class="box-title">All Sectors</h3>
            </div>
            <div class="box-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th style="width: 10px">id</th>
                            <th>Sectors</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>

                        @foreach($sectors as $IncomeSector)
                        <tr>
                            <td>{{ $IncomeSector->id }}</td>
                            <td>{{ $IncomeSector->name }}</td>
                            <td>{{ $IncomeSector->description }}</td>
                            <td>
                                {!!Form::open(['route' => ['sectors.destroy', $IncomeSector->id], 'method' =>
                                'DELETE'])!!}
                                
                                {!! Html::decode(link_to_route('sectors.show', '<i
                                    class="fa fa-folder-open"></i>',[$IncomeSector->id], ['class' => 'btn btn-info',
                                'title'=>'View'])) !!}

                                {!! Html::decode(link_to_route('sectors.edit', '<i
                                    class="fa fa-edit"></i>',[$IncomeSector->id], ['class' => 'btn btn-success',
                                'title'=>'Edit'])) !!}

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
