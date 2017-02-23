@extends('layouts.admin')

@section('content')

<div class="row">
    <table class="table table-striped">
        <thead class="thead-inverse">
            <tr>
                <th>#</th>
                <th>Име</th>
                <th>Имейл</th>
                <th>Роли</th>
                <th>Добавен на</th>
                <th>Последна промяна</th>
                <th>Операции</th>
            </tr>
        </thead>
        @foreach($users as $user)
        <tr>
            <th scope="row">{{$user->id}}</th>
            <td><a href="/admin/user/{{$user->id}}/edit">{{$user->name}}</td>
            <td>{{$user->email}}</td>
            <td>{{$user->roles}}</td>
            <td>{{$user->created_at}}</td>
            <td>{{$user->updated_at}}</td>
            <td>
                <ul class="list-inline">
                    <li>
                        <a href="/admin/user/show/{{$user->id}}" onclick="">
                            <abbr title="Preview">
                                <span class="glyphicon glyphicon-eye-open"></span>
                            </abbr>
                        </a>
                    </li>
                    <li>
                        <a href="/admin/user/{{$user->id}}/edit">
                            <abbr title="Edit">
                                <span class="glyphicon glyphicon-edit"></span>
                            </abbr>
                        </a>
                    </li>
                    <li>
                        <a href="/admin/user/{{$user->id}}/delete" onclick="">
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
