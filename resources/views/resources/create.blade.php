<html>
<head>
        <title>Upload File</title>
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
</head>
<body>
    <div class="container-fluid">
        <h3 class="py-2 pl-2">Ressources</h3>
    </div>
    <div class="row">
        <div class="card-body bg-light col-6 mx-4">
            <form action="{{ route('resource.store') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                    <label>Nom de fichier au choix: </label>
                    <input type="text" name="name" placeholder="Ex: Moussa" class="form-control">
                </div>
                <div class="form-group">
                    <label>Choisir un fichier en local</label>
                    <input type="file" name="file" class="form-control">
                </div>
                <input type="submit" name="submit" value="Enregistrer" class="btn btn-success">
            </form>
        </div>    
    </div>
    </body>
</html>