@extends('layouts.app') @section('content')

<div class="border-solid border-b-2 border-gry-500 p-2 mb-2">
  <div class="flex justify-between">
    <h2 class="text-base mb-4">更新</h2>
    <button
      class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow"
    >
      <a href="{{ route('todo.index') }}">戻る</a>
    </button>
  </div>
  <!-- <form method="POST"> -->
    <!-- 省略 -->
    {!! Form::open(['route' => ['todo.update', $todo->id], 'method' => 'PUT']) !!}
    <div class="mb-4">
      <label
        class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
      >
        Title
      </label>
      {!! Form::textarea('title', $todo->title, ['required', 'class' =>
      'appearance-none block w-full bg-white text-gray-700 border border-gray-200
      rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white
      focus:border-gray-500', 'placeholder' => '新規Title', 'rows' => '3']) !!}
    </div>
    <div class="mb-4">
      <label
        class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
      >
        内容
      </label>
      {!! Form::textarea( 'content', $todo->content, ['required', 'class' =>
      'appearance-none block w-full bg-white text-gray-700 border border-gray-200
      rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white
      focus:border-gray-500', 'placeholder' => '新規Todo']) !!}
    </div>
    {!! Form::submit('登録', ['class' => 'bg-blue-500 hover:bg-blue-700 text-white
    font-bold py-2 px-4 rounded']) !!}
    <!-- 閉じる -->
    {!! Form::close() !!}
    <!-- 省略 -->
  <!-- </form> -->
</div>

@endsection