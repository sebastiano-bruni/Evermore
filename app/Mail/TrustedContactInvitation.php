<?php

namespace App\Mail;

use App\Models\TrustedContact;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TrustedContactInvitation extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * L'utente che sta invitando
     */
    public User $inviter;

    /**
     * Il record dell'invito
     */
    public TrustedContact $contact;

    /**
     * Crea una nuova istanza del messaggio.
     */
    public function __construct(User $inviter, TrustedContact $contact)
    {
        $this->inviter = $inviter;
        $this->contact = $contact;
    }

    /**
     * Definisce l'oggetto dell'email.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Invito a diventare un Contatto Fidato su Evermore',
        );
    }

    /**
     * Definisce il contenuto dell'email.
     */
    public function content(): Content
    {
        return new Content(
        // Laravel cercherà questo file: resources/views/emails/invitation.blade.php
            view: 'emails.invitation',
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
