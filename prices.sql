-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Июл 17 2018 г., 18:04
-- Версия сервера: 5.7.22-0ubuntu0.16.04.1
-- Версия PHP: 7.0.30-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `prices`
--

-- --------------------------------------------------------

--
-- Структура таблицы `allnames`
--

CREATE TABLE `allnames` (
  `nameid` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `allnames`
--

INSERT INTO `allnames` (`nameid`, `name`) VALUES
(106, 'СПЗ-4'),
(107, 'СТС-Люкс'),
(108, 'Юнитерм'),
(109, 'НАДО'),
(110, 'ОТК'),
(111, 'Валдай ТК'),
(112, 'ВиК'),
(113, 'Дженерал Компани'),
(114, 'Литол-24 18кг'),
(115, 'Литол-24 180кг'),
(116, 'Литол-24 50кг'),
(117, 'Масло гидравлическое ВМГЗ (бочка)'),
(131, 'Масло трансмисс. ТЭП-15 (бочка 180 кг)'),
(132, 'АО СКК'),
(133, 'Ойл-Снаб Тлт'),
(142, 'High-Lube L2 400g'),
(145, 'МСМ Шеврон соседи'),
(146, 'Сызранская Керамика'),
(147, 'Chevron Black Pearl EP2 400g'),
(150, 'Масло трансформаторное ТКП 200л 180кг'),
(151, 'Mobilgrease XHP 222 0,4 кг'),
(152, 'Mobilgrease XHP 222 0,4 кг'),
(153, 'Вовчик'),
(155, 'Масло гидравлическое Гидромарка А 10л OilRight'),
(157, 'Мега ОЙЛ'),
(160, 'Масло индустриальное И-40 (бочка)'),
(161, 'Химэкспресс'),
(162, 'ДВК'),
(163, 'САМ-ПО'),
(165, 'Гидромарка А 10л ВолгаОйл'),
(166, 'Абиана'),
(167, 'Ondina 919 1л'),
(169, 'ННК'),
(170, 'НК НПЗ'),
(172, 'AEON 9000 17кг канистра'),
(173, 'Профинструмент'),
(174, 'Антифриз Cat'),
(175, 'Цеппелин г. Самара'),
(176, 'Смазка Fuchs Renolit HLT 2 18кг'),
(177, 'Смазка Fuchs Renolit HLT 2 0,4кг'),
(178, 'Смазочные материалы'),
(179, 'Klubersynth GH6-100 20л'),
(180, 'Клюбер центр.'),
(181, 'FAG ARKANOL-TEMP110 1кг'),
(182, 'БелтИмпэкс'),
(183, 'FAG ARKANOL-TEMP110 50кг'),
(184, 'Стройсервис'),
(186, 'Керосин КО-25 бочка'),
(187, 'Керосин РТ бочка'),
(188, 'ПРОМ ТЭК 2668435 2725648'),
(189, 'Химоптторг'),
(209, 'Салют'),
(212, 'NANO BLUE MULTIPURPOSE HT Grease 400g'),
(213, 'Жидкость 7-50С-3 (16,4 кг)'),
(214, 'Смазка силиконовая Si-M (тюбик)'),
(215, 'Состав МВС-3Н (24 кг)'),
(216, 'Масло гидравлическое МГЕ-46В (бочка)'),
(217, 'Масло индустриальное И-20 (бочка)'),
(218, 'Масло авиационное МС-20 (бочка)'),
(219, 'Смазка ЦИАТИМ-221 (банка 0,8кг)'),
(220, 'Масло компрессорное КС-19 (бочка 180 кг)'),
(221, 'Литол-24 42кг'),
(222, 'Смазка ШРУС-4 (туба 0,8 кг)'),
(223, 'Масло моторное М8-В Автол (бочка)'),
(224, 'Масло моторное М8Г2К (бочка)'),
(225, 'Масло моторное М10Г2К (бочка)'),
(226, 'Масло вакуумное ВМ-4 (16 кг)'),
(227, 'Смазка Kluber Isoflex NBU-15 (1 кг)'),
(228, 'Масло вакуумное ВМ-5с (15,5 кг)'),
(229, 'Смазка ЛС-1П (бочка)'),
(230, 'Масло цилиндровое Ц-52 (бочка)'),
(231, 'Масло турбинное ТП-22С (бочка)'),
(232, 'Смазка ЦИАТИМ-201 (21кг)'),
(233, 'Масло трансформаторное ГК (бочка)'),
(234, 'СОЖ Укринол (бочка)'),
(235, 'Смазка Солидол Жировой (21 кг)'),
(236, 'Смазка ВНИИНП-231 (1кг)'),
(237, 'Смазка ОКБ-122-7 (0,75 кг)'),
(238, 'Смазка АМС-3 (бидон 11,8 кг)'),
(239, 'Смазка ВНИИНП-286(ЭРА) (0,7кг)'),
(240, 'СОЖ Сульфофризол (бочка)'),
(241, 'Смазка МС-70 (бидон 16 кг)'),
(242, 'Смазка МЗ (15кг)'),
(243, 'Смазка ВНИИНП-225 (1кг)'),
(244, 'ОНМЗ'),
(246, 'Центр-Ойл г. Екб'),
(247, 'Континент НН'),
(248, 'Акрил Омск'),
(249, 'Нефтепродукт ЗАО г.НН'),
(250, 'ООС'),
(252, 'Масло индустриальное И-12 (бочка)'),
(253, 'Мюнхен-Ойл'),
(256, 'Смазка МС-17 15кг'),
(257, 'Русма'),
(258, 'Стас'),
(259, 'Ойл-Ком Екб.'),
(260, 'ЯЗЛМ (Липп) Ярсмазки'),
(261, 'Смазка ЦИАТИМ-221 (банка 0,9кг) (Ойл-Ком)'),
(262, 'Меркойл'),
(263, 'СпецХимПродукт Омск'),
(264, 'Состав МВС-3А'),
(266, 'Продест Ярославль'),
(267, 'НижегородХимПродукт'),
(268, 'Состав МВС-3Н (брикет 5кг)'),
(269, 'Масло вакуумное ВМ-4 (20л)'),
(270, 'Камский Завод Масел КЗМ'),
(271, 'Пента Юниор'),
(272, 'Авиастар-СП'),
(273, 'Масло индустриальное ИГП-49 (бочка)'),
(275, 'РОСА-1'),
(276, 'ПромСервисЦентр'),
(277, 'МИСКОМ'),
(278, 'СТД (Нонна)'),
(279, 'Смазка АМС-3 (бидон 17 кг)'),
(280, 'ПромПоставка НН'),
(281, 'ХЁРЦ Спб'),
(282, 'Состав МВС-3Н в КГ'),
(283, 'СЭП (ТСК)'),
(284, 'Мотор-Трейд (Кр.Куц.)'),
(285, 'Литол-24 21кг'),
(286, 'Литол-24 45кг'),
(287, 'Смазка АМС-3 (бидон 15 кг)'),
(288, 'СовИнТех'),
(289, 'СпецНефтьПродукт Тверская обл.'),
(290, 'Нектон Сиа'),
(291, 'Mobilgear 600 XP 460 (20л)'),
(292, 'Лавриченко'),
(294, 'Лима-Сервис'),
(295, 'Чирол'),
(296, 'Bechem Berulub FB 34 (0,4 кг)'),
(297, 'Bechem Berulub W+B Spray (0,4 кг)'),
(299, 'Дикомп-Классик'),
(300, 'Гелиос'),
(301, 'Керосин РТ 10л'),
(302, 'Масло моторное М10Г2К OR (10л)'),
(303, 'Масло вазелиновое ГОСТ (4л)'),
(304, 'Shell Corena D 68 (20л)'),
(305, 'Shell Corena P 150 (20л)'),
(308, 'Керосин РТ 20л'),
(309, 'Медхим'),
(310, 'Масло вазелиновое МХ-250 (аналог ГОСТ) (4л)'),
(311, 'Промышленные технологии (Фаворит Ойл)'),
(313, 'Нефрас С2 80/120 (бочка)'),
(314, 'Балашейские пески'),
(316, 'Bechem Beruplex LI EP 2 (25 кг)'),
(317, 'Масло компрессорное ТНК Компрессор VDL-100 (20л) '),
(318, 'РОСКОМ Батаев 261-16-56'),
(322, 'Дилекс'),
(323, 'ALUB Blue ALMIG (10л)'),
(325, 'Масло Mobil DTE 24 (208л) - гидравлическое'),
(326, ' Motorex Cool Concentrate (5л)'),
(327, 'ТЛТ-Опт, Тольятти'),
(328, 'Наш партнер'),
(330, 'Мочевина, 1 куб.'),
(331, 'Арсенал Марков'),
(332, 'ХозПромЭкспорт Уфа'),
(333, 'Куйбышевазот'),
(335, 'МегаМас (Высоцкий)'),
(336, 'Масло приборное МВП (в кг)'),
(337, 'Масло приборное МВП (175 кг)'),
(338, 'Масло трансформаторное ТСО (175 кг)'),
(340, 'Нефтебаза №1'),
(341, 'Прогресс'),
(343, 'Масло моторное М14В2 (бочка 180 кг)'),
(344, 'Масло Mobil DTE 25 (208л) - гидравлическое'),
(345, 'Масло трансформаторное Т-1500У (180кг)'),
(346, 'Масло индустриальное ИГП-14 (бочка 180 кг)'),
(347, 'Масло индустриальное И-50 (бочка 180кг)'),
(348, 'Масло гидравлическое ТНК Гидравлик OE HLP46 (бочка 180 кг)'),
(349, 'Масло гидравлическое ИГП-4 (бочка 180кг)'),
(350, 'Масло гидравлическое ИГП-8 (бочка 180кг)'),
(351, 'Масло трансмисс. ТАП-15 (бочка 180 кг)'),
(352, 'Масло трансмисс. ТАД-17 (ТМ-5) (бочка 180 кг)'),
(353, 'Масло авиационное СМ-4,5 (банка 15 кг)'),
(354, 'Масло вакуумное Adixen A-120 (5кг)'),
(355, 'Смазка WD-40 спрей 400 мл'),
(356, 'Би Питрон Самара'),
(358, 'Motorex Spindlelube ISO VG 68 (4л)'),
(360, 'Масло Гидравлик Стандарт 46 (180кг)'),
(361, 'Серые ГПН Тлт'),
(362, 'Анвек'),
(364, 'Масло редукторное Shell Omala S2 G68 - бочка (208л)'),
(365, 'Евросмаз'),
(367, 'Тосол 10 л'),
(368, 'Castrol GTX Magnatec 5w-40 (4л)'),
(369, 'Литол-24 0,8 кг'),
(370, 'Смазка графитная Ж 21 кг'),
(371, 'Смазка графитная УССА 0,8 кг'),
(372, 'Смазка ЦИАТИМ-201 (0,8 кг)'),
(373, 'Смазка ЦИАТИМ-201 (10 кг)'),
(374, 'Смазка ЦИАТИМ-221 ( 10 кг)'),
(375, 'Смазка ЭПС-98 (банка 0,8 кг)'),
(376, 'Смазка SKF LGHP 2  (18 кг)'),
(377, 'Смазка SKF LGHP 2  (0,42 кг)'),
(378, 'DG-40 (0,52л) Аналог WD-40 от Мега Ойл'),
(379, 'Смазка графитная Ж 10 кг'),
(380, 'Масло АМТ-300 (бочка 200л)'),
(383, 'ТЕК-КОМ'),
(384, 'Смазка WD-40 спрей 420 мл'),
(385, 'Смазка ЭПС-98 (Банка 1,3кг)'),
(386, 'Литол-24  2 кг'),
(387, 'Масло цепное OR (1л)'),
(389, 'DOT-4 (0,455 л)'),
(390, 'DOT-4 (0,910 л)'),
(391, 'Масло Автопромывочное 3,5л OR'),
(392, 'Масло Автопромывочное 5л Luxe'),
(393, 'Масло гидравлическое марки "Р" 1л'),
(394, 'Масло моторное Addinol Diesel Longlife MD 1548 SAE 15w-40 (канистра 20 л)'),
(395, 'Масло моторное Addinol Diesel Longlife MD 1548 SAE 15w-40 (бочка 205 л)'),
(396, 'Масло Автопромывочное 3л Волга-Ойл'),
(397, 'Масло гидравлическое марки "Р" 10 л'),
(398, 'Ойлс (Аддинол) Ольга 9791196'),
(399, 'УралСпецСервис  (89372095452)'),
(401, 'Mannol silicone spray 400ml'),
(403, 'Сервис'),
(404, 'Герметик Автосил 180 мл'),
(406, 'Инрол-СТС СибТрейдСервис'),
(407, 'Mobilube 85-w140 (20л)'),
(409, 'Ойл-Форби'),
(410, 'Слоистые пластики'),
(411, 'Bechem Berutemp 500 T2 (0,8 кг)'),
(414, 'Масло ИГП-38 (бочка 180 кг)'),
(415, 'Петро-Самара (276-45-80)'),
(416, 'ТНК Revolux D1 SAE 10W-40 (20л)'),
(417, 'Контур СПБ'),
(418, 'Масло приборное (170 кг бочка)'),
(419, 'Масло приборное МВП (170 кг бочка)'),
(420, 'Масло приборное МВП (15 кг бидон)'),
(421, 'Масло моторное М8Г2К (бочка)'),
(422, 'Масло моторное М8ДМ (бочка)'),
(424, 'Сервис Д'),
(427, 'Тяжмаш'),
(428, 'Смазка ВНИИНП-275 0,8кг'),
(429, 'Смазка ВНИИНП-273 0,8кг'),
(430, 'Смазка ВНИИНП-232 0,8кг'),
(431, 'Смазка ЦИАТИМ-202 0,8кг'),
(432, 'Смазка ЦИАТИМ-202 10кг'),
(436, 'СОЖ МР-7 (бочка 180кг)'),
(437, 'Спецавтомат Ростовская обл.'),
(439, 'Добавка Easy kit AL-3 Standard (200-599 L)'),
(440, 'Добавка Easy kit Cu-3 Standard (50-119 L)'),
(441, 'Добавка моющая Sanitaizer ST40 20 ml'),
(442, 'Фильтр для воды 20 мкм'),
(444, 'С-Металл'),
(446, 'Трумпф'),
(447, 'УСИ (Казахстан)'),
(448, 'Mobil DTE 10 Excel 46 (20 л)'),
(451, 'SHELL OMALA S4 WE 320 (20 л)'),
(452, 'Shell Tellus S2 V 46 (20 л)'),
(453, 'Shell Tellus S3M 32 (209 л)'),
(454, 'Shell Tellus S3M 68 (20 л)'),
(455, 'MOBILITH SHC 220 (16 кг)'),
(456, 'MOBILUX EP 004 (18 кг)'),
(457, 'OKS 1110 (0,5 кг)'),
(458, 'Divinol Lithogrease 000 (1 кг)'),
(459, 'Gadus S2 V220 2 (0,4 кг)'),
(460, 'Gadus S2 V100 3 (0,4 кг)'),
(461, 'Gadus S2 V220 00 (18 кг)'),
(462, 'Gadus S4 V45AC 00/000 (18 кг)'),
(463, 'Optileb RB-1 (17 кг)'),
(464, 'ЦПК'),
(465, 'SKF LGEV2 (0,4 кг)'),
(466, 'Маслостар (Москва)'),
(467, 'SKF LGLT 2/1 (0,4 кг)'),
(468, 'Охлаждающая жидкость Motorex COOL-X (25л)'),
(469, 'Квалитет (ТЛТ)'),
(471, 'ПФМС-4С (0,8 кг)'),
(472, 'Химпродукт Москва'),
(473, 'HLP-46 бочка (180 кг)'),
(475, 'Промывочное масло РН (бочка 200л)'),
(478, 'Роснефть Редуктор CLP 320 (бочка)'),
(480, 'Масло силиконовое ПМС-5 (19 кг)'),
(481, 'Реахим  Ст.Купавна'),
(482, 'Смывка APS-E (200 гр в уп. 24 шт)'),
(483, 'АЛТ МО, пос.Быково'),
(484, 'Смазка Лита (170,5 кг)'),
(485, 'Смазка EFELE VH-491 (ведро 5 кг.)'),
(486, 'Масло синтетическое POE32 (Errecom) – 5л'),
(487, 'Морена Самара (846) 574-02-17)'),
(489, 'Масло синтетическое POE55 (Errecom) – 5л'),
(490, 'Масло синтетическое POE22 (Errecom) – 5л'),
(491, 'Смазка Лита (10 кг)'),
(492, 'Скипидар живичный (10 л)'),
(493, 'Неостат Дзержинск'),
(494, 'Масло гидравлическое ТНК Гидравлик OE HLP46 (кан 18 кг)'),
(495, 'Масло гидравлическое ТНК Гидравлик OE HLP68 (бочка 180 кг)'),
(496, 'RENOLIT SF 7-041 (18 кг)'),
(497, 'Инхим Москва'),
(499, 'Motul Snowmobile 2t (1л)'),
(500, 'Motul Snowmobile 2t (4л)'),
(501, 'Союз-Авто (225-40-15)'),
(502, 'АвтомастерОйл (ТЛТ)'),
(503, 'Пегас (265-57-27)'),
(505, 'ENI i-Sigma Universal 10w40 (20л)'),
(506, 'ТНК Транс Гипоид 80W-90 (20л)'),
(507, 'Роснефть Gidrotec OE HLP 46 (20л)'),
(508, 'Роснефть Gidrotec OE HLP 46 (216л)'),
(509, 'Лукойл ТМ-5 SAE 80W-90 API (50л)'),
(510, 'Тосол Felix Euro (-35 град.) (20л)'),
(512, 'Масло холодильное ХА-30 (216л) УФА'),
(513, 'Avantin 361 IN 180кг (бочка)'),
(516, 'Средневолжская Трубно-Механическая (noginata@krm.npstroy.com)'),
(517, 'Смазка KR-941 силик. универс. (520 мл)'),
(520, 'Смазка ВНИИНП-279 0,8кг'),
(521, 'ТНК Редуктор CLP 100 (бочка)'),
(522, 'Лукойл Трансол-200 (18кг)'),
(523, 'Смазка КМ 30 080 (1кг ? уточнить фасовку)'),
(524, 'Gadus S2 V220 0 (18 кг)'),
(525, 'Масло ИЛС-5 (бочка)'),
(528, 'ССХ'),
(530, 'Масло ТСП-15К 180кг'),
(531, 'ZIC ATF III'),
(532, 'Shell Rimula R5 Е, 10W40 20л'),
(533, 'Антифриз  G-11 (10кг) зеленый'),
(534, 'Масло марки "А" гидравлическое'),
(535, 'Масло М10ДМ бочка 180кг'),
(536, 'Смазка Солидол Жировой 9,5 кг '),
(537, 'Смазка графитная 9,5 кг'),
(540, 'ТНК Гидротэк HVLP 46 OE (бочка)'),
(541, 'Shell Tellus S2 V 46 (209 л)'),
(542, 'КАСКАД Наприенко'),
(545, 'НЭТЧ'),
(546, 'Shell Omala S2 G 320 (20л)'),
(548, 'Тосол бочка (200л)'),
(550, 'ЭТИЛАЦЕТАТ бочка 180 кг'),
(551, 'Адверс'),
(552, 'Avantin 361 IN 18кг (канистра 20л)'),
(554, 'Oemeta Frigomet NF 470/30N (бочка 220 кг)'),
(556, 'УТС РУС (ШАТРОВ)'),
(557, 'LM Pro-Line Silikon-Spray (0,4л)'),
(558, 'Регион-Снаб (Ликви Моли Самара)'),
(559, 'Rocol Foodlube Universal 2 (аналог CASSIDA EPS 2) 10кг'),
(560, 'SKF FGFP 2 (0,4 кг)'),
(561, 'Bechem Berusynth H1 32 (аналог CASSIDA HF 32) (20л)'),
(562, 'Bechem Berusynth H1 46 (аналог CASSIDA HF 46) (20л)'),
(563, 'Bechem Berusynth H1 220 (аналог CASSIDA GL 220) (20л)'),
(564, 'Renolin THERM 320/ FM HEAT TRANSFER FLUID (20л)'),
(565, 'KLuberfood NH1 94-402 (0,4 кг)'),
(566, 'Масло индустриальное И-5 (бочка 180кг)'),
(568, 'СУПЕРКОНТ 1.1 кг'),
(569, 'СМОЛА ПЛС-ЛС 1 кг'),
(571, 'СУПЕРКОНТ  г. Красноярск'),
(572, 'ИНТЕРХИМ Дзержинск'),
(578, 'Масло моторное Роснефть Maximum Diesel 10w40 (20л)'),
(579, 'Тосол Top40 (10кг)'),
(580, 'Антифриз G-12 красный МиГ (10кг)'),
(582, 'Mobil ATF 220 Dexron II (20л)'),
(583, 'Развитие'),
(604, 'Стройиндустрия'),
(605, 'Стройавтокран'),
(608, 'СККМ');

-- --------------------------------------------------------

--
-- Структура таблицы `byers`
--

CREATE TABLE `byers` (
  `byers_id` smallint(5) UNSIGNED NOT NULL,
  `byers_nameid` mediumint(8) UNSIGNED NOT NULL,
  `clearp` float(5,2) UNSIGNED NOT NULL,
  `obnal` smallint(5) UNSIGNED NOT NULL,
  `wtime` float UNSIGNED NOT NULL,
  `comment` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `byers`
--

INSERT INTO `byers` (`byers_id`, `byers_nameid`, `clearp`, `obnal`, `wtime`, `comment`) VALUES
(42, 106, 0.00, 0, 0, 'И-12 - по 550 на шт, Ц221 - по 60 на шт'),
(43, 107, 0.00, 0, 0, NULL),
(44, 108, 0.00, 0, 0, NULL),
(45, 109, 0.00, 0, 0, NULL),
(46, 132, 4.75, 0, 0, 'чистыми'),
(47, 146, 5.00, 12, 0, NULL),
(48, 153, 0.00, 0, 0, NULL),
(49, 163, 0.00, 0, 0, NULL),
(50, 169, 0.00, 0, 0, NULL),
(51, 170, 0.00, 0, 0, NULL),
(52, 184, 0.00, 0, 0, NULL),
(53, 209, 0.00, 0, 0, 'на шт - 8, делится как 5 и 3'),
(54, 272, 5.00, 12, 0, NULL),
(55, 294, 5.00, 12, 0, NULL),
(56, 299, 7.00, 11, 0, 'Делится 2/3 -Ц, 1/3-М'),
(57, 300, 0.00, 0, 0, NULL),
(58, 314, 0.00, 0, 0, NULL),
(59, 328, 0.00, 0, 0, NULL),
(60, 333, 0.00, 0, 0, NULL),
(61, 341, 0.00, 0, 0, NULL),
(62, 356, 0.00, 0, 0, NULL),
(63, 399, 0.00, 0, 0, NULL),
(64, 403, 0.00, 0, 0, NULL),
(65, 406, 0.00, 0, 0, NULL),
(66, 410, 5.00, 12, 0, 'при обнале - 45-12'),
(67, 424, 0.00, 0, 0, NULL),
(68, 427, 5.00, 11, 0, NULL),
(69, 447, 0.00, 0, 0, NULL),
(70, 516, 0.00, 0, 0, NULL),
(71, 528, 0.00, 0, 0, NULL),
(72, 545, 0.00, 0, 0, NULL),
(73, 551, 0.00, 0, 0, NULL),
(74, 604, 10.00, 10, 0, NULL),
(75, 605, 10.00, 12, 0, 'когда малая рент - 100 на шт'),
(78, 608, 0.00, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `giveaways`
--

CREATE TABLE `giveaways` (
  `given_away` date NOT NULL,
  `giveaways_id` smallint(5) UNSIGNED NOT NULL,
  `comment` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `giveaway_sum` float UNSIGNED NOT NULL,
  `requestid` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `payments`
--

CREATE TABLE `payments` (
  `payed` date NOT NULL,
  `payments_id` smallint(5) UNSIGNED NOT NULL,
  `number` smallint(5) UNSIGNED NOT NULL,
  `comment` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sum` float UNSIGNED NOT NULL,
  `requestid` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `pricings`
--

CREATE TABLE `pricings` (
  `pricingid` smallint(5) UNSIGNED NOT NULL,
  `positionid` smallint(5) UNSIGNED NOT NULL,
  `byerid` smallint(5) UNSIGNED NOT NULL,
  `tradeid` smallint(5) UNSIGNED NOT NULL,
  `sellerid` smallint(5) UNSIGNED NOT NULL,
  `zak` float UNSIGNED NOT NULL,
  `kol` smallint(5) UNSIGNED NOT NULL,
  `tzr` smallint(5) UNSIGNED DEFAULT NULL,
  `wtime` float UNSIGNED DEFAULT NULL,
  `fixed` smallint(5) UNSIGNED NOT NULL,
  `op` float UNSIGNED NOT NULL,
  `tp` float UNSIGNED NOT NULL,
  `opr` float UNSIGNED NOT NULL,
  `tpr` float UNSIGNED NOT NULL,
  `firstobp` float UNSIGNED NOT NULL,
  `firstobpr` float UNSIGNED NOT NULL,
  `firstoh` float UNSIGNED NOT NULL,
  `marge` float UNSIGNED NOT NULL,
  `margek` float UNSIGNED NOT NULL,
  `rop` float UNSIGNED NOT NULL,
  `realop` float UNSIGNED NOT NULL,
  `rtp` float UNSIGNED NOT NULL,
  `realtp` float UNSIGNED NOT NULL,
  `clearp` float UNSIGNED NOT NULL,
  `obp` float UNSIGNED NOT NULL,
  `oh` smallint(5) UNSIGNED NOT NULL,
  `price` float UNSIGNED NOT NULL,
  `rent` float UNSIGNED NOT NULL,
  `winner` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `requests`
--

CREATE TABLE `requests` (
  `created` date NOT NULL,
  `requests_id` mediumint(5) UNSIGNED NOT NULL,
  `req_comment` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `requests_nameid` mediumint(8) UNSIGNED NOT NULL,
  `req_rent` float UNSIGNED DEFAULT '0',
  `byersid` smallint(5) UNSIGNED NOT NULL,
  `payment` tinyint(1) DEFAULT NULL,
  `req_sum` int(11) DEFAULT NULL,
  `1c_num` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `req_positions`
--

CREATE TABLE `req_positions` (
  `req_positionid` smallint(5) UNSIGNED NOT NULL,
  `pos_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `winnerid` smallint(5) UNSIGNED NOT NULL,
  `requestid` mediumint(8) UNSIGNED NOT NULL,
  `giveaway` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `sellers`
--

CREATE TABLE `sellers` (
  `sellers_id` smallint(5) UNSIGNED NOT NULL,
  `sellers_nameid` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `sellers`
--

INSERT INTO `sellers` (`sellers_id`, `sellers_nameid`) VALUES
(14, 110),
(15, 111),
(16, 112),
(17, 113),
(18, 133),
(19, 145),
(20, 157),
(23, 161),
(24, 162),
(25, 166),
(26, 173),
(27, 175),
(28, 178),
(29, 180),
(30, 182),
(31, 188),
(32, 189),
(33, 244),
(34, 246),
(35, 247),
(36, 248),
(37, 249),
(38, 250),
(39, 253),
(40, 257),
(41, 258),
(42, 259),
(43, 260),
(44, 262),
(45, 263),
(46, 264),
(47, 266),
(48, 267),
(49, 270),
(50, 271),
(51, 275),
(52, 276),
(53, 277),
(54, 278),
(55, 280),
(56, 281),
(57, 283),
(58, 284),
(59, 288),
(60, 289),
(61, 290),
(62, 292),
(63, 295),
(64, 309),
(65, 311),
(66, 318),
(67, 322),
(68, 327),
(69, 331),
(70, 332),
(71, 335),
(72, 340),
(73, 361),
(74, 362),
(75, 365),
(77, 383),
(78, 398),
(79, 409),
(80, 415),
(81, 417),
(82, 437),
(83, 444),
(84, 446),
(85, 464),
(86, 466),
(87, 469),
(88, 472),
(89, 481),
(90, 483),
(91, 487),
(92, 493),
(93, 497),
(94, 501),
(95, 502),
(96, 503),
(97, 542),
(98, 556),
(99, 558),
(100, 571),
(101, 572),
(102, 583);

-- --------------------------------------------------------

--
-- Структура таблицы `trades`
--

CREATE TABLE `trades` (
  `trades_id` smallint(5) UNSIGNED NOT NULL,
  `trades_nameid` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `trades`
--

INSERT INTO `trades` (`trades_id`, `trades_nameid`) VALUES
(10, 114),
(11, 115),
(12, 116),
(13, 117),
(14, 131),
(15, 142),
(18, 147),
(19, 150),
(21, 152),
(22, 155),
(24, 160),
(25, 165),
(26, 167),
(27, 172),
(28, 174),
(29, 176),
(30, 177),
(31, 179),
(32, 181),
(33, 183),
(34, 186),
(35, 187),
(36, 212),
(37, 213),
(38, 214),
(39, 215),
(40, 216),
(41, 217),
(42, 218),
(43, 219),
(44, 220),
(45, 221),
(46, 222),
(47, 223),
(48, 224),
(49, 225),
(50, 226),
(51, 227),
(52, 228),
(53, 229),
(54, 230),
(55, 231),
(56, 232),
(57, 233),
(58, 234),
(59, 235),
(60, 236),
(61, 237),
(62, 238),
(63, 239),
(64, 240),
(65, 241),
(66, 242),
(67, 243),
(68, 252),
(69, 256),
(70, 261),
(72, 268),
(73, 269),
(74, 273),
(75, 279),
(76, 282),
(77, 285),
(78, 286),
(79, 287),
(80, 291),
(81, 296),
(82, 297),
(83, 301),
(84, 302),
(85, 303),
(86, 304),
(87, 305),
(88, 308),
(89, 310),
(90, 313),
(91, 316),
(92, 317),
(93, 323),
(95, 325),
(96, 326),
(97, 330),
(98, 336),
(99, 337),
(100, 338),
(101, 343),
(102, 344),
(103, 345),
(104, 346),
(105, 347),
(106, 348),
(107, 349),
(108, 350),
(109, 351),
(110, 352),
(111, 353),
(112, 354),
(113, 355),
(114, 358),
(115, 360),
(116, 364),
(117, 367),
(118, 368),
(119, 369),
(120, 370),
(121, 371),
(122, 372),
(123, 373),
(124, 374),
(125, 375),
(126, 376),
(127, 377),
(128, 378),
(129, 379),
(130, 380),
(131, 384),
(132, 385),
(133, 386),
(134, 387),
(135, 389),
(136, 390),
(137, 391),
(138, 392),
(139, 393),
(140, 394),
(141, 395),
(142, 396),
(143, 397),
(144, 401),
(145, 404),
(146, 407),
(147, 411),
(148, 414),
(149, 416),
(150, 418),
(151, 419),
(152, 420),
(154, 422),
(155, 428),
(156, 429),
(157, 430),
(158, 431),
(159, 432),
(160, 436),
(161, 439),
(162, 440),
(163, 441),
(164, 442),
(165, 448),
(166, 451),
(167, 452),
(168, 453),
(169, 454),
(170, 455),
(171, 456),
(172, 457),
(173, 458),
(174, 459),
(175, 460),
(176, 461),
(177, 462),
(178, 463),
(179, 465),
(180, 467),
(181, 468),
(182, 471),
(183, 473),
(184, 475),
(185, 478),
(186, 480),
(187, 482),
(188, 484),
(189, 485),
(190, 486),
(192, 489),
(193, 490),
(194, 491),
(195, 492),
(196, 494),
(197, 495),
(198, 496),
(199, 499),
(200, 500),
(201, 505),
(202, 506),
(203, 507),
(204, 508),
(205, 509),
(206, 510),
(207, 512),
(208, 513),
(209, 517),
(210, 520),
(211, 521),
(212, 522),
(213, 523),
(214, 524),
(215, 525),
(216, 530),
(217, 531),
(218, 532),
(219, 533),
(220, 534),
(221, 535),
(222, 536),
(223, 537),
(224, 540),
(225, 541),
(226, 546),
(227, 548),
(228, 550),
(229, 552),
(230, 554),
(231, 557),
(232, 559),
(233, 560),
(234, 561),
(235, 562),
(236, 563),
(237, 564),
(238, 565),
(239, 566),
(240, 568),
(241, 569),
(242, 578),
(243, 579),
(244, 580),
(245, 582);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `allnames`
--
ALTER TABLE `allnames`
  ADD PRIMARY KEY (`nameid`);

--
-- Индексы таблицы `byers`
--
ALTER TABLE `byers`
  ADD PRIMARY KEY (`byers_id`),
  ADD KEY `byer_nameid` (`byers_nameid`);

--
-- Индексы таблицы `giveaways`
--
ALTER TABLE `giveaways`
  ADD PRIMARY KEY (`giveaways_id`),
  ADD KEY `requestid` (`requestid`);

--
-- Индексы таблицы `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payments_id`),
  ADD KEY `requestid` (`requestid`);

--
-- Индексы таблицы `pricings`
--
ALTER TABLE `pricings`
  ADD PRIMARY KEY (`pricingid`);

--
-- Индексы таблицы `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`requests_id`),
  ADD KEY `req_nameid` (`requests_nameid`);

--
-- Индексы таблицы `req_positions`
--
ALTER TABLE `req_positions`
  ADD PRIMARY KEY (`req_positionid`),
  ADD UNIQUE KEY `pos_name` (`pos_name`),
  ADD KEY `requestid` (`requestid`);

--
-- Индексы таблицы `sellers`
--
ALTER TABLE `sellers`
  ADD PRIMARY KEY (`sellers_id`),
  ADD KEY `seller_nameid` (`sellers_nameid`);

--
-- Индексы таблицы `trades`
--
ALTER TABLE `trades`
  ADD PRIMARY KEY (`trades_id`),
  ADD KEY `trade_nameid` (`trades_nameid`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `allnames`
--
ALTER TABLE `allnames`
  MODIFY `nameid` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=609;
--
-- AUTO_INCREMENT для таблицы `byers`
--
ALTER TABLE `byers`
  MODIFY `byers_id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;
--
-- AUTO_INCREMENT для таблицы `giveaways`
--
ALTER TABLE `giveaways`
  MODIFY `giveaways_id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT для таблицы `payments`
--
ALTER TABLE `payments`
  MODIFY `payments_id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT для таблицы `pricings`
--
ALTER TABLE `pricings`
  MODIFY `pricingid` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=554;
--
-- AUTO_INCREMENT для таблицы `requests`
--
ALTER TABLE `requests`
  MODIFY `requests_id` mediumint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;
--
-- AUTO_INCREMENT для таблицы `req_positions`
--
ALTER TABLE `req_positions`
  MODIFY `req_positionid` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=472;
--
-- AUTO_INCREMENT для таблицы `sellers`
--
ALTER TABLE `sellers`
  MODIFY `sellers_id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;
--
-- AUTO_INCREMENT для таблицы `trades`
--
ALTER TABLE `trades`
  MODIFY `trades_id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=246;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `byers`
--
ALTER TABLE `byers`
  ADD CONSTRAINT `byers_ibfk_1` FOREIGN KEY (`byers_nameid`) REFERENCES `allnames` (`nameid`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `giveaways`
--
ALTER TABLE `giveaways`
  ADD CONSTRAINT `giveaways_ibfk_1` FOREIGN KEY (`requestid`) REFERENCES `requests` (`requests_id`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`requestid`) REFERENCES `requests` (`requests_id`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `requests`
--
ALTER TABLE `requests`
  ADD CONSTRAINT `requests_ibfk_1` FOREIGN KEY (`requests_nameid`) REFERENCES `allnames` (`nameid`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `req_positions`
--
ALTER TABLE `req_positions`
  ADD CONSTRAINT `req_positions_ibfk_1` FOREIGN KEY (`requestid`) REFERENCES `requests` (`requests_id`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `sellers`
--
ALTER TABLE `sellers`
  ADD CONSTRAINT `sellers_ibfk_1` FOREIGN KEY (`sellers_nameid`) REFERENCES `allnames` (`nameid`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `trades`
--
ALTER TABLE `trades`
  ADD CONSTRAINT `trades_ibfk_1` FOREIGN KEY (`trades_nameid`) REFERENCES `allnames` (`nameid`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
