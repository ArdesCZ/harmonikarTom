<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form; // používání nette formulářů
use Nette\Mail\Message; // odeslání mailu přes nette

/**
 * Presenter (Controller) šablony Kontakt/kontakt.latte, který vytvoří formulář pro odeslání vzkazů z webu,
 * následně data z formuláře zpracuje a odešle na mail
 */
final class KontaktPresenter extends Nette\Application\UI\Presenter
{
    /**
     * funkce na vkládání formuláře pro psaní vzkazu
     */
    protected function createComponentCommentForm(): Form // nutno vložit use Nette\Application\UI\Form;
    {
        $form = new Form; // means Nette\Application\UI\Form

        $form->addText('jmeno')
            ->addRule(Form::FILLED, 'Vyplňte jméno')
            ->setRequired();

        $form->addText('prijmeni')
            ->addRule(Form::FILLED, 'Vyplňte příjmení')
            ->setRequired();

        $form->addText('email', 'Váš e-mail')
            ->setEmptyValue('@')
            ->addRule(Form::FILLED, 'Vyplňte váš e-mail')
            ->addRule(Form::EMAIL, 'E-mail má nesprávný tvar')
            ->setRequired();

        $form->addTextarea('content')
            ->addRule(Form::FILLED, 'Vyplňte vzkaz')
            ->setRequired();

        $form->onSuccess[] = [$this, 'commentFormSucceeded'];

        $form->addSubmit('send', 'Odelsat');

        return $form;
    }


    /**
     * metoda, která po stisknutí tlačítka "Odeslat" zpracuje formulář a vytvoří mail. který se odešle
     */
    public function commentFormSucceeded(Form $form, \stdClass $values): void
    {
        $postId = $this->getParameter('postId');

        $mail = new Message;

        $mail->setFrom($values->email)
        ->addTo('harmonikar.tom@gmail.com')
        ->setSubject('Odeslán vzkaz z harmonikare-tom');

        $template = $this->createTemplate();

        $template->setFile( '../app/Presenters/templates/Kontakt/mail.latte');

        $template->jmeno = $values->jmeno;
        $template->prijmeni = $values->prijmeni;
        $template->email = $values->email;
        $template->content = $values->content;

        $mail->setHtmlBody($template->renderToString());

        $mailer = new Nette\Mail\SmtpMailer([
            'host' => 'smtp.gmail.com',
            'username' => 'harmonikar.tom@gmail.com',
            'password' => 'udyujl00',
            'port' => '465',
            'secure' => 'ssl',
        ]);
        $mailer->send($mail);

        $this->flashMessage('Email byl odeslán', 'success');
        $this->redirect('Kontakt:potvrzeniMailu');
    }


}