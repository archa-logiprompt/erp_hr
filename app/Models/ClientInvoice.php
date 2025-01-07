<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientInvoice extends Model
{
    use HasFactory;

    protected $table = 'client_invoice_details';
    protected $guarded = ['id'];

    protected $fillable = [
        'invoiceDate', 'clientName', 'project', 'transactionMethod','center','companyName',
        'transactionId', 'invoiceNumber', 'transactionTitle','amount','title','balance','prefix',
        'unitPrice', 'description', 'total', 'note', 'document','gsts','bankAccount','gstamount','subtotal'
    ];

    /**
     * Cast JSON fields to arrays.
     */
    protected $casts = [
        'transactionTitle' => 'array',
        'unitPrice' => 'array',
        'description' => 'array',
    ];

    /**
     * Relationship with ClientDetails.
     */
    public function client()
    {
        return $this->belongsTo(ClientDetails::class, 'clientName', 'id');
    }

    /**
     * Relationship with Project.
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'project', 'id');
    }

    public function invoices()
    {
        return $this->hasMany(Invoices::class, 'invoiceid', 'id');
    }
    public function centers()
    {
        return $this->belongsTo(Center::class, 'center', 'id'); // assuming center_id is the foreign key in StudentInvoice
    }
}
