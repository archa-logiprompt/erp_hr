<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoices extends Model
{
    use HasFactory;

    // Guarded fields: exclude these from mass assignment
    protected $guarded = ['id'];

    // Fillable fields: allow mass assignment for these attributes
    protected $fillable = ['invoiceNumber', 'invoiceid', 'studentinvoiceid'];

    /**
     * Relationship with ClientInvoice.
     * Each invoice belongs to a single client invoice.
     */
    public function clientInvoice()
    {
        return $this->belongsTo(ClientInvoice::class, 'invoiceid', 'id');
    }

    /**
     * Relationship with StudentInvoice (if applicable).
     * Assuming there is a separate `StudentInvoice` model.
     */
    public function studentInvoice()
    {
        return $this->belongsTo(StudentInvoice::class, 'studentinvoiceid', 'id');
    }

    
}
