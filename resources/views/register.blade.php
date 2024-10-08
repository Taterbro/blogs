<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{asset('main.css')}}" />
    <title>login! Register!</title>
  </head>
  <body>
    <div class="stuff">
      <h1>Welcome to blogs</h1>
      <h2>Login or Register</h2>
      @if ($errors -> any())
      <div class="alert alert-danger">
        <ul>
          @foreach($errors->all() as $error)
            <li>{{$error}}</li>
          @endforeach
        </ul>
      </div>
      @endif
      <form action="{{route('register')}}" method="post" class="regform">
        <!--remember to add csrf field in laravel-->
        {{csrf_field()}}
        
        
        <input
          type="text"
          placeholder="name"
          name="name"
          maxlength="10"
        />
        <input
          type="email"
          placeholder="email"
          name="email"
        />
        <input type="password" placeholder="password" name="password" maxlength="16" />
        <div class="butt">
          <button type="submit" class="regbutt">Register</button>
        </div>
      </form>

      <form action="{{route('login')}}" method="post" class="regform">
        <!--remember to add csrf field in laravel-->
        {{csrf_field()}}
        <input type="text" placeholder="name" name="Lname" />
        <input type="password" placeholder="password" name="Lpassword" />
        
        <div class="butt">
          <button type="submit" class="regbutt">Login</button>
        </div>
      </form>
    </div>
  </body>

  <script src="{{ asset('js/app.js') }}"></script>
</html>
