<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('users.index', ['users' => User::withcount(['tasks', 'tickets'])->paginate()]);
    }

    public function create()
    {
        return $this->edit(new User());
    }

    public function edit(User $user)
    {
        return view('users.form', ['user' => $user]);
    }

    public function store(UserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = \Hash::make($data['password']);

        User::create($data);

        return redirect()->route('users.index');
    }

    public function update(UserRequest $request, User $user)
    {
        $data = $request->validated();

        if (!$data['password'])
            unset($data['password']);
        else
            $data['password'] = \Hash::make($data['password']);

        $user->update($data);

        return redirect()->route('users.index');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index');
    }
}
