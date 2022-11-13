<html>
    <head>
        <title>Home</title>
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
</head>
<body>
    <div class="mx-4">
        <h3>Creer un membre</h3><br/>
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
                <div class="card-header">Creer un membre</div>
            <div class="card-body bg-light">
                <form action="{{ route('member.store') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label>Nom</label>
                        <input type="text" name="name" class="form-control" placeholder="Ex: Serge">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" placeholder="example@gmail.com">
                    </div>
                    <div class="form-group">
                        <label>Role</label>
                        <select name="role" class="form-control">
                            <option value=2>Admin</option>
                            <option value=1>Membre</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Mot de passe</label>
                        <input type="password" name="password" class="form-control" placeholder="Mot de passe">
                    </div>
                    <input type="submit" value="Enregistrer" class="btn btn-info">
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>