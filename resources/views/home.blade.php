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
						<a class="nav-link active" href="#">Dashboard <span
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
                <h3 class="py-2 pl-3">Dashboard</h3>
                <a href="{{ route('event.create') }}">Creer un evenement</a>
                <br/>
                <a href="{{ route('resource.create') }}">Uploader un fichier</a>
                <br/>
                <a href="{{ route('resource.index') }}">Ressources</a>
                <br/>
                <a href="{{ route('event.index') }}">Evenements</a>
                <br/>
				</div>
		</div>
</body>
</html>
