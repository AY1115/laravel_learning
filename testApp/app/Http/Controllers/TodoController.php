<?php

declare(strict_types=1); /*ここは追記*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;  // 追記

class TodoController extends Controller
{

    /**
    * constructor function
    * @param Todo $todo
    */
    public function __construct(
        private Todo $todo
    ) {}
    // ここまで追記


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $todos = $this->todo->orderby('updated_at', 'desc')->paginate(5);
        return view('todo.index', ['todos' => $todos]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('todo.create');  // 追記
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 以下 returnまで追記
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string', 'max:255']
        ]);

        $this->todo->fill($validated)->save();

        return redirect()->route('todo.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $todo = $this->todo->findOrFail($id);  // 追記
        return view('todo.edit', ['todo' => $todo]);  // 追記
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string', 'max:255']
        ]);
        $this->todo->findOrFail($id)->update($validated);
        return redirect()->route('todo.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->todo->findOrFail($id)->delete();
        return redirect()->route('todo.index');
    }
}
