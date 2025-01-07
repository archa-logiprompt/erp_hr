<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
    public function latestInvoice()
    {
        return $this->hasOne(StudentInvoice::class, 'student_id', 'student_id')->latestOfMany();
    }
}
