<nav class="navbar navbar-expand-lg navbar-light fixed-top" style="background-color: #efecec">
	<a class="navbar-brand" href="#">
		<img src="{{ asset('assets/images/logo1.jpg') }}" height="50" alt="">
	</a>
	<div class="collapse navbar-collapse" id="navbar">
		<ul class="nav navbar-nav ml-auto">
			<li class="nav-item">
				<a class="nav-link active text-success" href="#"
					onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">{{ Auth::user()->name }} | Deconnexion <span
					class="sr-only">(current)</span></a>
				<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
			</li>
		</ul>
	</div>
</nav>