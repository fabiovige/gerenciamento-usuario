<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index()
    {
        $users = User::query()
            ->latest()
            ->paginate(5)
            ->withQueryString()
            ->through(fn ($user) => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ]);

        return Inertia::render('Users/Index', [
            'users' => $users
        ]);
    }

    public function create()
    {
        return Inertia::render('Users/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users.index')
            ->with('flash', [
                'type' => 'success',
                'message' => 'User created successfully!'
            ]);
    }

    public function edit(User $user)
    {
        return Inertia::render('Users/Edit', [
            'user' => $user
        ]);
    }

    public function update(Request $request, User $user)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ];

        // Adiciona regras de validação de senha apenas se uma nova senha foi fornecida
        if ($request->filled('password')) {
            $rules['password'] = ['required', 'confirmed', Rules\Password::defaults()];
        }

        $request->validate($rules);

        $user->fill([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('users.index')
            ->with('flash', [
                'type' => 'success',
                'message' => 'User updated successfully!'
            ]);
    }

    public function destroy(User $user)
    {
        // Impede que o usuário exclua a si mesmo
        if ($user->id === auth()->id()) {
            return back()->with('flash', [
                'type' => 'error',
                'message' => 'You cannot delete your own account.'
            ]);
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('flash', [
                'type' => 'success',
                'message' => 'User deleted successfully!'
            ]);
    }
}
