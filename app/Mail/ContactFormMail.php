<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable {

    use Queueable,
        SerializesModels;
    
    protected $contactName;
    protected $contactEmail;
    protected $message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($contactName, $contactEmail, $message) {
        $this->contactName = $contactName;
        $this->contactEmail = $contactEmail;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        //Sometimes Google shows an error with $this->contactEmail in from field  
        $this->from("testirajsajt@gmail.com", $this->contactName) 
                ->replyTo($this->contactEmail)
                ->subject("New message from contact form on website Blog");

        return $this->view('front.emails.contact_form', [
                    "contactName" => $this->contactName,
                    "contactEmail" => $this->contactEmail,
                    "contactMessage" => $this->message,
        ]);
    }

}
