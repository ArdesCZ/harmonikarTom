<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Nette\Database\Context; // použití nette databáze

/**
 * Presenter (Controller) šablony Vystoupeni/vystoupeni.latte, který načte databázovou tabulku vystoupeni
 */
final class VystoupeniPresenter extends Nette\Application\UI\Presenter
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
     * metoda, která načte obsah databázové tabulky vystoupeni
     */
    public function renderVystoupeni(): void
    {
        $rokL = date("Y"); // zjištění aktuálního roku
        $rokL1 = date("Y") + 1; // vrací aktuální rok + 1 rok
        $rokL2 = date("Y") + 2; // vrací aktuální rok + 2 roky
        $rokLm1 = date("Y") - 1; // vrací aktuální rok - 1 rok (vrací rok od aktuálního dozadu)

        // SQL složený dotaz pro zjištění počtu let v databázové tabulce vystoupení (když jsou v tabule vystoupení pro rok 2020 a 2021, tak výlsedek jsou 2)
        $dotazPocetLet = $this->database->query('SELECT COUNT(*) FROM (SELECT COUNT(rok) FROM vystoupeni GROUP BY rok) AS pocetLetVDatabazi');
        $rowPocetLet = $dotazPocetLet->fetch(); // z SQL objektu získat hodnotu
        $pocetLetVystoupeni = $rowPocetLet[0];
        $this->template->pocetLetVystoupeni = $pocetLetVystoupeni; // předání počtu let do šablony nepoužívá se

        $this->template->rokL = $rokL; // předání aktuálního roku do šablony jako proměnná rokL
        $this->template->rokL1 = $rokL1;
        $this->template->rokL2 = $rokL2;
        $this->template->rokLm1 = $rokLm1;

        // předání konzertů roků do šablony
        $this->template->vystoupeniL = $this->database->query('SELECT idVystoupeni, rok, CONCAT(DAY(datum),"."," ",MONTH(datum),".") AS datum, misto, cas 
                                                              FROM vystoupeni WHERE rok = ? ORDER BY vystoupeni.datum DESC', $rokL);
        $this->template->vystoupeniL1 = $this->database->query('SELECT idVystoupeni, rok, CONCAT(DAY(datum),"."," ",MONTH(datum),".") AS datum, misto, cas 
                                                              FROM vystoupeni WHERE rok = ? ORDER BY vystoupeni.datum DESC', $rokL1);
        $this->template->vystoupeniL2 = $this->database->query('SELECT idVystoupeni, rok, CONCAT(DAY(datum),"."," ",MONTH(datum),".") AS datum, misto, cas 
                                                              FROM vystoupeni WHERE rok = ? ORDER BY vystoupeni.datum DESC', $rokL2);
        $this->template->vystoupeniLm1 = $this->database->query('SELECT idVystoupeni, rok, CONCAT(DAY(datum),"."," ",MONTH(datum),".") AS datum, misto, cas 
                                                              FROM vystoupeni WHERE rok = ? ORDER BY vystoupeni.datum DESC', $rokLm1);

        // předání rezervací roků do šablony
        $this->template->rezervaceL = $this->database->query('SELECT idRezervace, rok, CONCAT(DAY(od),"."," ",MONTH(od),".") AS od, CONCAT(DAY(do),"."," ",MONTH(do),".") AS do 
                                                              FROM rezervace WHERE rok = ? ORDER BY rezervace.od DESC', $rokL);

        $this->template->rezervaceL1 = $this->database->query('SELECT idRezervace, rok, CONCAT(DAY(od),"."," ",MONTH(od),".") AS od, CONCAT(DAY(do),"."," ",MONTH(do),".") AS do 
                                                              FROM rezervace WHERE rok = ? ORDER BY rezervace.od DESC', $rokL1);

        $this->template->rezervaceL2 = $this->database->query('SELECT idRezervace, rok, CONCAT(DAY(od),"."," ",MONTH(od),".") AS od, CONCAT(DAY(do),"."," ",MONTH(do),".") AS do 
                                                              FROM rezervace WHERE rok = ? ORDER BY rezervace.od DESC', $rokL2);

        $this->template->rezervaceLm1 = $this->database->query('SELECT idRezervace, rok, CONCAT(DAY(od),"."," ",MONTH(od),".") AS od, CONCAT(DAY(do),"."," ",MONTH(do),".") AS do 
                                                              FROM rezervace WHERE rok = ? ORDER BY rezervace.od DESC', $rokLm1);



        // Pokud už je v databázi vystoupení na dva roky dopředu od nynějšího roku, pošli do šablony token true, že exsituje vystoupení a má se objevit tabulka
        // Pokud se toto nezpracuje, tak se v šabloně zobrazí jeno nadpis rok +2 od současného bez tabulky
        $dotazJeKonzertL2 = $this->database->query('SELECT COUNT(*) FROM vystoupeni WHERE rok = ?', $rokL2);
        $rowJeKonzertL2 = $dotazJeKonzertL2->fetch();
        $JeKonzertL2 = $rowJeKonzertL2[0];
        if ($JeKonzertL2 != 0) {
            $this->template->tokenV2 = true;
        } else {
            $this->template->tokenV2 = false;
        }

        $dotazJeKonzertL1 = $this->database->query('SELECT COUNT(*) FROM vystoupeni WHERE rok = ?', $rokL1);
        $rowJeKonzertL1 = $dotazJeKonzertL1->fetch();
        $JeKonzertL1 = $rowJeKonzertL1[0];
        if ($JeKonzertL1 != 0) {
            $this->template->tokenV1 = true;
        } else {
            $this->template->tokenV1 = false;
        }

        $dotazJeKonzertLm1 = $this->database->query('SELECT COUNT(*) FROM vystoupeni WHERE rok = ?', $rokLm1);
        $rowJeKonzertLm1 = $dotazJeKonzertLm1->fetch();
        $JeKonzertLm1 = $rowJeKonzertLm1[0];
        if ($JeKonzertLm1 != 0) {
            $this->template->tokenVm1 = true;
        } else {
            $this->template->tokenVm1 = false;
        }


        // Zjištění zda jsou data v tabulce rezervace
        $dotazJeRezervaceL2 = $this->database->query('SELECT COUNT(*) FROM rezervace WHERE rok = ?', $rokL2);
        $rowJeRezervaceL2= $dotazJeRezervaceL2->fetch();
        $JeRezervaceL2 = $rowJeRezervaceL2[0];
        if ($JeRezervaceL2 != 0) {
            $this->template->tokenR2 = true;
        } else {
            $this->template->tokenR2 = false;
        }

        $dotazJeRezervaceL1 = $this->database->query('SELECT COUNT(*) FROM rezervace WHERE rok = ?', $rokL1);
        $rowJeRezervaceL1= $dotazJeRezervaceL1->fetch();
        $JeRezervaceL1 = $rowJeRezervaceL1[0];
        if ($JeRezervaceL1 != 0) {
            $this->template->tokenR1 = true;
        } else {
            $this->template->tokenR1 = false;
        }

        $dotazJeRezervaceLm1 = $this->database->query('SELECT COUNT(*) FROM rezervace WHERE rok = ?', $rokLm1);
        $rowJeRezervaceLm1= $dotazJeRezervaceLm1->fetch();
        $JeRezervaceLm1 = $rowJeRezervaceLm1[0];
        if ($JeRezervaceLm1 != 0) {
            $this->template->tokenRm1 = true;
        } else {
            $this->template->tokenRm1 = false;
        }

    }

}