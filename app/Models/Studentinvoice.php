<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Studentinvoice extends Model
{

    use HasFactory;

    // Guarded fields: exclude these from mass assignment
    protected $guarded = ['id'];
protected $casts = [
    'invoicedate' => 'date',
];
protected $fillable = ['prefix', 'center', 'description', 'unitprice', 'amount', 'gst', 'total_amount', 'student_id', 'transactionmethod', 'transactionid', 'invoiceno', 'notes', 'balanceamount', 'generatedby', 'bankaccount', 'invoicedate', 'fees_id', 'splitup', 'gstAmt'];


    /**
     * Relationship with Student.
     * Each student invoice belongs to a single student.
     */
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }
    public function centers()
{
    return $this->belongsTo(Center::class, 'center', 'id'); // assuming center_id is the foreign key in StudentInvoice
}

}
