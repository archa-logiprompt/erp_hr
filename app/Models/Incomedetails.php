<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incomedetails extends Model
{
    use HasFactory;

    protected $table = 'incomedetails';
    protected $fillable = ['center', 'head', 'date', 'name', 'amount', 'method'];
    protected $guarded = ['id'];


    public function incomeHead()
    {
        return $this->belongsTo(IncomeHead::class, 'head', 'id');
    }

  public function centers()
{
    return $this->belongsTo(Center::class, 'center', 'id'); // Correct the foreign key and local key relationship
}

    
}
