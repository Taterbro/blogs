<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{asset('main.css')}}" />
    <title>blog-id</title>
  </head>
  <body>
    @auth 
    <div class="bloginfo">
      <h1>{{$post['title']}}</h1>
      <div class="inf">
        <p style="padding-left: 10px">
          {{$post['body']}}
        </p>
        <div class="subbox">
          <p class="sub">by: {{$post['author']}}</p>
          <p class="sub">date: {{$post['date']}}</p>
        </div>
      </div>
      <a href="{{route('blogs')}}">HOMEPAGE</a>
    </div>
    @else 
      <p>Please login to continue.</p>
    @endauth
    
  </body>
</html>
