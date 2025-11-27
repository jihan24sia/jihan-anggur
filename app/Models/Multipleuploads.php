<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Multipleuploads extends Model
{
    use HasFactory;

    // Pastikan nama tabel sesuai di database
    protected $table = 'multipleuploads'; // sebelumnya 'multiuploads', cek nama tabel

    protected $primaryKey = 'id';

    // Tambahkan ref_table dan ref_id ke fillable
    protected $fillable = [
        'filename',
        'ref_table',
        'ref_id',
        'created_at',
        'updated_at'
    ];

}
