<div class="col-md-3">
    <div class="box box-primary">
        <div class="box-body">
            
            <div class="d-flex justify-content-center">
                {{-- ========================================== --}}
                {{-- Image Upload/ Update :Start --}}
                {{-- ========================================== --}}
                {!! Form::model($business, ['enctype' => 'multipart/form-data','method' => 'PUT', 'action' =>
                ['BusinessController@update',$business->id]]) !!}
                <div class="image">

                    @if($business->logo_primary)

                    <img id="output" class="img-responsive" src="{{ asset('images/user/'.$business->user_image) }}">
                    <div class="photo_post">
                        {{Form::file('user_image', ['class'=>'file', 'id'=>'f02','placeholder'=>'Insert Image', 'onchange'=>'loadFile(event)'])}}
                        {!! Form::label('f02', 'Change Image', ['class'=>'change_image']) !!}
                    </div>
                    @else

                    <img id="output" class="img-responsive" src="{{ asset('images/avater.png') }}">
                    <div class="photo_post">
                        {{Form::file('user_image', ['class'=>'file', 'id'=>'f02','placeholder'=>'Insert Image', 'onchange'=>'loadFile(event)'])}}
                        {!! Form::label('f02', 'Upload Photo', ['class'=>'change_image']) !!}
                    </div>

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

<div class="col-md-9">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Quick Example</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form">
            <div class="box-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                </div>
                <div class="form-group">
                    <label for="exampleInputFile">File input</label>
                    <input type="file" id="exampleInputFile">

                    <p class="help-block">Example block-level help text here.</p>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox"> Check me out
                    </label>
                </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>
