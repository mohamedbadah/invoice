<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.css') }}">
    <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">
    <style>
        body {
            background-image: url({{ url('assets/img/log.jpg') }});
            background-size: 70% 70%;
        }

    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-4" style="margin-top:200px">
                <h4 id="success" style="text-align:center"></h4>
                <h2>Login</h2>
                <form>
                    <div class="form-group">
                        <input type="email" placeholder="enter the email" id="email" class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="password" placeholder="enter the password" id="password" class="form-control">
                    </div>
                    <div class="form-group">
                        <button type="button" onclick="login()" class="btn btn-success">login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    {{-- <script src="http://cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script>
        <script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script> --}}
    <script>
        function message(color, data) {
            let mysucess = document.getElementById('success');
            mysucess.textContent = data;
            mysucess.style.backgroundColor = color;
            mysucess.style.color = "#FFF";
            mysucess.style.padding = "10px";
            mysucess.style.fontSize = "20px";
        }

        function login() {
            axios.post('/user/check/', {
                    email: document.getElementById('email').value,
                    password: document.getElementById('password').value,
                })
                .then(function(response) {
                    console.log(response.data.message);
                    // toastr.success(response.data.message);
                    message("#0FF", response.data.message);
                    window.location.href = "/user/index";
                })
                .catch(function(error) {
                    console.log(error);
                    message("#f00", error.response.data.message);
                    // toastr.error(error.response.data.message)
                });
        }
    </script>
</body>

</html>
