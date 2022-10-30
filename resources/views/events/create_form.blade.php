<html>
    <head>
        <title>Home</title>
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
</head>
<body>
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="mx-5">
        <div class="row">
            <div class="col-6 card-body bg-light">
                <form action="{{ route('event.store') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label>Titre de l'evenement</label>
                        <input type="text" name="title" placeholder="Titre de l'evenement" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="start-date" class="mr-1">La date de debut de l'evenement: </label>
                        <input type="date" name="start_date" id="start-date" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="start-time" class="mr-1">L'heure de debut l'evenement: </label>
                        <input type="time" name="start_time" id="start-time" class="form-control">
                    </div>
        
                    <div class="form-group">
                        <label for="end-date" class="mr-1">La date de fin de l'evenement: </label>
                        <input type="date" name="end_date" id="end-date" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="end-time" class="mr-1">L'heure de fin l'evenement: </label>
                        <input type="time" name="end_time" id="end-time" class="form-control">
                    </div>
        
                    <div class="form-group">
                        <textarea placeholder="Les details de l'evenement" name="details" class="form-control"></textarea>
                    </div>
                    <input type="submit" name="submit" value="Creer" class="btn btn-success">
                </form>
            </div>
        </div>
    </div>
</body>
</html>
