<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class UserController extends Controller
{

    use HasRoles;

    public function index(Request $request)
    {
        // Handle search filters and pagination
        $users = User::query()
            ->when($request->name, function($query, $name) {
                return $query->where('name', 'like', "%{$name}%");
            })
            ->when($request->email, function($query, $email) {
                return $query->where('email', 'like', "%{$email}%");
            })
            ->orderBy('name')
            ->paginate(10);

        return view('exercises3.users.index', compact('users'));
    }

    public function create()
    {
        return view('exercises3.Users.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed', // Confirmed handles password confirmation
        ]);

        try {
            User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
            ]);

            return redirect()->route('exercises3.Users.index')->with('success', 'User created successfully.');
        } catch (\Exception $e) {
            return redirect()->route('exercises3.Users.index')->with('error', 'Error creating user.');
        }
    }

    public function show(string $id)
    {
        $user = User::findOrFail($id);
        $user->load('grades');
        return view('exercises3.Users.show', compact('user'));
    }

    public function profile(string $id)
    {
        $user = User::findOrFail($id);
        $user->load('grades');
        return view('exercises3.Users.profile', compact('user'));
    }



    public function edit(string $id)
{
    $user = User::findOrFail($id);
    // Load available roles and permissions
    $roles = Role::all();
    $permissions = Permission::all();

    // Pass the roles and permissions to the view
    return view('exercises3.Users.edit', compact('user', 'roles', 'permissions'));
}



public function update(Request $request, string $id)
{
    $user = User::findOrFail($id);

    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $id,
        'password' => 'nullable|min:8|confirmed',
        'roles' => 'nullable|array',
        'permissions' => 'nullable|array',
    ]);

    $updateData = [
        'name' => $validatedData['name'],
        'email' => $validatedData['email'],
    ];

    if (!empty($validatedData['password'])) {
        $updateData['password'] = bcrypt($validatedData['password']);
    }

    try {
        $user->update($updateData);


        if ($request->has('roles')) {
            $roleNames = Role::whereIn('id', $request->input('roles'))->pluck('name')->toArray();
            $user->syncRoles($roleNames);
        }

        if ($request->has('permissions')) {
            $permissionNames = Permission::whereIn('id', $request->input('permissions'))->pluck('name')->toArray();
            $user->syncPermissions($permissionNames);
        }

        return redirect()->route('exercises3.Users.index')->with('success', 'User updated successfully.');
    } catch (\Exception $e) {
        return redirect()->route('exercises3.Users.index')->with('error', 'Error updating user.');
    }
}



    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        try {
            $user->delete();
            return redirect()->route('exercises3.Users.index')->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('exercises3.Users.index')->with('error', 'Error deleting user.');
        }
    }
}
