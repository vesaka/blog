@extends('layouts.admin')

@section('content')

<div class="row">
    <table class="table table-striped">
        <thead class="thead-inverse">
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Created</th>
                <th>Last Update</th>
                <th>Actions</th>
            </tr>
        </thead>
        @foreach($articles as $article)
        <tr>
            <th scope="row">{{$article->id}}</th>
            <td><a href="/admin/article/{{$article->id}}/edit">{{$article->title}}</td>
            <td>{{$article->created_at}}</td>
            <td>{{$article->updated_at}}</td>
            <td>
                <ul class="list-inline">
                    <li>
                        <a href="/admin/article/show/{{$article->id}}" onclick="">
                            <abbr title="Preview">
                                <span class="glyphicon glyphicon-search"></span>
                            </abbr>
                        </a>
                    </li>
                    <li>
                        <a href="/admin/article/{{$article->id}}/edit">
                            <abbr title="Edit">
                                <span class="glyphicon glyphicon-edit"></span>
                            </abbr>
                        </a>
                    </li>
                    <li>
                        <a href="/admin/article/{{$article->id}}/delete" onclick="">
                            <abbr title="Remove">
                                <span class="glyphicon glyphicon-remove"></span>
                            </abbr>
                        </a>
                    </li>
                </ul>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
