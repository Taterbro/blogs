<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{asset('main.css')}}" />
    <title>your blogs</title>
  </head>
  <body>
  @auth 
  <div class="main">
      <h1>Your blogs</h1>
      <div class="blogcont">
        
           @foreach($myposts as $post)
        <div class="blogitem">
          <a href="{{route('bloginfo',['blog' => $post['id']])}}">
            <h3>{{$post['title']}}</h3>
            <p class="sub">uploaded: {{$post['date']}}</p>
          </a>
        </div>
        @endforeach
        
       
        
        <a href="{{route('blogs')}}">GO TO HOMEPAGE</a>
        <form action="{{route('addblog')}}" method="post" class="postform">
          {{csrf_field()}}
          <input type="text" name="title" placeholder="title" maxlength="25">
          <textarea name="body" placeholder="text goes here..." maxlength="500"></textarea>
          <button type="submit">Save Post</button>
        </form>
      </div>
    </div>
@else
  <p>please login to continue</p>
@endauth

   
  </body>
</html>
