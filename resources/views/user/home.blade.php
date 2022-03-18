<h1>{{Auth::guard('web')->user()->name}}</h1>
<h1><a href="{{route('user.logout')}}">logout</a></h1>
