<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function register(Request $request) {
        return view('exercises3.Users.register');
    }

    public function doRegister(Request $request) {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed'
        ]);

        User::create([
        'name' => $validatedData['name'],
        'email' => $validatedData['email'],
        'password' => bcrypt($validatedData['password'])
    ]);

    if($request->password!=$request->confirm_password)
        return redirect()->route('register', ['error'=>'Confirm password not matched.']);
    if(!$request->email || !$request->name || !$request->password)
        return redirect()->route('register', ['error'=>'Missing registration info.']);
    if(User::where('email', $request->email)->first()) //Secure
        return redirect()->route('register', ['error'=>'Missing registration info.']);

        return redirect()->route('exercises3.Users.login')->with('success', 'User created successfully.');
    }
    public function login(Request $request) {
        return view('exercises3.Users.login');
    }
    public function doLogin(Request $request) {
        if(!Auth::attempt(['email'=> $request->email, 'password'=> $request->password]));
        return redirect()->back()->withInput($request->input())->withErrors( 'Invalid login information.');
        $user = User::where('email', $request->email)->first();
        Auth::setUser($user);

        return redirect()->route('/')->with('success', 'User login successfully.');


    }
    public function doLogout(Request $request) {
        Auth::logout();
        return redirect('/');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

    {
        $users = User::query()
        ->when($request->name, function($query, $name) {
            return $query->where('name', 'like', "%{$name}%");
        })
        ->when($request->email, function($query, $email) {
            return $query->where('email', 'like', "%{$email}%");
        })
        ->orderBy('name')
        ->paginate(10);
}
        return view('exercises3.users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
            return view('exercises3.Users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed'
        ]);

        $user = User::create([
        'name' => $validatedData['name'],
        'email' => $validatedData['email'],
        'password' => bcrypt($validatedData['password'])
    ]);


        return redirect()->route('exercises3.Users.index')->with('success', 'User created successfully.');
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {
        $user = User::findOrFail($id);
        $user->load('grades');
        return view('exercises3.Users.show', compact('user'));
    }

    public function profile(string $id) {
        $user = User::findOrFail($id);
        $user->load('grades');
        return view('exercises3.Users.profile', compact('user'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('exercises3.Users.edit', compact('user'));
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'nullable|min:8|confirmed'
        ]);

        $updateData = [
            'name' => $validatedData['name'],
            'email' => $validatedData['email']
        ];

        // Only update password if provided
        if (!empty($validatedData['password'])) {
            $updateData['password'] = bcrypt($validatedData['password']);
        }

        $user->update($updateData);

        return redirect()->route('exercises3.Users.index')
                       ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('exercises3.Users.index')
                         ->with('success', 'User deleted successfully.');
    }
}
