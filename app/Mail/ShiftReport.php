<?php

namespace App\Mail;

use App\Models\Shift;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

class ShiftReport extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param  list<array{dates: list<string>, user: string}>  $rows
     */
    public function __construct(
        public Shift $shift,
        public Carbon $month,
        public array $rows,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: sprintf(
                'Schichtbericht %s – %s',
                $this->shift->name,
                $this->month->locale('de')->translatedFormat('F Y'),
            ),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.shift.report',
            with: [
                'shift' => $this->shift,
                'month' => $this->month,
                'monthLabel' => $this->month->locale('de')->translatedFormat('F Y'),
                'rows' => $this->rows,
            ],
        );
    }
}
