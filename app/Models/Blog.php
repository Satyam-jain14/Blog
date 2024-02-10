<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'title',
        'category',
        'image',
        'blog_content',
        'summary',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class)->orderBy('id','desc');
    }  
    // public function likes()
    // {
    //     return $this->hasOne(Like::class);
    // } 
    public function tlikes()
    {
        return $this->hasMany(Like::class);
    }                                
}
