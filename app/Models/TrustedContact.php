<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrustedContact extends Model
{
    use HasFactory;

    protected $fillable = [
        'commemorative_profile_id',
        'email',
        'trusted_user_id',
        'status',
    ];

    /**
     * Ottiene il profilo commemorativo a cui è legato l'invito.
     */
    public function commemorativeProfile(): BelongsTo
    {
        return $this->belongsTo(CommemorativeProfile::class);
    }
}
