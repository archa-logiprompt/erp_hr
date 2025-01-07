<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Center extends Model
{
    use HasFactory;
    protected $table = 'center';
    protected $guarded = ['id'];
    protected $fillable = ['name', 'address', 'mobile', 'email', 'image'];

    public function expenses()
    {
        return $this->hasMany(Expenses::class, 'center');
    }
}
