@extends('layouts.app')

@section('sidebar')
    @include('layouts.sidebar', ['status' => 'resource'])
@endsection

@section('content')

<!-- Create modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  		<div class="modal-dialog modal-dialog-centered" role="document">
    		<div class="modal-content">
      			<div class="modal-header">
        			<h5 class="modal-title" id="exampleModalLongTitle">Uploader un document</h5>
        			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          				<span aria-hidden="true">&times;</span>
        			</button>
      		</div>
      		<div class="modal-body">
			  <form action="{{ route('document.store') }}" method="POST" enctype="multipart/form-data" id="create">
                {{ csrf_field() }}
                @include('resources.form')
            </form>
      		</div>
      		<div class="modal-footer">
        		<!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        		<button type="button" class="btn btn-primary">Save changes</button> -->
      		</div>
    	</div>
  </div>
</div>
        <div class="container-fluid bg-light">
            <h3 class="py-2 pl-3">Ressources / Documents</h3>
        </div>
        <!-- @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif -->
        <div class="alert alert-success" style="display: none" id="success">
            <p>Upload effectif</p>
        </div>
        <a href="#" class="btn btn-success mt-2" data-toggle="modal" data-target="#exampleModalCenter"
        type="button">
            Ajouter un document
        </a>
        <div class="card-body">
            <div class="row files" style="display: inline-flex">
                @foreach($files as $file)
                    <div class="col ml-2">
						<a href="#">
							@if($file->extension == 'doc' || $file->extension == 'docx')
								<img src="{{ asset('assets/images/ms-word-96.png') }}" alt="" height="50" width="50">
							@endif
							@if($file->extension == 'pdf')
								<img src="{{ asset('assets/images/pdf-96.png') }}" alt="" height="50" width="50">
							@endif
							<p>{{ $file->filename }}</p>
						</a>
                    </div>    
                @endforeach
            </div>
        </div>

@endsection

@section('scripts')

<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

<script>
	
	$("#create").on("submit", function(e){
		e.preventDefault();
		var form = $(this);
		var url = form.attr("action");

		$.ajax({
			type:'POST',
			url: url,
			data: new FormData(this),
			processData: false,
    		contentType: false,
			dataType: "JSON",
			success: function(data) {
				if (data.hasOwnProperty("name") || data.hasOwnProperty("file")) {
                    if (data.hasOwnProperty("name")) {
                        $("#nameError").append(data.name[0]);
                        $("#nameError").css("display", "block");
                    }
                    if (data.hasOwnProperty("file")) {
                        $("#fileError").append(data.file[0]);
                        $("#fileError").css("display", "block");
                    }
                    return;
                }	
				$("#success").css("display", "block");
				$("#create")[0].reset();
                $("#exampleModalCenter").modal("hide");
				window.setTimeout(() => ($("#success").css("display", "none")), 3000);
				var img = '';
				if (data.extension == 'doc' || data.extension == 'docx') {
					img = "{{ asset('assets/images/ms-word-96.png') }}";
				}
				else {
					img = "{{ asset('assets/images/pdf-96.png') }}";
				}
				var content = "<div class='col'><img src=" + img + " width=50 height=50 alt=''>" + "<p>" + data.filename + "</p>";
				$(".files").append(content);
			}
		});
	});
</script>

@endsection