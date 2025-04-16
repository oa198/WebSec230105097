<?php
namespace App\Http\Controllers\Web;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Validation\Rules\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use Artisan;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller {

    use ValidatesRequests;

    public function list(Request $request) {
        if(!auth()->user()->hasPermissionTo('show_users')) abort(401);
        $query = User::select('*');
        $query->when($request->keywords,
            fn($q) => $q->where("name", "like", "%$request->keywords%"));
        $query->when($request->role,
            fn($q) => $q->whereHas('roles', fn($r) => $r->where('name', $request->role)));
        $users = $query->with(['purchases.product', 'purchases.statusMessages'])->get();
        return view('users.list', compact('users'));
    }

    public function register(Request $request) {
        return view('users.register');
    }

    public function doRegister(Request $request) {
        try {
            $this->validate($request, [
                'name' => ['required', 'string', 'min:5'],
                'email' => ['required', 'email', 'unique:users'],
                'password' => ['required', 'confirmed', Password::min(8)->numbers()->letters()->mixedCase()->symbols()],
            ]);
        } catch(\Exception $e) {
            return redirect()->back()->withInput()->withErrors('Invalid registration information.');
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->credit = 0.00;
        $user->save();

        $customerRole = Role::firstOrCreate(['name' => 'Customer'], ['guard_name' => 'web']);
        $user->assignRole($customerRole);

        return redirect('/');
    }

    public function login(Request $request) {
        return view('users.login');
    }

    public function doLogin(Request $request) {
        if(!Auth::attempt(['email' => $request->email, 'password' => $request->password]))
            return redirect()->back()->withInput()->withErrors('Invalid login information.');

        $user = User::where('email', $request->email)->first();
        Auth::setUser($user);

        return redirect('/');
    }

    public function doLogout(Request $request) {
        Auth::logout();
        return redirect('/');
    }

    public function addCreditForm(User $user) {
        return view('users.add_credit', compact('user'));
    }

    public function create() {
        return view('users.create');
    }

    public function store(Request $request) {
        if(!auth()->user()->hasPermissionTo('create_employees')) abort(401);

        $validated = $request->validate([
            'name' => ['required', 'string', 'min:5'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'confirmed', Password::min(8)->numbers()->letters()->mixedCase()->symbols()],
        ]);

        $employee = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'credit' => 0.00,
        ]);

        $employee->assignRole('Employee');

        return redirect()->route('users')->with('success', 'Employee created successfully!');
    }

    public function profile(Request $request, User $user = null) {
        $user = $user ?? auth()->user();
        $user = User::with(['purchases.product', 'purchases.statusMessages'])->find($user->id);
        if(auth()->id() != $user->id) {
            if(!auth()->user()->hasPermissionTo('show_users')) abort(401);
        }

        $permissions = [];
        foreach($user->permissions as $permission) {
            $permissions[] = $permission;
        }
        foreach($user->roles as $role) {
            foreach($role->permissions as $permission) {
                $permissions[] = $permission;
            }
        }

        return view('users.profile', compact('user', 'permissions'));
    }

    public function edit(Request $request, User $user = null) {
        $user = $user ?? auth()->user();
        if(auth()->id() != $user?->id) {
            if(!auth()->user()->hasPermissionTo('edit_users')) abort(401);
        }

        $roles = Role::all()->map(function($role) use ($user) {
            $role->taken = $user->hasRole($role->name);
            return $role;
        });

        $directPermissionsIds = $user->permissions()->pluck('id')->toArray();
        $permissions = Permission::all()->map(function($permission) use ($directPermissionsIds) {
            $permission->taken = in_array($permission->id, $directPermissionsIds);
            return $permission;
        });

        return view('users.edit', compact('user', 'roles', 'permissions'));
    }

    public function save(Request $request, User $user) {
        if(auth()->id() != $user->id) {
            if(!auth()->user()->hasPermissionTo('show_users')) abort(401);
        }

        $user->name = $request->name;
        $user->save();

        if(auth()->user()->hasPermissionTo('admin_users')) {
            $user->syncRoles($request->roles);
            $user->syncPermissions($request->permissions);
            Artisan::call('cache:clear');
        }

        return redirect(route('profile', ['user' => $user->id]));
    }

    public function delete(Request $request, User $user) {
        if(!auth()->user()->hasPermissionTo('delete_users')) abort(401);
        $user->delete();
        return redirect()->route('users');
    }

    public function editPassword(Request $request, User $user = null) {
        $user = $user ?? auth()->user();
        if(auth()->id() != $user?->id) {
            if(!auth()->user()->hasPermissionTo('edit_users')) abort(401);
        }

        return view('users.edit_password', compact('user'));
    }

    public function savePassword(Request $request, User $user) {
        if(auth()->id() == $user?->id) {
            $this->validate($request, [
                'password' => ['required', 'confirmed', Password::min(8)->numbers()->letters()->mixedCase()->symbols()],
            ]);

            if(!Auth::attempt(['email' => $user->email, 'password' => $request->old_password])) {
                Auth::logout();
                return redirect('/');
            }
        } else if(!auth()->user()->hasPermissionTo('edit_users')) {
            abort(401);
        }

        $user->password = bcrypt($request->password);
        $user->save();

        return redirect(route('profile', ['user' => $user->id]));
    }

    public function addCredit(Request $request, $id) {
        $user = User::findOrFail($id);
        $amount = $request->input('amount');

        if (is_numeric($amount) && $amount > 0) {
            $user->credit += $amount;
            $user->save();
            return redirect()->back()->with('success', 'Credit added successfully!');
        }

        return redirect()->back()->with('error', 'Invalid amount.');
    }

    public function buyProduct($productId)
    {
        $user = auth()->user();
        $product = Product::find($productId);

        if ($user->credit >= $product->price) {
            $user->credit -= $product->price;
            $user->save();

            $product->stock -= 1;
            $product->save();

            Purchase::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'purchase_price' => $product->price,
                'quantity' => 1,
                'status' => 'Pending',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return redirect()->route('products.list')->with('success', 'Purchase successful!');
        } else {
            return redirect()->route('products.list')->with('error', 'Insufficient credit!');
        }
    }
}
