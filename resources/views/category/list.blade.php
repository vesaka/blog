@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-lg-6">
        <form action="category" method="POST" id="category_form">
            {{ csrf_field() }}
            @if(isset($article)) 
            {{ method_field('PUT') }}
            @endif
            <input type="hidden" id="category_id" name="category_id" value=""/>
            <input type="hidden" id="category_method" name="category_mothod" value=""/>
            <div class="form-group">    
                <label>Име на категория</label>
                <input class="form-control" type="text" onkeyup="Category.setName(this.value);" id="category_name" name="category_name"/>
            </div>
            <button class="btn btn-primary" onclick="Category.setNull(event)">Нулиране</button>
            <button class="btn btn-success" typе="submit" onclick="Category.dialog(event, 'add')">Добави категория</button>
            <button class="btn btn-warning" typе="submit" onclick="Category.dialog(event, 'edit')">Промени категория</button>
            <button class="btn btn-danger" typе="submit" onclick="Category.dialog(event, 'remove')">Изтирване</button>
        </form>
        
        <div id="message-error"></div>

        @include('layouts.tree')
    </div>
    <div id="response" class="col-lg-12">

    </div>
</div>

<script>
    document.getElementById('category_form').validator({
        category_name: [
            ['required', 'Няма име на категория!'],
            ['regexp:alphaDash', 'Използвани е неразрешение символи!']
        ]
    }, {
        errorPlacement: function (el, msg) {
            document.getElementById("message-error").innerHTML = msg;
        },
        submitHandler: function (e) {
            console.log(e.target.id);
            e.preventDefault();
        }
    });
    var tree = $('#jstree');
            var categories = {!!$categories or []!!};
    tree.jstree({
        core: {
            data: categories,
            multiple: false,
        },
        plugins: [''],
        checkbox: {
            whole_node: true
        }
    }).bind('changed.jstree', function (e, data) {
        if (data.action === "select_node") {
            Category.id = tree.jstree().get_selected()[0];
            $('#category_id').val(Category.id);
        }
    }).bind('loaded.jstree', function () {
        tree.jstree('open_all');

    });

    var Category = {
        id: null,
        name: null,
        confirm_message: {
            add: 'Да се добави ли категория с име "{0}"?',
            edit: 'Да се преименува ли категория с име "{0}" в "{1}"?',
            remove: 'Да се изтрие ли "{0}"?'
        },
        setNull: function (e) {
            e.preventDefault();
            tree.jstree(true).deselect_all();
            Category.id = null;
        },
        setName: function (value) {
            if (value.length > 2) {
                Category.name = value;
            } else {
                Category.name = '';
            }
        },
        add: function () {
            if (confirm(Category.confirm_message['add'].format(Category.name))) {
                $.ajax({
                    url: '/admin/category',
                    type: 'POST',
                    dataType: 'json',
                    data: $('#category_form').serialize(),
                    success: function (result) {
                        Category.refresh(result);
                    },
                    error: function (result) {
                        $('#response').html(result.responseText);
                        var response = JSON.parse(result.responseText);
                        $('#message-error').html(response[Object.keys(response)[0]]);
                    }
                });
            }
        },
        edit: function () {
            var category = $('.jstree-clicked').text();
            var new_name = $('#category_name').val();
            if (confirm(Category.confirm_message['edit'].format(category, new_name))) {
                $.ajax({
                    url: '/admin/category/' + Category.id,
                    type: 'PUT',
                    dataType: 'json',
                    data: $('#category_form').serialize(),
                    success: function (result) {
                        
                        Category.refresh(result);
                    },
                    error: function (result) {
                        $('#response').html(result.responseText);
                    }
                });
            }
        },
        remove: function () {
            var category = $('.jstree-clicked').text();
            if (confirm(Category.confirm_message['remove'].format(category))) {
                $.ajax({
                    url: '/admin/category/' + (Category.id || 0),
                    type: 'DELETE',
                    dataType: 'json',
                    data: $('#category_form').serialize(),
                    success: function (result) {
                        Category.refresh(result);
                    },
                    error: function (result) {
                        $('#response').html(result.responseText);
                    }
                });
            }
        },
        refresh: function (data) {
            //$('#response').html(data);
            tree.jstree(true).settings.core.data = data;
            tree.jstree(true).refresh();
        },
        dialog: function (e, method) {
            e.preventDefault();
            Category[method]();

        }
    };

    if (!String.prototype.format) {
        String.prototype.format = function () {
            var args = arguments;
            return this.replace(/{(\d+)}/g, function (match, number) {
                return typeof args[number] !== 'undefined' ? args[number] : match;
            });
        };
    }
</script>
@endsection