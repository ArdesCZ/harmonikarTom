<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form; // použití nette formulářů
use Nette\Database\Context; // použití nette databáze
use Nette\Utils\DateTime; // použití pro úpravu datumu


final class AdminSekcePresenter extends Nette\Application\UI\Presenter
{
    // Ověření začátek

    public function actionAdminHome(): void
    {
        if (!$this->getUser()->isLoggedIn()) {
            $this->redirect('Prihlaseni:prihlaseni');
        }
    }

    public function actionSpravaVystoupeni(): void
    {
        if (!$this->getUser()->isLoggedIn()) {
            $this->redirect('Prihlaseni:prihlaseni');
        }
    }

    public function actionSpravaRepertoaru(): void
    {
        if (!$this->getUser()->isLoggedIn()) {
            $this->redirect('Prihlaseni:prihlaseni');
        }
    }

    public function actionSpravaFotogalerie(): void
    {
        if (!$this->getUser()->isLoggedIn()) {
            $this->redirect('Prihlaseni:prihlaseni');
        }
    }

    public function actionOut(): void
    {
        $this->getUser()->logout();
        $this->flashMessage('Odhlášení bylo úspěšné.');
        $this->redirect('Homepage:default');

    }

    // Ověření konec


    private $database;

    /**
     * metoda, která se stará o načtení dat pro připojení do databáze ze souboru config/local.neon a připojí se k databázi
     */
    public function __construct(Context $database)
    {
        $this->database = $database;
    }



    // Správa vystoupení začátek

    /**
     * metoda, která načte obsah databázové tabulky vystoupeni a rezervace
     */
    public function renderSpravaVystoupeni(): void
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


    /**
     * metoda, která vytvoří formulář pro vložení nového vystoupení
     */
    protected function createComponentFormVlozVystoupeni(): Form
    {
        $form = new Form;

        $form->addText('rok')->setRequired();
        $form->addText('datum');
        $form->addText('misto')->setRequired();
        $form->addText('cas');

        $form->addSubmit('odelat');
        $form->onSuccess[] = [$this, 'formVlozVystoupeniSucceeded'];

        return $form;
    }


    /**
     * metoda, která zpracuje formulář,
     * ze získaných údajů z formuláře vloží řádek do tabulky databáze
     */
    public function formVlozVystoupeniSucceeded(Form $form, \stdClass $values): void
    {
        // z formuláře se odstraní mezery (kdyby zadal 6. 6. ale je třeba 6.6.)
        $datumVystoupeniBezMezer = str_replace(' ', '', $values->datum);

        /*  metoda DateTime::createFromFormat slouží k úpravě formátu zadaného datumu, z formuláře máme zadaný den a měsíc ve formátu d.m. nakonec přidáme rok
            a metoda format to převede do formátu (y-m-d) jak je nastaveno v databazi
        */
        if ($values->datum != null){
            // ke dni a mesici se přidá rok
            $datumVystoupeniBezMezerKomp = $datumVystoupeniBezMezer .  $values->rok;
            $datumVystoupeni = DateTime::createFromFormat('d.m.Y', $datumVystoupeniBezMezerKomp);
            $datumVystoupeniFormat = $datumVystoupeni->format('Y-m-d');
        }else{
            $datumVystoupeniFormat = null;
        }

        $this->database->query('INSERT INTO vystoupeni', [
            'rok' => $values->rok,
            'datum' => $datumVystoupeniFormat,
            'misto' => $values->misto,
            'cas' => $values->cas,
        ]);

        $this->flashMessage('Vložení vystoupení bylo úspěšné.');
        $this->redirect('AdminSekce:spravaVystoupeni');
    }


    /**
     * metoda, která vytvoří formulář pro úpravu zvoleného vystoupení
     */
    protected function createComponentFormUpravVystoupeni(): Form
    {
        $form = new Form;

        $form->addText('idVystoupeniU');
        $form->addText('rokU')->setRequired();
        $form->addText('datumU');
        $form->addText('mistoU')->setRequired();
        $form->addText('casU');

        $form->addSubmit('odeslatU');
        $form->onSuccess[] = [$this, 'formUpravVystoupeniSucceeded'];

        return $form;
    }


