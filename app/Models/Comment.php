<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable=[
        'blog_id',
        'user_id',
        'comment'
    ];
    
    public function cuser()
    {
        return $this->belongsTo(User::class,"user_id");
    }
    // public function user()
    // {
    //     return $this->belongsToMany(User::class);
    // }
}
