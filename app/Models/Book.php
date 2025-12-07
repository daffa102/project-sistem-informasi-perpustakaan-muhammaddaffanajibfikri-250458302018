<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Book extends Model
{
    use HasFactory, SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'category_id',
        'title',
        'author',
        'publisher',
        'year',
        'stock',
        'qrcode',
        'description',
        'image',
        'is_available'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });

        static::saving(function ($model) {
            $model->is_available = $model->stock > 0;
        });

        // Hapus file saat Hard Delete (Force Delete)
        static::forceDeleted(function ($model) {
            if ($model->qrcode && \Illuminate\Support\Facades\Storage::disk('public')->exists($model->qrcode)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($model->qrcode);
            }
            
            if ($model->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($model->image)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($model->image);
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }
}
