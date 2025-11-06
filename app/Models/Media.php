<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'commemorative_profile_id',
        'type',
        'file_path',
        'title',
    ];

    /**
     * Ottiene il profilo commemorativo a cui appartiene il media.
     */
    public function commemorativeProfile(): BelongsTo
    {
        return $this->belongsTo(CommemorativeProfile::class);
    }
}
