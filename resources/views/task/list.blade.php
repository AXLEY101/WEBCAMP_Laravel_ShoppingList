@extends('layout')

{{-- タイトル --}}
@section('title')(詳細画面)@endsection

{{-- メインコンテンツ --}}
@section('contets')
        <h1>「買うもの」の登録</h1>
        @if(session('front.task_register_success') == true)
        買うものを登録しました！！<br>
        @endif
        @if ($errors->any())
                <div>
                @foreach ($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
                </div>
        @endif
            <form action="/task/register" method="post">
                @csrf
                「買うもの」名:<input name="name" value="{{old('name')}}"><br>
                <button>買うものを登録する</button>
            </form>

        <h1>「買うもの」一覧</h1>
        <table border="1">
        <tr>
            <th>登録日
            <th>「買うもの」名
    @foreach($list as $task)
        <tr>
            <td>{{\Carbon\Carbon::parse($task->created_at)->format('Y-m-d')}}
            <td>{{ $task->name}}
                    
    @endforeach
        
        </table>
        <!-- ページネーション -->
        現在 {{ $list->currentPage() }} ページ目<br>
        @if ($list->onFirstPage() === false)
        <a href="/task/list">最初のページ</a>
        @else
            最初のページ
        @endif
        /
        @if ($list->previousPageUrl() !== null)
            <a href="{{ $list->previousPageUrl() }}">前に戻る</a>
        @else
            前に戻る
        @endif
        /
        @if ($list->nextPageUrl() !== null)
            <a href="{{ $list->nextPageUrl() }}">次に進む</a>
        @else
            次に進む
        @endif
        <br>
        <hr>
        <menu label="リンク">
        <a href="/logout">ログアウト</a><br>
        </menu>
@endsection