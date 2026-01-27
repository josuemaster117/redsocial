<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'content',
        'image',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function likes()
    {
    return $this->hasMany(Like::class);
    }

    public function likedByAuthUser(): bool
    {
        return $this->likes()->where('user_id', Auth::id())->exists();
    }
}
