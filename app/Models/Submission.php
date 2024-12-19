<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = [
        'tool_id',
        'part_id',
        'submission_date',
        'worker_response',
        'is_feasible',
        'expiration_date',
        'company_name',
    ];

    public function tool()
    {
        return $this->belongsTo(Tool::class);
    }

    public function part()
    {
        return $this->belongsTo(ToolPart::class, 'part_id');
    }
}


