<?php

namespace App\Http\Controllers;

use App\Models\Todo; // Pastikan ada ini
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Tambahkan ini

class TodoController extends Controller
{
    public function index()
    {
    $todos = Todo::where('user_id', auth()->user()->id)
        ->orderBy('is_complete', 'asc')
        ->orderBy('created_at', 'desc')
        ->get();
    // add($todos);

    return view('todo.index', compact('todos'));
    }

    public function create()
    {
        return view('todo.create');
    }

    public function edit() // Perbaiki typo dari "esit" ke "edit"
    {
        return view('todo.edit');
    }

    public function store(Request$request, Todo $todo)
    {
        $request->validate([
            'title' => 'required|max:255',
        ]);

        //Practical
        //$todo = new Todo;
        //$todo->title = $request->title;
        //$todo->user_id = auth()->user()->id;
        //$todo->save();
        //Query Builder way
        //DB::table('todos')-> insert([
        //     'title' => $request->tittle,
        //      'user_id' =>auth()->user->id,
        //      'created_at' => now(),
        //]);

        //Eloquent Way - Readable
        $todo = Todo::create([
            'title' => ucfirst($request->title),
            'user_id' => auth()->id(),
        ]);
        
        return redirect()->route('todo.index')->with('success', 'Todo created  successfully!');

        }

    }
