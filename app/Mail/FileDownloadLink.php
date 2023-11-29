<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FileDownloadLink extends Mailable
{
    use Queueable, SerializesModels;
    
    public $downloadLink;
    
    public function __construct($downloadLink)
    {
        $this->downloadLink = $downloadLink;
    }

    /**
     * Get the message envelope.
     */
    public function build()
    {
        return $this->markdown('emails.file_download_link')
            ->subject('Your File Download Link');
    }
}
