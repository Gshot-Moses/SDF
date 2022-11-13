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
        			<h5 class="modal-title" id="exampleModalLongTitle">Uploader un ficher</h5>
        			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          				<span aria-hidden="true">&times;</span>
        			</button>
      		</div>
      		<div class="modal-body">
			  <form action="{{ route('brandbook.store') }}" method="POST" enctype="multipart/form-data" id="create">
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
            <h3 class="py-2 pl-3">Ressources / BrandBook</h3>
        </div>
        <!-- @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif -->
        <div class="alert alert-success" style="display: none" id="success">
            <p>Upload effectif</p>
        </div>
        <a href="#" class="btn btn-success m-2" data-toggle="modal" data-target="#exampleModalCenter">
            Ajouter un ficher
        </a>
        <div class="card-body">
            <div class="row files" style="display: inline-flex">
                @foreach($files as $file)
                    <div class="col">
                        <img src="{{ asset('assets/images/pdf-96.png') }}" alt="" height="50" width="50">
                        <p>{{ $file->filename }}</p>
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
                console.log(data);
				if (data.hasOwnProperty("nameError") || data.hasOwnProperty("fileError") || data.hasOwnProperty("mime")) {
                    if (data.hasOwnProperty("name")) {
                        $("#nameError").text(data.nameError);
                        $("#nameError").css("display", "block");
                    }
                    if (data.hasOwnProperty("file")) {
                        $("#fileError").text(data.fileError);
                        $("#fileError").css("display", "block");
                    }
                    if (data.hasOwnProperty("mime")) {
                        $("#fileError").text(data.mime);
                        $("#fileError").css("display", "block");
                    }
                    return;
                }	
				$("#success").css("display", "block");
				$("#create")[0].reset();
                $("#exampleModalCenter").modal("hide");
				window.setTimeout(() => ($("#success").css("display", "none")), 3000);
				
                var img = "{{ asset('assets/images/ms-word-96.png') }}";
				var content = "<div class='col'><img src=" + img + " width=50 height=50 alt=''>" + "<p>" + data.filename + "</p>";
				$(".files").append(content);
			}
		});
	});
</script>

@endsection