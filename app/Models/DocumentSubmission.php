<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentSubmission extends Model
{
    protected $fillable = [
        'master_document_id',
        'user_id',
        'tanggal_upload',
        'tanggal_pengesahan',
        'status',
        'deskripsi',
    ];

    public function masterDocument()
    {
        return $this->belongsTo(MasterDokumen::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
