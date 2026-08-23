<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BackupLog extends Model
{
    protected $fillable = ['nama_file', 'jenis', 'user_id', 'status', 'keterangan'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
