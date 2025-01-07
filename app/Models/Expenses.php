<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expenses extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function expenseHead()
    {
        return $this->belongsTo(ExpenseHead::class, 'head');
    }
    public function centers()
    {
        return $this->belongsTo(Center::class, 'center', ); // Correctly linking 'center' column with 'id' of the Center model
    }
}
