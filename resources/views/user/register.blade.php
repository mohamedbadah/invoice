<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{asset('dist/css/adminlte.css')}}">
    {{-- <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css"> --}}
</head>
<body class="bg-light">
  <div class="container">
      <div class="row">
          <div class="col-md-4 offset-4" style="margin-top:40px">
            <h2>Login AdminLTE</h2>
            <p id="message"></p>
   <form >
     {{-- @if (Session('sucess'))
                    <div class='alert alert-success'>{{session('sucess')}}</div>
                @endif
                  @if (Session('faild'))
                <div class='alert alert-danger'>{{session('faild')}}</div>
                    @endif
    @csrf --}}
   <div class="form-group">
   <input type="text" id="username" name="username" placeholder="enter Username" class="form-control mt-4">
   </div>
   <div class="form-group">
   <input type="email" id="email" name="email" placeholder="enter email" class="form-control mt-4">
   </div>
   <div class="form-group">
   <input type="password" id="password" name="password" placeholder="enter the password" class="form-control mt-4">
   </div>
   <div class="form-group">
   <input type="password" id="cpassword" name="cpassword" placeholder="enter the confirm password" class="form-control mt-4">
   </div>
   <div>
       {{-- <input type="submit" value="enter" class="btn btn-success offset-4 mt-4"> --}}
   </div>
   <div class="form-group">
       <button onclick="register()" class="btn btn-primary offset-4 mt-4">register</button>
   </div>
   </form>
</div>
</div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  {{-- <script src="http://cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script> --}}
        {{-- <script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script> --}}
<script>
    let message=document.getElementById("message");
    function register(){
        let formData=new FormData();
        formData.append('username',document.getElementById('username').value);
        formData.append('email',document.getElementById('email').value);
        formData.append('password',document.getElementById('password').value);
        formData.append('cpassword',document.getElementById('cpassword').value);
    axios.post('/user/create/',formData
//     {
//     username:document.getElementById('username').value,
//     email:document.getElementById('email').value,
//     password:document.getElementById('password').value,
//     cpassword:document.getElementById('cpassword').value
//   }
  )
  .then(function (response) {
    console.log(response.data.message);
    message.textContent=response.data.message;
    message.style.color="#FFF";
    message.style.backgroundColor="#00F";
    // toastr.success(response.data.message);
    window.location.href="/user/login/";
  })
  .catch(function (error) {
    console.log(error);
    // toastr.error(error.response.data.message);
    message.textContent=error.response.data.message;
    message.style.color="#FFF";
    message.style.backgroundColor="#F00";
  });
  }
</script>
</body>
</html>
