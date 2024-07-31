<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_id',
        'description',
        'status',
    ];

    public function report()
    {
        return $this->belongsTo(Report::class);
    }
}
