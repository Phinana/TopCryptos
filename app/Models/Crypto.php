<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CryptoHistory;
use App\Models\Blog;

class Crypto extends Model
{
    use HasFactory;

    protected $fillable = [
        'identifier',
        'name',
        'symbol',
        'rank',
        'date_added'
    ];

    public function cryptoHistories()
    {
        return $this->hasMany(CryptoHistory::class);
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }
}
