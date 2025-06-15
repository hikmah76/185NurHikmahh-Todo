<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    public function index()
    {
        $todos = Todo::with('category')
            ->where('user_id', Auth::id())
            ->orderBy('is_done', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $todosCompleted = Todo::where('user_id', Auth::id())
            ->where('is_done', true)
            ->count();
 
        return view('todo.index', compact('todos', 'todosCompleted'));
    }

    public function create()
    {
        $user = Auth::user();
        $categories = $user && $user->is_admin 
            ? Category::all() 
            : Category::where('user_id', $user->id)->get();

        return view('todo.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        Todo::create([
            'title' => ucfirst($request->title),
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('todo.index')->with('success', 'Todo Created Successfully');
    }

    public function edit(Todo $todo)
    {
        // Cek apakah user berhak mengedit todo ini
        if ($todo->user_id != Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $user = Auth::user();
        $categories = $user && $user->is_admin 
            ? Category::all() 
            : Category::where('user_id', $user->id)->get();

        return view('todo.edit', compact('todo', 'categories'));
    }

    public function update(Request $request, Todo $todo)
    {
        // Cek apakah user berhak mengupdate todo ini
        if ($todo->user_id != Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $todo->update([
            'title' => ucfirst($request->title),
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('todo.index')->with('success', 'Todo updated successfully!');
    }

    public function complete(Todo $todo)
    {
        if ($todo->user_id != Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $todo->update(['is_done' => true]);

        return redirect()->route('todo.index')->with('success', 'Todo marked as complete.');
    }

    public function uncomplete(Todo $todo)
    {
        if ($todo->user_id != Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $todo->update(['is_done' => false]);

        return redirect()->route('todo.index')->with('success', 'Todo marked as uncomplete.');
    }

    public function destroy(Todo $todo)
    {
        if ($todo->user_id != Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $todo->delete();
        return redirect()->route('todo.index')->with('success', 'Todo deleted successfully!');
    }

    public function destroyCompleted()
    {
        $deletedCount = Todo::where('user_id', Auth::id())
            ->where('is_done', true)
            ->delete();

        $message = $deletedCount > 0 
            ? "Successfully deleted {$deletedCount} completed todos!" 
            : 'No completed todos to delete.';

        return redirect()->route('todo.index')->with('success', $message);
    }
}