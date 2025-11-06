<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CommemorativeProfile extends Model
{
    use HasFactory;

    /**
     * I campi che possono essere assegnati in massa.
     */
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'birth_date',
        'death_date',
        'biography',
        'passions',
        'status',
        'rasa_person_id',
        'death_certificate_path',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'death_date' => 'date',
    ];

    /**
     * Ottiene l'utente proprietario del profilo.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Ottiene i file media associati al profilo.
     */
    public function media(): HasMany
    {
        return $this->hasMany(Media::class);
    }

    /**
     * Ottiene i contatti fidati associati al profilo.
     */
    public function trustedContacts(): HasMany
    {
        return $this->hasMany(TrustedContact::class);
    }

    /**
     * Ottiene le visite associate a questo profilo.
     */
    public function visits(): HasMany
    {
        return $this->hasMany(Visit::class);
    }
}
