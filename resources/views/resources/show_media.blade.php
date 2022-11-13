@extends('layouts.app')

@section('sidebar')
    @include('layouts.sidebar', ['status' => 'resource'])
@endsection

@section('content')

    <div class="container">
        <div class="text-center mt-5">
            <img src="{{ asset('storage/uploads/'.$filename) }}" height=200 width=200 alt="">
        </div>
    </div>

@endsection