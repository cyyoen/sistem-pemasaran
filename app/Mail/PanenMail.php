<?php

namespace App\Mail;

use App\Models\JadwalPanen;
use App\Models\Pengguna;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class PanenMail extends Mailable
{
    public function __construct(
        public Pengguna $pengguna,
        public JadwalPanen $jadwal,
        public int $hari = 3,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Pengingat: Panen Melon Pandawa Farm Segera Tiba');
    }

    public function content(): Content
    {
        return new Content(view: 'emails.panen');
    }
}