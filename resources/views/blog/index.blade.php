<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
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
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-41324097-2', 'auto');
  ga('send', 'pageview');

</script>
</body>
</html>
