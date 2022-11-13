@extends('layouts.app')

@push('stylesheets')
    <link rel="stylesheet" href="{{ asset('assets/css/tingle.min.css') }}">
@endpush

@section('sidebar')
    @include('layouts.sidebar', ['status' => 'resource'])
@endsection

@section('content')

<!-- Create Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  		<div class="modal-dialog modal-dialog-centered" role="document">
    		<div class="modal-content">
      			<div class="modal-header">
        			<h5 class="modal-title" id="exampleModalLongTitle">Uploader un fichier media</h5>
        			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          				<span aria-hidden="true">&times;</span>
        			</button>
      		</div>
      		<div class="modal-body">
			  <form action="{{ route('media.store') }}" method="POST" enctype="multipart/form-data" id="create">
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

<!-- show Modal -->
<div class="modal fade" id="showModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  		<div class="modal-dialog modal-dialog-centered" role="document">
    		<div class="modal-content">
      			<div class="modal-header">
        			<h5 class="modal-title" id="exampleModalLongTitle">Voir contenu</h5>
        			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          				<span aria-hidden="true">&times;</span>
        			</button>
      		</div>
      		<div class="modal-body">
			  <div class="row">
                <div class="col text-center" id="content"></div>
              </div>
      		</div>
      		<div class="modal-footer">
        		<!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
        		<a href="#" class="btn btn-success">Telecharger</a>
      		</div>
    	</div>
  </div>
</div>

        <div class="container-fluid bg-light">
            <h3 class="py-2 pl-3">Ressources / Media</h3>
        </div>
        <!-- @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif -->
        <div class="alert alert-success" style="display: none" id="success">
            <p>Upload effectif</p>
        </div>
        <a href="#" class="btn btn-success m-2" data-toggle="modal" data-target="#exampleModalCenter"
        type="button">
            Ajouter un fichier media
        </a>
        <div class="card-body">
            <div class="row files" style="display: inline-flex">
                @foreach($files as $file)
                    <div class="col">
                        <!-- <a href="#" id="viewImg" class="obj{{ $file->id }}" onclick="showImg('{{ $file->id }}', '{{ $file->filename }}', '{{ $file->extension }}')"> -->
                        <a href="#" data-toggle="modal" data-target="#showModal"
						data-url="{{ asset('storage/uploads/'.$file->filename) }}" data-extension="{{ $file->extension }}"
                        data-download="{{ route('resource.download', $file->id) }}">
                            @if($file->extension == 'jpg' || $file->extension == 'png' || $file->extension == 'gif')
                                <img src="{{ asset('assets/images/picture.png') }}" alt="" height="50" width="50">
                            @endif
                            @if($file->extension == 'mp3' || $file->extension == 'm4a' || $file->extension == 'wav')
                                <img src="{{ asset('assets/images/audio-100.png') }}" alt="" height="50" width="50">
                            @endif
                            @if($file->extension == 'mp4' || $file->extension == 'mkv' || $file->extension == '3gp')
                                <img src="{{ asset('assets/images/video-100.png') }}" alt="" height="50" width="50">
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
<!-- <script src="{{ asset('assets/js/tingle.min.js') }}"></script> -->

<script>
    $("#showModal").on("show.bs.modal", function(event){
		var button = $(event.relatedTarget);
		var url = button.data("url");
        var download = button.data("download");
		var extension = button.data("extension");
		var modal = $(this);
        modal.find(".modal-footer a").attr("href", download);
		if (extension == "png" || extension == "jpg" || extension == "gif") {
			var content = "<img src='" + url + "' alt='' height='250' width='300'>";
			modal.find(".modal-body div[id=content]").html(content);
		}
        else if (extension == "mp3") {
            var content = "<audio controls><source src='" + url + "' type='audio/mpeg'>Browser not supported</audio>";
            modal.find(".modal-body div[id=content]").html(content);
        }
        else if (extension == "mp4" || extension == "mkv") {
            var content = "<video height='320' width='200' controls><source src='" + url + "' type='video/mp4'>Browser not supported</video>";
            modal.find(".modal-body div[id=content]").html(content);
        }
		
	});

    function showImg(id, filename, extension) {
        var modalTinyBtn = new tingle.modal({
            footer: false
        });
        //var id = 
        // $(".obj" + id).on("click", function () {
        //     modalTinyBtn.open();
        // });
        var content = '';
        var asset = "{{ asset('storage/uploads') }}" + "/" + filename;
        if (extension == "png" || extension == "jpg" || extension == "gif") {
            content = "<img src='" + asset + "' alt='' width='200' height='200' class='text-center'>";
        }
        else if (extension == "mp3") {
            content = "<audio controls><source src='" + asset + "' type='audio/mpeg'>Browser not supported</audio>";
        }
        else if (extension == "mp4" || extension == "mkv") {
            content = "<video height='320' width='200' controls><source src='" + asset + "' type='video/mp4'>Browser not supported</video>";
        }
        console.log(content);
        modalTinyBtn.setContent(content);
        modalTinyBtn.open();
    }

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
				if (data.extension == 'jpg' || data.extension == 'png' || data.extension == 'gif') {
					img = "{{ asset('assets/images/picture.png') }}";
				}
				else if (data.extension == 'mp3' || data.extension == 'wav' || data.extension == 'm4a'){
					img = "{{ asset('assets/images/audio-100.png') }}";
				}
                else {
                    img = "{{ asset('assets/images/video-100.png') }}";
                }
                var viewRoute = "/resources/view/" + data.id;
				var content = "<div class='col'><a href='" + viewRoute + "'><img src=" + img + " width=50 height=50 alt=''>" + "<p>" + data.filename + "</p></a></div>";

				$(".files").append(content);
			}
		});
	});
</script>

@endsection