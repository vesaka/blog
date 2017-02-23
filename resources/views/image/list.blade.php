@extends('layouts.admin')

@section('content')
<div class="col-lg-12"><a href="/admin/image/create" class="btn btn-primary">Качване на изображение</a></div>
@foreach ($images as $image) 
<div class="col-lg-3 col-md-4 col-xs-6 thumb">
    <div id="error-message"></div>
    <div class="actions thumbnail col-lg-12">
        <ul class="list-inline">
            <li>
                <a href="image/{{$image->id}}" onclick="">
                    <abbr title="Preview">
                        <span class="glyphicon glyphicon-search"></span>
                    </abbr>
                </a>
            </li>
            <li>
                <a href="/admin/image/{{$image->id}}/edit">
                    <abbr title="Edit">
                        <span class="glyphicon glyphicon-edit"></span>
                    </abbr>
                </a>
            </li>
            <li>
                <a href="/sdmin/image/{{$image->id}}" onclick="deleteImage(event)">
                    <abbr title="Remove">
                        <span class="glyphicon glyphicon-remove"></span>
                    </abbr>
                </a>
            </li>
        </ul>
    </div>
    <a class="thumbnail" href="/admin/image/{{$image->id}}">
        <img src="{{$image->filepath}}" style="max-width: 150px; max-height: 150px;" class="img-responsive" alt=""/>
    </a>

</div>
<script>
    var deleteImage = function (e) {
        e.preventDefault();
        $.ajax({
            url: e.target.href,
            type: 'DELETE',
            success: function() {
                window.location.href = '/admin/image';
            },
            error: function(response) {
                $('#error-message').html('Грешка при изтриването');
            }
        })
    }
</script>
@endforeach
@endsection
