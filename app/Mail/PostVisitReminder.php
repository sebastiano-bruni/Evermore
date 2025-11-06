<?php

namespace App\Mail;

use App\Models\CommemorativeProfile;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PostVisitReminder extends Mailable
{
    use Queueable, SerializesModels;

    public User $visitor;
    public CommemorativeProfile $profile;

    /**
     * Crea una nuova istanza del messaggio.
     */
    public function __construct(User $visitor, CommemorativeProfile $profile)
    {
        $this->visitor = $visitor;
        $this->profile = $profile;
    }

    /**
     * Definisce l'oggetto dell'email.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Un ricordo della tua visita a ' . $this->profile->first_name,
        );
    }

    /**
     * Definisce il contenuto dell'email.
     */
    public function content(): Content
    {
        // Laravel cercherà questo file: resources/views/emails/post_visit.blade.php
        return new Content(
            view: 'emails.post_visit',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
