<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // حماية الـ CRUD بحيث لا يمكن الوصول إلا للمستخدمين المسجلين
    public function __construct()
    {
        $this->middleware('auth');

        // السماح فقط للمسؤولين بإدارة المستخدمين
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->is_admin) {
                abort(403, 'Unauthorized action.');
            }
            return $next($request);
        });
    }

    // عرض قائمة المستخدمين
    public function index() {
        $users = User::orderBy('name')->paginate(10);
        return view('users.index', compact('users'));
    }

    // عرض نموذج إنشاء مستخدم جديد
    public function create() {
        return view('users.create');
    }

    // تخزين مستخدم جديد
    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $is_admin = $request->has('is_admin') && auth()->user()->is_admin;

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'is_admin' => $is_admin,
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully!');
    }


    // عرض نموذج تعديل المستخدم
    public function edit(User $user) {
        return view('users.edit', compact('user'));
    }

    // تحديث بيانات المستخدم
    public function update(Request $request, User $user) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // السماح فقط للمسؤولين بتحديث is_admin
        if (auth()->user()->is_admin) {
            $user->is_admin = $request->has('is_admin');
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }


    // حذف المستخدم
    public function destroy(User $user) {
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')->with('error', 'You cannot delete yourself!');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }
}
