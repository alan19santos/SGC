<?php
namespace App\Mail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class EmployeeMail {


    private $mail;
    private $title;
    public function __construct($mail, $title) {

        $this->mail = $mail;
        $this->title = $title;
    }

    public function send($data) {
        // Log::info($data);
        $text = 'Nº do chamado: #'.$data['number'] . ', por favor entrar no sistema SGC';

        Mail::send('emails.email', ['meuMensagem' => $text, 'subtitle' => $this->title], function ($message) use ($data) {
            $message->to($this->mail);
            $message->subject('Existe um chamado aberto para você executar');
        });
    }
}
