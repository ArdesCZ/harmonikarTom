<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Nette\Database\Context; // načtení dat pro připojení k databázi

/**
 * Presenter (Controller) šablony Fotogalerie/fotogalerie.latte, který načte databázovou tabulku fotografie
 */
final class FotogaleriePresenter extends Nette\Application\UI\Presenter
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
     * metoda, která načte obsah databázové tabulky fotografie
     */
    public function renderFotogalerie(): void
    {
        $this->template->fotogalerie = $this->database->table('fotografie')
        ->order('idFotografie DESC');
    }
}
