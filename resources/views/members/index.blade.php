@extends('layouts.app')

@section('sidebar')
	@include('layouts.sidebar', ['status' => 'member'])
@endsection

@section('content')

	<!-- Modal create, update-->
	<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  		<div class="modal-dialog modal-dialog-centered" role="document">
    		<div class="modal-content">
      			<div class="modal-header">
        			<h5 class="modal-title" id="exampleModalLongTitle">Creation d'un membre</h5>
        			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          				<span aria-hidden="true">&times;</span>
        			</button>
      		</div>
      		<div class="modal-body">
			  <form action="{{ route('member.store') }}" method="POST" id="create">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label>Nom</label>
                        <input type="text" name="name" class="form-control" placeholder="Ex: Serge">
						<small class="text-danger" style="display: none" id="nameError"></small>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" placeholder="example@gmail.com">
						<small class="text-danger" style="display: none" id="emailError"></small>
					</div>
                    <div class="form-group">
                        <label>Role</label>
                        <select name="role" class="form-control">
                            <option value=2>Admin</option>
                            <option value=1>Membre</option>
                        </select>
                    </div>
                    <!-- <div class="form-group">
                        <label>Mot de passe</label>
                        <input type="password" name="password" class="form-control" placeholder="Mot de passe">
                    </div> -->
                    <input type="submit" value="Enregistrer" class="btn btn-info mt-5">
                </form>
      		</div>
      		<div class="modal-footer">
        		<!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        		<button type="button" class="btn btn-primary">Save changes</button> -->
      		</div>
    	</div>
  </div>
</div>

<!-- Modal confirm deletion-->
<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  		<div class="modal-dialog modal-dialog-centered" role="document">
    		<div class="modal-content">
      			<div class="modal-header">
        			<h5 class="modal-title" id="exampleModalLongTitle">Supprimer un membre</h5>
        			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          				<span aria-hidden="true">&times;</span>
        			</button>
      		</div>
      		<div class="modal-body">
			  <p>Souaitez-vous supprimer ce membre ?</p>
      		</div>
      		<div class="modal-footer">
        		<button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
        		<button type="button" class="btn btn-primary" id="delete">Supprimer</button>
      		</div>
    	</div>
  </div>
</div>

	<div class="bg-light text-dark py-3 pl-2">
		<h3>Membres</h3>
	</div>
	<!-- @if(session('status'))
		<div class="alert alert-success" id="success" style="display: none">
			{{ session('status') }}
		</div>
	@endif -->
	<div class="alert alert-success" id="success" style="display: none">
		<p>Creation effectif</p>
	</div>
	@if(Auth::user()->role->id == 2)
		<a href="#" class="btn btn-success" data-toggle="modal" data-target="#exampleModalCenter"
		data-title="Creer un membre" type="button">
			Creer un membre
		</a>
	@endif
	<table class="table mt-3" id="drawer">
		<thead class="thead-light">
			<tr>
				<th scope="col">id</th>
				<th scope="col">Nom</th>
				@if(Auth::user()->role->id == 2)
				<th scope="col">Actions</th>
				@endif
			</tr>
		</thead>
		<tbody>
			@foreach($members as $member)
			<tr id="row{{ $member->id }}">
				<td>{{ $member->id }}</td>
				<td id="name{{ $member->id }}">{{ $member->name }}</td>
				@if(Auth::user()->role->id == 2)
				<td>
					<button class="btn btn-info"
					data-toggle="modal" data-target="#exampleModalCenter" data-name="{{ $member->name }}"
					data-email="{{ $member->email }}" data-role="{{ $member->role->id }}"
					data-url="{{ route('member.update', $member->id) }}"
                    data-title="Editer un membre" type="button">
						Modifier
					</button>
					<a href="#" class="btn btn-danger" data-toggle="modal" data-target="#modalDelete"
					data-url="{{ route('member.delete', $member->id) }}">
						Supprimer
					</a>
				</td>
				@endif
			</tr>
			@endforeach
		</tbody>
	</table>


@endsection

@section('scripts')

