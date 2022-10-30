<html>
    <head>
        <title>Resources</title>
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    </head>
    <body>
        <div class="container-fluid bg-light">
            <h3 class="py-2 pl-3">Ressources / BrandBook</h3>
        </div>
        @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif
        <div class="card-body">
            <div class="row">

                @foreach($files as $file)
                    <div class="col">
                        <img src="" alt="" height="50" width="50">
                        <p>{{ $file->filename }}</p>
                    </div>    
                @endforeach
            </div>
        </div>
    </body>
</html>