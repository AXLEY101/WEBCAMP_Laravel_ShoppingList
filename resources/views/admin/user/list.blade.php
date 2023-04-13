@extends('admin.layout')

{{-- メインコンテンツ --}}
@section('contets')
        

        <h1>ユーザ一覧</h1>
        <table border="1">
        <tr>
            <td>ユーザID
            <td>ユーザ名
            <td>購入した「買うもの」数
    @foreach ($users as $user)
        <tr>
            <td>{{$user->id}}
            <td>{{$user->name}}
            <td>{{$user->task_num}}
            
    @endforeach
        </table>

@endsection