<script>
	// Delete case
	$("#modalDelete").on("show.bs.modal", function(event){
		var button = $(event.relatedTarget);
		var url = button.data("url");

		var modal = $(this);
		modal.find(".modal-footer button[id=delete]").on("click", function(){
            modal.modal("hide");
			$.get(url, function(data) {
				$("#row" + data.id).remove();

				$("#success").text("Suppression effectif");
				$("#success").css("display", "block");

				window.setTimeout(() => ($("#success").css("display", "none")), 3000);
			});
		});
	});

	// Change modal content with respect to button
	$("#exampleModalCenter").on("show.bs.modal", function(event) {
		var button = $(event.relatedTarget);
		var name = button.data("name");
		var email = button.data("email");
		var role = button.data("role");
		var url = button.data("url");
        var title = button.data("title");
		//console.log(url);

		$("#nameError").text("");
		$("#emailError").text("");

		var modal = $(this);
		modal.find(".modal-title").text(title);
		modal.find(".modal-body form").attr("action", url);
		modal.find(".modal-body input[name=name]").attr("value", name);
		modal.find(".modal-body input[name=email]").attr("value", email);
		modal.find(".modal-body select").val(role);
	});
	$("#create").on("submit", function(e){
		e.preventDefault();
		var form = $(this);
		var url = form.attr("action");
		var name = $("input[name=name]").val();
		//var password = $("input[name=password]").val();
		var email = $("input[name=email]").val();
		var role = $("role").val();

		$.ajax({
			type:'POST',
			url: url,
			data: new FormData(this),
			processData: false,
    		contentType: false,
			dataType: "JSON",
			success: function(data) {
				console.log(data);
				// Error check from server
				if (data.hasOwnProperty("nameError") || data.hasOwnProperty("emailError")) {
					if (data.hasOwnProperty("nameError")) {
						$("#nameError").text(data.nameError);
                        $("#nameError").css("display", "block");
					}
					if (data.hasOwnProperty("emailError")) {
						$("#emailError").text(data.emailError);
                        $("#emailError").css("display", "block");
					}
					return;
				}

				// Member update handling case
				if (data.hasOwnProperty("success")) {
					// Show success feedback
					$("#success").text("Modification effectif");
					$("#success").css("display", "block");

					// Rest form elements
					//$("#create")[0].reset();
					$("#create input[name=name]").attr("value", "");
					$("#create input[name=email]").attr("value", "");
					$("#nameError").text("");
					$("#emailError").text("");

					// Hide modal
                	$("#exampleModalCenter").modal("hide");

					// Timeout success feedback
					window.setTimeout(() => ($("#success").css("display", "none")), 3000);

					// Update concerned table row
					$("#name" + data.id).text(data.name);
					return;
				}

				//Member creation
				$("#success").css("display", "block");

				$("#create")[0].reset();
				$("#nameError").text("");
				$("#emailError").text("");

                $("#exampleModalCenter").modal("hide");
				window.setTimeout(() => ($("#success").css("display", "none")), 3000);

				var append = "";
                var btn1 = makeEditButton(data);

				var btn2 = makeDeleteButton(data.delete);
				var isAdmin = "{{ Auth::user()->role->id == 2 ? true : false }}"
				if (isAdmin != true) {
					append = "<tr id='row" + data.id + "'><td>" + data.id + "</td><td id='name" + data.id + "'>" + data.name + "</td></tr>";
				}
				else {
					append = "<tr id='row" + data.id + "'><td>" + data.id + "</td><td id='name" + data.id + "'>" + data.name + "</td><td>" + btn1 + " " + btn2 + "</td></tr>";
				}

				$("#drawer tr:last").after(append);
			}
		});
	});

    function makeEditButton(userData) {
        var btnClass = "btn btn-info";
        var dataToggle = "modal";
        var dataTarget = "#exampleModalCenter";
        var dataName = userData.name;
        var dataEmail = userData.email;
        var dataRole = userData.role_id;
        var dataUrl = userData.edit;

        return "<a href='#' class='" + btnClass + "' data-toggle='" + dataToggle +
            "' data-target='" + dataTarget + "' data-name='" + dataName +
            "' data-email='" + dataEmail + "' data-role='" + dataRole + "' data-url='" +
            dataUrl + "'>Modifier</a>"
    }

    function makeDeleteButton(deleteUrl) {
        var btnClass = "btn btn-danger";
        var dataToggle = "modal";
        var dataTarget = "#modalDelete";
        var dataUrl = deleteUrl;

        return "<a href='#' class='" + btnClass + "' data-toggle='" + dataToggle +
            "' data-target='" + dataTarget + "' data-url='" + dataUrl +
            "'>Supprimer</a>";
    }
</script>

@endsection
