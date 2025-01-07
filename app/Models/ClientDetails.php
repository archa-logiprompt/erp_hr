<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientDetails extends Model
{
    use HasFactory;

    // Allow all attributes except 'id' to be mass assignable
    protected $guarded = ['id'];


    public function user()
    {
        return $this->belongsTo(User::class, 'userId', 'id'); // userId is the foreign key in ClientDetails
    }
    
    public function projects()
{
    return $this->hasMany(Project::class, 'client', 'id');
}

}
