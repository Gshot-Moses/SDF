<html>
    <head>
        <title>Home</title>
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
			<a class="navbar-brand" href="#">Project name</a>
			<div class="collapse navbar-collapse" id="navbar">
				<ul class="nav navbar-nav ml-auto">
					<li class="nav-item">
						<a class="nav-link active" href="#">{{ Auth::user()->name }} | Deconnexion <span
						class="sr-only">(current)</span></a>
					</li>
				</ul>
			</div>
		</nav>
		<div id="main-container" class="container-fluid">
			<div class="row">
				<div class="col-sm-3 col-md-2 d-none d-sm-block sidebar">
					<ul class="nav flex-column">
						<li class="active"><a href="{{ route('home') }}">Actualite</a></li>
						<li><a href="#">Email</a></li>
						<li><a href="{{ route('event.index') }}">Agenda</a></li>
                        <li><a href="{{ route('resource.index') }}">Ressources</a></li>
						<li><a href="{{ route('member.index') }}">Membres</a></li>
					</ul>
				</div>
				<div id="main-content-container" class="col-sm-9 col-md-10">
                    <div class="bg-light text-dark py-3 pl-2">
                        <h3>Membres</h3>
                    </div>
                    @if(session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if(Auth::user()->role->id == 2)
                        <a href="{{ route('member.create') }}" class="btn btn-info">Creer un membre</a>
                    @endif
                    @foreach($members as $member)
                    <div class="card-body bg-light mt-1">
                        <a href="#">{{ $member->name }}</a>
                    </div>
                    @endforeach
				</div>
		</div>
</body>
</html>
