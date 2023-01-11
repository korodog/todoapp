@extends('layouts.todoapp')

@section('title', 'Todoアプリ-編集画面')

@section('content')

@if (Auth::check())
    <main>
        <div>
            <div>
                <form action="/{{ $task->id }}" method="post">
                    @csrf
                    @method('PUT')

                    <div>
                        <div class="editTask">
                        <label>
                            <input type="text" name="task_name" value="{{ $task->name }}">
                            @error('task_name')
                                <div class="editError">
                                    <p>
                                        {{ $message }}
                                    </p>
                                </div>
                                @enderror
                        </label>
                        </div>
                        <div class="editBack1">
                            <div class="editBack2">
                            <div class="editBack3">
                            <a href="/tasks">
                                戻る
                            </a>
                            </div>
                            </div>
                            <div class="goEdit">
                            <button type="submit">
                                編集する
                            </button>
                            </div>
                        </div>
                    </div>
                </form>    
            </div>
        </div>
    </main>
@else
    <div>
        <p>※ログインして下さい。</p>    
    </div>   
@endif
@endsection
   
</body>
</html>