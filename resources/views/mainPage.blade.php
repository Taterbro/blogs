<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{asset('main.css')}}" />
    <title>blogs!</title>
  </head>
  <body>
    @auth 
    <div class="main">
      <h1>Global blogs</h1>
      <div class="blogcont">
        @foreach($posts as $post)
        <div class="blogitem">
          <a href="{{route('bloginfo',['id'=> $post['id']])}}">
            <h3>{{$post['title']}}</h3>
            <p class="sub">by: {{$post['author']}}</p>
            <p class="sub">uploaded: {{$post['date']}}</p>
          </a>
        </div>
        @endforeach
        
      </div>
      <a href="{{route('myblogs')}}">MY BLOGS</a>
      <form action="{{route('logout')}}" method="post">
        {{csrf_field()}}
        <button>Log out</button>
      </form>
      

    </div>
    @else
    <p>please login to view this page</p>
    @endauth 
    
  </body>
</html>
