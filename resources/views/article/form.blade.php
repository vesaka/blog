@extends('layouts.admin')

@section('content')
<form action="{{!isset($article) ? '/admin/article' : '/admin/article/' . $article->id}}" method="POST" id="article_form" class="form-horizontal docs-options" role="form">
    {{ csrf_field() }}
    @if(isset($article)) 
    {{ method_field('PUT') }}
    @endif
    <div class="col-md-12">
        <button class="btn btn-primary" type="submit" id="article_submit">Submit</button>
    </div>
    <div  class="col-md-12" id="error-message">
        @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

    </div>
    <div class="col-md-8">
        <div class="form-group">
            <input type="text" class="form-control" name="article_title" placeholder="Image title" id="title" value="{{$article->title or 'lorem ipsum'}}">
        </div>
        <textarea name="article_description" id="editor">{!!$article->description or Lipsum::headers()->link()->ul()->html(3)!!}</textarea>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <input type="text" name="article_tags" id="tokenfield" value="{{$article->tags or 'lorem,ipsum'}}" />
        </div>
        <input type="hidden" id="category" name="article_category" value="{{$article->category_id or "4"}}"/>
        @include('layouts.tree')
    </div>
    <div class="col-md-12">
        <button class="btn btn-primary" type="submit" id="article_submit">Submit</button>
        <input class="btn btn-primary" type="submit" id="article_submit" vale="Submit"/>
    </div>
</form>

<script>
    document.getElementById('article_form').validator({
    article_title: [
    ['required', 'Article title is required'],
    ['regexp:alphaDashCyrilic', 'Illegal characters! Letters, numbers and dashes only']
    ],
            article_category: [
            ['required', 'Article category required']
            ],
            article_description: [
            ['required', 'Article description is required'],
            ['maxLength:100000', 'Description must be less than {0} characters']
            ]
    }, {
    beforeSubmit: function () {
    tinymce.triggerSave();
    },
            errorPlacement: function (el, msg) {
            document.getElementById("message-error").innerHTML = msg;
            },
    });
    var tree = $('#jstree');
    var categories = {!!$categories or []!!};
    tree.jstree({
    core: {
    data: categories,
            multiple: false,
            themes: {
            icons: false
            }
    },
            plugins: ['checkbox'],
            checkbox: {
            whole_node: true
            }
    }).bind('changed.jstree', function (e, data) {
    if (data.action === "select_node") {
    if (data.node.children.length > 0) {
    tree.jstree(true).deselect_node(data.node);
    tree.jstree(true).toggle_node(data.node);
    return;
    } else {
    $('#category').val(data.node.id);
    }
    }

    }).bind('loaded.jstree', function () {
    tree.jstree('open_all');
    var cat_id = $('#category').val();
    if (cat_id) {
    tree.jstree('select_node', $('#jstree #' + cat_id));
    }
    });
    tinymce.init({
    selector: '#editor',
            height: 300,
            theme: 'modern',
            plugins: [
                    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                    'searchreplace wordcount visualblocks visualchars code fullscreen',
                    'insertdatetime media nonbreaking save table contextmenu directionality',
                    'emoticons template paste textcolor colorpicker textpattern imagetools'
            ],
            toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
            toolbar2: 'print preview media | forecolor backcolor emoticons',
            image_advtab: true,
            templates: [
            {title: 'Test template 1', content: 'Test 1'},
            {title: 'Test template 2', content: 'Test 2'}
            ]
    });
    $('#tokenfield').tokenfield({
    autocomplete: {
    source: {!!$tags!!},
            delay: 100
    },
            showAutocompleteOnFocus: true
    });
</script>
@endsection
