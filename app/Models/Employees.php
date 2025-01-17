<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    use HasFactory;
    protected $gaurded=['id'];
    protected $fillable = [
        'user_id', 
        'empid',
        'country',
        'mobile',
        'gender',
        'ProfilePicture',
        'joining_date',
        'dob',
        'role',
        'dep_name',
        'designation_id',
        'loginYes',
        'recievemailyes',
        'hourlyrateyes',
        'acc_name',
        'account_no',
        'bank_name',
        'ifsc',
        'branch_name',
        'pg',
        'ug',
        'twelth',
        'tenth',
        'copy_adhaar',
        'employee_type',
        'adhaar',
        'status'




    ];
    public function user()
    {
    return $this->belongsTo(User::class, 'user_id', 'id');
    }  
    
    public function department()
    {
        return $this->belongsTo(Department::class, 'dep_name', 'id');
    } 
    public function designation()
{
    return $this->belongsTo(Designation::class, 'designation_id', 'id');
}
public function user_roles()
{
    return $this->hasMany(User_roles::class, 'user_id', 'role_id');
}


}