<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MailSend extends Mailable
{
    public $yourname;
    use Queueable, SerializesModels;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name)
    {
      $this->yourname = $name;  
    } 

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
       return $this->from('pengirim@malasngoding.com')
                   ->view('emailku')
                   ->with(
                    [
                        'nama' => $this->yourname,
                        'website' => 'https://jmadventour.com',
                    ]);
    }

    public function kirim($name){
        return $this->from('pengirim@malasngoding.com')
                   ->view('emailku')
                   ->with(
                    [
                        'nama' => $name,
                        'website' => 'https://jmadventour.com',
                    ]);
    }
}