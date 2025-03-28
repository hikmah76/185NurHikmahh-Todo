<?php

namespace App\Http\Controllers;

use App\Models\Todo; // Pastikan ada ini
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Tambahkan ini

class TodoController extends Controller
{
    public function index()
    {
        $todos = Todo::where('user_id', Auth::id())->get();
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
}
