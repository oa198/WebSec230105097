<?php
namespace App\Http\Controllers\Web;

use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\User;

class ProductsController extends Controller
{
    use ValidatesRequests;

    public function __construct()
    {
        $this->middleware('auth:web')->except('list');
    }

    public function list(Request $request)
    {
        $query = Product::query();

        $query->when($request->keywords,
            fn($q) => $q->where("name", "like", "%$request->keywords%"));

        $query->when($request->min_price,
            fn($q) => $q->where("price", ">=", $request->min_price));

        $query->when($request->max_price,
            fn($q) => $q->where("price", "<=", $request->max_price));

        $query->when($request->order_by,
            fn($q) => $q->orderBy($request->order_by, $request->order_direction ?? "ASC"));

        $products = $query->get();

        return view('products.list', compact('products'));
    }

    public function edit(Request $request, Product $product = null)
    {
        $product = $product ?? new Product();
        return view('products.edit', compact('product'));
    }

    public function save(Request $request, Product $product = null)
    {
        $this->validate($request, [
            'code' => ['required', 'string', 'max:32'],
            'name' => ['required', 'string', 'max:128'],
            'model' => ['required', 'string', 'max:256'],
            'description' => ['required', 'string', 'max:1024'],
            'price' => ['required', 'numeric'],
        ]);

        $product = $product ?? new Product();
        $product->fill($request->all());
        $product->save();

        return redirect()->route('products.list');
    }

    public function delete(Request $request, Product $product)
    {
        if(!auth()->user()->hasPermissionTo('delete_products')) {
            abort(403);
        }

        $product->delete();
        return redirect()->route('products.list');
    }

    public function buy(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => ['sometimes', 'integer', 'min:1', 'max:'.$product->stock]
        ]);

        $user = auth()->user();
        $quantity = $request->quantity ?? 1;
        $totalPrice = $product->price * $quantity;

        if (!$user->hasRole('Customer')) {
            return back()->with('error', 'Only customers can make purchases');
        }

        if ($user->credit < $totalPrice) {
            return back()->with('error', 'Insufficient credit for this purchase');
        }

        if ($product->stock < $quantity) {
            return back()->with('error', 'Not enough stock available');
        }

        DB::beginTransaction();
        try {
            $user->credit -= $totalPrice;
            $user->save();

            $product->stock -= $quantity;
            $product->save();

            Purchase::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'purchase_price' => $product->price,
                'quantity' => $quantity,
                'status' => 'Pending',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::commit();

            return redirect()
                ->route('products.list')
                ->with('success', 'Purchase completed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Purchase failed: '.$e->getMessage());
        }
    }
}
