@extends('layouts.admin')

@section('content')
<form action="/article/quote/" method="POST" id="quote_form" class="form-horizontal docs-options" role="form">
    {{ csrf_field() }}
    @if(isset($article)) 
        {{ method_field('PUT') }}
    @endif
    <div class="col-md-12">
        <button class="btn btn-primary" type="submit" id="article_submit">Submit</button>
    </div>
    <div class="col-md-8">
        <textarea name="quote_text" id="editor">{!!$article->description or Lipsum::headers()->link()->ul()->html(3)!!}</textarea>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <input type="text" name="article_tags" id="tokenfield" value="{{$article->tags or 'lorem,ipsum'}}" />
        </div>
        <input type="hidden" id="category" name="article_category" value="{{$article->category_id or "4"}}"/>
        <div id="jstree"></div>
    </div>
    <div class="col-md-12">
        <button class="btn btn-primary" type="submit" id="article_submit">Submit</button>
        <input class="btn btn-primary" type="submit" id="article_submit" vale="Submit"/>
    </div>
    <button class="btn btn-primary" onclick="Category.setNull(event)">Нулиране</button>
    <button class="btn btn-success" typе="submit" onclick="Category.dialog(event, 'add')">Добави категория</button>
            <button class="btn btn-warning" typе="submit" onclick="Category.dialog(event, 'edit')">Промени категория</button>
            <button class="btn btn-danger" typе="submit" onclick="Category.dialog(event, 'remove')">Изтирване</button>
</form>

<script>
    
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

    $('#tokenfield').tokenfield({
        autocomplete: {
            source: {!!$tags!!},
            delay: 100
        },
        showAutocompleteOnFocus: true
    });
</script>
@endsection
