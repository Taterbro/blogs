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

      <div class="comments">
        <h1>COMMENTS</h1>
        <ul>
        @foreach($comments as $comment)
          <a href="{{route('editcomment',['comment'=>$comment['id']])}}">
          <li>{{$comment->comment}} <i>by </i>{{$comment->written_by}}</li>
          </a>
          

        @endforeach
        </ul>
        
        
      </div>

      <form action="{{route('comment',['blog'=>$post['id']])}}" method="post" class="postform">
          {{csrf_field()}}
          <textarea name="comment" placeholder="text goes here..." maxlength="500"></textarea>
          <button type="submit">Add comment</button>
        </form>


      <a href="{{route('blogs')}}">HOMEPAGE</a>
    </div>
    @else 
      <p>Please login to continue.</p>
    @endauth
    
  </body>
</html>
