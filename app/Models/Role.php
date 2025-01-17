<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
  
    public function user_roles()
    {
    return $this->belongsTo(User_roles::class, 'user_id', 'id');
    }  
}
