<?php
namespace App\Mail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ResidentMail {


    private $mail;
    private $title;
    public function __construct($mail, $title) {

        $this->mail = $mail;
        $this->title = $title;
    }

    public function send($data) {
        // Log::info($data);
        Mail::send('emails.email', ['meuMensagem' => 'senha: '.$data['password'], 'subtitle' => $this->title], function ($message) use ($data) {
            $message->to($data['email']);
            $message->subject('Criação de Usuário - SGC');
        });
    }
}
