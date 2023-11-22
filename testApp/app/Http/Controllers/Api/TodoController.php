<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Models\Todo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TodoController extends Controller
{
    public function __construct(
      private Todo $todo
    ) {}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string', 'max:255']
        ]);
        $this->todo->fill($validated)->save();

        return ['message' => 'ok'];
    }


    //更新・削除する際のテーブルからデータの照合
    public function edit(string $id)
    {
        $todo = $this->todo->findOrFail($id);
        return $todo; //値の照合結果

        //下記はviewの必要がないため削除
        //return view('todo.edit', ['todo' => $todo]);
    }


    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string', 'max:255']
        ]);
        $this->todo->findOrFail($id)->update($validated);
        return ["message" => "ok"]; //更新処理が成功したらOK

        //ページを表示させる必要はなしのため削除
        //return redirect()->route('todo.index');
    }

    public function destroy(string $id)
    {
        $this->todo->findOrFail($id)->delete();
        return ["message" => "ok"];

        //ページを表示させる必要はなしのため削除
        //return redirect()->route('todo.index');
    }


    








}