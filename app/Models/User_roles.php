<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_roles extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $fillable = [
        'user_id', 
        'role_id',
       




    ];
    public function role()
{
    return $this->belongsTo(Role::class, 'role_id', 'id');
}

}
