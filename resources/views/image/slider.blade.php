@foreach($images as $image)
<div>
    <a href="/image/{{$image->id}}/{{$image->slug}}">
        <img class="image-big" data-u="image" alt="{{$image->name}}" src="/storage/{{$image->title}}"/>
    </a>
    <img data-u="thumb" alt="{{$image->name}}" src="/storage/{{$image->thumb}}"/>
</div>
@endforeach
