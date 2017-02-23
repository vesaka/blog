<div class="col-lg-12">
    <strong  class="label label-important col-lg-12">{{$success or null}}</strong>
    @foreach($quotes as $quote)

    <div class="panel thumbnail" style="cursor: pointer">


        <div onclick="Quote.show({{$quote->id}})" class="panel-body">
            <div class="col-sm-12">
                <b class="label label-info col-sm-2">Категория</b><em class="label label-default col-sm-6">{{$quote->category}}</em>
                <a class="col-sm-4 col-sm-push-3" onclick="Quote.remove(event, {{$quote->id}})">
                    <i class="glyphicon glyphicon-remove"></i>
                </a>
            </div>
            <div class="col-sm-12">{{$quote->text}}</div>
        </div>

        <div class="panel-heading">
            <div class="text-center">
                <div class="row">
                    <div class="col-sm-8">
                        <span><em>Последна промяна:</em></span>
                        <small><em>{{$quote->updated_at}}</em></small>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel-footer">
            @php ($quote_tags = explode(',', $quote->tags))
            @foreach($quote_tags as $tag)
            <span class="label label-default">{{$tag}}</span>
            @endforeach
        </div>
    </div>
    @endforeach
</div>
