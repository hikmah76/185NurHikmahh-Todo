<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
class TodoController extends Controller
{
    public function index()
    {
        $todos = Todo::where('user_id', Auth::id())->orderBy('is_done', 'desc')->get();

        $todosCompleted = Todo::where('user_id',auth()->user()->id)
        ->where('is_done',true)
        ->count();
 
         return view('todo.index', compact('todos','todosCompleted'));
    }

    public function create()
{
    if (auth()->user()->is_admin) {
        $categories = Category::all(); // admin bisa lihat semua
    } else {
        $categories = Category::where('user_id', auth()->id())->get(); // user biasa hanya lihat miliknya
    }

    return view('todo.create', compact('categories'));
}


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $todo = Todo::create([
            'title' => ucfirst($request->title),
            'user_id' => Auth::id(),
        ]);
        return redirect()->route('todo.index')->with('success', 'Todo Created Successfully');
    }

    public function complete(Todo $todo)
    {
        if ($todo->user_id != Auth::id()) {
            abort(403);
        }

        $todo->is_done = true;
        $todo->save();

        return redirect()->route('todo.index')->with('success', 'Todo marked as complete.');
    }

    public function uncomplete(Todo $todo)
    {
        if ($todo->user_id != Auth::id()) {
            abort(403);
        }

        $todo->is_done = false;
        $todo->save();

        return redirect()->route('todo.index')->with('success', 'Todo marked as uncomplete.');
    }

public function edit(Todo $todo)
{
    if (auth()->id() !== $todo->user_id && !auth()->user()->is_admin) {
        return redirect()->route('todo.index')->with('danger', 'Unauthorized');
    }

    if (auth()->user()->is_admin) {
        $categories = Category::all(); 
    } else {
        $categories = Category::where('user_id', auth()->id())->get();
    }

    return view('todo.edit', compact('todo', 'categories'));
}


public function update(Request $request, Todo $todo)
{
    $request->validate([
        'title' => 'required|max:255',
        'category_id' => 'required|exists:categories,id',
    ]);

    $todo->update([
        'title' => ucfirst($request->title),
        'category_id' => $request->category_id,
    ]);

    return redirect()->route('todo.index')->with('success', 'Todo updated successfully!');
}


public function destroy(Todo $todo)
{
    if (auth()->user()->id == $todo->user_id) {
        $todo->delete();
        return redirect()->route('todo.index')->with('success', 'Todo deleted successfully!');
    } else {
        return redirect()->route('todo.index')->with('danger', 'You are not authorized to delete this todo!');
    }
}

public function destroyCompleted()
{
    // get all todos for current user where is_completed is true
    $todosCompleted = Todo::where('user_id', auth()->user()->id)
        ->where('is_done', true)
        ->get();

    foreach ($todosCompleted as $todo) {
        $todo->delete();
    }

    // dd($todosCompleted);
    return redirect()->route('todo.index')->with('success', 'All completed todos deleted successfully!');
}
    

}