    /**
     * metoda, která zpracuje formulář,
     * ze získaných údajů z formuláře upraví konkrétní řádek tabulky databáze na základě jeho id
     */
    public function formUpravVystoupeniSucceeded(Form $form, \stdClass $values): void
    {
        // z formuláře se odstraní mezery (kdyby zadal 6. 6. ale je třeba 6.6.)
        $datumVystoupeniBezMezerUprav = str_replace(' ', '', $values->datumU);
        /*  metoda DateTime::createFromFormat slouží k úpravě formátu zadaného datumu, z formuláře máme zadaný den a měsíc ve formátu d.m. nakonec přidáme rok
            a metoda format to převede do formátu (y-m-d) jak je nastaveno v databazi
        */
        if ($values->datumU != null){
            // ke dni a mesici se přidá rok
            $datumVystoupeniBezMezerUpravKomp = $datumVystoupeniBezMezerUprav .  $values->rokU;
            $datumVystoupeniUprav = DateTime::createFromFormat('d.m.Y', $datumVystoupeniBezMezerUpravKomp);
            $datumVystoupeniUpravFormat = $datumVystoupeniUprav->format('Y-m-d');
        }else{
            $datumVystoupeniUpravFormat = null;
        }

        $this->database->query('UPDATE vystoupeni SET', [
            'rok' => $values->rokU,
            'datum' => $datumVystoupeniUpravFormat,
            'misto' => $values->mistoU,
            'cas' => $values->casU,
        ], 'WHERE idVystoupeni = ?', $values->idVystoupeniU);

        $this->flashMessage('Úprava vystoupení byla úspěšná.');
        $this->redirect('AdminSekce:spravaVystoupeni');
    }


    /**
     * metoda, která vytvoří formulář pro smazání zvoleného vystoupení
     */
    protected function createComponentFormVymazVystoupeni(): Form
    {
        $form = new Form;

        $form->addText('idVystoupeniV');
        $form->addSubmit('odeslatV');
        $form->onSuccess[] = [$this, 'formVymazVystoupeniSucceeded'];

        return $form;
    }


    /**
     * metoda, která zpracuje formulář,
     * ze získaných údajů z formuláře smaže konkrétní řádek tabulky databáze na základě jeho id
     */
    public function formVymazVystoupeniSucceeded(Form $form, \stdClass $values): void
    {
        $this->database->query('DELETE FROM vystoupeni WHERE idVystoupeni = ?', $values->idVystoupeniV);

        $this->flashMessage('Vystoupení bylo smazané.');
        $this->redirect('AdminSekce:spravaVystoupeni');
    }

    /**
     * metoda, která vytvoří formulář pro vložení nové rezervace
     */
    protected function createComponentFormVlozRezervace(): Form
    {
        $form = new Form;

        $form->addText('rok')->setRequired();
        $form->addText('od')->setRequired();
        $form->addText('do');

        $form->addSubmit('odeslat');
        $form->onSuccess[] = [$this, 'formVlozRezervaceSucceeded'];

        return $form;
    }

    /**
     * metoda, která zpracuje formulář,
     * ze získaných údajů z formuláře vloží řádek do tabulky databáze
     */
    public function formVlozRezervaceSucceeded(Form $form, \stdClass $values): void
    {
        // z formuláře se odstraní mezery (kdyby zadal 6. 6. ale je třeba 6.6.)
        $datumBezMezerOd = str_replace(' ', '', $values->od);
        // ke dni a mesici se přidá rok
        $datumBezMezerOdKomp = $datumBezMezerOd .  $values->rok;
        /*  metoda DateTime::createFromFormat slouží k úpravě formátu zadaného datumu, z formuláře máme zadaný den a měsíc ve formátu d.m. nakonec přidáme rok
            a metoda format to převede do formátu (y-m-d) jak je nastaveno v databazi
        */
        $datumOd = DateTime::createFromFormat('d.m.Y', $datumBezMezerOdKomp);
        $datumOdFormat = $datumOd->format('Y-m-d');

        $datumBezMezerDo = str_replace(' ', '', $values->do);
        if ($values->do != null){
            $datumBezMezerDoKomp = $datumBezMezerDo .  $values->rok;
            $datumDo = DateTime::createFromFormat('d.m.Y', $datumBezMezerDoKomp);
            $datumDoFormat = $datumDo->format('Y-m-d');
        }else{
            $datumDoFormat = null;
        }

        $this->database->query('INSERT INTO rezervace', [
            'rok' => $values->rok,
            'od' => $datumOdFormat,
            'do' => $datumDoFormat,
        ]);

        $this->flashMessage('Vložení rezervace bylo úspěšné.');
        $this->redirect('AdminSekce:spravaVystoupeni');
    }


