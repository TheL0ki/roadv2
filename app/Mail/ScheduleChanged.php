<?php

namespace App\Mail;

use DateTime;
use App\Models\User;
use App\Models\Schedule;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class ScheduleChanged extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public User $user,
        public DateTime $date
        )
    {

    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Schedule Changed',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $schedule = Schedule::with('shift')->where('user_id', $this->user->id)->where('year', $this->date->format('Y'))->where('month', $this->date->format('m'))->get();

        $formattedSchedule = [];
        $i = 1;

        foreach ($schedule as $item) {
            if(isset($formattedSchedule[$item->day])) {
                $formattedSchedule[$i] = [
                    'display' => $item->shift->display,
                ];
                $i++;
            } else {
                $formattedSchedule[$i]['display'] = null;
                $i++;
            }
        }

        return new Content(
            view: 'mail.schedule.changed',
            with: [
                'user' => $this->user,
                'date' => $this->date,
                'schedule' => $formattedSchedule,
            ]
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
