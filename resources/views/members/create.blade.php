<html>
    <head>
        <title>Home</title>
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
</head>
<body>
    <div class="mx-4">
        <h3>Creer un membre</h3><br/>
        <div class="row">
            <div class="col-6 card-body bg-light">
                <form action="" method="POST">
                    <div class="form-group">
                        <label>Nom</label>
                        <input type="text" name="name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Role</label>
                        <select name="role"class="form-control">
                            <option>Admin</option>
                            <option>Membre</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Mot de passe</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <input type="submit" value="Enregistrer" class="btn btn-info">
                </form>
            </div>
        </div>
    </div>
</body>
</html>