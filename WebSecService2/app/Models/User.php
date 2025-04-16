<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'credit',
        'last_login_at',
        'last_login_ip'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'credit' => 'decimal:2',
        'last_login_at' => 'datetime',
    ];

    // Relationships
    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class);
    }


    public function purchaseProduct(Product $product, int $quantity): void
    {
        $this->validatePurchase($product, $quantity);

        DB::transaction(function () use ($product, $quantity) {
            $this->processPurchaseTransaction($product, $quantity);
        });
    }


    protected function validatePurchase(Product $product, int $quantity): void
    {
        if (!$this->hasSufficientCredit($product->price * $quantity)) {
            throw new \Exception('Insufficient credit for this purchase');
        }

        if (!$product->hasSufficientStock($quantity)) {
            throw new \Exception('Insufficient product stock');
        }
    }


    protected function processPurchaseTransaction(Product $product, int $quantity): void
    {
        $totalCost = $product->price * $quantity;

        
        $this->decrement('credit', $totalCost);


        $product->decrement('stock', $quantity);


        $this->purchases()->create([
            'product_id' => $product->id,
            'purchase_price' => $product->price,
            'quantity' => $quantity,
            'total_price' => $totalCost
        ]);
    }

    // Credit Methods
    public function hasSufficientCredit(float $amount): bool
    {
        return $this->credit >= $amount;
    }


    public function addCredit(float $amount): void
    {
        if ($amount <= 0) {
            throw new \InvalidArgumentException('Credit amount must be positive');
        }
        $this->increment('credit', $amount);
    }


    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function isEmployee(): bool
    {
        return $this->hasRole('employee');
    }

    public function isCustomer(): bool
    {
        return $this->hasRole('customer');
    }

    public function getPrimaryRoleAttribute(): string
    {
        return $this->roles->first()->name ?? 'customer';
    }


    public function scopeAdmins($query)
    {
        return $query->role('admin');
    }

    public function scopeEmployees($query)
    {
        return $query->role('employee');
    }

    public function scopeCustomers($query)
    {
        return $query->role('customer');
    }


    public function setCreditAttribute($value)
    {
        $this->attributes['credit'] = max(0, $value);
    }
}
