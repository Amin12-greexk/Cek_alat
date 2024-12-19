<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToolPart extends Model
{
    protected $fillable = ['tool_id', 'part_name', 'description', 'validation', 'image'];

    // Explicit Route Key Binding
    public function getRouteKeyName()
    {
        return 'id'; // Ensure 'id' is used for route model binding
    }

    public function tool()
    {
        return $this->belongsTo(Tool::class);
    }
}

