<html>
<head>
    <title>{{ $published->first()->latestRevision->name }} | {{ $published->first()->latestRevision->user->name }}</title>
    <link href="{{ elixir('css/blog.css') }}" rel="stylesheet">
</head>
<body>
<div class="card_wrap">
    @foreach ($published as $article)
      <div class="card_body a">
        <div class="card_body-gradient"></div>
        <div class="description">
          <h1>{{ $article->latestRevision->name }}</h1>
        </div>
        <div class="footer">
          <h3 class="quote">{{ $article->latestRevision->published_at }}</h3>
          <h3 class="author">{{ $article->latestRevision->user->name }}</h3>
        </div>
      </div>

      <div class="card_body b">
        <div class="article">
            <h3 class="quote">{!! nl2br($article->latestRevision->verse) !!}</h3>
            <p>{!! nl2br($article->latestRevision->meaning_function) !!}</p>
        </div>
      </div>
    @endforeach
</div>
<script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
<script>
var card = $('.card_body');

setTimeout(function(){
      card.addClass('active');
}, 500);
</script>
</body>
</html>
