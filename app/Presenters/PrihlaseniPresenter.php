<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form; // použití nette formulářů

final class PrihlaseniPresenter extends Nette\Application\UI\Presenter
{
    /**
     * metoda, která vytvoří formulář pro přihlášení do adminSekce webu
     */
    protected function createComponentSignInForm(): Form
    {
        $form = new Form;
        $form->addText('uzivatelskeJmeno', 'Uživatelské jméno:')
            ->setRequired();

        $form->addPassword('heslo', 'Heslo:')
        ->setRequired();

        $form->addSubmit('odeslat', 'Přihlásit');

        $form->onSuccess[] = [$this, 'signInFormSucceeded'];
        return $form;
    }

    /**
     * metoda která nastaví výchozí layout na AdminSekce/@layout.latte z důvodu,
     * že admin má přístup k jiným stránkám a menu tudíž musí mít zvláštní layout
     */
    public function formatLayoutTemplateFiles(): array
    {
        $layouts = parent::formatLayoutTemplateFiles();
        $layouts[] = __DIR__ . "/templates/AdminSekce/@layout.latte";
        return $layouts;
    }

    /**
     * metoda, která zpracuje formulář,
     * ověří zadané údaje, jelikož aplikace má jen jednoho uživatele je načtení údajů pro porovnání ze souboru config/common.neon sekce security
     * pokud jsou údaje správné, přesměruje na AdminSekce:default (home stránka admina)
     */
    public function signInFormSucceeded(Form $form, \stdClass $values): void
    {
        try {
            $this->getUser()->login($values->uzivatelskeJmeno, sha1($values->heslo));
            $this->redirect('AdminSekce:default');

        } catch (Nette\Security\AuthenticationException $e) {
            $form->addError('Nesprávné přihlašovací jméno nebo heslo.');
            $this->flashMessage('Nesprávné přihlašovací jméno nebo heslo.');
        }
    }
}