<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolesAndPermission extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    // public function permissionAssigned()
    // {
    //     return $this->belongsTo(Permission::class, 'permission_id');
    // }
}
