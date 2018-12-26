@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">Profile Image</div>

                <div class="card-body">
                    <!-- Profile Vue component -->
                    <avatar></avatar>
                </div>
            </div>
            <div class="card">
                <div class="card-header">Video</div>

                <div class="card-body">
                    <!-- Profile Vue component -->
                    <vimeo :user="{{ Auth::user() }}"></vimeo>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
