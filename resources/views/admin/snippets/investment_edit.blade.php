<!-- Modal -->
<div id="edit_investment_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            {!! Form::open(['action'=>'InvestmentController@update','method'=>'POST']) !!}
            
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Investment</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="invest_id" id="invest_id" value="">
                <div class=" row form-group">
                    {!! Form::label('amount', 'Amount ',['class'=>'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {{Form::number('amount',null,['class' => 'form-control', 'id'=>'amount','required'])}}
                    </div>
                </div>

                <div class="row form-group">
                    {!! Form::label('description', 'Description ',['class'=>'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {{Form::textarea('description',null,['class' => 'form-control', 'id'=>'description', 'rows'=>'5'])}}
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                {{Form::submit('Save', ['class'=>'btn btn-info'])}}
            </div>
            {!! Form::close() !!}
        </div>

    </div>
</div>
