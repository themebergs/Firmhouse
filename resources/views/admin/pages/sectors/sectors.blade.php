@section('admin_header')

<li><a href="/admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
<li class="active">Sectors</li>

@endsection

<div class="row">
    <div class="col-md-4">

        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Add Sector</h3>
            </div>
            @if(isset($Sector))
            {!! Form::model($Sector, ['method' => 'PUT', 'action' => ['SectorController@update',$Sector->id]]) !!}
            @else
            {!!Form::open(['action' => 'SectorController@store','method' => 'POST', 'class'=>'form-horizontal'])!!}
            @endif
            <div class="box-body">
                <div class="form-group">
                    {!! Form::label('name', 'Sector Name: ', ['class'=>'col-sm-3 control-label']) !!}

                    <div class="col-sm-9">
                        {{Form::text('name',null,['value'=>'$Sector->name','class' => 'form-control'])}}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('description', 'Description: ', ['class'=>'col-sm-3 control-label']) !!}

                    <div class="col-sm-9">
                        {{Form::textarea('description',null,['value'=>'$Sector->description', 'class' => 'form-control', 'rows'=>'4'])}}
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                @if(!isset($Sector))
                {{Form::submit('Add To Expence Category', ['class'=>'btn btn-info pull-right'])}}
                @else
                @if($Sector->type == 1)
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

                        @foreach($Sectors as $Sector)
                        <tr>
                            <td>{{ $Sector->id }}</td>
                            <td>{{ $Sector->name }}</td>
                            <td>{{ $Sector->description }}</td>
                            <td>
                                {!!Form::open(['route' => ['sectors.destroy', $Sector->id], 'method' =>
                                'DELETE'])!!}
                                
                                {!! Html::decode(link_to_route('sectors.show', '<i
                                    class="fa fa-folder-open"></i>',[$Sector->id], ['class' => 'btn btn-info',
                                'title'=>'View'])) !!}

                                {!! Html::decode(link_to_route('sectors.edit', '<i
                                    class="fa fa-edit"></i>',[$Sector->id], ['class' => 'btn btn-success',
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
