<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Crypto;
use App\Models\CryptoHistory;
use App\Models\User;
use App\Models\BlogAnswer;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'body',
        'date',
        'crypto_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function crypto()
    {
        return $this->belongsTo(Crypto::class);
    }

    public function cryptoHistories()
    {
        return $this->belongsToMany(CryptoHistory::class, 'blog_crypto_histories');
    }

    public function blogAnswers()
    {
        return $this->hasMany(BlogAnswer::class);
    }
}
