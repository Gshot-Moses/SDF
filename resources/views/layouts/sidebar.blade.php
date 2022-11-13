
<div class="col-3 col-md-2 d-none d-sm-block sidebar">
	<ul class="nav flex-column">
		<li class="{{ $status == 'dashboard' ? 'active': '' }}"><a href="{{ route('home') }}">Actualite</a></li>
		<li class="{{ $status == 'email' ? 'active': '' }}"><a href="{{ route('mail.index') }}">Email</a></li>
		<li class="{{ $status == 'event' ? 'active': '' }}"><a href="{{ route('event.index') }}">Agenda</a></li>
        <li class="{{ $status == 'resource' ? 'active': '' }}"><a href="{{ route('resource.index') }}">Ressources</a></li>
        <li class="{{ $status == 'member' ? 'active': '' }}"><a href="{{ route('member.index') }}">Membres</a></li>
        <li class="{{ $status == 'operation' ? 'active': '' }}"><a href="#">Operations</a></li>
	</ul>
</div>