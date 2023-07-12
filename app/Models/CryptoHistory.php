<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Crypto;
use App\Models\Blog;

class CryptoHistory extends Model
{
    protected $table = 'crypto_histories';

    protected $fillable = [
        'crypto_id',
        'interval',
        'current_price',
        'date'
    ];

    public function crypto()
    {
        return $this->belongsTo(Crypto::class);
    }

    public function blogs()
    {
        return $this->belongsToMany(Blog::class, 'blog_crypto_histories');
    }
}
