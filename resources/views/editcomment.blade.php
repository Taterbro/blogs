<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EditComment</title>
</head>
<body>

@if(session('message')) 
    <div>
        {{session('message')}}  <!--to display that edit change was successful-->
    </div>

@endif

<form action="{{route('actuallyEdit',['comment'=> $comment['id']])}}" method="post" class="postform">
          {{csrf_field()}}
          @method('PUT')
          <textarea name="comment" placeholder="text goes here..." maxlength="500">{{$comment['comment']}}</textarea>
          <button type="submit">Save comment</button>
        </form>

        <a href="{{route('blogs')}}">GO TO HOMEPAGE</a>
</body>
</html>