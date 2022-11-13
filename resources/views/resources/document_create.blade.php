<html>
<head>
        <title>Upload File</title>
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
</head>
<body>
    <div class="container-fluid">
        <h3 class="py-2 pl-2">Ressources</h3>
    </div>
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row">
        <div class="card-body bg-light col-6 mx-4">
            <form action="{{ route('document.store') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                @include('resources.form')
            </form>
        </div>    
    </div>
    </body>
</html>