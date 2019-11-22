@if(session('success'))
<div class="alert alert-success alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Success!</strong> {{session('success')}}
</div>
@endif

@foreach ($errors->all() as $error)
<div class="alert alert-danger alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error ! </strong>{{ $error }}
</div>
@endforeach

{{-- Ajax message --}}
<div class="alert alert-success alert-dismissible" id="ajax-success" style="display:none;">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong id="ajax_status"></strong>:&nbsp; <span id="ajax_message"></span>
</div>

<div class="alert alert-danger alert-dismissible" id="ajax-failed" style="display:none;">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong id="ajax_error"></strong>!&nbsp; <span id="error_message"></span>
</div>