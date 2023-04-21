<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Customer;
use App\Models\Product;

class SignupEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    public $input;

    /**
     * Create a new message instance.
     */
    public function __construct()
    {
       
    }

   
    public function build()
    {
        $pdf = PDF::loadView('ajax.custom')->setOptions(['defaultFont' => 'sans-serif']);
        
        $password = 'mypassword';
        $pdf->setEncryption($password);
        
        return $this->from('shivamtomar5338@gmail.com', 'Shivam')
            ->subject('Welcome')
            ->view('ajax.custom')
            ->attachData($pdf->output(), 'invoice.pdf');
    }
    
}
