<div class="row">
    <div class="col-md-4">

        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Horizontal Form</h3>
            </div>
            {!!Form::open(['action' => 'CategoryController@store','method' => 'POST', 'class'=>'form-horizontal'])!!}
            <div class="box-body">
                <div class="form-group">
                    {!! Form::label('category', 'Category Name: ', ['class'=>'col-sm-3 control-label']) !!}

                    <div class="col-sm-9">
                        {{Form::text('category',null,['value'=>'$Product->model','class' => 'form-control'])}}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('description', 'Description: ', ['class'=>'col-sm-3 control-label']) !!}

                    <div class="col-sm-9">
                        {{Form::textarea('description',null,['value'=>'$Product->description', 'class' => 'form-control', 'rows'=>'4'])}}
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                {{Form::submit('Add To Expence Category', ['class'=>'btn btn-info pull-right'])}}
            </div>
            <!-- /.box-footer -->
            {!! Form::close() !!}
        </div>
    </div>

    <div class="col-md-8">
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Horizontal Form</h3>
            </div>
            <div class="box-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th style="min-width: 150px">Category</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                        <tr>
                            <td>1.</td>
                            <td>Update software</td>
                            <td>
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde reprehenderit, eveniet dolore provident quis ducimus illum. Et nobis, aliquid maiores vitae hic ipsam magni, incidunt consequuntur deleniti optio vel. Architecto cumque ad, quaerat sed dolores, iusto officia sint eligendi dolorem odit, fuga assumenda obcaecati ipsam? Repellat quae culpa exercitationem deserunt.
                            </td>
                            <td>
                                edit/del
                            </td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
