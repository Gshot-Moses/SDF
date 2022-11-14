
<div class="col-3 col-md-2 d-none d-sm-block sidebar">
	<ul class="nav flex-column">
		<li class="{{ $status == 'dashboard' ? 'active': '' }}"><a href="{{ route('home') }}" style="display: block">Actualite</a></li>
		<li class="{{ $status == 'email' ? 'active': '' }}"><a href="{{ route('mail.index') }}" style="display: block">Email</a></li>
		<li class="{{ $status == 'event' ? 'active': '' }}"><a href="{{ route('event.index') }}" style="display: block">Agenda</a></li>
        <li class="{{ $status == 'resource' ? 'active': '' }}"><a href="{{ route('resource.index') }}" style="display: block">Ressources</a></li>
        <li class="{{ $status == 'member' ? 'active': '' }}"><a href="{{ route('member.index') }}" style="display: block">Membres</a></li>
        <li class="{{ $status == 'operation' ? 'active': '' }}"><a href="#" style="display: block">Operations</a></li>
	</ul>
</div>