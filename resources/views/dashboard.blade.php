@extends('layouts.app')

@section('sidebar')
	@include('layouts.sidebar', ['status' => 'dashboard'])
@endsection

@section('content')

<h3 class="py-2 pl-3">Dashboard</h3>
<div class="container-fluid">
	<div class="card-body bg-light" style="{width: 80%;}">
		<span class="text-success">Actualite</span>
	</div>
	<div class="row mt-5">
		<div class="col-12 col-md-6 col-lg-3">
			<div class="card-body bg-light" style="{height: 30%;}">
				<span class="text-success">Militants</span>
				<br/><br/>
				<span class="text-left">36 338</span>
			</div>
		</div>
		<div class="col-12 col-md-6 col-lg-3">
			<div class="card-body bg-light" style="{height: 30%;}">
				<span class="text-success">Nombre d'elu</span>
				<br/><br/>
				<span class="text-left">78</span>
			</div>
		</div>
		<div class="col-lg-6 col-sm-12">
			<div class="card-body bg-light" style="{height: 30%;}">
				<span class="text-success">Couverture territoriale</span>
				<br/><br/>
				<span class="text-left">13/360</span>
			</div>
		</div>
	</div>
</div>
@endsection

@section('scripts')

<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

@endsection
