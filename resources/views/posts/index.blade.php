<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <title>Data Posts</title>
</head>

<body>

    <div class="container" style="margin-top: 80px">
        <div class="row">

            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">MAIN MENU</div>
                    <div class="card-body">
                        <ul class="list-group">
                            <a href="{{ route('posts.index') }}" class="list-group-item list-group-item-action active">Dashboard</a>
                            <a href="#" class="list-group-item list-group-item-action">Profile</a>

                            <a href="{{ route('logout') }}" class="list-group-item list-group-item-action"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">DATA POSTS</div>
                    <div class="card-body">

                        <h5>Selamat Datang, <strong>{{ Auth::user()->name }}</strong></h5>
                        <hr>

                        <a href="{{ route('posts.create') }}" class="btn btn-md btn-success" style="margin-bottom: 10px">TAMBAH DATA</a>

                        @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        @endif

                        <table class="table table-bordered" id="myTable">
                            <thead>
                                <tr>
                                    <th scope="col">TITLE</th>
                                    <th scope="col">CONTENT</th>
                                    <th scope="col">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($posts as $post)
                                <tr>
                                    <td>{{ $post->title }}</td>
                                    <td>{!! $post->content !!}</td>
                                    <td class="text-center">
                                        <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-sm btn-primary">EDIT</a>

                                        <form onsubmit="return confirm('Apakah anda yakin ?');" action="{{ route('posts.destroy', $post->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">HAPUS</button>
                                        </form>

                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
            setTimeout(function() {
                $(".alert-success").fadeOut('slow');
            }, 1500);
        });
    </script>
</body>

</html>