<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $appends = ['balancefee'];


    public function invoices()
    {
        return $this->hasMany(Studentinvoice::class, 'student_id');
    }
    public function studentInstallment()
    {
        return $this->hasMany(StudentInstallment::class, 'student_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
