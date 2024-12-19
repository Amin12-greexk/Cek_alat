<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Tool extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'image'];

    // Relationship with ToolPart
    public function parts()
    {
        return $this->hasMany(ToolPart::class);
    }

    // Relationship with Submission
    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    public function tags()
{
    return $this->belongsToMany(Tag::class, 'tag_tool', 'tool_id', 'tag_id');
}




}

