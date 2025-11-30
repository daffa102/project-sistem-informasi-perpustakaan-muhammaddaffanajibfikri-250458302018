<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Member extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'nim', 'name', 'slug', 'phone', 'address'];



    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function wishlists()
{
    return $this->hasMany(Wishlist::class);
}

public function hasInWishlist($bookId)
{
    return $this->wishlists()->where('book_id', $bookId)->exists();
}
}
