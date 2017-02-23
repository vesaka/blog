@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-lg-6">
        <form action="category" method="POST" id="quote_form">
            {{ csrf_field() }}
            <input type="hidden" id="quote_id" name="quote_id" value=""/>
            <input type="hidden" id="quote_category" name="quote_category" value=""/>
            <div class="form-group">    
                <label class="label label-default col-lg-12">Текст за изпращане</label>
                <textarea id="quote_text" class="form-control" name="quote_text">{{Lipsum::short()->text(1)}}</textarea>
            </div>
            <div class="form-group"> 
                <input type="text"  class="form-control" id="tokenfield" name="quote_tags"/>
            </div>
            <button class="btn btn-primary" type="reset" onclick="Quote.nullify()">Нулиране</button>
            <button class="btn btn-success" typе="submit" onclick="Quote.dialog(event, 'add')">Добави цитат</button>
            <button class="btn btn-warning" typе="submit" onclick="Quote.dialog(event, 'edit')">Промени цитат</button>
            <button class="btn btn-danger"   typе="submit" onclick="Quote.dialog(event, 'remove')">Изтирване</button>
        </form>

        <div id="message-error"></div>

        @include('layouts.tree')
    </div>
    <div id="response" class="col-lg-6 pre-scrollable">
        @include('quote.list')
    </div>
</div>

<script>
    var categories = '{!!$categories!!}';
    var tags = JSON.parse('{!!$tags!!}');
    var tree = $('#jstree');
    var quote_id = $('#quote_id');
    var $tokenfield = $('#tokenfield');
    tree.jstree({
        core: {
            data: JSON.parse(categories),
            multiple: false
        },
        checkbox: {
            whole_node: true
        }
    }).bind('changed.jstree', function (e, data) {
        if (data.action === "select_node") {
            $('#quote_category').val(tree.jstree().get_selected()[0]);
        }
    }).bind('loaded.jstree', function () {
        tree.jstree('open_all');
    });
    var Quote = {
        name: null,
        confirm_message: {
            add: 'Добавяне?',
            edit: 'Потвърждате ли промяната?',
            remove: 'Изтриване?'
        },
        nullify: function () {
            tree.jstree(true).deselect_all();
            $tokenfield.tokenfield('setTokens', []);
        },
        search: function () {

        },
        show: function (id) {
            $.ajax({
                url: '/admin/quote/' + id,
                type: 'GET',
                dataType: 'json',
                success: function (result) {
                    quote_id.val(result.id);
                    $('#quote_text').val(result.text);
                    $tokenfield.tokenfield('setTokens', result.tags);
                    tree.jstree(true).deselect_all();
                    tree.jstree(true).select_node(result.category_id);
                    $('#quote_category').val(result.category_id);
                },
                error: function (result) {
                    var response = JSON.parse(result.responseText);
                    $('#message-error').html(response[Object.keys(response)[0]]);
                }
            });
        },
        add: function () {
            if (confirm(Quote.confirm_message['add'])) {
                $.ajax({
                    url: '/admin/quote',
                    type: 'POST',
                    dataType: 'html',
                    data: $('#quote_form').serialize(),
                    success: function (result) {
                        Quote.refresh(result);
                    },
                    error: function (result) {
                        var response = JSON.parse(result.responseText);
                        $('#message-error').html(response[Object.keys(response)[0]]);
                    }
                });
            }
        },
        edit: function () {
            var category = $('.jstree-clicked').text();
            console.log($('#quote_form').serialize());
            if (confirm(Quote.confirm_message['edit'])) {
                $.ajax({
                    url: '/admin/quote/' + quote_id.val(),
                    type: 'PUT',
                    dataType: 'html',
                    data: $('#quote_form').serialize(),
                    success: function (result) {
                        console.log(result);
                        Quote.refresh(result);
                    },
                    error: function (result) {
                        $('#response').html(result.responseText);
                    }
                });
            }
        },
        remove: function () {
            if (confirm(Quote.confirm_message['remove'])) {
                $.ajax({
                    url: '/admin/quote/' + (quote_id.val()),
                    type: 'DELETE',
                    dataType: 'html',
                    data: $('#quote_form').serialize(),
                    success: function (result) {
                        Quote.refresh(result);
                    },
                    error: function (result) {
                        $('#response').html(result.responseText);
                    }
                });
            }
        },
        delete: function(e, id) {
            e.preventDefault();
            e.stopPropagation();
            quote_id.val(id);
            Quote.remove();
        },
        refresh: function (data) {
            Quote.nullify();
            $('#response').html(data);
        },
        dialog: function (e, method) {
            e.preventDefault();
            Quote[method]();
        }
    };
    $tokenfield.tokenfield({
        autocomplete: {
            source: tags,
            delay: 100,
            minLength: 3,
        },
        showAutocompleteOnFocus: true
    });
</script>
@endsection