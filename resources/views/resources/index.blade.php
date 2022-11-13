@extends('layouts.app')

@section('sidebar')
    @include('layouts.sidebar', ['status' => 'resource'])
@endsection

@section('content')
		
    <div class="container-fluid bg-light">
        <h3 class="py-2 pl-3">Ressources</h3>
    </div>
    @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="card-body">
        <div class="row">
        @foreach($folders as $folder)
            <div class="col-4 col-md-2">
                <a href="{{ route('resource.folder', $folder->id) }}">
                <img src="{{ asset('assets/images/dossier-96.png') }}" alt="" height="50" width="50">
                <p>{{ $folder->foldername }}</p>
                </a>
            </div>    
        @endforeach
    </div>
        
@endsection
