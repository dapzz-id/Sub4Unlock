<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnlockLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'target_url',
        'short_code',
        'views',
        'unlocks',
        'status',
        'user_id',
        'social_requirements'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function incrementViews()
    {
        $this->increment('views');
    }

    public function incrementUnlocks()
    {
        $this->increment('unlocks');
    }

    public function adNetwork()
    {
        return $this->belongsTo(AdNetwork::class, 'ad_network_id');
    }
}