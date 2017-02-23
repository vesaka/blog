<div class="col-md-8 well">
    @foreach($articles as $article)
    <div class="well">
        <h2>
            <a href="/article/{{$article->id}}">{{$article->title}}</a>
        </h2>
        <p class="lead">
            by <a href="index.php">Vesaka</a>
        </p>
        <p><span class="glyphicon glyphicon-time"></span> Posted on {{$article->created_at}}</p>
        <hr>
        <img class="img-responsive" src="" alt="">
        <hr>
        @php ($text = strip_tags($article->text))
        <p>{!!mb_strlen($text) > 255 ? mb_substr($text, 0, 255) . '...' : $text!!}</p>
        <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
        <div class="panel-footer">
            @php ($article_tags = explode(',', $article->tags))
            @foreach($article_tags as $tag)
            <span class="label label-default">{{$tag}}</span>
            @endforeach
        </div>
        <hr>
    </div>
    @endforeach
</div>
