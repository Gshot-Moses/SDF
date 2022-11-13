<html>
    <head>
        <title>Home</title>
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
</head>
<body>
<div class="mx-4">
        <h3>Composer un mail</h3><br/>
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
            <div class="card col-6">
                <div class="card-header">Ecrire</div>
            <div class="card-body bg-light">
                <form action="" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label>Adresse mail recepteur</label>
                        <input type="text" name="name" class="form-control" placeholder="serge@gmail.com">
                    </div>
                    <div class="form-group">
                        <label>Suject</label>
                        <input type="email" name="email" class="form-control" placeholder="Sujet">
                    </div>
                    <div class="form-group">
                        <textarea name="body" class="form-control" placeholder="Corps du message"></textarea>
                    </div>
                    <input type="submit" value="Enregistrer" class="btn btn-info">
                </form>
            </div>
        </div>
    </div>
</div>