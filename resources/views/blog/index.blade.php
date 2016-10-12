<html>
<head>
<title>{{ $published->first()->latestRevision->name }} | {{ $published->first()->latestRevision->user->name }}</title>
<style>
* {
  box-sizing: border-box;
}

html,
body {
  height: 100%;
  background-image: url(https://hd.unsplash.com/37/IHLjdHdzSvi0rgUMMlSK_TE3_0286.jpg);
  background-size: cover;
  font-family: 'Roboto Condensed', sans-serif;
  margin: 0;
}

.card_wrap {
  position: relative;
  display: flex;
  height: 100%;
  width: 75%;
  margin-left: calc(25% / 2);
}

.card_body {
  position: relative;
  margin: auto;
  height: 0;
  box-shadow: -25px 25px 60px 5px rgba(0, 0, 0, 0.5), 
              -60px 60px 100px 13px rgba(0, 0, 0, 0.27);
  overflow: hidden;
  transition: height 0.3s ease-in-out;
}

.card_body .description,
.card_body .footer {
  position: absolute;
  left: 25px;
  color: transparent;
  transition: all 0.5s ease-in-out 0.5s;
}

.card_body .description {
  top: 380px;
}
.card_body .footer {
  bottom: 135px;
}

.card_body h3,
.card_body h1 {
  /* text-transform: uppercase; */
}

.card_body h1 {
  font-weight: 700;
  font-size: 34px;
}
.card_body h3 {
  font-weight: 300;
}
.quote {
    font-style: italic;
    font-size: 0.8em;
    font-weight: bold;
    text-align: right;
}
.author {
  font-weight: 400 !important;
}

.card_body-gradient {
  position: absolute;
  top: -290px;
  height: 800px;
  width: 100%;
  background: linear-gradient(to bottom, 
              rgba(201, 230, 255, 0.19) 100px, #164036 500px);
  transition: top 0.3s ease-in-out 0.3s;
}
.card_body.active {
  height: 80%;
}
.card_body.active .card_body-gradient {
  top: 0;
}
.card_body.active .description {
  top: 230px;
  color: #fff;
}
.card_body.active .footer {
  bottom: 35px;
  color: #fff;
}
.cards {
}
.a {
    width: 25%;
}
.b {
    width: 75%;
    overflow: auto;
}
.article {
    background: white;
    font-size: 1.5em;
    padding: 1em 2em;
}
.article p {
    overflow: auto;
    font-family: Roboto,sans-serif;
    font-size: 20px;
    font-weight: 300;
    line-height: 1.4;
}
</style>
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
