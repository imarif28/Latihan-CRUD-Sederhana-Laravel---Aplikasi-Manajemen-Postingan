<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login Akun</title>
</head>

<body>

    <div class="container" style="margin-top: 50px">
        <div class="row">
            <div class="col-md-5 offset-md-3">
                <div class="card">
                    <div class="card-body">
                        <label>LOGIN</label>
                        <hr>

                        <form>
                            <div class="form-group">
                                <label>Alamat Email</label>
                                <input type="email" class="form-control" id="email" placeholder="Masukkan Alamat Email">
                            </div>

                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control" id="password" placeholder="Masukkan Password">
                            </div>

                            <button type="submit" class="btn btn-submit btn-block btn-success">LOGIN</button>
                        </form>

                    </div>
                </div>

                <div class="text-center" style="margin-top: 15px">
                    Belum punya akun? <a href="{{ route('register.index') }}">Silahkan Register</a>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.min.js"></script>

    <script>
        $(document).ready(function() {

            $("form").on("submit", function(e) {
                e.preventDefault();

                var email = $("#email").val();
                var password = $("#password").val();
                var token = $("meta[name='csrf-token']").attr("content");

                if (email.length == "") {
                    Swal.fire({
                        type: 'warning',
                        title: 'Oops...',
                        text: 'Alamat Email Wajib Diisi !'
                    });
                } else if (password.length == "") {
                    Swal.fire({
                        type: 'warning',
                        title: 'Oops...',
                        text: 'Password Wajib Diisi !'
                    });
                } else {
                    $.ajax({
                        url: "{{ route('login.store') }}",
                        type: "POST",
                        dataType: "JSON",
                        cache: false,
                        data: {
                            "email": email,
                            "password": password,
                            "_token": token
                        },

                        success: function(response) {

                            if (response.success) {

                                Swal.fire({
                                        type: 'success',
                                        title: 'Login Berhasil!',
                                        text: 'Anda akan di arahkan dalam 3 Detik',
                                        timer: 3000,
                                        showConfirmButton: false
                                    })
                                    .then(function() {
                                        window.location.href = "{{ route('posts.index') }}";
                                    });

                            } else {
                                Swal.fire({
                                    type: 'error',
                                    title: 'Login Gagal!',
                                    text: 'silahkan coba lagi!'
                                });
                            }
                        },

                        error: function(jqXHR, textStatus, errorThrown) {
                            if (jqXHR.status === 401) {
                                Swal.fire({
                                    type: 'error',
                                    title: 'Login Gagal!',
                                    text: jqXHR.responseJSON.message
                                });
                            } else if (jqXHR.status === 422) {
                                let errors = jqXHR.responseJSON.errors;
                                let errorHtml = '<div style="text-align: left;"><ul>';
                                $.each(errors, function(key, value) {
                                    errorHtml += '<li>' + value[0] + '</li>';
                                });
                                errorHtml += '</ul></div>';

                                Swal.fire({
                                    type: 'error',
                                    title: 'Input Tidak Valid!',
                                    html: errorHtml
                                });
                            } else {
                                Swal.fire({
                                    type: 'error',
                                    title: 'Opps!',
                                    text: 'server error!'
                                });
                            }
                        }
                    });
                }
            });
        });
    </script>

</body>

</html>