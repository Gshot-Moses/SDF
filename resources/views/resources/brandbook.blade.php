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
        <a href="{{ route('brandbook.create') }}" class="btn btn-info m-2">Ajouter un ficher</a>
        <div class="card-body">
            <div class="row mx-2">
                @foreach($files as $file)
                    <div class="col">
                        @if($file->extension == 'doc' || $file->extension == 'docx')
                            <img src="{{ asset('assets/images/ms-word-96.png') }}" alt="" height="50" width="50">
                        @endif
                        @if($file->extension == 'pdf')
                            <img src="{{ asset('assets/images/pdf-96.png') }}" alt="" height="50" width="50">
                        @endif
                        <p>{{ $file->filename }}</p>
                    </div>    
                @endforeach
            </div>
        </div>
    </body>
</html>