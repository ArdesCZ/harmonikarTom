-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Stř 17. lis 2021, 13:50
-- Verze serveru: 10.4.14-MariaDB
-- Verze PHP: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `harmonikardatabaze`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `fotografie`
--

CREATE TABLE `fotografie` (
  `idFotografie` int(11) NOT NULL,
  `nazev` varchar(40) DEFAULT NULL,
  `popisek` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `fotografie`
--

INSERT INTO `fotografie` (`idFotografie`, `nazev`, `popisek`) VALUES
(26, 'stáhnout (1).jpg', 'Kocka1'),
(27, 'stáhnout (2).jpg', 'Kocka2'),
(28, 'stáhnout.jpg', 'Kocka3');

-- --------------------------------------------------------

--
-- Struktura tabulky `repertoar`
--

CREATE TABLE `repertoar` (
  `idPisne` int(11) NOT NULL,
  `nazev` varchar(40) NOT NULL COMMENT 'název písně',
  `zanr` varchar(20) DEFAULT NULL COMMENT 'lidové, taneční, ostatní',
  `tanec` varchar(20) DEFAULT NULL COMMENT 'polka, valčík, waltz'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `repertoar`
--

INSERT INTO `repertoar` (`idPisne`, `nazev`, `zanr`, `tanec`) VALUES
(1, 'Snubní prstýnek', 'Lidové písně', 'Valčík'),
(2, 'Moje česká vlast', 'Lidové písně', 'Valčík'),
(3, 'Ptali sa maměnka', 'Lidové písně', 'Valčík'),
(4, 'Fláma', 'Lidové písně', 'Polka'),
(5, 'Šumařinka', 'Lidové písně', 'Polka'),
(6, 'Na Palackým mostě', 'Lidové písně', 'Polka'),
(7, 'Ku Praze uhání vlak', 'Lidové písně', 'Polka'),
(8, 'Chaloupky pod horama', 'Lidové písně', 'Valčík'),
(9, 'U našich kasáren', 'Lidové písně', 'Polka'),
(10, 'Vdávala matička', 'Lidové písně', 'Valčík'),
(11, 'Morava krásná zem', 'Lidové písně', 'Valčík'),
(12, 'Byl večer tichý', 'Lidové písně', 'Valčík'),
(13, 'Těžko jste mě mamko má', 'Lidové písně', 'Polka'),
(14, 'Pivovarští koně', 'Lidové písně', 'Polka'),
(15, 'Pivovárek', 'Lidové písně', 'Valčík'),
(16, 'Až se budem brát', 'Lidové písně', 'Polka'),
(17, 'Ach cestičko ušlapaná', 'Lidové písně', 'Valčík'),
(18, 'Přerovana', 'Lidové písně', 'Polka'),
(19, 'Římovský můstek', 'Lidové písně', 'Valčík'),
(20, 'Dva šátečky', 'Lidové písně', 'Polka'),
(21, 'Povětrné střevíčky', 'Lidové písně', 'Valčík'),
(22, 'Hradišťanka', 'Lidové písně', 'Polka'),
(23, 'Žala naša Anička', 'Lidové písně', 'Polka'),
(24, 'Měl jsem frajárečku', 'Lidové písně', 'Valčík'),
(25, 'Břeclavská kasárna', 'Lidové písně', 'Polka'),
(26, 'Šumař Bárta', 'Lidové písně', 'Valčík'),
(27, 'Čtyři páry', 'Lidové písně', 'Polka'),
(28, 'Sukýnka', 'Lidové písně', 'Valčík'),
(29, 'Vysoký jalovec', 'Lidové písně', 'Polka'),
(30, 'Švestková alej', 'Lidové písně', 'Valčík'),
(31, 'Škoda lásky', 'Lidové písně', 'Polka'),
(32, 'Ručičky nebojte se', 'Lidové písně', 'Valčík'),
(33, 'Rybářská směs valčíků', 'Lidové písně', 'Valčík'),
(34, 'Muzikantská směs polek', 'Lidové písně', 'Polka'),
(35, 'Pražská směs polek', 'Lidové písně', 'Polka'),
(36, 'Zednická směs valčíků', 'Lidové písně', 'Valčík'),
(37, 'Šoférská směs polek', 'Lidové písně', 'Polka'),
(38, 'Myslivecká směs polek', 'Lidové písně', 'Polka'),
(39, 'Maryša - Kolárovci', 'Lidové písně', NULL),
(40, 'Zbraslavská - už kamarádi', 'Lidové písně', NULL),
(41, 'Kdyby ty muziky nebyly', 'Lidové písně', 'Polka'),
(42, 'Ring-ring  ABBA  český text', 'Taneční písně', NULL),
(43, 'Loudá se půlměsíc', 'Taneční písně', NULL),
(44, 'Už vyplouvá loď John B', 'Taneční písně', NULL),
(45, 'Dívka s perlami ve vlasech', 'Taneční písně', NULL),
(46, 'Hastrmane tatrmane melou', 'Taneční písně', NULL),
(47, 'Není všechno paráda', 'Taneční písně', NULL),
(48, 'Lady karneval', 'Taneční písně', NULL),
(49, 'Trezor', 'Taneční písně', NULL),
(50, 'Zvonky štěstí', 'Taneční písně', NULL),
(51, 'U stánků', 'Taneční písně', NULL),
(52, 'Panenka , R. Křesťan', 'Taneční písně', NULL),
(53, 'Lambáda - orchestrálka', 'Taneční písně', NULL),
(54, 'Dům holubí', 'Taneční písně', NULL),
(55, 'Bílá královna', 'Taneční písně', NULL),
(56, 'Zahrada ticha', 'Taneční písně', NULL),
(57, 'Hej , Jude - orchestrálka', 'Taneční písně', NULL),
(58, 'Čmelák', 'Taneční písně', NULL),
(59, 'Alenka v říši divů', 'Taneční písně', NULL),
(60, 'Zrcadlo', 'Taneční písně', NULL),
(61, 'Báječná ženská', 'Taneční písně', NULL),
(62, 'Diana', 'Taneční písně', NULL),
(63, 'František Dobrota', 'Taneční písně', NULL),
(64, 'Hrobař', 'Taneční písně', NULL),
(65, 'Já nesnídám sám', 'Taneční písně', NULL),
(66, 'Jarošovský pivovar', 'Taneční písně', NULL),
(67, 'Jednou mi fotr povídá', 'Taneční písně', NULL),
(68, 'Blázen žárlí', 'Taneční písně', NULL),
(69, 'Ježek se má', 'Taneční písně', NULL),
(70, 'Kdyby tady byla, taková panenk', 'Taneční písně', NULL),
(71, 'Když náš táta hrál', 'Taneční písně', NULL),
(72, 'Mašinka', 'Taneční písně', NULL),
(73, 'Na kolena', 'Taneční písně', NULL),
(74, 'Nonstop', 'Taneční písně', NULL),
(75, 'Okno mé lásky', 'Taneční písně', NULL),
(76, 'Víš', 'Taneční písně', NULL),
(77, 'Poslední kovboj', 'Taneční písně', NULL),
(78, 'Pověste ho vejš', 'Taneční písně', NULL),
(79, 'Povídej', 'Taneční písně', NULL),
(80, 'Proč zrovna ty', 'Taneční písně', NULL),
(81, 'Pták Rosomák', 'Taneční písně', NULL),
(82, 'Sametová', 'Taneční písně', NULL),
(83, 'Slzy tvý mámy šedivý', 'Taneční písně', ''),
(84, 'Tohle je ráj', 'Taneční písně', ''),
(85, 'Už mi lásko není 20let', 'Taneční písně', ''),
(86, 'Veď mě dál ,cesto má', 'Taneční písně', NULL),
(87, 'Yesterdey - orchestrálka', 'Taneční písně', ''),
(88, 'Babylon', 'Taneční písně', ''),
(89, 'Prohrát není žádná hanba', 'Taneční písně', ''),
(90, 'Let it be - orchestrálka', 'Taneční písně', ''),
(91, 'Ptačí tanec', 'Taneční písně', ''),
(92, 'Šenkýřka', 'Taneční písně', ''),
(93, 'Stříbrný měsíc - orchestrálka', 'Taneční písně', ''),
(94, 'Večerníček pro dospělé', 'Taneční písně', ''),
(95, 'Baby', 'Taneční písně', ''),
(96, 'Colorado', 'Taneční písně', ''),
(97, 'Frankie Dlouhán', 'Taneční písně', ''),
(98, 'Jsem prý blázen jen', 'Taneční písně', ''),
(99, 'Malagelo', 'Taneční písně', ''),
(100, 'Nádherná láska', 'Taneční písně', ''),
(101, 'Schody do nebe', 'Taneční písně', ''),
(102, 'Snídaně v trávě', 'Taneční písně', ''),
(103, 'Paní k utahání', 'Taneční písně', ''),
(104, 'Tam kde teče Misisipi', 'Taneční písně', ''),
(105, 'Tereza (osamělý město)', 'Taneční písně', ''),
(106, 'Tisíc mil', 'Taneční písně', ''),
(107, 'To vadí', 'Taneční písně', ''),
(108, 'Všichni už jsou v Mexiku', 'Taneční písně', ''),
(109, 'Sbohem galánečko', 'Taneční písně', ''),
(110, 'Sedm žlutých kamínků', 'Taneční písně', ''),
(111, 'Hlídač krav', 'Taneční písně', ''),
(112, 'Kampak trempe', 'Taneční písně', ''),
(113, 'Sbohem lásko', 'Taneční písně', ''),
(114, 'Kaťuša - Kalinka', 'Taneční písně', ''),
(115, 'Panenka z kouta', 'Taneční písně', ''),
(116, 'Vesnická romance', 'Taneční písně', ''),
(117, 'Motýl', 'Taneční písně', ''),
(118, 'Vítr změn', 'Taneční písně', ''),
(119, 'Vyznání', 'Taneční písně', ''),
(120, 'Máma má rýmu', 'Taneční písně', ''),
(121, 'Šťastnej chlap', 'Taneční písně', ''),
(122, 'Sladké mámení', 'Taneční písně', ''),
(123, 'Bedna od wisky', 'Taneční písně', ''),
(124, 'Wisky , to je moje gusto', 'Taneční písně', ''),
(125, 'Náklaďák', 'Taneční písně', ''),
(126, 'Sladké mámení', 'Taneční písně', ''),
(127, 'Hořely padaly hvězdy', 'Taneční písně', ''),
(128, 'Kdybych já byl kovářem', 'Taneční písně', ''),
(129, 'Víno - Chinaky', 'Taneční písně', ''),
(130, 'Neříkej - Reflexi', 'Taneční písně', ''),
(131, 'Královské regé', 'Taneční písně', NULL);

-- --------------------------------------------------------

--
-- Struktura tabulky `rezervace`
--

CREATE TABLE `rezervace` (
  `idRezervace` int(11) NOT NULL,
  `rok` varchar(4) NOT NULL,
  `od` date NOT NULL,
  `do` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `rezervace`
--

INSERT INTO `rezervace` (`idRezervace`, `rok`, `od`, `do`) VALUES
(1, '2020', '2020-05-31', '2020-06-07'),
(2, '2020', '2020-04-04', NULL),
(3, '2020', '2020-01-25', NULL),
(4, '2020', '2020-02-01', NULL),
(5, '2020', '2020-03-07', NULL),
(6, '2020', '2020-02-15', NULL),
(7, '2020', '2020-07-12', '2020-07-24'),
(18, '2020', '2020-09-19', NULL);

-- --------------------------------------------------------

--
-- Struktura tabulky `uzivatel`
--

CREATE TABLE `uzivatel` (
  `id` int(11) NOT NULL,
  `uzivJM` varchar(20) NOT NULL,
  `heslo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `uzivatel`
--

INSERT INTO `uzivatel` (`id`, `uzivJM`, `heslo`) VALUES
(1, 'adminTom', '29a5d61b106e5efcc685853eedbc84a12e8030a5');

-- --------------------------------------------------------

--
-- Struktura tabulky `vystoupeni`
--

CREATE TABLE `vystoupeni` (
  `idVystoupeni` int(10) UNSIGNED NOT NULL COMMENT 'idčko',
  `rok` varchar(4) NOT NULL COMMENT 'jelikož má i rok dopředu',
  `datum` date DEFAULT NULL COMMENT 'jen datum bez času\r\n',
  `misto` varchar(50) NOT NULL COMMENT 'místo konání,\r\nkdyž má volno tak rezervace',
  `cas` varchar(40) DEFAULT NULL COMMENT 'čas se upřesňuje až později (i z důvodu akcí rok dopředu)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Tabulka zobrazující vystoupení';

--
-- Vypisuji data pro tabulku `vystoupeni`
--

INSERT INTO `vystoupeni` (`idVystoupeni`, `rok`, `datum`, `misto`, `cas`) VALUES
(1, '2020', '2020-01-06', 'Doubrava - domov seniorů', '14h'),
(2, '2020', '2020-01-15', ' Kolín - domov seniorů', '14 - 15h'),
(3, '2020', '2020-01-18', 'Dobrovítov', ' 17h'),
(7, '2020', '2020-02-22', 'Kouřim - masopust', '13 - 16h'),
(8, '2020', '2020-02-24', 'Uhlířské Janovice - domov seniorů', '9:30h'),
(9, '2020', '2020-02-27', 'Kutná Hora - restaurace BOWLING', '17 - 20h'),
(11, '2020', '2020-03-05', 'Kouřim - kavárnička u Pražské brány', '15 - 18h'),
(12, '2020', '2020-03-06', 'Zruč CENTRIN - zpívání se Šárkou', ''),
(14, '2020', '2020-03-08', 'Ledeč nad Sázavou - soukromá akce', '13 - 17h'),
(15, '2020', '2020-03-14', 'Zbraslavice - SONUS karneval - ZRUŠENO', ''),
(16, '2020', '2020-03-19', 'Kouřim - vítání jara kytičkou - ZRUŠENO', '15 - 19h'),
(19, '2020', '2020-06-13', 'Chotouchov - soukromá akce', ''),
(20, '2020', '2020-06-18', 'Kouřim - domov seniorů', '15 - 18h'),
(21, '2020', '2020-07-04', 'Jedlá - soukromá akce', ''),
(22, '2020', '2020-07-05', 'Rápošov - svěcení sochy', ' 14h'),
(23, '2020', '2020-07-11', 'Sázava - soukromá akce', ''),
(25, '2020', '2020-07-25', 'Třemošnice - svatba', ''),
(26, '2020', '2020-07-28', 'Kutná Hora - U tří Pávů', '17 - 20h'),
(27, '2020', '2020-07-30', 'Kouřim', '19 - 21:30h'),
(28, '2020', '2020-08-02', 'Kouřim', '19 - 21:30h'),
(29, '2020', '2020-08-08', 'Trnávka - soukromá akce', ''),
(30, '2020', '2020-08-22', 'Svatba - Bělá', '15h'),
(31, '2020', '2020-08-29', 'Zbraslavice - vystoupení SONUS', ''),
(32, '2020', '2020-09-05', 'Chmeliště - soukromá akce', ''),
(33, '2020', '2020-09-12', 'Kouřim - Sen noci Kouřimské', '19:15 - 22:00h'),
(34, '2020', '2020-09-17', 'Kouřim - kavárnička u Pražské brány', '15 - 18h'),
(37, '2020', '2020-11-14', 'Třemošnice - setkání harmonikářů', ''),
(38, '2020', '2020-11-15', 'Bělá - rybí hody', '16 - 20h'),
(39, '2020', '2020-12-10', 'Kouřim', '15 - 19h'),
(40, '2020', '2020-12-17', 'Kouřim', '18:15 - 22:00h'),
(41, '2020', '2020-12-19', 'Paběnice - adventní vystoupení s dětským sborem', ''),
(42, '2021', '2021-02-13', 'Kouřim - masopust', ''),
(51, '2021', '2021-09-25', 'Dobrovítov - vepřové hody', ''),
(52, '2020', '2020-12-18', 'Kutná Hora , divadlo J.K.Tyla', '');

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `fotografie`
--
ALTER TABLE `fotografie`
  ADD PRIMARY KEY (`idFotografie`);

--
-- Klíče pro tabulku `repertoar`
--
ALTER TABLE `repertoar`
  ADD PRIMARY KEY (`idPisne`);

--
-- Klíče pro tabulku `rezervace`
--
ALTER TABLE `rezervace`
  ADD PRIMARY KEY (`idRezervace`);

--
-- Klíče pro tabulku `uzivatel`
--
ALTER TABLE `uzivatel`
  ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `vystoupeni`
--
ALTER TABLE `vystoupeni`
  ADD PRIMARY KEY (`idVystoupeni`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `fotografie`
--
ALTER TABLE `fotografie`
  MODIFY `idFotografie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT pro tabulku `repertoar`
--
ALTER TABLE `repertoar`
  MODIFY `idPisne` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT pro tabulku `rezervace`
--
ALTER TABLE `rezervace`
  MODIFY `idRezervace` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pro tabulku `uzivatel`
--
ALTER TABLE `uzivatel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pro tabulku `vystoupeni`
--
ALTER TABLE `vystoupeni`
  MODIFY `idVystoupeni` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'idčko', AUTO_INCREMENT=53;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
