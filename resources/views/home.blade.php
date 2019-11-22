@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @guest
                        Welcome to {{ config('app.name', 'Laravel') }}
                    @else
                    You are logged in @can('isSuperAdmin')as Super Admin @endcan
                    @endguest
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