    /**
     * metoda, která vytvoří formulář pro úpravu zvolené rezervace
     */
    protected function createComponentFormUpravRezervace(): Form
    {
        $form = new Form;

        $form->addText('idRezervaceU');
        $form->addText('rokU')->setRequired();
        $form->addText('odU')->setRequired();
        $form->addText('doU');

        $form->addSubmit('odeslatU');
        $form->onSuccess[] = [$this, 'formUpravRezervaceSucceeded'];

        return $form;
    }


    /**
     * metoda, která zpracuje formulář,
     * ze získaných údajů z formuláře upraví konkrétní řádek tabulky databáze na základě jeho id
     */
    public function formUpravRezervaceSucceeded(Form $form, \stdClass $values): void
    {
        // z formuláře se odstraní mezery (kdyby zadal 6. 6. ale je třeba 6.6.)
        $datumBezMezerOdU = str_replace(' ', '', $values->odU);
        // ke dni a mesici se přidá rok
        $datumBezMezerOdKompU = $datumBezMezerOdU .  $values->rokU;
        /*  metoda DateTime::createFromFormat slouží k úpravě formátu zadaného datumu, z formuláře máme zadaný den a měsíc ve formátu d.m. nakonec přidáme rok
            a metoda format to převede do formátu (y-m-d) jak je nastaveno v databazi
        */
        $datumOdU = DateTime::createFromFormat('d.m.Y', $datumBezMezerOdKompU)->format('Y-m-d'); //metoda DateTime::createFromFormat slouží

        $datumBezMezerDoU = str_replace(' ', '', $values->doU);

        if ($values->doU != null){
            $datumBezMezerDoUKomp = $datumBezMezerDoU .  $values->rokU;
            $datumDoU = DateTime::createFromFormat('d.m.Y', $datumBezMezerDoUKomp);
            $datumDoUFormat = $datumDoU->format('Y-m-d');
        }else{
            $datumDoUFormat = null;
        }

        $this->database->query('UPDATE rezervace SET', [
            'rok' => $values->rokU,
            'od' => $datumOdU,
            'do' => $datumDoUFormat,
        ], 'WHERE idRezervace = ?', $values->idRezervaceU);

        $this->flashMessage('Úprava rezervace byla úspěšná.');
        $this->redirect('AdminSekce:spravaVystoupeni');
    }

    /**
     * metoda, která vytvoří formulář pro smazání zvoleného vystoupení
     */
    protected function createComponentFormVymazRezervace(): Form
    {
        $form = new Form;

        $form->addText('idRezervaceV');
        $form->addSubmit('odeslatV');
        $form->onSuccess[] = [$this, 'formVymazRezervaceSucceeded'];

        return $form;
    }

    /**
     * metoda, která zpracuje formulář,
     * ze získaných údajů z formuláře smaže konkrétní řádek tabulky databáze na základě jeho id
     */
    public function formVymazRezervaceSucceeded(Form $form, \stdClass $values): void
    {
        $this->database->query('DELETE FROM rezervace WHERE idRezervace = ?', $values->idRezervaceV);

        $this->flashMessage('Rezervace byla smazána.');
        $this->redirect('AdminSekce:spravaVystoupeni');
    }

    //správa vystoupení konec


    //správa repertoáru začátek
    /**
     * metoda, která načte obsah databázové tabulky repertoar
     */
    public function renderSpravaRepertoaru(): void
    {
        $this->template->adminSekce = $this->database->table('repertoar')
        ->order('nazev');
    }

    /**
     * metoda, která vytvoří formulář pro vložení nové písně
     */
    protected function createComponentFormVlozRepertoar(): Form
    {
        $form = new Form;

        $form->addText('nazev')->setRequired();
        $form->addText('zanr');
        $form->addText('tanec');

        $form->addSubmit('odelat');
        $form->onSuccess[] = [$this, 'formVlozRepertoarSucceeded'];

        return $form;
    }


    /**
     * metoda, která zpracuje formulář,
     * ze získaných údajů z formuláře vloží řádek do tabulky databáze
     */
    public function formVlozRepertoarSucceeded(Form $form, \stdClass $values): void
    {
        $this->database->query('INSERT INTO repertoar', [
            'nazev' => $values->nazev,
            'zanr' => $values->zanr,
            'tanec' => $values->tanec,
        ]);
        $this->flashMessage('Vložení písně bylo úspěšné.');
        $this->redirect('AdminSekce:spravaRepertoaru');
    }

    /**
     * metoda, která vytvoří formulář pro úpravu zvolené písně
     */
    protected function createComponentFormUpravRepertoar(): Form
    {
        $form = new Form;

        $form->addText('idPisneU');
        $form->addText('nazevU')->setRequired();
        $form->addText('zanrU')->setRequired();
        $form->addText('tanecU');

        $form->addSubmit('odeslatU');
        $form->onSuccess[] = [$this, 'formUpravRepertoarSucceeded'];

        return $form;
    }


