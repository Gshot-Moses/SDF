@extends('layouts.app')

@section('sidebar')
    @include('layouts.sidebar', ['status' => 'resource'])
@endsection

@section('content')
    <div class="text-center mt-5">
        <audio controls>
            <source src="{{ asset('storage/uploads/'.$filename) }}" type="audio/mpeg">
            Browser not supported
        </audio>
    </div>
@endsection