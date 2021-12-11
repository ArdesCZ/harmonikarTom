<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Nette\Database\Context; // použití nette databáze

/**
 * Presenter (Controller) šablony Repertoar/repertoar.latte, který načte databázovou tabulku repertoar
 */
final class RepertoarPresenter extends Nette\Application\UI\Presenter
{
    private $database;

    /**
     * metoda, která se stará o načtení dat pro připojení do databáze ze souboru config/local.neon a připojí se k databázi
     */
    public function __construct(Context $database)
    {
        $this->database = $database;
    }

    /**
     * metoda, která načte obsah databázové tabulky repertoar
     */
    public function renderRepertoar(): void
    {

        $this->template->repertoar = $this->database->table('repertoar')
            ->order('nazev');
    }

}