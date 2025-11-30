<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class Borrowing extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'member_id', 'book_id', 'borrow_date', 'return_date', 'status', 'due_date'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function calculateFineAmount()
    {
        if (!$this->due_date) return 0;

        $dueDate = \Carbon\Carbon::parse($this->due_date);


        $compareDate = $this->return_date
            ? \Carbon\Carbon::parse($this->return_date)
            : \Carbon\Carbon::today();

        if ($compareDate->lessThanOrEqualTo($dueDate)) {
            return 0;
        }

        return $compareDate->diffInDays($dueDate) * 1000; 
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function fine()
    {
        return $this->hasOne(Fine::class);
    }
}


