<?php

namespace Controller;

use Model\User;
use Src\Request;

class UserController
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        // валидация и сохранение
    }

    public function editUser(Request $request)
    {
        $id = $request->get('id');
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $id = $request->get('id');
        $user = User::findOrFail($id);
        // обновление
    }

    public function destroy(Request $request)
    {
        $id = $request->get('id');
        $user = User::findOrFail($id);
        $user->delete();
        return redirect('/users');
    }
}