    /**
     * metoda, která zpracuje formulář,
     * ze získaných údajů z formuláře upraví konkrétní řádek tabulky databáze na základě jeho id
     */
    public function formUpravRepertoarSucceeded(Form $form, \stdClass $values): void
    {
        $this->database->query('UPDATE repertoar SET', [
            'nazev' => $values->nazevU,
            'zanr' => $values->zanrU,
            'tanec' => $values->tanecU,
        ], 'WHERE idPisne = ?', $values->idPisneU);
        $this->flashMessage('Úprava písně byla úspěšná.');
        $this->redirect('AdminSekce:spravaRepertoaru');
    }


    /**
     * metoda, která vytvoří formulář pro smazání zvolené písně
     */
    protected function createComponentFormVymazRepertoar(): Form
    {
        $form = new Form;

        $form->addText('idPisneV');
        $form->addSubmit('odeslatV');
        $form->onSuccess[] = [$this, 'formVymazRepertoarSucceeded'];

        return $form;
    }

    /**
     * metoda, která zpracuje formulář,
     * ze získaných údajů z formuláře smaže konkrétní řádek tabulky databáze na základě jeho id
     */
    public function formVymazRepertoarSucceeded(Form $form, \stdClass $values): void
    {
        $this->database->query('DELETE FROM repertoar WHERE idPisne = ?', $values->idPisneV);

        $this->flashMessage('Píseň byla smazána.');
        $this->redirect('AdminSekce:spravaRepertoaru');
    }
    //správa repertoáru konec


    //správa fotogalerie začátek
    /**
     * metoda, která načte obsah databázové tabulky fotogalerie,
     */
    public function renderSpravaFotogalerie(): void
    {
        $this->template->adminSekce = $this->database->table('fotografie')
        ->order('idFotografie DESC');
    }


    /**
     * metoda, která vytvoří formulář pro vložení nové fotografie
     */
    protected function createComponentFormVlozFotogalerie(): Form
    {
        $form = new Form;

        $form->addText('popisek')->setRequired();
        $form->addUpload('file')
            ->addRule(Form::IMAGE, 'Fotografie musí být JPEG, PNG nebo GIF.')
            ->setRequired();

        $form->addSubmit('odeslat');
        $form->onSuccess[] = [$this, 'formVlozFotogalerieSucceeded'];

        return $form;
    }


    /**
     *metoda, která zpracuje formulář,
     * do databáze se ukládá pouze název souboru a popisek (použivá se v javascript galerii pro titulek fotky)
     * samotná fotka se vkládá do složky ../www/fotogalerie/fotky
     */
    public function formVlozFotogalerieSucceeded(Form $form, \stdClass $values): void
    {
        $pathFile = "../www/fotoGalerie/fotky/" . $values->file->getName();
        $values->file->move($pathFile); // samotný přesun fotky

        $this->database->query('INSERT INTO fotografie', [
            'nazev' => $values->file->getName(),
            'popisek' => $values->popisek,
        ]);

        $this->flashMessage('Vložení fotografie bylo úspěšné.');
        $this->redirect('AdminSekce:spravaFotogalerie');
    }

    /**
     * metoda, která vytvoří formulář pro smazání zvolené fotografie
     */
    protected function createComponentFormVymazFotogalerie(): Form
    {
        $form = new Form;

        $form->addText('idFotografieV');
        $form->addSubmit('odeslatV');
        $form->onSuccess[] = [$this, 'formVymazFotogalerieSucceeded'];

        return $form;
    }


    /**
     * metoda, která zpracuje formulář,
     * nejdříve dochází k samotné smazání souboru,
     * poté dochází k smazání informací z databáze
     */
    public function formVymazFotogalerieSucceeded(Form $form, \stdClass $values): void
    {

        $hledejNazevSouboru = $this->database->query('SELECT nazev FROM fotografie WHERE idFotografie = ?', $values->idFotografieV); //
        $row = $hledejNazevSouboru->fetch();
        $nazevSouboruString = $row[0];
        \Nette\Utils\FileSystem::delete("../www/fotoGalerie/fotky/$nazevSouboruString");

        // výmaz infa z databáze
        $this->database->query('DELETE FROM fotografie WHERE idFotografie = ?', $values->idFotografieV);

        $this->flashMessage('Fotografie byla smazána.');
        $this->redirect('AdminSekce:spravaFotogalerie');
    }
    //správa fotogalerie konec

}
