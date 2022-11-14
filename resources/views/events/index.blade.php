@extends('layouts.app')

@push('stylesheets')
<link href="{{ asset('assets/css/evo-calendar.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/evo-calendar.midnight-blue.css') }}" rel="stylesheet">
@endpush

@section('sidebar')
    @include('layouts.sidebar', ['status' => 'event'])
@endsection

@section('content')

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  		<div class="modal-dialog modal-dialog-centered" role="document">
    		<div class="modal-content">
      			<div class="modal-header">
        			<h5 class="modal-title" id="exampleModalLongTitle">Creation d'un evenement</h5>
        			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          				<span aria-hidden="true">&times;</span>
        			</button>
      		</div>
      		<div class="modal-body">
			  <form action="{{ route('event.store') }}" method="POST" id="create">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label>Titre de l'evenement</label>
                        <input type="text" name="title" placeholder="Titre de l'evenement" class="form-control">
                        <small class="text-danger" id="titleError"></small>
                    </div>
                    <div class="form-group">
                        <label for="start-date" class="mr-1">La date de debut de l'evenement: </label>
                        <input type="date" name="start_date" id="start-date" class="form-control">
                        <small class="text-danger" id="startDateError"></small>
                    </div>

                    <!-- <div class="form-group">
                        <label for="start-time" class="mr-1">L'heure de debut l'evenement: </label>
                        <input type="time" name="start_time" id="start-time" class="form-control">
                    </div> -->
        
                    <div class="form-group">
                        <label for="end-date" class="mr-1">La date de fin de l'evenement: </label>
                        <input type="date" name="end_date" id="end-date" class="form-control">
                        <small class="text-danger" id="endDateError"></small>
                    </div>

                    <!-- <div class="form-group">
                        <label for="end-time" class="mr-1">L'heure de fin l'evenement: </label>
                        <input type="time" name="end_time" id="end-time" class="form-control">
                    </div> -->
        
                    <div class="form-group">
                        <textarea placeholder="Les details de l'evenement" name="details" class="form-control"></textarea>
                        <small class="text-danger" id="detailsError"></small>
                    </div>
                    <input type="submit" name="submit" value="Creer" class="btn btn-success">
                </form>
      		</div>
      		<div class="modal-footer">
        		<!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        		<button type="button" class="btn btn-primary">Save changes</button> -->
      		</div>
    	</div>
  </div>
</div>

<div class="bg-light">
    <h3 class="py-2 pl-3">Evenements</h3>
</div>
<!-- @if(session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif -->
<div class="alert alert-success" style="display: none" id="success">
    <p>Creation effectif</p>
</div>
@if(Auth::user()->role->id == 2)
    <a href="#" class="btn btn-success" data-toggle="modal" data-target="#exampleModalCenter"
    type="button">
        Creer un evenement
    </a>
@endif
<div class="row mt-2">
    <div class="col-12 col-lg-10">
        <div id="calendar"></div>
    </div>
</div>

@endsection

@section('scripts')

    <script src="{{ asset('assets/js/evo-calendar.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#calendar').evoCalendar({
                'language': 'fr',
                'calendarEvents': {{ Js::from($cal) }},
            });
        });

        $("#create").on("submit", function(e){
            e.preventDefault();
            var form = $(this);
            var url = form.attr("action");

            $.ajax({
                type:'POST',
                url: url,
                data: new FormData(this),
                dataType: "JSON",
                processData: false,
                contentType: false,
                success:function(data){
                    //console.log(data);
                    if (data.hasOwnProperty("titleError") || data.hasOwnProperty("startDateError")
                    || data.hasOwnProperty("endDateError") || data.hasOwnProperty("detailsError")
                    || data.hasOwnProperty("dateError1") || data.hasOwnProperty("dateError2")) {
                        if (data.hasOwnProperty("titleError")) {
                            $("#titleError").text(data.titleError);
                        }
                        if (data.hasOwnProperty("startDateError")) {
                            $("#startDateError").text(data.startDateError);
                        }
                        if (data.hasOwnProperty("endDateError")) {
                            $("#endDateError").text(data.endDateError);
                        }
                        if (data.hasOwnProperty("detailsError")) {
                            $("#detailsError").text(data.detailsError);
                        }
                        if (data.hasOwnProperty("dateError1")) {
                            $("#startDateError").text(data.dateError1);

                            $("#titleError").text("");
                            $("#detailsError").text("");
                        }
                        if (data.hasOwnProperty("dateError2")) {
                            $("#endDateError").text(data.dateError2);

                            $("#titleError").text("");
                            $("#detailsError").text("");
                        }
                        return;
                    }
                    $("#create")[0].reset();
                    $("#titleError").text("");
                    $("#startDateError").text("");
                    $("#endDateError").text("");
                    $("#detailsError").text("");
                    
                    $("#exampleModalCenter").modal("hide");

                    $("#success").css("display", "block");
                    setTimeout(function() {
                        $("#success").css("display", "none");
                    }, 3000);
                    
                    $("#calendar").evoCalendar("addCalendarEvent", {
                        id: data.id,
                        name: data.name,
                        description: data.details,
                        date: data.due_date,
                        type: 'event'
                    });
                }
            });
	    });
    </script>
@endsection