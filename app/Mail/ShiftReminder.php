<?php

namespace App\Mail;

use App\Models\Shift;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

class ShiftReminder extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public Shift $shift,
        public Carbon $date,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: sprintf(
                'Erinnerung: Schicht %s am %s',
                $this->shift->name,
                $this->date->format('d.m.Y'),
            ),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.shift.reminder',
            with: [
                'user' => $this->user,
                'shift' => $this->shift,
                'dateLabel' => $this->date->format('d.m.Y'),
                'start' => substr((string) $this->shift->hour_start, 0, 5),
                'end' => substr((string) $this->shift->hour_end, 0, 5),
                'settingsUrl' => rtrim((string) config('app.url'), '/').'/settings',
            ],
        );
    }
}
