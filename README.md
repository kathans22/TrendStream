# TrendStream
# Project Setup Guide

## 1. Installation of XAMPP

To run this project, you need to install XAMPP. Follow the steps below:

- **Windows:**
  - Download XAMPP from (https://www.apachefriends.org/index.html).
  - Run the installer and follow the installation instructions.
  - Once installed, launch XAMPP Control Panel.

- **macOS:**
  - Download XAMPP from (https://www.apachefriends.org/index.html).
  - Open the downloaded .dmg file and drag the XAMPP folder to your Applications directory.
  - Launch XAMPP from the Applications folder.
- **Linux:**
  - Download XAMPP from [here](https://www.apachefriends.org/index.html).
  - Open your terminal and navigate to the directory where the downloaded file is located.
  - Give execute permissions to the downloaded installer using the command:
    ```
    chmod +x [xampp-installer-filename].run
    ```
  - Run the installer with the command:
    ```
    sudo ./[xampp-installer-filename].run
    ```
  - Follow the installation instructions provided by the installer.


## 2. Starting XAMPP

Follow these steps to start XAMPP:

1. Open XAMPP Control Panel.
2. Start the Apache and MySQL modules by clicking on the "Start" button next to them.
3. Once both modules are running, you can proceed with the next steps.

## 3. Database Setup

After starting XAMPP, navigate to http://localhost/phpmyadmin/ in your web browser.

1. Create a new database named `test`.
2. In the SQL tab of the newly created `test` database, execute the following MySQL commands:

```sql
-- Sample SQL commands to run in the `test` database
-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2024 at 07:59 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `blog_id` int(11) NOT NULL,
  `usid` int(11) NOT NULL,
  `bcid` int(11) NOT NULL,
  `blog_title` varchar(500) NOT NULL,
  `blog_cover_photo` varchar(10000) NOT NULL,
  `blog_content` longtext NOT NULL,
  `blog_status` varchar(100) NOT NULL,
  `blog_post_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `lcode` varchar(100) NOT NULL,
  `blog_view` int(11) NOT NULL,
  `tags` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`blog_id`, `usid`, `bcid`, `blog_title`, `blog_cover_photo`, `blog_content`, `blog_status`, `blog_post_time`, `lcode`, `blog_view`, `tags`) VALUES
(2, 44, 7, ' new post', 'Screenshot (2).png', '<p>New blog</p>\n', 'deleted', '2023-06-11 06:07:58', 'ar-SA', 11, ''),
(3, 44, 12, 'hhisiks', 'Screenshot (4).png', '', 'posted', '2023-04-05 16:50:56', 'bo-CN', 0, ''),
(4, 14, 14, 'newblog', 'Screenshot (2).png', '', 'posted', '2023-04-05 18:56:20', 'bem-ZM', 0, ''),
(5, 44, 14, 'newblog', 'Screenshot (2).png', '', 'drafted', '2023-06-06 19:19:14', 'bem-ZM', 0, ''),
(6, 14, 18, 'new blog', 'Screenshot (2).png', '', 'posted', '2023-06-09 06:14:30', 'ar-SA', 1, ''),
(7, 44, 18, 'new blog', 'Screenshot (2).png', '', 'deleted', '2023-04-06 10:51:25', 'ar-SA', 0, ''),
(8, 44, 11, 'college blog', 'Screenshot (3).png', '', 'deleted', '2023-04-06 10:50:39', 'be-BY', 0, ''),
(9, 44, 7, 'NEW BLOG1', 'Screenshot (24).png', '<figure class=\"easyimage easyimage-side\"><img alt=\"\" src=\"blob:http://localhost/9e1d57ee-2837-48c3-a948-b1d8810838d3\" width=\"1920\" />\n<figcaption></figcaption>\n</figure>\n\n<p><span style=\"font-size:20px\">new blog&nbsp;</span></p>\n\n<p>skskzasa san,mazodka/x ;xuhjdiahxduhdhidoqjc&nbsp; nvbsjcj C IUQWNCOB .es</p>\n\n<p>dhcfmdaxMXAJDCM SXGB JFHB VKJNBDSLKHCN X ,JMBB NIEUE NFN&nbsp; NF2N2 FW&nbsp;</p>\n\n<ol>\n	<li>DHD,NJCC</li>\n	<li>GHDSUHYXZVJ</li>\n	<li>ADCCG YXHNGXZ</li>\n</ol>\n\n<p><span style=\"font-size:20px\"><strong>ghgasghsavxhjagx</strong></span></p>\n\n<ul>\n	<li><span style=\"font-size:11px\">shsjusjbadsb</span></li>\n	<li><span style=\"font-size:11px\">hudfviuhjwdf</span></li>\n	<li><span style=\"font-size:11px\">dfjbnbcx&nbsp;&nbsp;</span></li>\n</ul>\n', 'deleted', '2023-05-03 12:59:16', 'ar-SA', 1, ''),
(10, 44, 14, 'new blog111', 'Screenshot (5).png', '<figure class=\"easyimage easyimage-side\"><img alt=\"\" src=\"blob:http://localhost/25e7baf8-ebf9-44f3-a611-2470ad90ba39\" width=\"1920\" />\n<figcaption></figcaption>\n</figure>\n\n<p><span style=\"font-size:20px\">new blog&nbsp;</span></p>\n\n<figure class=\"easyimage easyimage-full\"><img alt=\"\" src=\"blob:http://localhost/ab664005-f0d6-451c-b1fc-959969defd7f\" width=\"1920\" />\n<figcaption></figcaption>\n</figure>\n\n<p><span style=\"font-size:11px\">dfjbnbcx&nbsp;&nbsp;</span></p>\n', 'deleted', '2023-04-13 05:04:42', 'am-ET', 0, ''),
(11, 44, 4, 'ggsjs', 'Screenshot (5).png', '<figure class=\"easyimage easyimage-side\"><img alt=\"\" src=\"blob:http://localhost/9e1d57ee-2837-48c3-a948-b1d8810838d3\" width=\"1920\" />\n<figcaption></figcaption>\n</figure>\n\n<p><span style=\"font-size:20px\">new blog&nbsp;</span></p>\n\n<figure class=\"easyimage easyimage-side\"><img alt=\"\" src=\"blob:http://localhost/bb2eb3a3-0313-4585-9cf1-5dd29ec3a390\" width=\"1920\" />\n<figcaption></figcaption>\n</figure>\n\n<figure class=\"easyimage easyimage-full\"><img alt=\"\" src=\"blob:http://localhost/ab664005-f0d6-451c-b1fc-959969defd7f\" width=\"1920\" />\n<figcaption></figcaption>\n</figure>\n\n<p><span style=\"font-size:11px\">dfjbnbcx&nbsp;&nbsp;</span></p>\n', 'deleted', '2023-04-13 05:04:59', 'bi-VU', 0, ''),
(12, 44, 4, 'ggsjs', 'Screenshot (5).png', '<figure class=\"easyimage easyimage-side\"><img alt=\"\" src=\"blob:http://localhost/9e1d57ee-2837-48c3-a948-b1d8810838d3\" width=\"1920\" />\n<figcaption></figcaption>\n</figure>\n\n<p><span style=\"font-size:20px\">new blog&nbsp;</span></p>\n\n<figure class=\"easyimage easyimage-side\"><img alt=\"\" src=\"blob:http://localhost/bb2eb3a3-0313-4585-9cf1-5dd29ec3a390\" width=\"1920\" />\n<figcaption></figcaption>\n</figure>\n\n<figure class=\"easyimage easyimage-full\"><img alt=\"\" src=\"blob:http://localhost/ab664005-f0d6-451c-b1fc-959969defd7f\" width=\"1920\" />\n<figcaption></figcaption>\n</figure>\n\n<p><span style=\"font-size:11px\">dfjbnbcx&nbsp;&nbsp;</span></p>\n', 'deleted', '2023-05-03 13:07:50', 'bi-VU', 1, ''),
(13, 44, 5, 'gdhhdhskls', 'Screenshot (3).png', '<p>jhgghhg</p>\n\n<figure class=\"easyimage easyimage-full\"><img alt=\"\" src=\"blob:http://localhost/5a2b3177-6b91-4e26-9f63-d5cac39a1ec2\" width=\"1920\" />\n<figcaption></figcaption>\n</figure>\n\n<p>&nbsp;</p>\n', 'posted', '2023-04-07 05:13:47', 'be-BY', 0, ''),
(14, 44, 12, 'Northeast India a piece of heaven ', 'Screenshot (514).png', '<p>Northeast India is an exotic land.&nbsp;<strong>Being a North-Eastern girl myself</strong>, I can vouch for the fact that&nbsp;<a href=\"https://www.lonelyplanet.com/india/northeast-states\">Northeast India</a>&nbsp;is unique and a land full of surprises. The unbeatable hospitality of the people, jaw-dropping natural beauty, cloud laden landscapes, Eco-friendly lifestyles, and enriching history of the land will surely make you wander in the distant land at least once.</p>\n\n<p>Though north-eastern states have been getting a fair share of the spotlight in the tourist map of India lately, it is still considered as a remote part of India by many. Apart from the famous festivals like&nbsp;<strong><em><a href=\"https://www.traveldiaryparnashree.com/2019/01/in-pictures-fascinating-faces-from-hornbill-festival-in-nagaland.html\">Hornbill</a>, Ziro, NH7 Weekender, Tawang, Orange, Sangai, Bihu, etc.</em></strong><em>,&nbsp;</em>people are not aware of the social fabric and the rich cultural heritage of Northeast India.</p>\n\n<p>Due to a lack of knowledge about this region and inadequate information available on the internet, there are a lot of presumptions about this exotic part of India. Only well-traveled nomads and hard-core travelers have explored the remote parts of this region.</p>\n\n<p>Though, states like&nbsp;<strong><em><a href=\"https://www.traveldiaryparnashree.com/category/destinations/india/north-east/meghalaya\">Meghalaya</a>,&nbsp;<a href=\"https://www.traveldiaryparnashree.com/category/destinations/india/north-east/arunachal-pradesh\">Arunachal Pradesh</a>,&nbsp;</em></strong>and<a href=\"https://en.wikipedia.org/wiki/Nagaland\"><strong><em>&nbsp;Nagaland</em></strong></a>&nbsp;have become popular due to their famous music festivals, which draw hundreds of music lovers and tourists to this part of India each year. But, Northeast India tourism is not all about jazz and music festivals. This is a fascinating region, known for its rustic beauty, deep-rooted history, age-old traditions,<strong>&nbsp;and tribal communities.</strong></p>\n\n<p>The way of life of each tribal community is way different from others. The beauty of this far land is that you will get to see diversity at its best. Whether it is the language, attire, rituals, beliefs, or food, every tribal community has its own lifestyle and it is way too different from the rest of them.&nbsp;<strong>It is quite intriguing and overwhelming for people who travel to this region for the very first time.</strong></p>\n\n<p>The biggest river island, lush tea gardens, gushing waterfalls, hidden caves, natural root bridges, monasteries, endangered animals, cleanest villages,&nbsp; wilderness in the national parks, virgin scenic landscapes, stilt houses or gripping story of headhunters and their way of life.</p>\n\n<p>Northeast India can take you on a journey of a unique expedition like never before.&nbsp; Bordered by Bhutan, China, Bangladesh, and Myanmar, Northeast India consists of 8 states &ndash;<strong><em>Arunachal Pradesh, Assam, Manipur, Meghalaya, Mizoram, Nagaland, Sikkim, and Tripura</em></strong>.</p>\n\n<p>&nbsp;</p>\n\n<p>To visit Northeast India, you are required to obtain an&nbsp;<strong>ILP (for Indian Nationals &amp; Foreign Nationals) and PAP (only for Foreign Nationals) for a few states, due to its strategic and sensitive locations, bordering with Bhutan, China, and Myanmar.</strong></p>\n\n<p><strong>The government has modified rules on permits to promote Northeast tourism in the region. You still need to check on the states for permit information before you plan your first Northeast India trip. However, no permits (ILP and PAP) are required to visit Assam, Meghalaya, and Tripura.</strong></p>\n\n<p>&nbsp;</p>\n\n<p>Apart from these states, other north-eastern states like&nbsp;<strong>Arunachal Pradesh and Sikkim&nbsp;</strong>require&nbsp;<strong>ILP</strong>&nbsp;for Indian tourists and&nbsp;<strong>PAP&nbsp;</strong>for Foreign Nationals. For states like&nbsp;<strong>Mizoram</strong>, Manipur, Nagaland, Foreign nationals need to register themselves at the local Foreigner Registration Office (FRO) of the districts they visit within 24 hours of arrival.</p>\n\n<p>It is to be noted that Nathula Pass and Gurudongmar Lake are off-limits<strong>&nbsp;to foreign nationals completely. Also,&nbsp;</strong>citizens of&nbsp;<strong>Afghanistan, China, and Pakistan&nbsp;</strong>require prior approval of the Ministry of Home Affairs, Government of India, before entering the state of&nbsp;<strong>Mizoram.</strong></p>\n\n<p>The cost of the permits varies from state to state. The basic requirements for ILP and PAP for foreign nationals are copies of passport, visa, passport size photographs, and flight tickets. For Indian nationals, you need to produce passport size photographs and valid photo identity proof (Voter ID/ Aadhaar Card).&nbsp;</p>\n\n<p><img alt=\"\" src=\"blob:http://localhost/5a2b3177-6b91-4e26-9f63-d5cac39a1ec2\" width=\"1920\" /></p>\n\n<p>&nbsp;</p>\n', 'posted', '2023-06-11 06:04:50', 'en-GB', 6, 'northeast,river rafting,tracking,adventure,jungle safari,tea plantation,nature,travel,lifestyle'),
(15, 44, 13, 'Well-Being & Happiness', 'laughter1.png', '<p>હાસ્ય એ શ્રેષ્ઠ દવા છે સારું હાસ્ય શેર કરવામાં મજા આવે છે, પરંતુ શું તમે જાણો છો કે તે ખરેખર તમારા સ્વાસ્થ્યને સુધારી શકે છે? હાસ્ય અને રમૂજના શક્તિશાળી લાભોનો ઉપયોગ કેવી રીતે કરવો તે જાણો.</p>\n\n<h2 style=\"text-align:start\"><strong><span style=\"font-size:14px\"><span style=\"color:#045346\"><span style=\"background-color:#fffefc\">હાસ્યના ફાયદા</span></span></span></strong></h2>\n\n<p style=\"text-align:start\"><span style=\"font-size:14px\"><span style=\"font-family:Inter,sans-serif\"><span style=\"color:#656667\"><span style=\"background-color:#fffefc\">તે સાચું છે: હાસ્ય મજબૂત દવા છે.&nbsp;તે લોકોને એવી રીતે એકસાથે ખેંચે છે જે શરીરમાં સ્વસ્થ શારીરિક અને ભાવનાત્મક ફેરફારોને ટ્રિગર કરે છે.&nbsp;હાસ્ય તમારી રોગપ્રતિકારક શક્તિને મજબૂત બનાવે છે, મૂડમાં વધારો કરે છે, પીડા ઘટાડે છે અને તણાવની નુકસાનકારક અસરોથી તમારું રક્ષણ કરે છે.&nbsp;તમારા મન અને શરીરને ફરીથી સંતુલનમાં લાવવા માટે એક સારા હાસ્ય કરતાં વધુ ઝડપથી અથવા વધુ ભરોસાપાત્ર રીતે કંઈ કામ કરતું નથી.&nbsp;રમૂજ તમારા બોજને હળવો કરે છે, આશાને પ્રેરણા આપે છે, તમને અન્ય લોકો સાથે જોડે છે અને તમને ગ્રાઉન્ડેડ, ફોકસ્ડ અને સજાગ રાખે છે.&nbsp;તે તમને ગુસ્સો છોડવામાં અને જલ્દી માફ કરવામાં પણ મદદ કરે છે.</span></span></span></span></p>\n\n<p style=\"text-align:start\"><span style=\"font-size:14px\"><span style=\"font-family:Inter,sans-serif\"><span style=\"color:#656667\"><span style=\"background-color:#fffefc\">મટાડવું અને નવીકરણ કરવાની ઘણી શક્તિ સાથે, સરળતાથી અને વારંવાર હસવાની ક્ષમતા એ સમસ્યાઓને દૂર કરવા, તમારા સંબંધોને વધારવા અને શારીરિક અને ભાવનાત્મક સ્વાસ્થ્ય બંનેને ટેકો આપવા માટે એક જબરદસ્ત સ્ત્રોત છે.&nbsp;સૌથી શ્રેષ્ઠ, આ અમૂલ્ય દવા મનોરંજક, મફત અને ઉપયોગમાં સરળ છે.</span></span></span></span></p>\n\n<p style=\"text-align:start\"><span style=\"font-size:14px\"><span style=\"font-family:Inter,sans-serif\"><span style=\"color:#656667\"><span style=\"background-color:#fffefc\">બાળકો તરીકે, અમે દિવસમાં સેંકડો વખત હસતા હતા, પરંતુ પુખ્ત વયના લોકો તરીકે, જીવન વધુ ગંભીર અને હાસ્ય વધુ ભાગ્યે જ જોવા મળે છે.&nbsp;પરંતુ રમૂજ અને હાસ્ય માટે વધુ તકો શોધીને, તમે તમારા ભાવનાત્મક સ્વાસ્થ્યને સુધારી શકો છો, તમારા સંબંધોને મજબૂત કરી શકો છો, વધુ ખુશી મેળવી શકો છો - અને તમારા જીવનમાં વર્ષો ઉમેરી શકો છો.</span></span></span></span></p>\n\n<h3 style=\"text-align:start\"><span style=\"font-size:14px\"><span style=\"font-family:Inter,sans-serif\"><span style=\"color:#232426\"><span style=\"background-color:#fffefc\">હાસ્ય તમારા સ્વાસ્થ્ય માટે સારું છે</span></span></span></span></h3>\n\n<p style=\"text-align:start\"><span style=\"font-size:14px\"><span style=\"font-family:Inter,sans-serif\"><span style=\"color:#656667\"><span style=\"background-color:#fffefc\"><strong>હાસ્ય આખા શરીરને આરામ આપે છે.&nbsp;</strong>સારું, હાર્દિક હાસ્ય શારીરિક તાણ અને તાણને દૂર કરે છે, જે પછી તમારા સ્નાયુઓને 45 મિનિટ સુધી આરામ આપે છે.</span></span></span></span></p>\n\n<p style=\"text-align:start\"><span style=\"font-size:14px\"><span style=\"font-family:Inter,sans-serif\"><span style=\"color:#656667\"><span style=\"background-color:#fffefc\"><strong>હાસ્ય રોગપ્રતિકારક શક્તિને વધારે છે.&nbsp;</strong>હાસ્ય સ્ટ્રેસ હોર્મોન્સ ઘટાડે છે અને રોગપ્રતિકારક કોષો અને ચેપ સામે લડતા એન્ટિબોડીઝમાં વધારો કરે છે, આમ રોગ સામે તમારી પ્રતિકારક શક્તિમાં સુધારો કરે છે.</span></span></span></span></p>\n\n<p style=\"text-align:start\"><span style=\"font-size:14px\"><span style=\"font-family:Inter,sans-serif\"><span style=\"color:#656667\"><span style=\"background-color:#fffefc\"><strong>હાસ્ય એ એન્ડોર્ફિન્સના પ્રકાશનને ઉત્તેજિત કરે છે,</strong>&nbsp;જે શરીરના કુદરતી ફીલ-ગુડ રસાયણો છે.&nbsp;એન્ડોર્ફિન્સ એકંદરે સુખાકારીની ભાવનાને પ્રોત્સાહન આપે છે અને અસ્થાયી રૂપે પીડાને દૂર કરી શકે છે.</span></span></span></span></p>\n\n<p style=\"text-align:start\"><span style=\"font-size:14px\"><span style=\"font-family:Inter,sans-serif\"><span style=\"color:#656667\"><span style=\"background-color:#fffefc\"><strong>હાસ્ય હૃદયનું રક્ષણ કરે છે.&nbsp;</strong>હાસ્ય રક્તવાહિનીઓના કાર્યમાં સુધારો કરે છે અને રક્ત પ્રવાહમાં વધારો કરે છે, જે તમને હાર્ટ એટેક અને અન્ય કાર્ડિયોવેસ્ક્યુલર સમસ્યાઓ સામે રક્ષણ કરવામાં મદદ કરી શકે છે.</span></span></span></span></p>\n\n<p style=\"text-align:start\"><span style=\"font-size:14px\"><span style=\"font-family:Inter,sans-serif\"><span style=\"color:#656667\"><span style=\"background-color:#fffefc\"><strong>હાસ્ય કેલરી બર્ન કરે છે.&nbsp;</strong>ઠીક છે, તેથી તે જીમમાં જવા માટે કોઈ રિપ્લેસમેન્ટ નથી, પરંતુ એક અભ્યાસમાં જાણવા મળ્યું છે કે દિવસમાં 10 થી 15 મિનિટ સુધી હસવાથી લગભગ 40 કેલરી બર્ન થઈ શકે છે - જે એક વર્ષ દરમિયાન ત્રણ અથવા ચાર પાઉન્ડ ગુમાવવા માટે પૂરતી હોઈ શકે છે.</span></span></span></span></p>\n\n<p style=\"text-align:start\"><span style=\"font-size:14px\"><span style=\"font-family:Inter,sans-serif\"><span style=\"color:#656667\"><span style=\"background-color:#fffefc\"><strong>હાસ્ય ક્રોધનો ભાર હળવો કરે છે</strong>&nbsp;.&nbsp;શેર કરેલા હાસ્ય કરતાં ગુસ્સો અને સંઘર્ષને વધુ ઝડપથી પ્રસરે છે.&nbsp;રમુજી બાજુને જોવું સમસ્યાઓને પરિપ્રેક્ષ્યમાં મૂકી શકે છે અને કડવાશ કે રોષને પકડી રાખ્યા વિના મુકાબલોમાંથી આગળ વધવા માટે સક્ષમ બનાવે છે.</span></span></span></span></p>\n\n<p style=\"text-align:start\"><span style=\"font-size:14px\"><span style=\"font-family:Inter,sans-serif\"><span style=\"color:#656667\"><span style=\"background-color:#fffefc\"><strong>હાસ્ય તમને લાંબુ જીવવામાં પણ મદદ કરી શકે છે.&nbsp;</strong>નોર્વેમાં થયેલા એક અભ્યાસમાં જાણવા મળ્યું છે કે રમૂજની ગજબની ભાવના ધરાવતા લોકો તે લોકો કરતાં વધુ જીવે છે જેઓ વધુ હસતા નથી.&nbsp;કેન્સર સામે લડતા લોકો માટે આ તફાવત ખાસ કરીને નોંધપાત્ર હતો.</span></span></span></span></p>\n\n<h2 style=\"text-align:start\"><span style=\"font-size:14px\"><span style=\"color:#045346\"><span style=\"background-color:#fffefc\">હાસ્યના શારીરિક, માનસિક અને સામાજિક ફાયદા શું છે?</span></span></span></h2>\n\n<h3 style=\"text-align:start\"><span style=\"font-size:14px\"><span style=\"font-family:Inter,sans-serif\"><span style=\"color:#232426\"><span style=\"background-color:#fffefc\">શારીરિક સ્વાસ્થ્ય લાભ</span></span></span></span></h3>\n\n<ul>\n	<li><span style=\"font-size:14px\">રોગપ્રતિકારક શક્તિ વધારે છે</span></li>\n	<li><span style=\"font-size:14px\">સ્ટ્રેસ હોર્મોન્સ ઘટાડે છે</span></li>\n	<li><span style=\"font-size:14px\">પીડા ઘટાડે છે</span></li>\n	<li><span style=\"font-size:14px\">તમારા સ્નાયુઓને આરામ આપે છે</span></li>\n	<li><span style=\"font-size:14px\">હૃદય રોગથી બચાવે છે</span></li>\n</ul>\n\n<h3 style=\"text-align:start\"><span style=\"font-size:14px\"><span style=\"font-family:Inter,sans-serif\"><span style=\"color:#232426\"><span style=\"background-color:#fffefc\">માનસિક સ્વાસ્થ્ય લાભ</span></span></span></span></h3>\n\n<ul>\n	<li><span style=\"font-size:14px\">જીવનમાં આનંદ અને ઉત્સાહ ઉમેરે છે</span></li>\n	<li><span style=\"font-size:14px\">ચિંતા અને તાણ હળવી કરે છે</span></li>\n	<li><span style=\"font-size:14px\">તણાવ દૂર કરે છે</span></li>\n	<li><span style=\"font-size:14px\">મૂડ સુધારે છે</span></li>\n	<li><span style=\"font-size:14px\">સ્થિતિસ્થાપકતાને મજબૂત બનાવે છે</span></li>\n</ul>\n\n<h3 style=\"text-align:start\"><span style=\"font-size:14px\"><span style=\"font-family:Inter,sans-serif\"><span style=\"color:#232426\"><span style=\"background-color:#fffefc\">સામાજિક લાભ</span></span></span></span></h3>\n\n<ul>\n	<li><span style=\"font-size:14px\">સંબંધોને મજબૂત બનાવે છે</span></li>\n	<li><span style=\"font-size:14px\">બીજાને આપણી તરફ આકર્ષે છે</span></li>\n	<li><span style=\"font-size:14px\">ટીમ વર્ક વધારે છે</span></li>\n	<li><span style=\"font-size:14px\">સંઘર્ષને દૂર કરવામાં મદદ કરે છે</span></li>\n	<li><span style=\"font-size:14px\">જૂથ બંધનને પ્રોત્સાહન આપે છે</span></li>\n</ul>\n\n<h2 style=\"text-align:start\"><span style=\"font-size:14px\"><span style=\"color:#045346\"><span style=\"background-color:#fffefc\">હાસ્ય તમને માનસિક રીતે સ્વસ્થ રહેવામાં મદદ કરે છે</span></span></span></h2>\n\n<p style=\"text-align:start\"><span style=\"font-size:14px\"><span style=\"font-family:Inter,sans-serif\"><span style=\"color:#656667\"><span style=\"background-color:#fffefc\">હાસ્ય તમને સારું લાગે છે.&nbsp;અને આ હકારાત્મક લાગણી હાસ્ય શમી ગયા પછી પણ તમારી સાથે રહે છે.&nbsp;રમૂજ તમને મુશ્કેલ પરિસ્થિતિઓ, નિરાશાઓ અને નુકસાનમાંથી સકારાત્મક, આશાવાદી દૃષ્ટિકોણ રાખવામાં મદદ કરે છે.</span></span></span></span></p>\n\n<p style=\"text-align:start\"><span style=\"font-size:14px\"><span style=\"font-family:Inter,sans-serif\"><span style=\"color:#656667\"><span style=\"background-color:#fffefc\">ઉદાસી અને પીડામાંથી રાહત મેળવવા કરતાં વધુ, હાસ્ય તમને અર્થ અને આશાના નવા સ્ત્રોતો શોધવાની હિંમત અને શક્તિ આપે છે.&nbsp;સૌથી મુશ્કેલ સમયમાં પણ, એક હાસ્ય&ndash;અથવા તો ખાલી સ્મિત&ndash;તમને સારું લાગે તે તરફ ખૂબ આગળ વધી શકે છે.&nbsp;અને હાસ્ય ખરેખર ચેપી છે - માત્ર હાસ્ય સાંભળવાથી તમારું મગજ પ્રબળ બને છે અને તમને હસવા અને આનંદમાં જોડાવા માટે તૈયાર કરે છે.</span></span></span></span></p>\n\n<p>&nbsp;</p>\n', 'posted', '2023-04-07 05:13:52', 'gu-IN', 0, 'laughter,medicine,well being,happiness,mental strength'),
(16, 44, 4, 'Who, What, Why, & How of Digital Marketing', 'digitalmarket1.jpg', '<p>With how accessible the internet is today, would you believe me if I told you the number of people who go online every day is&nbsp;<em>still</em>&nbsp;increasing?</p>\n\n<p>It is. In fact, there are about 4.9 billion global internet users as of 2021, a&nbsp;<a href=\"https://www.statista.com/statistics/273018/number-of-internet-users-worldwide/\" rel=\"noopener\" target=\"_blank\">400 million jump from 2020</a>. And although we say it a lot, the way people shop and buy really has changed along with it &mdash; meaning offline marketing can&rsquo;t be your only strategy for driving sales because you need to meet audiences where they&rsquo;re already spending time: on the internet.&nbsp;</p>\n\n<p>Marketing has always been about connecting with your audience in the right place and at the right time. Today, that means you need to meet them where they are already spending time: on the internet.</p>\n\n<p>A seasoned inbound marketer might say inbound marketing and digital marketing are virtually the same thing, but there are some minor differences. And conversations with marketers and business owners in the U.S., U.K., Asia, Australia, and New Zealand, I&#39;ve learned a lot about how those small differences are being observed across the world.</p>\n\n<h3>How does a business define digital marketing?</h3>\n\n<p>At this stage, digital marketing is vital for your business and brand awareness. It seems like every other brand has a website, and if they don&#39;t, they at least have a social media presence or digital ad strategy. Digital content and marketing is so common that consumers now expect and rely on it as a way to learn about brands. Because digital marketing has so many possibilities, you can get creative and experiment with a variety of marketing tactics on a budget.</p>\n\n<p>Overall, digital marketing is defined by using numerous digital tactics and channels to connect with customers where they spend much of their time: online. The best digital marketers have a clear picture of how each digital marketing campaign supports their overarching goals. And depending on the goals of their marketing strategy, marketers can support a larger campaign through the free and paid channels at their disposal.</p>\n\n<p>A content marketer, for example, could create a series of blog posts that&nbsp;<a href=\"https://blog.hubspot.com/marketing/beginner-inbound-lead-generation-guide-ht?_ga=2.9199479.315972660.1668017381-8813612.1668017381&amp;hubs_content=blog.hubspot.com/marketing/what-is-digital-marketing&amp;hubs_content-cta=generate+leads\" rel=\"noopener\" target=\"_blank\">generate leads</a>&nbsp;from an ebook. A social media marketer might help promote those blogs through paid and organic posts on the&nbsp;<a href=\"https://blog.hubspot.com/marketing/social-media-marketing?_ga=2.9199479.315972660.1668017381-8813612.1668017381&amp;hubs_content=blog.hubspot.com/marketing/what-is-digital-marketing&amp;hubs_content-cta=business%27s+social+media+accounts\" rel=\"noopener\" target=\"_blank\">business&#39;s social media accounts</a>, and the email marketer could create an&nbsp;<a href=\"https://blog.hubspot.com/marketing/email-marketing-guide?_ga=2.9199479.315972660.1668017381-8813612.1668017381&amp;hubs_content=blog.hubspot.com/marketing/what-is-digital-marketing&amp;hubs_content-cta=email+campaign\" rel=\"noopener\" target=\"_blank\">email campaign</a>&nbsp;to send those who download the ebook more information on the company. We&#39;ll talk more about these specific digital marketers in a minute.</p>\n\n<h2>Why is digital marketing important?</h2>\n\n<p>Digital marketing helps you reach a larger audience than you could through traditional methods and target the prospects who are most likely to buy your product or service. Additionally, it&#39;s often more cost-effective than traditional advertising and enables you to measure success on a daily basis and pivot as you see fit.</p>\n\n<p>&nbsp;</p>\n\n<p>There are a few major benefits of digital marketing:&nbsp;</p>\n\n<ol>\n	<li>\n	<p>You can focus your efforts on&nbsp;<em>only&nbsp;</em>the prospects most likely to purchase your product or service.</p>\n	</li>\n	<li>\n	<p>It&#39;s more cost-effective than&nbsp;<a href=\"https://blog.hubspot.com/blog/tabid/6307/bid/2989/inbound-marketing-vs-outbound-marketing.aspx?hubs_content=blog.hubspot.com/marketing/what-is-digital-marketing&amp;hubs_content-cta=outbound+marketing+methods\" rel=\"noopener\" target=\"_blank\">outbound marketing methods</a>.</p>\n	</li>\n	<li>\n	<p>Digital marketing evens the playing field within your industry and allows you to compete with bigger brands.</p>\n	</li>\n	<li>\n	<p>Digital marketing is measurable.</p>\n	</li>\n	<li>\n	<p>It&rsquo;s easier to adapt and change a digital marketing strategy.</p>\n	</li>\n	<li>\n	<p>Digital marketing can improve your&nbsp;<a href=\"https://blog.hubspot.com/marketing/top-cro-experts-questions?hubs_content=blog.hubspot.com/marketing/what-is-digital-marketing&amp;hubs_content-cta=conversion+rate\" rel=\"noopener\" target=\"_blank\">conversion rate</a>&nbsp;and the quality of your leads.</p>\n	</li>\n	<li>\n	<p>You can engage audiences at every stage with digital marketing.</p>\n	</li>\n</ol>\n\n<p>&nbsp;</p>\n\n<h4><strong>Website Traffic</strong></h4>\n\n<p>With digital marketing, you can see the exact number of people who have viewed your website&#39;s homepage in real-time by using&nbsp;<a href=\"https://www.hubspot.com/products/analytics?hubs_post=blog.hubspot.com/marketing/what-is-digital-marketing&amp;hubs_post-cta=digital+analytics+software&amp;_ga=2.8656887.315972660.1668017381-8813612.1668017381&amp;hubs_content=blog.hubspot.com/marketing/what-is-digital-marketing&amp;hubs_content-cta=digital+analytics+software\" rel=\"noopener\" target=\"_blank\">digital analytics software</a>&nbsp;available in marketing platforms like HubSpot.</p>\n\n<p>You can also see how many pages they visited, what device they were using, and where they came from, amongst other&nbsp;<a href=\"https://blog.hubspot.com/marketing/digital-marketing-analytics?hubs_content=blog.hubspot.com/marketing/what-is-digital-marketing&amp;hubs_content-cta=digital+analytics+data\" rel=\"noopener\" target=\"_blank\">digital analytics data</a>.</p>\n\n<p>This intelligence helps you prioritize which marketing channels to spend more or less time on based on the number of people those channels drive to your website. For example, if only 10% of your traffic is coming from organic search, you know that you probably need to spend some time on SEO to increase that percentage.</p>\n\n<p>With offline marketing, it can be difficult to tell how people interact with your brand before they interact with a salesperson or make a purchase. With digital marketing, you can identify&nbsp;<a href=\"https://www.businessnewsdaily.com/8564-future-of-marketing.html\" rel=\"noopener\" target=\"_blank\">trends and patterns</a>&nbsp;in people&#39;s behavior before they&#39;ve reached the final stage in their buyer&#39;s journey, meaning you can make more informed decisions about how to attract them to your website right at the top of the marketing funnel.</p>\n\n<h3><strong>It&rsquo;s easier to adapt and change a digital marketing strategy.</strong></h3>\n\n<p>A lot of work goes into developing a marketing strategy. Generally, you will follow through with that strategy until completion, allow it to take effect, and then judge its results. However, things do not always go according to plan. You may realize halfway through that a calculation was off, an assumption was incorrect, or an audience did not react how they were expected to. Being able to pivot or adjust the strategy along the way is highly beneficial because it prevents you from having to start over completely.</p>\n\n<p>Being able to change your strategy easily is a great benefit of digital marketing. Adapting a digital marketing strategy is a lot easier than other, more traditional forms of marketing, like mailers or billboard advertising. For instance, if an online ad isn&rsquo;t delivering as expected, you can quickly adjust it or pause it to yield better results.</p>\n\n<p><img alt=\"\" src=\"blob:http://localhost/bcba78e9-1564-4891-ab48-d2ff8152fe99\" width=\"1920\" /></p>\n\n<p>&nbsp;</p>\n', 'posted', '2023-04-07 05:15:04', 'en-GB', 0, 'digital marketing,technology,tech'),
(17, 44, 2, 'New Education Policy', 'New-Education-Policy1.jpg', '<p>New National Education Policy 2023: The New National Education Policy is a watershed moment in&nbsp;<strong><a href=\"https://leverageedu.com/blog/current-education-system-in-india/\">India&rsquo;s educational system.&nbsp;</a></strong>After 34 years of following the same norms, the Ministry of Education (previously known as MHRD) made significant changes to our education policy on July 29, 2020. The Indian government just adopted the New National Education Policy for 2023. Hence, it is only logical that the question &ldquo;What this New National Education Policy genuinely is?&rdquo; must be coming to people&rsquo;s minds. This is where our post comes in to help them find an answer. We will go through all of the major features of the New National Education Policy in this section. Also, we shall discuss the NEP 5+3+3+4 structure in detail. Hence, students who wish to comprehend the government&rsquo;s education policy should read this article.</p>\n\n<h2>Objective of New Education Policy 2023</h2>\n\n<p>The National Education Policy&rsquo;s primary purpose is to raise the standard of education in India to a global level, allowing the country to emerge as a leader in knowledge-based sectors. This goal is reached by the National Education Policy&rsquo;s universalization of education.</p>\n\n<p>To that purpose, the government has enacted various revisions to the former education policy as part of the National Education Policy 2023, with the goal of improving education quality and enabling children to have a good education.</p>\n\n<h3><strong>Principles of New Education Policy</strong></h3>\n\n<ol>\n	<li>Determine and nurture each child&rsquo;s potential.</li>\n	<li>Increase children&rsquo;s reading and numeracy knowledge</li>\n	<li>Providing flexible learning opportunities.</li>\n	<li>Spend money on public education.</li>\n	<li>Improve education quality</li>\n	<li>Introduce children to Indian culture.</li>\n	<li>Do excellent research, teach good governance, and empower children</li>\n	<li>Transparency in education policy</li>\n	<li>Emphasize the usage of technology and evaluate</li>\n	<li>Teach many languages</li>\n	<li>Improve your child&rsquo;s creativity and logical thinking.</li>\n</ol>\n\n<h2>Benefits of the New Education Policy 2023</h2>\n\n<p>The following are the benefits and features of this policy:</p>\n\n<ul>\n	<li>The former education policy has been replaced with the New National Education Policy, which was implemented by the Ministry of Education.</li>\n	<li>The Ministry of Human Resources will now be known as the Ministry of Education.</li>\n	<li>The national education policy will now make education universal, with the exception of medical and law studies.</li>\n	<li>Formerly, the pattern of 10 plus two was followed, however under the new education policy, the pattern of 5 + 3 + 3 + 4 will be adopted.</li>\n	<li>There was once a&nbsp;<strong><a href=\"https://leverageedu.com/blog/science-stream/\">Science</a></strong>,&nbsp;<strong><a href=\"https://leverageedu.com/blog/commerce-stream/\">Commerce</a></strong>, and<strong><a href=\"https://leverageedu.com/blog/arts-stream-subjects/\">&nbsp;Arts stream</a></strong>, however this will no longer be the case.</li>\n	<li>Students can study&nbsp;<strong><a href=\"https://leverageedu.com/blog/accounting-courses/\">accounting</a></strong>&nbsp;alongside physics or arts if they so desire.</li>\n	<li>In six standard,&nbsp;<a href=\"https://leverageedu.com/blog/computer-languages/\"><strong>computer languages</strong></a>&nbsp;will be taught to students.</li>\n	<li>Every schools will be outfitted with digital technology.</li>\n	<li>All forms of content will be translated into regional languages, and virtual labs will be built.</li>\n	<li>The NEP will cost 6% of GDP to execute.</li>\n	<li>If desired, the learner would be able to study Sanskrit and other ancient Indian languages.</li>\n	<li>Board exams will be held twice a year to relieve the student of the stress.</li>\n	<li><strong><a href=\"https://leverageedu.com/blog/masters-in-artificial-intelligence/\">Artificial intelligence</a></strong>&nbsp;software will also be utilised to facilitate learning.</li>\n	<li>The&nbsp;<strong><a href=\"https://leverageedu.com/blog/mphil/\">M. Phil degree</a></strong>&nbsp;from higher education is being phased out.</li>\n	<li>The pupil will be taught three languages determined by the state.</li>\n	<li>The National Council of Educational Research and Training will develop the national curricular framework for schooling.</li>\n	<li>Several institutions will be established to carry out the National Education Policy.</li>\n	<li>Particular emphasis will be placed on the children&rsquo;s education and talents.</li>\n</ul>\n\n<h2>The 5+3+3+4 Structure: What Does it Mean?</h2>\n\n<p>The replacement of the 10+2 structure with the 5+3+3+4 structure is the most eye-catching alteration in the NEP 2023. For a long period, the 10+2 has been used in our educational system. As a result, a total shift in that structure may be bewildering for the children. We will try to explain the meaning of the 5+3+3+4 structure and how it differs from the old 10+2 structure below.</p>\n\n<p>The administration has divided student education into four segments under the new Pedagogical and Circular Structure. Secondary, Middle, Preparatory, and Foundational are the four sections. These four stages of schooling will be critical components of students&rsquo; educational development throughout their school careers. The following is how these four stages of student education will be divided.</p>\n\n<ul>\n	<li>The Foundation Stage is the first step of education for children. Students will be groomed for 5 years in this programme. These five years will include three years of Anganwadi/Pre-Primary/Balvatika, as well as first and second grade.</li>\n	<li>The preparing stage will be the second stage. This stage of education will also span three years. The third, fourth, and fifth grades will lay the groundwork for the intermediate and secondary phases.</li>\n	<li>The third stage of education will be middle school. This is for students in grades 6th through 8th. These three years will prepare pupils for the ultimate part of their education, secondary school.</li>\n	<li>The secondary stage will be the final part of students&rsquo; schooling lives; instead of two years, students will have four years from Class 9th to Class 12th to complete their secondary education.</li>\n</ul>\n', 'posted', '2023-04-28 10:30:07', 'en-GB', 2, 'new policy,education,goverment,bjp'),
(18, 44, 10, 'Wimbledon 2023', 'Wimbledon1.jpg', '<p>June 19 (Reuters) - Wimbledon is a grasscourt Grand Slam managed by the All England Lawn Tennis Club (AELTC). The tournament was first held in 1877. Here is what you need to know about the year&#39;s third major after the Australian Open and French Open:</p>\n\n<h2>WHEN IS WIMBLEDON HAPPENING?</h2>\n\n<p>* This year&#39;s Wimbledon tournament runs from July 3-16.</p>\n\n<h2>WHERE IS WIMBLEDON TAKING PLACE?</h2>\n\n<p>* Wimbledon is held in London every year.</p>\n\n<p>* The three main showcourts at the All England Club are Centre Court, Court One and Court Two. Unlike other Grand Slam venues, the All England Club does not name its courts after former players.</p>\n\n<p>* Centre Court is the largest with a capacity of nearly 15,000 spectators.</p>\n\n<p>* Court One has a capacity of 12,345 while Court Two, nicknamed &#39;Graveyard of Champions&#39;, seats 4,000.</p>\n\n<h2>WHO IS INVOLVED IN WIMBLEDON?</h2>\n\n<p>* The top-ranked players automatically enter the main draw with 32 seeds announced prior to the draw to ensure they do not meet in the early rounds. From the 2021 Championships, seedings for the men&#39;s and ladies&#39; singles are based on world rankings.</p>\n\n<p>* Novak Djokovic is the men&#39;s world number one after claiming a&nbsp;<a href=\"https://www.reuters.com/sports/tennis/djokovic-claims-record-23rd-grand-slam-title-with-third-french-open-2023-06-11/\">23rd Grand Slam title</a>&nbsp;at the French Open. He will be defending his 2022 title.</p>\n\n<p>* Poland&#39;s Iga Swiatek, the French Open and U.S. Open champion, is the women&#39;s world number one. Swiatek&#39;s best finish at Wimbledon was in 2021, when she made the fourth round.</p>\n\n<p>* Kazakhstan&#39;s Elena Rybakina is the defending women&#39;s champion.</p>\n\n<p>* Organisers also hand out wild cards for local hopes and notable players who have dropped down the rankings.</p>\n\n<p>* Russian and Belarusian players will be allowed to take part in Wimbledon this year.</p>\n\n<p>Players from the two countries were banned from last year&#39;s tournament following Russia&#39;s invasion of Ukraine in February 2022, which Moscow calls a &quot;special military operation.&quot;</p>\n\n<p><img alt=\"\" src=\"blob:http://localhost/bcba78e9-1564-4891-ab48-d2ff8152fe99\" width=\"1920\" /></p>\n\n<p>&nbsp;</p>\n', 'posted', '2023-05-03 10:59:21', 'en-GB', 10, 'WIMBLEDON'),
(19, 44, 4, 'jvghjhg', 'Screenshot (4).png', '<figure class=\"easyimage easyimage-full\"><img alt=\"\" src=\"blob:http://localhost/cbf9fa20-8441-42c3-a2ee-88d4587b1e08\" width=\"1920\" />\n<figcaption></figcaption>\n</figure>\n\n<p>&nbsp;</p>\n', 'deleted', '2023-05-05 08:19:52', 'be-BY', 1, ''),
(20, 44, 18, 'Importance of fitness in our lifestyle', 'fitness3.jpg', '<p><img alt=\"\" src=\"blob:http://localhost/c9c38cc5-b2fd-42c5-a8af-4183d59756c7\" width=\"1920\" />We have always heard the words &lsquo;health&rsquo; and &lsquo;fitness&rsquo;. We use it ourselves when we say phrases like &lsquo;health is wealth&rsquo; and &lsquo;fitness is the key&rsquo;. What does the word health really mean? It implies the idea of &lsquo;being well&rsquo;. We call a person healthy and fit when he/she functions well physically as well as mentally.</p>\n\n<p>Factors affecting our health and fitness</p>\n\n<p>Good health and fitness is not something which one can achieve entirely on our own. It depends on their physical environment and the quality of food intake. We live in villages, towns, and cities.</p>\n\n<p>In such places, even our physical environment affects our health. Therefore, our social responsibility for a pollution-free environment directly affects our health. Our day-to-day habits also determine our fitness level. The quality of food, air, water all helps in building our fitness level.</p>\n\n<p>Role of nutritious diet on our health and fitness</p>\n\n<p>The first thing about where fitness starts is food. We should eat nutritious food. Food rich in protein, vitamins, minerals, and carbohydrates is very essential. Protein is necessary for body growth. Carbohydrates provide the required energy in performing various tasks. Vitamin and minerals help in building bones and boosting our immune system.</p>\n\n<p>However, taking food in uneven quantities is not good for the body. Taking essential nutrients in adequate amounts is called a balanced diet. Taking a balanced diet keeps the body and mind strong and healthy. Good food helps in better sleep, proper brain functioning and healthy body weight.</p>\n\n<p>Include vegetables, fruits, and pulses in daily diet. One must have a three-course meal. Having roughage helps in cleaning inner body organs. Healthy food habits prevent various diseases. Reducing the amount of fat in the diet prevents cholesterol and heart diseases.</p>\n\n<p>&nbsp;</p>\n', 'deleted', '2023-04-07 05:19:18', 'en-GB', 0, 'health,fitness,fitlifestyle,healthy,workout,gym,diet,juice,no to alcohols'),
(21, 44, 1, '7 ways to reduce plastic pollution..', 'nature1.webp', '<p><a href=\"https://www.un.org/en/un-chronicle/reducing-single-use-plastic-pollution-unified-approach\" target=\"_blank\">Ninety-one percent of all plastic produced</a>&nbsp;is designed for single-use purposes &mdash; used just once and then thrown away. Plastic takes hundreds of years to decompose, and it can release harmful chemicals into the environment. And despite growing awareness of how dangerous it is, plastic production is set to double in the next 20 years.</p>\n\n<p>This&nbsp;<a href=\"https://www.worldenvironmentday.global/\" target=\"_blank\">World Environment Day</a>, we&rsquo;re joining the global call to beat plastic pollution. Here are seven ways we&rsquo;re working hard to do that.</p>\n\n<h2>1. Making it easier to recycle</h2>\n\n<p>It can be difficult to figure out what personal items are recyclable &mdash; including plastic goods like bottles, bags or clothes &mdash; and where to recycle them.</p>\n\n<p>In 2021, we&nbsp;<a href=\"https://www.blog.google/outreach-initiatives/sustainability/power-recycling-turning-searches-store-visits/\">introduced</a>&nbsp;a new group of recycling attributes for Google Business Profiles on Search and Maps, allowing local storefronts and shops to show the recycling services they offer and helping people&nbsp;<a href=\"https://www.localguidesconnect.com/t5/Highlights/5-easy-ways-you-can-help-the-environment-on-Google-Maps/ba-p/3576121\" target=\"_blank\">share</a>&nbsp;this information with others in their community. Now you can search for nearby recycling drop-off locations &mdash; through searches like &quot;plastic bottle recycling near me&quot; &mdash; all over the world.</p>\n\n<h2>2. Helping people find pre-owned items</h2>\n\n<p>It&rsquo;s no secret that the fashion industry contributes significantly to emissions and waste: Clothing is responsible for about&nbsp;<a href=\"https://www.mckinsey.com/industries/retail/our-insights/fashion-on-climate\" target=\"_blank\">four percent</a>&nbsp;of carbon emissions. What&rsquo;s more, each year the fashion industry&nbsp;<a href=\"https://www.wired.co.uk/bc/article/fashion-industry-plastic-addiction-arch-and-hook\" target=\"_blank\">uses 342 million barrels of petroleum</a>&nbsp;to produce plastic-based fibers such as polyester, nylon or acrylic.</p>\n\n<p>We&rsquo;ve introduced new features in Google Shopping to help people make more sustainable fashion choices, like shopping for&nbsp;<a href=\"https://blog.google/products/search/new-ways-to-make-more-sustainable-choices/\">pre-owned items</a>. Within Search, you&rsquo;ll see labels that highlight pre-owned products so it&rsquo;s easier to make eco-friendlier shopping decisions.</p>\n\n<h2>3. Reducing waste with machine learning</h2>\n\n<p><a href=\"https://www.circularity-gap.world/2022\" target=\"_blank\">Less than 10%</a>&nbsp;of our global resources are recycled, and nearly a fifth of items that are sent to recycling plants aren&rsquo;t supposed to be there. This is made worse by inefficiencies and inaccuracies in the waste sorting processes at material recovery facilities.</p>\n\n<p>To help combat these issues, we introduced&nbsp;<a href=\"https://blog.tensorflow.org/2022/10/circularnet-reducing-waste-with-machine.html\" target=\"_blank\">CircularNet</a>, a set of machine learning and AI algorithms to support the way waste management facilities identify, sort, manage and recycle materials.</p>\n\n<p>We&rsquo;re continuing to improve the models in partnership with experts in the waste management and recycling industries. And we hope that, with time, CircularNet enables better and more efficient recycling strategies.</p>\n\n<h2>4. Supporting others focused on making change</h2>\n\n<p>We also know how important it is to support others with big ideas to tackle these challenges.&nbsp;<a href=\"http://google.org/\" target=\"_blank\">Google.org</a>&nbsp;grantee&nbsp;<a href=\"http://www.gringgo.co/\" target=\"_blank\">Gringgo</a>, for example, uses technology to improve waste management systems. They&rsquo;ve&nbsp;<a href=\"https://blog.google/outreach-initiatives/google-org/reduce-plastic-waste-indonesia/\">launched</a>&nbsp;a number of apps, including one for waste workers to track the amount and type of waste they collect. In their first year, the Gringgo team was able to improve recycling rates by 35% in their pilot village, Sanur Kaja in Bali.&nbsp;<a href=\"https://blog.google/around-the-globe/google-asia/sustainability-ngos-asia-pacific/\">Azure Alliance</a>, a recipient of the AVPN APAC Sustainability Seed Fund supported by Google.org, has taken a more hands-on approach. They&rsquo;ve developed the Azure Fighter, an unmanned and fully electric boat that snatches floating debris like plastic from harbors, lakes, ponds and waterways.</p>\n\n<p><a href=\"https://startup.google.com/\" target=\"_blank\">Google for Startups</a>&nbsp;has also sought out companies focused on using technology to solve sustainability challenges. Through an&nbsp;<a href=\"https://blog.google/outreach-initiatives/entrepreneurs/circular-economy-accelerator/\">accelerator</a>, the team provided mentoring and technical support to 11 startups focused on everything from food waste to fashion recycling and reuse. One company,&nbsp;<a href=\"https://www.nuvi-labs.com/\" target=\"_blank\">Nuvilab</a>, uses AI to analyze food waste and improve operational efficiency in restaurants across South Korea.</p>\n\n<h2>5. Using sustainable materials in our hardware</h2>\n\n<p>As part of our goal to achieve net-zero emissions across our operations and value chain &mdash; including consumer hardware products &mdash; by 2030, we&rsquo;ve focused on building&nbsp;<a href=\"https://blog.google/products/devices-services/a-look-at-how-were-building-more-sustainable-hardware/\">more sustainable hardware</a>.</p>\n\n<p>In 2022, approximately 30% of the materials used in new products we launched and manufactured were recycled content.<a href=\"https://blog.google/outreach-initiatives/sustainability/google-plastic-pollution-reduction/#footnote-1\" id=\"footnote-source-1\"><sup>1</sup></a>&nbsp;And as part of our commitment to plastic-free hardware packaging by 2025, our latest packaging for Pixel 7 uses 99% plastic-free materials.<a href=\"https://blog.google/outreach-initiatives/sustainability/google-plastic-pollution-reduction/#footnote-2\" id=\"footnote-source-2\"><sup>2</sup></a></p>\n\n<p>Beyond building more sustainably, we&rsquo;re also working to create&nbsp;<a href=\"https://www.blog.google/products/google-nest/nest-renew-general-availability/\">new products</a>&nbsp;and&nbsp;<a href=\"https://blog.google/products/devices-services/google-store-nyc-opening/\">retail spaces</a>&nbsp;that help reduce energy consumption, support clean energy and&nbsp;<a href=\"https://sustainability.google/progress/projects/ewaste-recycling/\" target=\"_blank\">reduce waste</a>. We also established a&nbsp;<a href=\"https://blog.google/outreach-initiatives/sustainability/pixel-phone-repairs/\">partnership</a>&nbsp;with iFixit to give our customers more phone repair options &mdash; and in turn, extend the life of each device.</p>\n\n<h2>6. Reducing the plastic in our offices</h2>\n\n<p>We want to show others a better way forward by becoming a&nbsp;<a href=\"https://sustainability.google/commitments/circular-economy/#a-circular-google\" target=\"_blank\">circular Google</a>. We&rsquo;re looking into swapping single-use disposable products in our onsite food service operations with more reusable solutions, whether it&rsquo;s snack wrappers or packaging used during distribution and delivery. Reducing, and ultimately eliminating, single-use plastics will help stem the tide of plastic polluting our planet.</p>\n\n<p>In April, we also launched our&nbsp;<a href=\"https://blog.google/outreach-initiatives/sustainability/single-use-plastics-challenge/\">Single-Use Plastics Challenge</a>, which gives food companies with packaging that&rsquo;s free of single-use plastic the opportunity to test their solutions in Google&#39;s U.S.-based cafes and kitchens.</p>\n\n<p>This work builds on our ongoing efforts to map out the types of single-use plastic products purchased through our supply chain and partner with distributors that use more reusable, durable containers to transport goods. We&rsquo;re also working with some of those companies to help them shift away from single-use plastics in their operations.</p>\n\n<h2>7. Visualizing plastic pollution</h2>\n\n<p>Plastic degrades into smaller pieces called microplastics, which then end up in the air we breathe. To highlight this concerning and dangerous process, Google Arts &amp; Culture worked with data artist Giorgia Lupi to visualize these particles in a virtual exhibit. The interactive&nbsp;<a href=\"https://artsexperiments.withgoogle.com/plasticair/\" target=\"_blank\">Plastic Air</a>&nbsp;experiment offers a glimpse into the composition of plastics in the air &mdash; a mix that could include, for example, granules from bottles, fragments from broken CDs or fibers from polyester textiles &mdash; and ways to take action.</p>\n\n<p><img alt=\"\" src=\"blob:http://localhost/c9c38cc5-b2fd-42c5-a8af-4183d59756c7\" width=\"1920\" /></p>\n\n<p>&nbsp;</p>\n', 'posted', '2023-05-05 11:57:29', 'en-GB', 2, 'pollution,plastic,hazardous,reduction'),
(22, 44, 10, 'abhay', 'Screenshot (26).png', '<p><span style=\"font-size:18px\"><strong>new laptop&nbsp;</strong></span></p>\n\n<ol>\n	<li>h1</li>\n	<li>h2</li>\n	<li>h3</li>\n	<li>h4</li>\n	<li>h5</li>\n	<li>h6</li>\n	<li>h7</li>\n</ol>\n\n<p><span style=\"font-size:14px\"><strong>laptop1&nbsp;</strong></span></p>\n\n<ul>\n	<li><span style=\"font-size:14px\">l1</span></li>\n	<li><span style=\"font-size:14px\">l2</span></li>\n	<li><span style=\"font-size:14px\">l3</span></li>\n	<li><span style=\"font-size:14px\">l4</span></li>\n	<li><span style=\"font-size:14px\">l5</span></li>\n	<li><span style=\"font-size:14px\">l6</span></li>\n	<li><span style=\"font-size:14px\">l7</span></li>\n</ul>\n\n<p><span style=\"font-size:14px\">x<sup>2&nbsp;</sup>+x<sup>2</sup>=2x<sup>2</sup></span></p>\n\n<table border=\"1\" cellpadding=\"1\" cellspacing=\"1\" style=\"width:500px\">\n	<tbody>\n		<tr>\n			<td>\n			<p>h1&nbsp;</p>\n			</td>\n			<td>\n			<p>h2</p>\n			</td>\n		</tr>\n		<tr>\n			<td>content1</td>\n			<td>content2</td>\n		</tr>\n		<tr>\n			<td>c1</td>\n			<td>c2</td>\n		</tr>\n	</tbody>\n</table>\n\n<p>&nbsp;</p>\n', 'deleted', '2023-04-07 08:48:06', 'ar-SA', 0, '');
INSERT INTO `blogs` (`blog_id`, `usid`, `bcid`, `blog_title`, `blog_cover_photo`, `blog_content`, `blog_status`, `blog_post_time`, `lcode`, `blog_view`, `tags`) VALUES
(23, 44, 2, 'Education', 'education2.jpg', '<p><strong>Education</strong>&nbsp;is a purposeful activity directed at achieving certain aims, such as transmitting&nbsp;<a href=\"https://en.wikipedia.org/wiki/Knowledge\" title=\"Knowledge\">knowledge</a>&nbsp;or fostering&nbsp;<a href=\"https://en.wikipedia.org/wiki/Skills\" title=\"Skills\">skills</a>&nbsp;and&nbsp;<a href=\"https://en.wikipedia.org/wiki/Character_trait\" title=\"Character trait\">character traits</a>. These aims may include the development of&nbsp;<a href=\"https://en.wikipedia.org/wiki/Understanding\" title=\"Understanding\">understanding</a>,&nbsp;<a href=\"https://en.wikipedia.org/wiki/Rationality\" title=\"Rationality\">rationality</a>,&nbsp;<a href=\"https://en.wikipedia.org/wiki/Kindness\" title=\"Kindness\">kindness</a>, and&nbsp;<a href=\"https://en.wikipedia.org/wiki/Honesty\" title=\"Honesty\">honesty</a>. Various researchers emphasize the role of&nbsp;<a href=\"https://en.wikipedia.org/wiki/Critical_thinking\" title=\"Critical thinking\">critical thinking</a>&nbsp;in order to distinguish education from&nbsp;<a href=\"https://en.wikipedia.org/wiki/Indoctrination\" title=\"Indoctrination\">indoctrination</a>. Some theorists require that education results in an improvement of the student while others prefer a value-neutral definition of the term. In a slightly different sense, education may also refer, not to the process, but to the product of this process: the&nbsp;<a href=\"https://en.wikipedia.org/wiki/Mental_state\" title=\"Mental state\">mental states</a>&nbsp;and dispositions possessed by educated people. Education&nbsp;<a href=\"https://en.wikipedia.org/wiki/History_of_education\" title=\"History of education\">originated</a>&nbsp;as the transmission of cultural heritage from one generation to the next. Today,&nbsp;<a href=\"https://en.wikipedia.org/wiki/Educational_aims_and_objectives\" title=\"Educational aims and objectives\">educational goals</a>&nbsp;increasingly encompass new ideas such as the&nbsp;<a href=\"https://en.wikipedia.org/wiki/Philosophy_of_education#Critical_theory\" title=\"Philosophy of education\">liberation of learners</a>,&nbsp;<a href=\"https://en.wikipedia.org/wiki/21st_century_skills\" title=\"21st century skills\">skills needed for modern society</a>,&nbsp;<a href=\"https://en.wikipedia.org/wiki/Empathy\" title=\"Empathy\">empathy</a>, and complex&nbsp;<a href=\"https://en.wikipedia.org/wiki/Vocational_skills\" title=\"Vocational skills\">vocational skills</a>.</p>\n\n<p>Types of education are commonly divided into&nbsp;<em>formal</em>,&nbsp;<a href=\"https://en.wikipedia.org/wiki/Non-formal_education\" title=\"Non-formal education\">non-formal</a>, and&nbsp;<a href=\"https://en.wikipedia.org/wiki/Informal_education\" title=\"Informal education\">informal education</a>. Formal education takes place in&nbsp;<a href=\"https://en.wikipedia.org/wiki/School\" title=\"School\">education and training institutions</a>, is usually structured by curricular aims and objectives, and learning is typically guided by a&nbsp;<a href=\"https://en.wikipedia.org/wiki/Teacher\" title=\"Teacher\">teacher</a>. In most regions,&nbsp;<a href=\"https://en.wikipedia.org/wiki/Compulsory_education\" title=\"Compulsory education\">formal education is compulsory</a>&nbsp;up to a certain age and commonly divided into&nbsp;<a href=\"https://en.wikipedia.org/wiki/Educational_stage\" title=\"Educational stage\">educational stages</a>&nbsp;such as&nbsp;<a href=\"https://en.wikipedia.org/wiki/Kindergarten\" title=\"Kindergarten\">kindergarten</a>,&nbsp;<a href=\"https://en.wikipedia.org/wiki/Primary_school\" title=\"Primary school\">primary school</a>&nbsp;and&nbsp;<a href=\"https://en.wikipedia.org/wiki/Secondary_school\" title=\"Secondary school\">secondary school</a>. Nonformal education occurs as addition or alternative to formal education.<sup><a href=\"https://en.wikipedia.org/wiki/Education#cite_note-1\">[1]</a></sup>&nbsp;It may be structured according to educational arrangements, but in a more flexible manner, and usually takes place in community-based, workplace-based or civil society-based settings. Lastly, informal education occurs in daily life, in the family, any&nbsp;<a href=\"https://en.wikipedia.org/wiki/Experience\" title=\"Experience\">experience</a>&nbsp;that has a formative effect on the way one thinks, feels, or acts may be considered educational, whether unintentional or&nbsp;<a href=\"https://en.wikipedia.org/wiki/Autodidacticism\" title=\"Autodidacticism\">intentional</a>. In practice there is a continuum from the highly formalized to the highly informalized, and informal learning can occur in all three settings.<sup><a href=\"https://en.wikipedia.org/wiki/Education#cite_note-2\">[2]</a></sup>&nbsp;For instance,&nbsp;<a href=\"https://en.wikipedia.org/wiki/Homeschooling\" title=\"Homeschooling\">homeschooling</a>&nbsp;can be classified as nonformal or informal, depending upon the structure.</p>\n\n<p>Regardless of setting, educational methods include&nbsp;<a href=\"https://en.wikipedia.org/wiki/Teaching\" title=\"Teaching\">teaching</a>,&nbsp;<a href=\"https://en.wikipedia.org/wiki/Training\" title=\"Training\">training</a>,&nbsp;<a href=\"https://en.wikipedia.org/wiki/Storytelling\" title=\"Storytelling\">storytelling</a>,&nbsp;<a href=\"https://en.wikipedia.org/wiki/Discussion\" title=\"Discussion\">discussion</a>, and directed&nbsp;<a href=\"https://en.wikipedia.org/wiki/Research\" title=\"Research\">research</a>. The&nbsp;<a href=\"https://en.wikipedia.org/wiki/Methodology\" title=\"Methodology\">methodology</a>&nbsp;of teaching is called&nbsp;<em><a href=\"https://en.wikipedia.org/wiki/Pedagogy\" title=\"Pedagogy\">pedagogy</a></em>. Education is supported by a variety of different&nbsp;<a href=\"https://en.wikipedia.org/wiki/Philosophy_of_education\" title=\"Philosophy of education\">philosophies</a>,&nbsp;<a href=\"https://en.wikipedia.org/wiki/Educational_science\" title=\"Educational science\">theories</a>&nbsp;and&nbsp;<a href=\"https://en.wikipedia.org/wiki/Educational_research\" title=\"Educational research\">empirical research agendas</a>.</p>\n\n<p>There are movements for&nbsp;<a href=\"https://en.wikipedia.org/wiki/Education_reform\" title=\"Education reform\">education reforms</a>, such as for improving quality and efficiency of education towards relevance in students&#39; lives and efficient&nbsp;<a href=\"https://en.wikipedia.org/wiki/Problem_solving\" title=\"Problem solving\">problem solving</a>&nbsp;in modern or future society at large, or for&nbsp;<a href=\"https://en.wikipedia.org/wiki/Evidence-based_education\" title=\"Evidence-based education\">evidence-based education methodologies</a>. A&nbsp;<a href=\"https://en.wikipedia.org/wiki/Right_to_education\" title=\"Right to education\">right to education</a>&nbsp;has been recognized by some&nbsp;<a href=\"https://en.wikipedia.org/wiki/Government\" title=\"Government\">governments</a>&nbsp;and the&nbsp;<a href=\"https://en.wikipedia.org/wiki/United_Nations\" title=\"United Nations\">United Nations</a>.<sup><a href=\"https://en.wikipedia.org/wiki/Education#cite_note-3\">[a]</a></sup>&nbsp;For example, 24 January is the&nbsp;<a href=\"https://en.wikipedia.org/wiki/International_Day_of_Education\" title=\"International Day of Education\">International Day of Education</a>.<sup><a href=\"https://en.wikipedia.org/wiki/Education#cite_note-4\">[3]</a></sup>&nbsp;At UN - level, several observance years and decades have been dedicated to education,<sup><a href=\"https://en.wikipedia.org/wiki/Education#cite_note-5\">[4]</a></sup>&nbsp;such as 1970 International Education Year.<sup><a href=\"https://en.wikipedia.org/wiki/Education#cite_note-6\">[5]</a></sup>&nbsp;Education is also one of the&nbsp;<a href=\"https://en.wikipedia.org/wiki/17_Global_Goals\" title=\"17 Global Goals\">17 Global Goals</a>, where global initiatives aim at achieving&nbsp;<a href=\"https://en.wikipedia.org/wiki/Sustainable_Development_Goal_4\" title=\"Sustainable Development Goal 4\">Sustainable Development Goal 4</a>, which promotes quality education for all.</p>\n\n<h2><strong><span style=\"font-size:14px\">Definitions</span></strong></h2>\n\n<p>Main article:&nbsp;<a href=\"https://en.wikipedia.org/wiki/Definitions_of_education\" title=\"Definitions of education\">Definitions of education</a></p>\n\n<p>Numerous definitions of education have been suggested by theorists belonging to diverse fields.<sup><a href=\"https://en.wikipedia.org/wiki/Education#cite_note-Marshall2006-7\">[6]</a></sup><sup><a href=\"https://en.wikipedia.org/wiki/Education#cite_note-Curtis2013-8\">[7]</a></sup><sup><a href=\"https://en.wikipedia.org/wiki/Education#cite_note-Matheson2014-9\">[8]</a></sup>&nbsp;Many agree that education is a purposeful activity directed at achieving certain aims, especially the transmission of&nbsp;<a href=\"https://en.wikipedia.org/wiki/Knowledge\" title=\"Knowledge\">knowledge</a>.<sup><a href=\"https://en.wikipedia.org/wiki/Education#cite_note-Chazan2021-10\">[9]</a></sup>&nbsp;But they often include other aims as well, such as fostering skills and character traits.<sup><a href=\"https://en.wikipedia.org/wiki/Education#cite_note-Chazan2021-10\">[9]</a></sup><sup><a href=\"https://en.wikipedia.org/wiki/Education#cite_note-Marshall2006-7\">[6]</a></sup><sup><a href=\"https://en.wikipedia.org/wiki/Education#cite_note-11\">[10]</a></sup>&nbsp;However, there are deep disagreements about the exact nature of education besides these general characteristics. According to some conceptions, it is primarily a process that occurs during events like schooling, teaching, and learning.<sup><a href=\"https://en.wikipedia.org/wiki/Education#cite_note-Peters1967-12\">[11]</a></sup><sup><a href=\"https://en.wikipedia.org/wiki/Education#cite_note-AmericanHeritageDictionary-13\">[12]</a></sup><sup><a href=\"https://en.wikipedia.org/wiki/Education#cite_note-Curtis2013-8\">[7]</a></sup>&nbsp;Others understand it not as a process but as the achievement or product brought about by this process. On this view, education is what educated persons have, i.e. the&nbsp;<a href=\"https://en.wikipedia.org/wiki/Mental_state\" title=\"Mental state\">mental states</a>&nbsp;and dispositions that are characteristic of them.<sup><a href=\"https://en.wikipedia.org/wiki/Education#cite_note-Peters1967-12\">[11]</a></sup><sup><a href=\"https://en.wikipedia.org/wiki/Education#cite_note-AmericanHeritageDictionary-13\">[12]</a></sup><sup><a href=\"https://en.wikipedia.org/wiki/Education#cite_note-Curtis2013-8\">[7]</a></sup>&nbsp;However, the term may also refer to the academic study of the methods and processes taking place during teaching and learning, as well as the social institutions involved in these processes.<sup><a href=\"https://en.wikipedia.org/wiki/Education#cite_note-AmericanHeritageDictionary-13\">[12]</a></sup>&nbsp;<a href=\"https://en.wikipedia.org/wiki/Etymologically\" title=\"Etymologically\">Etymologically</a>, the word &quot;education&quot; is derived from the Latin word&nbsp;<em><a href=\"https://en.wiktionary.org/wiki/en:educatio#Latin\" title=\"wikt:en:educatio\">ēducātiō</a></em>&nbsp;(&quot;A breeding, a bringing up, a rearing&quot;) from&nbsp;<em><a href=\"https://en.wiktionary.org/wiki/en:educo#Latin\" title=\"wikt:en:educo\">ēducō</a></em>&nbsp;(&quot;I educate, I train&quot;) which is related to the&nbsp;<a href=\"https://en.wikipedia.org/wiki/Homonym\" title=\"Homonym\">homonym</a>&nbsp;<em><a href=\"https://en.wiktionary.org/wiki/en:educo#Latin\" title=\"wikt:en:educo\">ēdūcō</a></em>&nbsp;(&quot;I lead forth, I take out; I raise up, I erect&quot;) from&nbsp;<em><a href=\"https://en.wiktionary.org/wiki/en:e-#Latin\" title=\"wikt:en:e-\">ē-</a></em>&nbsp;(&quot;from, out of&quot;) and&nbsp;<em><a href=\"https://en.wiktionary.org/wiki/en:duco#Latin\" title=\"wikt:en:duco\">dūcō</a></em>&nbsp;(&quot;I lead, I conduct&quot;).<sup><a href=\"https://en.wikipedia.org/wiki/Education#cite_note-14\">[13]</a></sup></p>\n\n<h2><span style=\"font-size:14px\"><strong>Types</strong></span></h2>\n\n<p>Education is commonly subdivided into different types. The most common subdivision is between formal,&nbsp;<a href=\"https://en.wikipedia.org/wiki/Non-formal_education\" title=\"Non-formal education\">non-formal</a>, and&nbsp;<a href=\"https://en.wikipedia.org/wiki/Informal_education\" title=\"Informal education\">informal education</a>.<sup><a href=\"https://en.wikipedia.org/wiki/Education#cite_note-La_Belle1982-36\">[35]</a></sup><sup><a href=\"https://en.wikipedia.org/wiki/Education#cite_note-Eshach2007-37\">[36]</a></sup><sup><a href=\"https://en.wikipedia.org/wiki/Education#cite_note-Curtis2013-8\">[7]</a></sup><sup><a href=\"https://en.wikipedia.org/wiki/Education#cite_note-38\">[37]</a></sup>&nbsp;However, some theorists only distinguish between formal and informal education.<sup><a href=\"https://en.wikipedia.org/wiki/Education#cite_note-39\">[38]</a></sup>&nbsp;A process of teaching constitutes formal education if it happens in a complex&nbsp;<a href=\"https://en.wikipedia.org/wiki/Institution\" title=\"Institution\">institutionalized</a>&nbsp;framework. Such frameworks are usually chronologically and hierarchically organized as in modern schooling systems, which have different classes based on the student&#39;s age and progress, all the way from primary school to university. Because of its scale, formal education is usually controlled and guided by a&nbsp;<a href=\"https://en.wikipedia.org/wiki/Government\" title=\"Government\">governmental</a>&nbsp;entity and is normally&nbsp;<a href=\"https://en.wikipedia.org/wiki/Compulsory_education\" title=\"Compulsory education\">compulsory</a>&nbsp;up to a certain age.<sup><a href=\"https://en.wikipedia.org/wiki/Education#cite_note-La_Belle1982-36\">[35]</a></sup><sup><a href=\"https://en.wikipedia.org/wiki/Education#cite_note-Tudor2013-40\">[39]</a></sup>&nbsp;Non-formal and informal education differ from formal education due to their lack of such a governmental institutionalized framework. Non-formal education constitutes a middle ground in the sense that it is also organized, systematic, and carried out with a clear purpose in mind, such as&nbsp;<a href=\"https://en.wikipedia.org/wiki/Tutoring\" title=\"Tutoring\">tutoring</a>, fitness classes, or the&nbsp;<a href=\"https://en.wikipedia.org/wiki/Scouting\" title=\"Scouting\">scouting</a>&nbsp;movement.<sup><a href=\"https://en.wikipedia.org/wiki/Education#cite_note-La_Belle1982-36\">[35]</a></sup><sup><a href=\"https://en.wikipedia.org/wiki/Education#cite_note-Tudor2013-40\">[39]</a></sup><sup><a href=\"https://en.wikipedia.org/wiki/Education#cite_note-Curtis2013-8\">[7]</a></sup>&nbsp;Informal education, on the other hand, happens in an unsystematic way through daily experiences and exposure to the environment. Unlike formal and non-formal education, there is usually no designated authority figure responsible for teaching.<sup><a href=\"https://en.wikipedia.org/wiki/Education#cite_note-Eshach2007-37\">[36]</a></sup>&nbsp;Informal education is present in many different settings and happens throughout one&#39;s life, mostly in a spontaneous manner. This is how children usually learn their mother tongue from their parents or when learning how to prepare a certain dish by cooking together.<sup><a href=\"https://en.wikipedia.org/wiki/Education#cite_note-La_Belle1982-36\">[35]</a></sup><sup><a href=\"https://en.wikipedia.org/wiki/Education#cite_note-Tudor2013-40\">[39]</a></sup><sup><a href=\"https://en.wikipedia.org/wiki/Education#cite_note-Curtis2013-8\">[7]</a></sup>&nbsp;Some accounts tie the difference between the three types mainly to the location where the learning takes place: in school for formal education, in places of the individual&#39;s day-to-day routine for informal education, and in other places occasionally visited for non-formal education.<sup><a href=\"https://en.wikipedia.org/wiki/Education#cite_note-Eshach2007-37\">[36]</a></sup>&nbsp;It has been argued that the&nbsp;<a href=\"https://en.wikipedia.org/wiki/Motivation\" title=\"Motivation\">motivation</a>&nbsp;responsible for formal education is predominantly extrinsic, whereas it tends to be mainly intrinsic for non-formal and informal education.<sup><a href=\"https://en.wikipedia.org/wiki/Education#cite_note-Eshach2007-37\">[36]</a></sup>&nbsp;The distinction between the three types is normally clear for the paradigmatic cases but there are various intermediate forms of education that do not easily fall into one category.<sup><a href=\"https://en.wikipedia.org/wiki/Education#cite_note-La_Belle1982-36\">[35]</a></sup><sup><a href=\"https://en.wikipedia.org/wiki/Education#cite_note-Eshach2007-37\">[36]</a></sup></p>\n\n<p>Formal education plays a central role in modern civilization. But in&nbsp;<a href=\"https://en.wikipedia.org/wiki/Primitive_culture\" title=\"Primitive culture\">primitive cultures</a>, most of the education happens not on the formal but on the informal level.<sup><a href=\"https://en.wikipedia.org/wiki/Education#cite_note-BritannicaEducation-29\">[28]</a></sup><sup><a href=\"https://en.wikipedia.org/wiki/Education#cite_note-Scribner1973-41\">[40]</a></sup><sup><a href=\"https://en.wikipedia.org/wiki/Education#cite_note-42\">[41]</a></sup>&nbsp;This usually means that there is no distinction between activities focused on education and other activities. Instead, the whole environment may be seen as a form of school and many or all adults may act as teachers. An important reason for moving to formal forms of education is due to the sheer quantity of knowledge to be passed on, which requires both a formal setting and well-trained teachers to be transmitted effectively. A side effect of the process of formalization is that the educational experience becomes more abstract and more removed from daily life. In this regard, more emphasis is put on grasping general patterns instead of observing and imitating particular behavior.<sup><a href=\"https://en.wikipedia.org/wiki/Education#cite_note-BritannicaEducation-29\">[28]</a></sup><sup><a href=\"https://en.wikipedia.org/wiki/Education#cite_note-Scribner1973-41\">[40]</a></sup></p>\n', 'posted', '2023-06-10 10:51:45', 'en-GB', 965, 'education,study'),
(24, 44, 18, 'neew tryle', '1681138339702.jpg', '<p>hhhgshidhjdhshd</p>\n', 'deleted', '2023-05-04 10:36:41', 'ar-SA', 2, ''),
(25, 23, 16, 'ahhs', 'blog.png', '', 'deleted', '2023-05-03 14:21:03', 'be-BY', 1, ''),
(26, 23, 16, 'ahhs', 'blog.png', '<p>The&nbsp;<strong>universe</strong>&nbsp;is all of&nbsp;<a href=\"https://en.wikipedia.org/wiki/Space\" title=\"Space\">space</a>&nbsp;and&nbsp;<a href=\"https://en.wikipedia.org/wiki/Time\" title=\"Time\">time</a><sup><a href=\"https://en.wikipedia.org/wiki/Universe#cite_note-spacetime-10\">[a]</a></sup>&nbsp;and their contents,<sup><a href=\"https://en.wikipedia.org/wiki/Universe#cite_note-Zeilik1998-11\">[10]</a></sup>&nbsp;including&nbsp;<a href=\"https://en.wikipedia.org/wiki/Planet\" title=\"Planet\">planets</a>,&nbsp;<a href=\"https://en.wikipedia.org/wiki/Star\" title=\"Star\">stars</a>,&nbsp;<a href=\"https://en.wikipedia.org/wiki/Galaxy\" title=\"Galaxy\">galaxies</a>, and all other forms of&nbsp;<a href=\"https://en.wikipedia.org/wiki/Matter\" title=\"Matter\">matter</a>&nbsp;and&nbsp;<a href=\"https://en.wikipedia.org/wiki/Energy\" title=\"Energy\">energy</a>. The&nbsp;<a href=\"https://en.wikipedia.org/wiki/Big_Bang\" title=\"Big Bang\">Big Bang</a>&nbsp;theory is the prevailing&nbsp;<a href=\"https://en.wikipedia.org/wiki/Cosmology\" title=\"Cosmology\">cosmological</a>&nbsp;description of the development of the universe. According to this theory, space and time emerged together&nbsp;13.787&plusmn;0.020&nbsp;billion years&nbsp;ago,<sup><a href=\"https://en.wikipedia.org/wiki/Universe#cite_note-12\">[11]</a></sup>&nbsp;and the universe has been expanding ever since the Big Bang. While the spatial size of the entire universe is unknown,<sup><a href=\"https://en.wikipedia.org/wiki/Universe#cite_note-Brian_Greene_2011-3\">[3]</a></sup>&nbsp;it is possible to measure the size of the&nbsp;<a href=\"https://en.wikipedia.org/wiki/Observable_universe\" title=\"Observable universe\">observable universe</a>, which is approximately 93 billion&nbsp;<a href=\"https://en.wikipedia.org/wiki/Light-year\" title=\"Light-year\">light-years</a>&nbsp;in diameter at the present day.</p>\n\n<p>&nbsp;</p>\n\n<p>&nbsp;</p>\n', 'deleted', '2023-06-03 09:31:54', 'be-BY', 6, ''),
(27, 23, 16, 'ahhs', 'blog.png', '<p>The&nbsp;<strong>universe</strong>&nbsp;is all of&nbsp;<a href=\"https://en.wikipedia.org/wiki/Space\" title=\"Space\">space</a>&nbsp;and&nbsp;<a href=\"https://en.wikipedia.org/wiki/Time\" title=\"Time\">time</a><sup><a href=\"https://en.wikipedia.org/wiki/Universe#cite_note-spacetime-10\">[a]</a></sup>&nbsp;and their contents,<sup><a href=\"https://en.wikipedia.org/wiki/Universe#cite_note-Zeilik1998-11\">[10]</a></sup>&nbsp;including&nbsp;<a href=\"https://en.wikipedia.org/wiki/Planet\" title=\"Planet\">planets</a>,&nbsp;<a href=\"https://en.wikipedia.org/wiki/Star\" title=\"Star\">stars</a>,&nbsp;<a href=\"https://en.wikipedia.org/wiki/Galaxy\" title=\"Galaxy\">galaxies</a>, and all other forms of&nbsp;<a href=\"https://en.wikipedia.org/wiki/Matter\" title=\"Matter\">matter</a>&nbsp;and&nbsp;<a href=\"https://en.wikipedia.org/wiki/Energy\" title=\"Energy\">energy</a>. The&nbsp;<a href=\"https://en.wikipedia.org/wiki/Big_Bang\" title=\"Big Bang\">Big Bang</a>&nbsp;theory is the prevailing&nbsp;<a href=\"https://en.wikipedia.org/wiki/Cosmology\" title=\"Cosmology\">cosmological</a>&nbsp;description of the development of the universe. According to this theory, space and time emerged together&nbsp;13.787&plusmn;0.020&nbsp;billion years&nbsp;</p>\n\n<p>ago,<sup><a href=\"https://en.wikipedia.org/wiki/Universe#cite_note-12\">[11]</a></sup>&nbsp;and the universe has been expanding ever since the Big Bang. While the spatial size of the entire universe is unknown,<sup><a href=\"https://en.wikipedia.org/wiki/Universe#cite_note-Brian_Greene_2011-3\">[3]</a></sup>&nbsp;it is possible to measure the size of the&nbsp;<a href=\"https://en.wikipedia.org/wiki/Observable_universe\" title=\"Observable universe\">observable universe</a>, which is approximately 93 billion&nbsp;<a href=\"https://en.wikipedia.org/wiki/Light-year\" title=\"Light-year\">light-years</a>&nbsp;in diameter at the present day.</p>\n\n<p>jhdxkajs fedsikwwk&nbsp; &nbsp; 3weuiiu23wfsn</p>\n\n<p>ago,<sup><a href=\"https://en.wikipedia.org/wiki/Universe#cite_note-12\">[11]</a></sup>&nbsp;and the universe has been expanding ever since the Big Bang. While the spatial size of the entire universe is unknown,<sup><a href=\"https://en.wikipedia.org/wiki/Universe#cite_note-Brian_Greene_2011-3\">[3]</a></sup>&nbsp;it is possible to measure the size of the&nbsp;<a href=\"https://en.wikipedia.org/wiki/Observable_universe\" title=\"Observable universe\">observable universe</a>, which is approximately 93 billion&nbsp;<a href=\"https://en.wikipedia.org/wiki/Light-year\" title=\"Light-year\">light-years</a>&nbsp;in diameter at the present day.</p>\n\n<p>jhdxkajs fedsikwwk&nbsp; &nbsp; 3weuiiu23wfsn</p>\n\n<p>ago,<sup><a href=\"https://en.wikipedia.org/wiki/Universe#cite_note-12\">[11]</a></sup>&nbsp;and the universe has been expanding ever since the Big Bang. While the spatial size of the entire universe is unknown,<sup><a href=\"https://en.wikipedia.org/wiki/Universe#cite_note-Brian_Greene_2011-3\">[3]</a></sup>&nbsp;it is possible to measure the size of the&nbsp;<a href=\"https://en.wikipedia.org/wiki/Observable_universe\" title=\"Observable universe\">observable universe</a>, which is approximately 93 billion&nbsp;<a href=\"https://en.wikipedia.org/wiki/Light-year\" title=\"Light-year\">light-years</a>&nbsp;in diameter at the present day.</p>\n\n<p>jhdxkajs fedsikwwk&nbsp; &nbsp; 3weuiiu23wfsn</p>\n\n<p>ago,<sup><a href=\"https://en.wikipedia.org/wiki/Universe#cite_note-12\">[11]</a></sup>&nbsp;and the universe has been expanding ever since the Big Bang. While the spatial size of the entire universe is unknown,<sup><a href=\"https://en.wikipedia.org/wiki/Universe#cite_note-Brian_Greene_2011-3\">[3]</a></sup>&nbsp;it is possible to measure the size of the&nbsp;<a href=\"https://en.wikipedia.org/wiki/Observable_universe\" title=\"Observable universe\">observable universe</a>, which is approximately 93 billion&nbsp;<a href=\"https://en.wikipedia.org/wiki/Light-year\" title=\"Light-year\">light-years</a>&nbsp;in diameter at the present day.</p>\n\n<p>jhdxkajs fedsikwwk&nbsp; &nbsp; 3weuiiu23wfsn</p>\n', 'deleted', '2023-06-11 05:38:36', 'be-BY', 44, ''),
(28, 31, 6, 'school', 'WhatsApp Image 2023-04-09 at 13.25.41.jpeg', '<p>A&nbsp;<strong>blog</strong>&nbsp;(a&nbsp;<a href=\"https://en.wikipedia.org/wiki/Clipping_(morphology)\" title=\"Clipping (morphology)\">truncation</a>&nbsp;of &quot;<strong>weblog</strong>&quot;)<sup><a href=\"https://en.wikipedia.org/wiki/Blog#cite_note-1\">[1]</a></sup>&nbsp;is an informational&nbsp;<a href=\"https://en.wikipedia.org/wiki/Website\" title=\"Website\">website</a>&nbsp;published on the&nbsp;<a href=\"https://en.wikipedia.org/wiki/World_Wide_Web\" title=\"World Wide Web\">World Wide Web</a>&nbsp;consisting of discrete, often informal diary-style text entries (posts). Posts are typically displayed in&nbsp;<a href=\"https://en.wikipedia.org/wiki/Reverse_chronology\" title=\"Reverse chronology\">reverse chronological order</a>&nbsp;so that the most recent post appears first, at the top of the&nbsp;<a href=\"https://en.wikipedia.org/wiki/Web_page\" title=\"Web page\">web page</a>. Until 2009, blogs were usually the work of a single individual,<sup>[<em><a href=\"https://en.wikipedia.org/wiki/Wikipedia:Citation_needed\" title=\"Wikipedia:Citation needed\">citation needed</a></em>]</sup>&nbsp;occasionally of a small group, and often covered a single subject or topic. In the 2010s, &quot;multi-author blogs&quot; (MABs) emerged, featuring the writing of multiple authors and sometimes professionally&nbsp;<a href=\"https://en.wikipedia.org/wiki/Editing\" title=\"Editing\">edited</a>. MABs from&nbsp;<a href=\"https://en.wikipedia.org/wiki/Newspaper\" title=\"Newspaper\">newspapers</a>, other&nbsp;<a href=\"https://en.wikipedia.org/wiki/News_media\" title=\"News media\">media outlets</a>, universities,&nbsp;<a href=\"https://en.wikipedia.org/wiki/Think_tank\" title=\"Think tank\">think tanks</a>,&nbsp;<a href=\"https://en.wikipedia.org/wiki/Advocacy_group\" title=\"Advocacy group\">advocacy groups</a>, and similar institutions account for an increasing quantity of blog&nbsp;<a href=\"https://en.wikipedia.org/wiki/Web_traffic\" title=\"Web traffic\">traffic</a>. The rise of&nbsp;<a href=\"https://en.wikipedia.org/wiki/Twitter\" title=\"Twitter\">Twitter</a>&nbsp;and other &quot;<a href=\"https://en.wikipedia.org/wiki/Microblogging\" title=\"Microblogging\">microblogging</a>&quot; systems helps integrate MABs and single-author blogs into the news media.&nbsp;<em>Blog</em>&nbsp;can also be used as a verb, meaning&nbsp;<em>to maintain or add content to a blog</em>.</p>\n\n<p>The emergence and growth of blogs in the late 1990s coincided with the advent of web publishing tools that facilitated the posting of content by non-technical users who did not have much experience with&nbsp;<a href=\"https://en.wikipedia.org/wiki/HTML\" title=\"HTML\">HTML</a>&nbsp;or&nbsp;<a href=\"https://en.wikipedia.org/wiki/Computer_programming\" title=\"Computer programming\">computer programming</a>. Previously, knowledge of such technologies as&nbsp;<a href=\"https://en.wikipedia.org/wiki/HTML\" title=\"HTML\">HTML</a>&nbsp;and&nbsp;<a href=\"https://en.wikipedia.org/wiki/File_Transfer_Protocol\" title=\"File Transfer Protocol\">File Transfer Protocol</a>&nbsp;had been required to publish content on the Web, and early Web users therefore tended to be&nbsp;<a href=\"https://en.wikipedia.org/wiki/Hacker\" title=\"Hacker\">hackers</a>&nbsp;and computer enthusiasts. In the 2010s, the majority are interactive&nbsp;<a href=\"https://en.wikipedia.org/wiki/Web_2.0\" title=\"Web 2.0\">Web 2.0</a>&nbsp;websites, allowing visitors to leave online comments, and it is this interactivity that distinguishes them from other static websites.<sup><a href=\"https://en.wikipedia.org/wiki/Blog#cite_note-2\">[2]</a></sup>&nbsp;In that sense, blogging can be seen as a form of&nbsp;<a href=\"https://en.wikipedia.org/wiki/Social_networking_service\" title=\"Social networking service\">social networking service</a>. Indeed, bloggers not only produce content to post on their blogs but also often build social relations with their readers and other bloggers.<sup><a href=\"https://en.wikipedia.org/wiki/Blog#cite_note-3\">[3]</a></sup>&nbsp;Blog owners or authors often&nbsp;<a href=\"https://en.wikipedia.org/wiki/Internet_forum#Moderators\" title=\"Internet forum\">moderate</a>&nbsp;and&nbsp;<a href=\"https://en.wikipedia.org/wiki/Wordfilter\" title=\"Wordfilter\">filter</a>&nbsp;online comments to remove&nbsp;<a href=\"https://en.wikipedia.org/wiki/Hate_speech\" title=\"Hate speech\">hate speech</a>&nbsp;or other offensive content. There are also high-readership blogs which do not allow comments.</p>\n\n<p>Many blogs provide commentary on a particular subject or topic, ranging from&nbsp;<a href=\"https://en.wikipedia.org/wiki/Philosophy\" title=\"Philosophy\">philosophy</a>,&nbsp;<a href=\"https://en.wikipedia.org/wiki/Religion\" title=\"Religion\">religion</a>, and&nbsp;<a href=\"https://en.wikipedia.org/wiki/Art\" title=\"Art\">arts</a>&nbsp;to&nbsp;<a href=\"https://en.wikipedia.org/wiki/Science\" title=\"Science\">science</a>,&nbsp;<a href=\"https://en.wikipedia.org/wiki/Politics\" title=\"Politics\">politics</a>, and&nbsp;<a href=\"https://en.wikipedia.org/wiki/Sport\" title=\"Sport\">sports</a>. Others function as more personal&nbsp;<a href=\"https://en.wikipedia.org/wiki/Online_diary\" title=\"Online diary\">online diaries</a>&nbsp;or&nbsp;<a href=\"https://en.wikipedia.org/wiki/Online_advertising\" title=\"Online advertising\">online brand advertising</a>&nbsp;of a particular individual or company. A typical blog combines text,&nbsp;<a href=\"https://en.wikipedia.org/wiki/Digital_image\" title=\"Digital image\">digital images</a>, and&nbsp;<a href=\"https://en.wikipedia.org/wiki/Hyperlink\" title=\"Hyperlink\">links</a>&nbsp;to other blogs, web pages, and other media related to its topic. Most blogs are primarily textual, although some focus on art (<em><a href=\"https://en.wikipedia.org/wiki/Art_blog\" title=\"Art blog\">art blogs</a></em>), photographs (<em><a href=\"https://en.wikipedia.org/wiki/Photoblog\" title=\"Photoblog\">photoblogs</a></em>), videos (<em><a href=\"https://en.wikipedia.org/wiki/Video_blog\" title=\"Video blog\">video blogs</a></em>&nbsp;or &quot;<em>vlogs</em>&quot;), music (<em><a href=\"https://en.wikipedia.org/wiki/MP3_blog\" title=\"MP3 blog\">MP3 blogs</a></em>), and audio (<em><a href=\"https://en.wikipedia.org/wiki/Podcast\" title=\"Podcast\">podcasts</a></em>). In education, blogs can be used as instructional resources; these are referred to as&nbsp;<em><a href=\"https://en.wikipedia.org/wiki/Edublog\" title=\"Edublog\">edublogs</a></em>.&nbsp;<a href=\"https://en.wikipedia.org/wiki/Microblogging\" title=\"Microblogging\">Microblogging</a>&nbsp;is another type of blogging, featuring very short posts.</p>\n\n<p>&#39;Blog&#39; and &#39;blogging&#39; are now loosely used for content creation and sharing on&nbsp;<a href=\"https://en.wikipedia.org/wiki/Social_media\" title=\"Social media\">social media</a>, especially when the content is long-form and one creates and shares content on regular basis. So, one could be maintaining a blog on&nbsp;<a href=\"https://en.wikipedia.org/wiki/Facebook\" title=\"Facebook\">Facebook</a>&nbsp;or blogging on&nbsp;<a href=\"https://en.wikipedia.org/wiki/Instagram\" title=\"Instagram\">Instagram</a>. Blogging is writing about what you like. In other words, writing about what you know and providing valuable information to people searching for it.</p>\n\n<p>A 2022 estimate suggested that there were over 600 million public blogs out of more than 1.9 billion websites.<sup><a href=\"https://en.wikipedia.org/wiki/Blog#cite_note-4\">[4]</a></sup></p>\n', 'deleted', '2023-06-11 05:08:22', 'ar-SA', 26, ''),
(29, 31, 9, 'collage life', 'blog.png', '<p>I have successfully managed to make a div hide on click after 400 milliseconds using a setInterval function. My issue is that it runs continually, I only need the function to execute once. After a quick search I discovered that the setInterval can be stopped by clearInterval. Am I using this incorrectly? The closeAnimation function is being executed on click. I modelled my code after the code on this page:&nbsp;<a href=\"http://www.w3schools.com/jsref/met_win_setinterval.asp\" rel=\"noreferrer\">http://www.w3schools.com/jsref/met_win_setinterval.asp</a></p>\n\n<pre>\n<code>function closeAnimation() {\n    setInterval(function(){hide()}, 400);\n    clearInterval(stopAnimation);\n}\n\nvar stopAnimation = setInterval({hide()}, 400); </code></pre>\n', 'deleted', '2023-06-11 05:03:19', 'en-GB', 34, ''),
(30, 31, 2, 'Blog', 'Screenshot (4).png', '<p><strong>બ્લોગ</strong>&nbsp;<em><strong>વેબલોગ</strong></em>નું&nbsp;<a href=\"https://gu.wikipedia.org/w/index.php?title=%E0%AA%B8%E0%AA%82%E0%AA%95%E0%AB%8D%E0%AA%B7%E0%AA%BF%E0%AA%AA%E0%AB%8D%E0%AA%A4_%E0%AA%B0%E0%AB%81%E0%AA%AA_(%E0%AA%B5%E0%AB%8D%E0%AA%AF%E0%AA%BE%E0%AA%95%E0%AA%B0%E0%AA%A3)&amp;action=edit&amp;redlink=1\" title=\"સંક્ષિપ્ત રુપ (વ્યાકરણ) (પાનું અસ્તિત્વમાં નથી)\">ટુંકુ રુપ</a>&nbsp;(<a href=\"https://en.wikipedia.org/wiki/contraction_(grammar)\" title=\"en:contraction (grammar)\">contraction</a>). એક&nbsp;<a href=\"https://gu.wikipedia.org/w/index.php?title=%E0%AA%B5%E0%AB%87%E0%AA%AC%E0%AA%B8%E0%AA%BE%E0%AA%87%E0%AA%9F&amp;action=edit&amp;redlink=1\" title=\"વેબસાઇટ (પાનું અસ્તિત્વમાં નથી)\">વેબસાઇટ</a>&nbsp;(<a href=\"https://en.wikipedia.org/wiki/website\" title=\"en:website\">website</a>) છે, જે સામાન્યપણે ટીપ્પણીઓની નિયમિત એન્ટ્રીઝ, ઘટનાઓનું વર્ણન કે પછી ગ્રાફિક્સ અથવા વિડીયો જેવી અન્ય સામગ્રી સાથે વ્યક્તિ દ્વારા ચલાવવામાં આવે છે.એન્ટ્રીઝ સામાન્યપણે ઉલ્ટા કાલક્રમાનુસાર દર્શાવવામાં આવે છે.&quot;બ્લોગ&quot;ને ક્રિયાપદ તરીકે પણ વાપરી શકાય છે, જેનો અર્થ<em>&nbsp;બ્લોગ જાળવવો કે તેમાં વિગત ઉમેરવી&nbsp;</em>એવો થાય છે.</p>\n\n<p>ઘણા બ્લોગ ચોક્કસ વિષય પર કોમેન્ટરી કે સમાચાર પૂરા પાડે છે, જ્યારે અન્ય બ્લોગ વ્યક્તિગત&nbsp;<a href=\"https://gu.wikipedia.org/w/index.php?title=%E0%AA%93%E0%AA%A8%E0%AA%B2%E0%AA%BE%E0%AA%87%E0%AA%A8_%E0%AA%A1%E0%AA%BE%E0%AA%AF%E0%AA%B0%E0%AB%80&amp;action=edit&amp;redlink=1\" title=\"ઓનલાઇન ડાયરી (પાનું અસ્તિત્વમાં નથી)\">ઓનલાઇન ડાયરી</a>&nbsp;(<a href=\"https://en.wikipedia.org/wiki/online_diary\" title=\"en:online diary\">online diaries</a>)ની કામગીરી બજાવે છે. એક નમુનારુપ બ્લોગમાં લખાણ, અન્ય બ્લોગ સાથેની લિન્ક્સ,&nbsp;<a href=\"https://gu.wikipedia.org/w/index.php?title=%E0%AA%B5%E0%AB%87%E0%AA%AC_%E0%AA%AA%E0%AB%87%E0%AA%87%E0%AA%9C&amp;action=edit&amp;redlink=1\" title=\"વેબ પેઇજ (પાનું અસ્તિત્વમાં નથી)\">વેબ પેઇજ</a>&nbsp;(<a href=\"https://en.wikipedia.org/wiki/Web_page\" title=\"en:Web page\">Web page</a>) અને તેના વિષય સંબંધિત અન્ય માધ્યમનો સમાવેશ થાય છે. ઘણા બ્લોગમાં વાચકો એક ઇન્ટરેક્ટિવ ફોર્મેટમાં ટીકાટીપ્પણી કરી શકે છે. તે બ્લોગનો મહત્વનો હિસ્સો હોય છે.મોટા ભાગના બ્લોગ લખાણ આધારિત હોય છે, તેમ છતાં કેટલાક કલા (<a href=\"https://gu.wikipedia.org/w/index.php?title=%E0%AA%86%E0%AA%B0%E0%AB%8D%E0%AA%9F%E0%AA%B2%E0%AB%8B%E0%AA%97&amp;action=edit&amp;redlink=1\" title=\"આર્ટલોગ (પાનું અસ્તિત્વમાં નથી)\">આર્ટલોગ</a>&nbsp;(<a href=\"https://en.wikipedia.org/wiki/artlog\" title=\"en:artlog\">artlog</a>)), ફોટોગ્રાફ્ટ (<a href=\"https://gu.wikipedia.org/w/index.php?title=%E0%AA%AB%E0%AB%8B%E0%AA%9F%E0%AB%8B%E0%AA%AC%E0%AB%8D%E0%AA%B2%E0%AB%8B%E0%AA%97&amp;action=edit&amp;redlink=1\" title=\"ફોટોબ્લોગ (પાનું અસ્તિત્વમાં નથી)\">ફોટોલોગ</a>&nbsp;(<a href=\"https://en.wikipedia.org/wiki/photoblog\" title=\"en:photoblog\">photoblog</a>)), સ્કેચીઝ (<a href=\"https://gu.wikipedia.org/w/index.php?title=%E0%AA%B8%E0%AB%8D%E0%AA%95%E0%AB%87%E0%AA%9A%E0%AA%AC%E0%AB%8D%E0%AA%B2%E0%AB%8B%E0%AA%97&amp;action=edit&amp;redlink=1\" title=\"સ્કેચબ્લોગ (પાનું અસ્તિત્વમાં નથી)\">સ્કેચલોગ</a>&nbsp;(<a href=\"https://en.wikipedia.org/wiki/sketchblog\" title=\"en:sketchblog\">sketchblog</a>)), વિડીયોઝ (<a href=\"https://gu.wikipedia.org/w/index.php?title=%E0%AA%B5%E0%AB%80%E0%AA%B2%E0%AB%8B%E0%AA%97&amp;action=edit&amp;redlink=1\" title=\"વીલોગ (પાનું અસ્તિત્વમાં નથી)\">વીલોગ</a>&nbsp;(<a href=\"https://en.wikipedia.org/wiki/vlog\" title=\"en:vlog\">vlog</a>)), સંગીત (<a href=\"https://gu.wikipedia.org/w/index.php?title=%E0%AA%8F%E0%AA%AE%E0%AA%AA%E0%AB%80%E0%AA%A5%E0%AB%8D%E0%AA%B0%E0%AB%80_%E0%AA%AC%E0%AB%8D%E0%AA%B2%E0%AB%8B%E0%AA%97&amp;action=edit&amp;redlink=1\" title=\"એમપીથ્રી બ્લોગ (પાનું અસ્તિત્વમાં નથી)\">એમપીથ્રી બ્લોગ</a>&nbsp;(<a href=\"https://en.wikipedia.org/wiki/MP3_blog\" title=\"en:MP3 blog\">MP3 blog</a>)), ઓડિયો (<a href=\"https://gu.wikipedia.org/w/index.php?title=%E0%AA%AA%E0%AB%8B%E0%AA%A1%E0%AA%95%E0%AA%BE%E0%AA%B8%E0%AB%8D%E0%AA%9F&amp;action=edit&amp;redlink=1\" title=\"પોડકાસ્ટ (પાનું અસ્તિત્વમાં નથી)\">પોડકાસ્ટિંગ</a>&nbsp;(<a href=\"https://en.wikipedia.org/wiki/podcast\" title=\"en:podcast\">podcast</a>)) પર ધ્યાન કેન્દ્રિત કરે છે, જે&nbsp;<a href=\"https://gu.wikipedia.org/w/index.php?title=%E0%AA%B8%E0%AA%BE%E0%AA%AE%E0%AA%BE%E0%AA%9C%E0%AA%BF%E0%AA%95_%E0%AA%AE%E0%AA%BE%E0%AA%A7%E0%AB%8D%E0%AA%AF%E0%AA%AE&amp;action=edit&amp;redlink=1\" title=\"સામાજિક માધ્યમ (પાનું અસ્તિત્વમાં નથી)\">સામાજિક માધ્યમ</a>&nbsp;(<a href=\"https://en.wikipedia.org/wiki/social_media\" title=\"en:social media\">social media</a>)ના વ્યાપક નેટવર્કનો ભાગ હોય છે.&nbsp;<a href=\"https://gu.wikipedia.org/w/index.php?title=%E0%AA%B2%E0%AA%98%E0%AB%81-%E0%AA%AC%E0%AB%8D%E0%AA%B2%E0%AB%8B%E0%AA%97%E0%AA%BF%E0%AA%82%E0%AA%97&amp;action=edit&amp;redlink=1\" title=\"લઘુ-બ્લોગિંગ (પાનું અસ્તિત્વમાં નથી)\">લઘુ-બ્લોગિંગ</a>&nbsp;(<a href=\"https://en.wikipedia.org/wiki/Micro-blogging\" title=\"en:Micro-blogging\">Micro-blogging</a>) બ્લોગિંગનો અન્ય પ્રકાર છે, જેમાં અત્યંત નાની પોસ્ટ્સ સાથેના બ્લોગ્સનો સમાવેશ થાય છે. ડીસેમ્બર 2007એ, બ્લોગ સર્ચ એન્જિન&nbsp;<a href=\"https://gu.wikipedia.org/w/index.php?title=%E0%AA%9F%E0%AB%87%E0%AA%95%E0%AA%A8%E0%AB%8B%E0%AA%B0%E0%AA%BE%E0%AA%A4%E0%AB%80&amp;action=edit&amp;redlink=1\" title=\"ટેકનોરાતી (પાનું અસ્તિત્વમાં નથી)\">ટેકનોરાતી</a>&nbsp;(<a href=\"https://en.wikipedia.org/wiki/Technorati\" title=\"en:Technorati\">Technorati</a>)એ 11.2 કરોડથી પણ વધારે બ્લોગ્સ ટ્રેક કર્યા હતા.<sup><a href=\"https://gu.wikipedia.org/wiki/%E0%AA%AC%E0%AB%8D%E0%AA%B2%E0%AB%89%E0%AA%97#cite_note-1\">[૧]</a></sup><a href=\"https://gu.wikipedia.org/w/index.php?title=%E0%AA%B5%E0%AA%BF%E0%AA%A1%E0%AB%80%E0%AA%AF%E0%AB%8B_%E0%AA%AC%E0%AB%8D%E0%AA%B2%E0%AB%8B%E0%AA%97%E0%AA%BF%E0%AA%82%E0%AA%97&amp;action=edit&amp;redlink=1\" title=\"વિડીયો બ્લોગિંગ (પાનું અસ્તિત્વમાં નથી)\">વિડીયો બ્લોગિંગ</a>&nbsp;(<a href=\"https://en.wikipedia.org/wiki/video_blogging\" title=\"en:video blogging\">video blogging</a>)ના આગમન સાથે,&nbsp;<em>બ્લોગ</em>&nbsp;શબ્દનો અર્થ વધારે વ્યાપક બન્યો - કોઈ પણ એવું માધ્યમ જેમાં બ્લોગ કર્તા પોતાનો અભિપ્રાય આપે છે અથવા કશાક વિષે ફક્ત વાતો કરે છે.</p>\n', 'deleted', '2023-06-11 05:02:56', 'gu-IN', 871, ''),
(31, 34, 10, 'Rise of football in India', 'football.webp', '<p>Football&#39;s popularity in India is rising. It has the potential to rival cricket as the go-to sport for the next generation. A decade ago, if anyone asked you which sport does India play, cricket would be the most obvious answer. Fortunately, that has changed over the past few years. Other sports like badminton, kabaddi, and football have cornered a lot of the new sports enthusiasts.</p>\n\n<p dir=\"ltr\">2017 was a good year for football in India, with the national team going on to qualify for the 2019 Asian Cup while the country also successfully hosted the FIFA Under-17 World Cup. The Indian Under-17 side also gave a good account of themselves in the tournament.</p>\n\n<p dir=\"ltr\">Sunil Chhetri has started becoming a name more people know and recognize. A lot of local talent has been promoted in the ISL in particular and the marketing teams have made sure that the viewers remember these names. Football has also received a lot of support from Bollywood. A lot of stars either own stakes in teams or have been very vocal about their support for European teams. Ranbir Kapoor&#39;s love for Barcelona and Ranveer Singh&#39;s love for Arsenal is well documented.</p>\n\n<p dir=\"ltr\">Coverage of football matches and tournaments by the media has increased manifold, particularly, because of the huge demand for information around it. A few years ago, the only time you would see sports journalists write opinion pieces about football was if there was a World Cup coming up. Those also used to be very generic and mostly just used information from foreign articles. Now you can read about all the big matches on a daily basis.</p>\n\n<p dir=\"ltr\">There is still hope for Indian football</p>\n\n<p dir=\"ltr\">The dream of every Indian football fans is to see the nation playing in a senior World Cup and one day that might be achieved if Indian football continues to develop at the same rate. 2017 was a successful year for the nation and the players will be looking to continue that form for the next 12-months too. The senior team is foraging on the right path under Constantine while the Under-17 players are now gaining experience playing for Indian Arrows in the I-League. The future is bright for football in India as we head into another year. It is clear that football still has a long way to go before it can match cricket in terms of popularity and revenue generation but there is no doubt that it has caught the imagination of the youth of the country.</p>\n', 'posted', '2023-06-03 09:31:43', 'en-GB', 157, 'football rise'),
(32, 34, 16, 'neew', 'Screenshot (5).png', '', 'deleted', '2023-05-03 17:00:11', 'bem-ZM', 1, ''),
(33, 34, 17, 'hhhd', 'Screenshot (1).png', '', 'drafted', '2023-05-24 09:29:45', 'be-BY', 1, '');
INSERT INTO `blogs` (`blog_id`, `usid`, `bcid`, `blog_title`, `blog_cover_photo`, `blog_content`, `blog_status`, `blog_post_time`, `lcode`, `blog_view`, `tags`) VALUES
(34, 34, 12, 'Statue of Unity', 'statueofunity.jpg', '<pre style=\"text-align:center\">\n<span style=\"font-size:17px\"><span style=\"background-color:rgba(0, 0, 0, 0.05)\"><span style=\"font-family:inherit\"><span style=\"color:#222222\"><em>ઊંચો અને શકિતશાળી, તે તેના પડોશીઓ પર ઊંચો હતો\nતેની સમજદાર આંખો તેના શ્રમના ફળનો આનંદ માણી રહી છે.\nવૈવિધ્યસભર સમુદાયનું વિલિનીકરણ કરવાનું તેમનું સ્વપ્ન\nઆખરે સ્ટેચ્યુ ઓફ યુનિટીમાં કાયમ માટે સીલ કરવામાં આવી હતી. </em>  \n<strong><em>\nભારતના લોખંડી પુરુષ - સરદાર વલ્લભભાઈ પટેલને શ્રદ્ધાંજલિ </em></strong></span></span></span></span></pre>\n\n<p><span style=\"font-size:14px\">તે આશ્ચર્યજનક નથી કે ગુજરાતમાં સ્ટેચ્યુ ઓફ યુનિટી ઘણા પ્રવાસીઓ માટે મુલાકાત લેવાના સ્થળોની યાદીમાં સ્થાન મેળવ્યું છે, જેમાં યોર્સ ટ્રુલીનો સમાવેશ થાય છે.&nbsp;એક માટે, હું વિશ્વની સૌથી ઊંચી પ્રતિમાના તીવ્ર સ્કેલનો અનુભવ કરવા માંગતો હતો.&nbsp;અને પછી, કેટલાક આશ્ચર્યજનક સ્ટેચ્યુ ઓફ યુનિટી હકીકતો છે જે ગુજરાતમાં આ સરદાર પટેલ પ્રતિમાની લાલચમાં વધારો કરે છે.&nbsp;ઘણા લોકો માટે, ડ્રો સ્ટેચ્યુ ઓફ યુનિટીની આસપાસ જોવા માટેના વધારાના સ્થળો જેવા કે થીમ આધારિત બગીચા, સરદાર સરોવર ડેમ અને કેવડિયાના ઇકો-ટાઉન (&nbsp;<em>હવે એકતાનગર તરીકે ઓળખાય છે</em>&nbsp;).&nbsp;જો તમે એવા પ્રવાસીઓમાંથી એક છો જે તમારી જિજ્ઞાસાને સંતોષવા માગે છે, તો આ સ્ટેચ્યુ ઑફ યુનિટી માર્ગદર્શિકા તમને અહીં તમારી સફરની યોજના બનાવવા માટે જરૂરી છે.</span></p>\n\n<p>&nbsp;</p>\n\n<h2 style=\"text-align:start\"><span style=\"font-size:14px\"><span style=\"font-family:-apple-system,system-ui,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;,&quot;Segoe UI Symbol&quot;\"><span style=\"color:#222222\"><span style=\"background-color:#ffffff\">સ્ટેચ્યુ ઓફ યુનિટી ગુજરાતની યાત્રા માર્ગદર્શિકા</span></span></span></span></h2>\n\n<p style=\"text-align:start\"><span style=\"font-size:14px\"><span style=\"color:#222222\"><span style=\"font-family:-apple-system,system-ui,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;,&quot;Segoe UI Symbol&quot;\"><span style=\"background-color:#ffffff\">સ્ટેચ્યુ ઓફ યુનિટી પ્રવાસ માટે થોડું આયોજન કરવાની જરૂર પડે છે કારણ કે તે માત્ર વિશાળ શિલ્પ જોવા માટે જ નથી.&nbsp;સ્ટેચ્યુ ઓફ યુનિટીની નજીક જોવા માટે અન્ય પુષ્કળ સ્થળો છે અને આમાંના દરેક માટે તમારે ટિકિટ બુક કરાવવી જરૂરી છે.&nbsp;સ્ટેચ્યુ ઓફ યુનિટી (SOU) ની આ પ્રવાસ માર્ગદર્શિકા આ ​​આકર્ષણોનો ટૂંકમાં પરિચય આપે છે અને તમને એકતાનગરની આસપાસ ફરવા, ક્યાં રોકાવું અને સ્ટેચ્યુ ઓફ યુનિટીની ટિકિટ કેવી રીતે બુક કરવી તેની ટીપ્સ આપે છે.</span></span></span></span></p>\n\n<p style=\"text-align:start\"><span style=\"font-size:14px\"><span style=\"color:#222222\"><span style=\"font-family:-apple-system,system-ui,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;,&quot;Segoe UI Symbol&quot;\"><span style=\"background-color:#ffffff\">જેઓ હજુ પણ વિશ્વની સૌથી ઊંચી પ્રતિમાની મુલાકાત લેવા અંગે મૂંઝવણમાં છે, તેઓ માટે હું તમને આ વર્ચ્યુઅલ સ્ટેચ્યુ ઓફ યુનિટી પ્રવાસ શરૂ કરવા વિનંતી કરું છું.&nbsp;મને ખાતરી છે કે તમારે ગુજરાતના આ મહાકાવ્ય સ્મારકની મુલાકાત લેવાની શા માટે જરૂર છે તેનું કારણ તમે જાતે શોધી શકશો.&nbsp;તેથી વધુ પડતી મુશ્કેલી વિના, ચાલો પ્રારંભ કરીએ.</span></span></span></span></p>\n\n<h2 style=\"text-align:start\"><span style=\"font-size:14px\"><span style=\"font-family:-apple-system,system-ui,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;,&quot;Segoe UI Symbol&quot;\"><span style=\"color:#222222\"><span style=\"background-color:#ffffff\">સરદાર વલ્લભભાઈ પટેલ કોણ છે?</span></span></span></span></h2>\n\n<p style=\"text-align:start\"><span style=\"font-size:14px\"><span style=\"color:#222222\"><span style=\"font-family:-apple-system,system-ui,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;,&quot;Segoe UI Symbol&quot;\"><span style=\"background-color:#ffffff\">31 ઓક્ટોબર, 1875 ના રોજ ગુજરાતના નડિયાદમાં જન્મેલા, તેમનું પૂરું નામ&nbsp;<a href=\"https://en.wikipedia.org/wiki/Vallabhbhai_Patel\" rel=\"noreferrer noopener\" style=\"box-sizing:inherit; transition:color 0.1s ease-in-out 0s, background-color 0.1s ease-in-out 0s; text-decoration:underline; color:var(--accent)\" target=\"_blank\">વલ્લભભાઈ ઝવેરભાઈ પટેલ</a>&nbsp;હતું .&nbsp;તેઓ મોટા થયા અને તેમનું પ્રારંભિક શિક્ષણ ગુજરાતમાં જ પૂર્ણ કર્યું.&nbsp;તેમણે તેમની પ્રથમ કાયદાની પરીક્ષા - 1900માં જિલ્લા વકીલની પરીક્ષા પાસ કરી અને તેમની સ્વતંત્ર પ્રેક્ટિસ શરૂ કરી.&nbsp;વલ્લભભાઈ પટેલે વહેલાં લગ્ન કર્યાં - 16 વર્ષની ઉંમરે અને તેમને બે બાળકો હતા.&nbsp;દુર્ભાગ્યે, તેણે 1908 માં તેની પત્ની ગુમાવી દીધી અને બાકીના જીવન માટે તે વિધુર રહ્યો.&nbsp;1910 માં, તેઓ અદ્યતન કાયદાનો અભ્યાસ કરવા માટે મિડલ ટેમ્પલ યુકે ગયા અને ત્યારબાદ તેઓ અમદાવાદ, ભારતમાં પાછા આવ્યા.</span></span></span></span></p>\n\n<p style=\"text-align:start\"><span style=\"font-size:14px\"><span style=\"color:#222222\"><span style=\"font-family:-apple-system,system-ui,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;,&quot;Segoe UI Symbol&quot;\"><span style=\"background-color:#ffffff\">તેઓ ટૂંક સમયમાં જ પ્રખ્યાત ફોજદારી વકીલ બન્યા પરંતુ 1917 સુધી રાજકીય બળવો પ્રત્યે ઉદાસીન રહ્યા. તે પછી તેઓ પ્રથમ ભારતીય મ્યુનિસિપલ કમિશનર બન્યા.&nbsp;1928 માં, તેમણે બારડોલીમાં&nbsp;<a href=\"https://en.wikipedia.org/wiki/Civil_disobedience\" rel=\"noreferrer noopener\" style=\"box-sizing:inherit; transition:color 0.1s ease-in-out 0s, background-color 0.1s ease-in-out 0s; text-decoration:underline; color:var(--accent)\" target=\"_blank\">સવિનય આજ્ઞાભંગ ચળવળનું</a>&nbsp;નેતૃત્વ કર્યા પછી તેમણે સરદારનું બિરુદ મેળવ્યું .&nbsp;આ પછી, તેઓ ભારતને મુક્ત કરવા અંગ્રેજો સામેની ચળવળોમાં સક્રિય સહભાગી બન્યા.&nbsp;આમાં 1942માં&nbsp;લોકપ્રિય&nbsp;<a href=\"https://en.wikipedia.org/wiki/Quit_India_Movement\" rel=\"noreferrer noopener\" style=\"box-sizing:inherit; transition:color 0.1s ease-in-out 0s, background-color 0.1s ease-in-out 0s; text-decoration:underline; color:var(--accent)\" target=\"_blank\">ભારત છોડો ચળવળનો સમાવેશ થાય છે.</a></span></span></span></span></p>\n\n<p style=\"text-align:start\"><span style=\"font-size:14px\">ભારત સ્વતંત્ર થયા પછી, તેમણે નાયબ વડા પ્રધાન તરીકે કામ કર્યું.&nbsp;તેઓ એવા વ્યક્તિ તરીકે જાણીતા છે જેમણે 500 થી વધુ રજવાડાઓને એક સંયુક્ત ભારતમાં વિલીનીકરણ કરવામાં મદદ કરી હતી.&nbsp;બાદમાં, તેમણે મુક્ત ભારતના પ્રથમ ગૃહ પ્રધાનની ભૂમિકા નિભાવી.&nbsp;તેમના યોગદાનથી તેમને &quot;ભારતના લોખંડી પુરુષ&quot;નું બિરુદ મળ્યું.&nbsp;આ માણસ છે - સરદાર વલ્લભભાઈ પટેલ જે વિશ્વની સૌથી ઉંચી પ્રતિમા - સ્ટેચ્યુ ઓફ યુનિટી દ્વારા અમર થયા છે.</span></p>\n\n<h2 style=\"text-align:start\"><span style=\"font-size:14px\"><span style=\"font-family:-apple-system,system-ui,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;,&quot;Segoe UI Symbol&quot;\"><span style=\"color:#222222\"><span style=\"background-color:#ffffff\">કેવડિયામાં સ્ટેચ્યુ ઓફ યુનિટીનો ઈતિહાસ</span></span></span></span></h2>\n\n<p style=\"text-align:start\"><span style=\"font-size:14px\"><span style=\"color:#222222\"><span style=\"font-family:-apple-system,system-ui,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;,&quot;Segoe UI Symbol&quot;\"><span style=\"background-color:#ffffff\">તે ઓક્ટોબર 2013 માં હતું, કે ગુજરાતના તત્કાલિન મુખ્યમંત્રી - નરેન્દ્ર મોદીજીએ ગુજરાતમાં સરદાર પટેલની સૌથી ઊંચી પ્રતિમા બનાવવા માટેના મેગા પ્રોજેક્ટની જાહેરાત કરી હતી.&nbsp;થોડા દિવસો બાદ સરદાર પટેલની 138મી જન્મજયંતિ પર કેવડિયા ખાતે મોદીજી દ્વારા પહેલો શિલાન્યાસ કરવામાં આવ્યો હતો.&nbsp;આ પ્રોજેક્ટના અમલીકરણ માટે&nbsp;<em>સરદાર વલ્લભભાઈ પટેલ રાષ્ટ્રીય એકતા ટ્રસ્ટ (SVPRET)</em>&nbsp;નામના ટ્રસ્ટની રચના કરવામાં આવી હતી.&nbsp;ગુજરાત સરકાર સાથે મળીને તેમના દ્વારા હાથ ધરવામાં આવેલા મુખ્ય કાર્યોમાંનું એક ભારતમાં ગ્રામજનો પાસેથી ભંગાર લોખંડ એકત્ર કરવાનું હતું.&nbsp;2016 સુધીમાં, ખેડૂતો પાસેથી આશરે 135 મેટ્રિક ટન આયર્ન એકત્ર કરવામાં આવ્યું હતું જેમણે તેમના જૂના ખેતીના સાધનોનો ત્યાગ કર્યો હતો.</span></span></span></span></p>\n\n<p style=\"text-align:start\"><span style=\"font-size:14px\">ભંડોળ એકત્ર કરવા માટે રન ફોર યુનિટી જેવી અસંખ્ય ઇવેન્ટ્સ હાથ ધરવામાં આવી હતી.&nbsp;લાર્સન એન્ડ ટુબ્રો (L&amp;T) એ 2014 માં બાંધકામ માટે બિડ જીતી હતી અને મેઈનહાર્ટ ગ્રૂપ, ટર્નર કન્સ્ટ્રક્શન અને માઈકલ ગ્રેવ્સ એન્ડ એસોસિએટ્સ દ્વારા રચાયેલા કન્સોર્ટિયમની દેખરેખ હેઠળ પ્રોજેક્ટ શરૂ થયો હતો.&nbsp;તડવી જાતિ, લીમડી અને કેવડિયાના કેટલાક સ્થાનિકો અને આદિવાસીઓએ વિકાસનો વિરોધ કર્યો હતો.&nbsp;જો કે, વિરોધ હોવા છતાં, પ્રોજેક્ટ આકાર લીધો અને અંતે, 2018 માં સરદાર પટેલના 143મા જન્મદિવસ પર, મોદીજીએ શક્તિશાળી સ્ટેચ્યુ ઓફ યુનિટીનું ઉદ્ઘાટન કર્યું.&nbsp;તે માત્ર ભારતના લોખંડી પુરૂષને સમર્પણ નથી પરંતુ તે ભારતની એન્જિનિયરિંગ અને તકનીકી ક્ષમતાઓનું પ્રતિક છે.</span></p>\n\n<p style=\"text-align:start\">&nbsp;</p>\n', 'posted', '2023-06-10 14:42:14', 'gu-IN', 6, 'statue of unity,iron man,gujarat tourism,vadodara,tallest statue'),
(35, 34, 15, 'aa', 'Screenshot (11).png', '', 'deleted', '2023-05-19 01:44:33', 'am-ET', 4, ''),
(36, 34, 18, 'ramayana', 'Untitled Workspace.png', '<p>bhhh</p>\n', 'deleted', '2023-06-11 05:47:40', 'am-ET', 12, ''),
(37, 34, 18, 'new', 'WhatsApp Image 2023-04-23 at 18.26.57.jpg', '', 'deleted', '2023-06-11 05:47:29', 'be-BY', 35, ''),
(38, 34, 1, 'blogging', 'social networking diagram.jpg', '', 'deleted', '2023-06-09 06:03:59', 'bs-BA', 33, ''),
(39, 34, 2, 'hiii', 'Untitled Diagram.drawio (2).png', '<p>new nweee</p>\n', 'deleted', '2023-06-11 05:51:48', 'am-ET', 9, ''),
(40, 34, 6, 'new tryle', 'social networking diagram.jpg', '<p>ututuutut</p>\n', 'deleted', '2023-06-11 05:47:13', 'cy-GB', 71, 'blog,new,new blog,newtarde'),
(41, 34, 1, 'Nature', 'nature1.jpeg', '<p><strong>Nature</strong>, in the broadest sense, is the&nbsp;<a href=\"https://en.wikipedia.org/wiki/Physics\" title=\"Physics\">physical</a>&nbsp;world or&nbsp;<a href=\"https://en.wikipedia.org/wiki/Universe\" title=\"Universe\">universe</a>. &quot;Nature&quot; can refer to the&nbsp;<a href=\"https://en.wikipedia.org/wiki/Phenomenon\" title=\"Phenomenon\">phenomena</a>&nbsp;of the physical world, and also to life in general. The study of nature is a large, if not the only, part of&nbsp;<a href=\"https://en.wikipedia.org/wiki/Science\" title=\"Science\">science</a>. Although humans are part of nature, human activity is often understood as a separate category from other natural phenomena.<sup><a href=\"https://en.wikipedia.org/wiki/Nature#cite_note-What_does_nature_mean-1\">[1]</a></sup></p>\n\n<p>The word&nbsp;<em>nature</em>&nbsp;is borrowed from the&nbsp;<a href=\"https://en.wikipedia.org/wiki/Old_French\" title=\"Old French\">Old French</a>&nbsp;<em>nature</em>&nbsp;and is derived from the&nbsp;<a href=\"https://en.wikipedia.org/wiki/Latin\" title=\"Latin\">Latin</a>&nbsp;word&nbsp;<em>natura</em>, or &quot;essential qualities, innate disposition&quot;, and in ancient times, literally meant &quot;<a href=\"https://en.wikipedia.org/wiki/Birth\" title=\"Birth\">birth</a>&quot;.<sup><a href=\"https://en.wikipedia.org/wiki/Nature#cite_note-etymonline-nature-2\">[2]</a></sup>&nbsp;In ancient philosophy,&nbsp;<em>natura</em>&nbsp;is mostly used as the Latin translation of the Greek word&nbsp;<em><a href=\"https://en.wikipedia.org/wiki/Physis\" title=\"Physis\">physis</a></em>&nbsp;(&phi;ύ&sigma;&iota;&sigmaf;), which originally related to the intrinsic characteristics of plants, animals, and other features of the world to develop of their own accord.<sup><a href=\"https://en.wikipedia.org/wiki/Nature#cite_note-3\">[3]</a></sup><sup><a href=\"https://en.wikipedia.org/wiki/Nature#cite_note-4\">[4]</a></sup>&nbsp;The concept of nature as a whole, the physical&nbsp;<a href=\"https://en.wikipedia.org/wiki/Universe\" title=\"Universe\">universe</a>, is one of several expansions of the original notion;<sup><a href=\"https://en.wikipedia.org/wiki/Nature#cite_note-What_does_nature_mean-1\">[1]</a></sup>&nbsp;it began with certain core applications of the word &phi;ύ&sigma;&iota;&sigmaf; by&nbsp;<a href=\"https://en.wikipedia.org/wiki/Pre-Socratic_philosophy\" title=\"Pre-Socratic philosophy\">pre-Socratic</a>&nbsp;philosophers (though this word had a dynamic dimension then, especially for&nbsp;<a href=\"https://en.wikipedia.org/wiki/Heraclitus\" title=\"Heraclitus\">Heraclitus</a>), and has steadily gained currency ever since.</p>\n\n<p>During the advent of modern&nbsp;<a href=\"https://en.wikipedia.org/wiki/Scientific_method\" title=\"Scientific method\">scientific method</a>&nbsp;in the last several centuries, nature became the passive reality, organized and moved by divine laws.<sup><a href=\"https://en.wikipedia.org/wiki/Nature#cite_note-5\">[5]</a></sup><sup><a href=\"https://en.wikipedia.org/wiki/Nature#cite_note-6\">[6]</a></sup>&nbsp;With the&nbsp;<a href=\"https://en.wikipedia.org/wiki/Industrial_revolution\" title=\"Industrial revolution\">Industrial revolution</a>, nature increasingly became seen as the part of reality deprived from intentional intervention: it was hence considered as sacred by some traditions (<a href=\"https://en.wikipedia.org/wiki/Jean-Jacques_Rousseau\" title=\"Jean-Jacques Rousseau\">Rousseau</a>, American&nbsp;<a href=\"https://en.wikipedia.org/wiki/Transcendentalism\" title=\"Transcendentalism\">transcendentalism</a>) or a mere decorum for&nbsp;<a href=\"https://en.wikipedia.org/wiki/Divine_providence\" title=\"Divine providence\">divine providence</a>&nbsp;or human history (<a href=\"https://en.wikipedia.org/wiki/Hegel\" title=\"Hegel\">Hegel</a>,&nbsp;<a href=\"https://en.wikipedia.org/wiki/Marx\" title=\"Marx\">Marx</a>). However, a&nbsp;<a href=\"https://en.wikipedia.org/wiki/Vitalist\" title=\"Vitalist\">vitalist</a>&nbsp;vision of nature, closer to the pre-Socratic one, got reborn at the same time, especially after&nbsp;<a href=\"https://en.wikipedia.org/wiki/Charles_Darwin\" title=\"Charles Darwin\">Charles Darwin</a>.<sup><a href=\"https://en.wikipedia.org/wiki/Nature#cite_note-What_does_nature_mean-1\">[1]</a></sup></p>\n\n<p>Within the various uses of the word today, &quot;nature&quot; often refers to&nbsp;<a href=\"https://en.wikipedia.org/wiki/Geology\" title=\"Geology\">geology</a>&nbsp;and&nbsp;<a href=\"https://en.wikipedia.org/wiki/Wildlife\" title=\"Wildlife\">wildlife</a>. Nature can refer to the general realm of living plants and animals, and in some cases to the processes associated with inanimate objects&mdash;the way that particular types of things exist and change of their own accord, such as the weather and geology of the&nbsp;<a href=\"https://en.wikipedia.org/wiki/Earth\" title=\"Earth\">Earth</a>. It is often taken to mean the &quot;<a href=\"https://en.wikipedia.org/wiki/Natural_environment\" title=\"Natural environment\">natural environment</a>&quot; or&nbsp;<a href=\"https://en.wikipedia.org/wiki/Wilderness\" title=\"Wilderness\">wilderness</a>&mdash;wild animals, rocks, forest, and in general those things that have not been substantially altered by human intervention, or which persist despite human intervention. For example, manufactured objects and human interaction generally are not considered part of nature, unless qualified as, for example, &quot;human nature&quot; or &quot;the whole of nature&quot;. This more traditional concept of natural things that can still be found today implies a distinction between the natural and the artificial, with the artificial being understood as that which has been brought into being by a human&nbsp;<a href=\"https://en.wikipedia.org/wiki/Consciousness\" title=\"Consciousness\">consciousness</a>&nbsp;or a human&nbsp;<a href=\"https://en.wikipedia.org/wiki/Mind\" title=\"Mind\">mind</a>. Depending on the particular context, the term &quot;natural&quot; might also be distinguished from the&nbsp;<a href=\"https://en.wiktionary.org/wiki/unnatural\" title=\"wikt:unnatural\">unnatural</a>&nbsp;or the&nbsp;<a href=\"https://en.wikipedia.org/wiki/Supernatural\" title=\"Supernatural\">supernatural</a>.<sup><a href=\"https://en.wikipedia.org/wiki/Nature#cite_note-What_does_nature_mean-1\">[1]</a></sup></p>\n', 'posted', '2023-06-11 05:58:51', 'en-GB', 173, 'nature'),
(42, 34, 1, 'gaming', '2223123.jpg', '', 'drafted', '2023-06-12 08:07:30', 'am-ET', 0, 'blog'),
(43, 34, 18, 'new game', '2223123.jpg', '', 'drafted', '2023-06-12 08:16:50', 'be-BY', 0, 'blog'),
(44, 44, 12, 'Welcome to San Antonio', 'san antonio.webp', '<p>The Lone Star State is home to one of the most unique and historic cities in the United States. San Antonio, Texas is a UNESCO World Heritage City of Gastronomy and the Culinary Capital of Texas with the best food arts fusions you will ever taste. An 11-day Fiesta. An incredible Riverwalk with an even more incredible back story. And some of the best art and architecture in America.</p>\n\n<h3>1. The first and only UNESCO World Heritage Site in Texas</h3>\n\n<p>In 2015, UNESCO designated a grouping of five Spanish colonial missions in the San Antonio area as a World Heritage site, one of only 24 UNESCO World Heritage sites in the United States. Explore the colonial-era architecture at&nbsp;<a href=\"https://artsandculture.google.com/partner/san-antonio-missions-national-historical-park\" target=\"_blank\">San Antonio Missions National Historical Park</a>, and check out&nbsp;<a href=\"https://artsandculture.google.com/partner/the-alamo\" target=\"_blank\">The Alamo</a>&nbsp;to see why San Antonio is called the Alamo City.</p>\n\n<h3>2. The largest collection of Latino art in the US and a bustling arts scene</h3>\n\n<p>San Antonio is a capital of Latino culture in the US, which is reflected in local art collections and stunning public art with ties to Latino heritage. The&nbsp;<a href=\"https://artsandculture.google.com/partner/san-antonio-museum-of-art\" target=\"_blank\">San Antonio Museum of Art&rsquo;s</a>&nbsp;collection spans from the ancient Americas to the present and includes an outstanding collection of&nbsp;<a href=\"https://artsandculture.google.com/story/kgVBP_XKqFsypQ\" target=\"_blank\">popular art</a>.&nbsp;<a href=\"https://artsandculture.google.com/partner/centro-de-artes-gallery\" target=\"_blank\">Centro de Artes Gallery</a>&nbsp;celebrates Latino art, and be sure to explore contemporary art centers, including&nbsp;<a href=\"https://artsandculture.google.com/partner/ruby-city\" target=\"_blank\">Ruby City</a>&nbsp;and The&nbsp;<a href=\"https://artsandculture.google.com/partner/blue-star-contemporary\" target=\"_blank\">Contemporary at Blue Star</a>, and&nbsp;<a href=\"https://artsandculture.google.com/partner/culture-commons-gallery\" target=\"_blank\">Culture Commons Gallery</a>. The&nbsp;<a href=\"https://artsandculture.google.com/partner/mcnay-art-museum\" target=\"_blank\">McNay Art Museum&rsquo;s</a>&nbsp;Spanish Colonial architecture houses a phenomenal collection from around the world, including contemporary Latino artists.</p>\n\n<p>Murals celebrating the city&rsquo;s Hispanic roots are&nbsp;<a href=\"https://artsandculture.google.com/story/WAVx-q1jQ7KMRg\" target=\"_blank\">all around the city</a>, from a celebration of Selena to the installation&nbsp;<em>Familia y Cultura es Vida</em>. Towering over downtown San Antonio is the famous&nbsp;<a href=\"https://artsandculture.google.com/asset/sebastian-torch-of-friendship-antorcha-de-amistad-2002-joel-salcido/dAFDQpWlzbOIHw\" target=\"_blank\">The Torch of Friendship</a>, a 65 foot sculpture made by the Mexican sculptor Sebastian, honoring the bond between San Antonio and Mexico, dating from pre-1836 when Texas was a part of Mexico.</p>\n\n<h3>3.&nbsp;<a href=\"https://artsandculture.google.com/story/bwVRd_XiEPSrTw\" target=\"_blank\">The River Walk</a>&nbsp;is an oasis and hub for local businesses</h3>\n\n<p>A 15-mile urban waterway runs through the middle of the city and is the heart of San Antonio&rsquo;s food, arts, and small businesses, from a floating fish installation to some of Texas&rsquo; most diverse culinary offerings. The River Walk, located one level below street level, is a multifaceted destination &mdash; while it is the most visited attraction in Texas, it also is a natural and calm world unto itself.</p>\n\n<h3>4. Native plants and gardens take center stage</h3>\n\n<p>Have you heard of the Blanco Crabapple, Eve&#39;s Necklace and Texas Mountain laurel? The Texas landscape is rich and varied &mdash; featuring desertscapes, evergreen piney woods, rolling hill country and thousands of miles of gulf beaches &mdash; and all of it is full of life. One place to see it all is the&nbsp;<a href=\"https://artsandculture.google.com/story/AQXxmdyoKEjD9w\" target=\"_blank\">Texas Native Trail</a>&nbsp;at the&nbsp;<a href=\"https://artsandculture.google.com/partner/san-antonio-botanical-garden\" target=\"_blank\">San Antonio Botanical Garden</a>, a 1.5-mile loop trail that winds through the native plants of Texas.&nbsp;<a href=\"https://artsandculture.google.com/partner/villa-finale-museum-gardens\" target=\"_blank\">Villa Finale Museum and Gardens</a>&nbsp;is another gorgeous stop for greenery and manicured gardens.</p>\n\n<h3>5. San Antonio is a gastronomic capital with diverse flavors</h3>\n\n<p>The city is not only the birthplace of Tex-Mex cuisine, but a true&nbsp;<a href=\"https://artsandculture.google.com/story/QQWR12mKuidfHA\" target=\"_blank\">center of gastronomy</a>&nbsp;and the Culinary Capital of Texas. San Antonio&rsquo;s legacy is a confluence of cultures: from Latino and Tejano heritage to German and Asian immigrants, chances are you&rsquo;ll find something for your palate.</p>\n\n<h3>6. Home of the&nbsp;<a href=\"https://artsandculture.google.com/story/OwUR_BDWydApcg\" target=\"_blank\">American Cowboy</a></h3>\n\n<p>Did you know San Antonio is home to the American Cowboy and Mexican Vaquero? The&nbsp;<a href=\"https://artsandculture.google.com/partner/briscoe-western-art-museum\" target=\"_blank\">Briscoe Western Art Museum</a>&nbsp;and the&nbsp;<a href=\"https://artsandculture.google.com/partner/witte-museum\" target=\"_blank\">Witte Museum</a>&nbsp;offer unique perspectives on the role of this American figure, from the Black men and women who&nbsp;<a href=\"https://artsandculture.google.com/story/5QXRW6aD0AXBhQ\" target=\"_blank\">shaped ranching culture</a>&nbsp;to Werner Segarra&rsquo;s photographs of&nbsp;<a href=\"https://artsandculture.google.com/story/OwUR_BDWydApcg\" target=\"_blank\">contemporary</a>&nbsp;Norte&ntilde;o Cowboys.</p>\n\n<h3>7. Diverse communities with rich histories</h3>\n\n<p>Historical organizations honor the difficulties and triumphs of past San Antonians. The&nbsp;<a href=\"https://artsandculture.google.com/partner/saaacam\" target=\"_blank\">San Antonio African American Community Archive and Museum</a>&nbsp;commemorates African American history in the city, and state Historical Commission sites&nbsp;<a href=\"https://artsandculture.google.com/partner/casa-navarro-state-historic-site\" target=\"_blank\">Casa Navarro</a>&nbsp;and the&nbsp;<a href=\"https://artsandculture.google.com/partner/landmark-inn-state-historic-site\" target=\"_blank\">Landmark Inn</a>&nbsp;explore the life of early Texan leaders and settlers. The&nbsp;<a href=\"https://artsandculture.google.com/partner/hmmsa\" target=\"_blank\">Holocaust Memorial Museum of San Antonio</a>&nbsp;is dedicated to the stories of Holocaust survivors. Annual events, including the University of Texas at San Antonio&rsquo;s Asian Festival, the largest Martin Luther King March in the country, and largest Diwali in America are must-sees as well.</p>\n', 'posted', '2023-06-12 08:46:41', 'en-GB', 2, 'San Antonio,travel,travelling,USA,History,UNESCO,Latino art'),
(45, 34, 1, 'jjii', '', '', 'deleted', '2023-06-12 09:12:04', 'am-ET', 0, 'blog'),
(46, 34, 15, 'foods and drinks for foofies', 'food-1024x682.jpg', '<p>Maintaining a healthy diet while travelling is not the world&rsquo;s easiest thing to do. Not only is your access to food restricted by what is available around you, but also the temptations to snack and eat junk food are enhanced when you hit the road. The good news is that eating and drinking healthily isn&rsquo;t impossible &ndash; you just need to keep these tips and tricks in mind the next time you hit the road. Packing healthier options with you The most obvious way to avoid indulging in bad snacks and drinks is by packing healthier options with you. If you have healthy food with you, you naturally won&rsquo;t feel the need to spend money and end up making bad choices. So, instead of being forced to buy a chocolate<em>&hellip;show more content&hellip;</em><br />\nYou don&rsquo;t have to just rely on packed goods in order to stay healthy &ndash; it is possible to buy healthy foods and drinks at your destination and on the road. When shopping at the airport or station (gas, bus or train), try to consider the above food choices as your go to items. Purchase turkey or chicken sandwiches, look for nut and fruit mixes with no added chocolate or sugar and skip the sugary beverages for water. Yogurt can be a great option, especially when soothing an upset stomach and opt for salads whenever possible. Just remember to have the dressing on the side to avoid those sneaky calories. Furthermore, check your options beforehand! If you know the route and especially the stations you&rsquo;ll be stopping by, check out what supermarkets or brands are available. You can even find discounts from VoucherBin to eat at restaurants across the UK to ensure you eat healthy and save money. For example, if you are staying at a Premier Inn, browse their website to see the menu and plan your meals ahead of time.</p>\n', 'posted', '2023-06-17 05:51:36', 'en-GB', 0, 'foods,drinks,foodies,foodlifestyle'),
(47, 34, 4, 'AI : a threat or a worship', 'image.jpg', '<p>HOBBES&rsquo;s dismissal of the religious dreams and visions that plagued the ignorant and the pious was predicated on his conviction, spelled out in the opening pages of&nbsp;<em>Leviathan</em>, that &ldquo;life is but a motion of Limbs.&rdquo; The heart, he reasoned, was &ldquo;but a Spring, the Nerves, but so many Strings&rdquo;. That being so, could we not say that &ldquo;all Automata . . . have an artificial life&rdquo;, or that human ingenuity might &ldquo;make an Artificial Animal&rdquo;? The human body was, after all, just a complex machine.</p>\n\n<p>Much the same could be said of the human mind. In his&nbsp;<em>Elements of Philosophy</em>, written a few years later, he reasoned that &ldquo;ratiocination&rdquo; &mdash; reasoned thought &mdash; was, at heart, &ldquo;computation&rdquo;. What went on in the head was ultimately no more than &ldquo;addition and subtraction . . . multiplication and division&rdquo;.</p>\n\n<p>The implication of these two convictions was momentous. If the body was no more than springs and joints, and the mind no more than addition and subtraction, it should, in theory, be possible to build a human from scratch. The idea remained a dream even as, fulfilling Hobbes&rsquo;s prophecy 200 years later, the logician George Boole firmly established &ldquo;the Laws of Thought on Which are Founded the Mathematical Theories of Logic and Probabilities&rdquo;.</p>\n\n<p>A century after Boole&rsquo;s work was published, the computer scientist John McCarthy coined the phrase &ldquo;<a href=\"https://www.churchtimes.co.uk/topics/artificial-intelligence-ai\" tabindex=\"-1\">artificial intelligence</a>&rdquo; at a conference at Dartmouth College, New Hampshire, and helped to establish a discipline that promised to turn Hobbes&rsquo;s vision into reality. If neuroscience was able to deconstruct all that was quintessentially human into signals in the brain, there was, in principle, no reason why computer science couldn&rsquo;t reconstruct it, one bit at a time.</p>\n\n<p><br />\nIT WAS decades before AI could boast of anything more than an aptitude for chess, but, by the time AlphaGo, a programme produced by Google&rsquo;s Deep Mind, beat Lee Sedol, the 18-times world champion, at the fiendishly difficult &ldquo;Go&rdquo;, it was beginning to look as if the game was up.</p>\n\n<p>For some, the prospect positively pulsed with potential.&nbsp;<a href=\"https://www.churchtimes.co.uk/topics/technology\" tabindex=\"-1\">Technology</a>&nbsp;offered the opportunity for the plodding, irrational, limited, analogue human to be augmented and transformed.&nbsp;<a href=\"https://www.churchtimes.co.uk/topics/hospitalsmedicine\" tabindex=\"-1\">Medicine</a>&nbsp;(or rather, medicine and public health) had more than doubled life expectancy (in some countries) over the course of the 20th century. Gene therapy promised to extend it further in the 21st, and brain-computer interfaces offered the possibility of cheating&nbsp;<a href=\"https://www.churchtimes.co.uk/topics/deathdying\" tabindex=\"-1\">death</a>&nbsp;altogether by scanning, digitising, and uploading the entire brain into a storage facility from which it could be downloaded and re-embodied at some point in the future (if desired).</p>\n\n<p>Whether or not this particularly ambitious goal was achievable, humans might be radically improved in other ways. AI offered the potential to break out from the constraints imposed by evolutionary biology, and re-engineer our frail, faulty humanity. Humans could use information technology to improve their memory, their mental processing, and even their morality. As Ray Kurzweil, the American futurist, who was the St Paul of this transhumanist gospel, claimed, with puppy-dog enthusiasm: &ldquo;We&rsquo;re going to get more neocortex, we&rsquo;re going to be funnier, we&rsquo;re going to be better at music. We&rsquo;re going to be sexier. . . We&rsquo;re really going to exemplify all the things that we value in humans to a greater degree.&rdquo; Amen.</p>\n\n<p>Re-engineered as a kind of super-species that was capable of self-virtualisation, humans might then escape the limitations of earth, and take their new form beyond the solar system, spreading out across the cosmos in some kind of interstellar mission.</p>\n\n<p>Such a human transformation was part of a wider, cosmic transformation that made the Soviets&rsquo; &ldquo;new man&rdquo; seem positively pedestrian. Intelligent machines could engineer other intelligent machines. Liberated by ever-faster processing power, AI would grow exponentially until it arrived at &ldquo;The Singularity&rdquo;, the point at which the new superintelligence would leave behind humans and their ponderous sublunary lives, and reshape itself, us, and the earth as it saw fit.</p>\n\n<p>&ldquo;Humans are merely tools for creating the Internet-of-All-Things, which may eventually spread out from planet Earth to pervade the whole galaxy and even the whole universe,&rdquo; Yuval Noah Harari wrote in&nbsp;<em>Homo Deus: A brief history of tomorrow</em>&nbsp;(Vintage, 2016). &ldquo;This cosmic data-processing system would be like God. It will be everywhere and will control everything.&rdquo;</p>\n\n<p><br />\nTHE idea that all this might not work out so well for humans themselves occurred to more than simply the professional dystopians. Stephen Hawking warned that, once this singularity was reached, humans would not be able to compete. &ldquo;The development of full&nbsp;<a href=\"https://www.churchtimes.co.uk/topics/artificial-intelligence-ai\" tabindex=\"-1\">artificial intelligence</a>&nbsp;could spell the end of the human race.&rdquo;</p>\n', 'posted', '2023-06-17 13:39:07', 'en-GB', 0, 'AI,threat,worship'),
(48, 34, 7, 'Movie : Extraction 2', 'Extraction2Review.jpg.webp', '<p>In our&nbsp;<em>Extraction 2</em>&nbsp;review, the movie takes audiences on another adrenaline-fueled ride with&nbsp;<a href=\"https://www.imdb.com/name/nm1165110/\" rel=\"noopener\" target=\"_blank\">Chris Hemsworth</a>&nbsp;reprising his role as the resilient and gritty Tyler Rake. Directed by&nbsp;<a href=\"https://www.imdb.com/name/nm1092087/?ref_=nv_sr_srsg_0_tt_1_nm_7_q_sam%2520hargrave\">Sam Hargrave</a>, known for his exceptional stunt coordination in films like&nbsp;<a href=\"https://www.themovieblog.com/2019/04/avengers-endgame-review/\" rel=\"noopener\" target=\"_blank\"><em>Avengers: Endgame</em></a>, the sequel builds upon the success of its predecessor and delivers a thrilling and intense cinematic experience.</p>\n\n<p>The film wastes no time in plunging viewers into the heart of the action. From the opening sequence, it becomes clear that&nbsp;<em>Extraction 2</em>&nbsp;is not going to hold back when it comes to jaw-dropping stunts and visceral fight scenes. The choreography is meticulously crafted, with every punch, kick, and gunshot feeling weighty and impactful. Hargrave&rsquo;s background as a stuntman shines through as he expertly captures the chaos and danger of the combat sequences, making them feel raw and authentic.</p>\n\n<p>&nbsp;</p>\n\n<p>One of the standout aspects of&nbsp;<em>Extraction 2</em>&nbsp;is its stunning cinematography. The film is set in the bustling city of Tbilisi, Georgia, and the visuals do justice to the vibrant and richly textured setting. The camera glides through the streets, capturing the city&rsquo;s energy and blending seamlessly with the high-octane action. The use of long takes and tracking shots during the action sequences adds a level of immersion rarely seen in the genre, making the audience feel like they are right in the midst of the chaos.</p>\n\n<p>Hemsworth once again proves his versatility as an actor, effortlessly portraying Tyler Rake&rsquo;s complex mix of toughness and vulnerability. Rake is a haunted and tormented character, and Hemsworth brings depth and emotional resonance to the role. His physicality is undeniable, but it is the quieter moments where he truly shines, revealing the layers of his character beneath the tough exterior.</p>\n\n<p>The screenplay, penned by&nbsp;<a href=\"https://www.themovieblog.com/tag/joe-russo/\">Joe Russo</a>, maintains a tight grip on the story, keeping the narrative momentum strong throughout. While&nbsp;<em>Extraction 2</em>&nbsp;is primarily an action film, it still manages to weave in moments of introspection and character development. The film explores themes of redemption, sacrifice, and the blurred lines between heroism and villainy. These thematic underpinnings elevate the film beyond its explosive set pieces and provide a satisfying emotional arc for the characters.</p>\n\n<p>In terms of its pacing,&nbsp;<em>Extraction 2</em>&nbsp;rarely lets up, delivering one pulse-pounding sequence after another. The stakes are constantly raised, and the tension never wanes. However, there are instances where the film could have benefited from a bit more breathing room. Some scenes feel rushed, preventing the audience from fully absorbing the consequences of the characters&rsquo; actions. Nonetheless, this fast-paced approach also adds to the film&rsquo;s relentless energy and keeps viewers on the edge of their seats.</p>\n\n<p>&nbsp;</p>\n\n<p>The film&rsquo;s score, composed by Henry Jackman and Alex Belcher, complements the action perfectly. It swells and recedes in all the right places, heightening the tension and accentuating the emotional beats. From the thunderous percussion during the fight scenes to the haunting melodies during the quieter moments, the music becomes an integral part of the film&rsquo;s overall experience.</p>\n', 'posted', '2023-06-18 02:59:47', 'en-GB', 3, 'chris hemsworth,marvel,russo bros,extraction,extraction : 2'),
(49, 34, 10, 'cricket is a favorite sport', 'my-favourite-game-cricket-essay.webp', '<p>Cricket is not just a game but an emotion for all Indians. We consider it a festival, and it brings us immense happiness. It is sometimes also said that cricket is also the unofficial sport of India. We love it to the extent that we consider cricketers as our own family members. Here are a few sample essays on the topic &lsquo;my favourite game cricket&rsquo;.</p>\n\n<p>&nbsp;</p>\n\n<p>Cricket is my favourite game. It is a very famous sport and has immensely evolved during the ages. Cricket is for both men and women. It is an outdoor game which requires a total of 11 players. Two teams play against each other, and the team with the maximum number of runs wins the match. Cricket can be played in three forms - a test match, a twenty-twenty and a one-day game. Cricket has two parts - one is batting, and the other is fielding or bowling. The team that wins the toss gets to choose whether they are willing to bat or bowl. My favourite is batting since I excel in that part. Cricket is also known as the &ldquo;game of uncertainty&rdquo;, as the winner cannot be easily predicted until the last ball.</p>\n\n<p>&nbsp;</p>\n\n<p>&nbsp;</p>\n\n<p dir=\"ltr\">I love playing all sports, but a sport that excites me is cricket. Two teams consisting of 11 players each play it. The official body that governs all cricket and organises tournaments is ICC. Cricket has three formats mainly: test format, ODI format, and T20 format. The test match is for five days. The ODI runs for 50 overs, and the T20 game is for 20 overs which is the shortest format.</p>\n\n<p dir=\"ltr\">Cricket has been an integral part of my life since my childhood. Playing gully cricket with my friends on Sunday afternoons is a memory that till now I love to relive. Each six, four, or wicket can bring tears to our eyes, either of joy or sadness. I still remember the world cup winning night in 2011. We were all jumping with happiness, and that six from Dhoni made us cry out of joy. I was also a batsman in a state-level team back then. Every game of cricket makes me happy, and the glee of playing or watching cricket is immeasurable. This game has taught me sportsmanship spirit and to never give up until the game is over. Cricket is not just a game but rather a beautiful emotion.</p>\n', 'posted', '2023-06-18 06:01:17', 'en-GB', 0, 'cricket,ipls2023,wtcfinal,odiwc2023'),
(50, 43, 11, 'bgmi back in india', 'bgmi.webp', '<p>Krafton, the creators of the popular game Battlegrounds Mobile India (BGMI), has revealed that the game will be making a comeback to Android and iOS platforms. BGMI had been banned in India in July 2022 citing security concerns. However, Krafton has confirmed that they will soon bring back the game, which will be available for download.</p>\n\n<p>Sean Hyunil Sohn, CEO of KRAFTON, Inc. India, expressed his gratitude, stating, &quot;We are highly grateful to the Indian authorities for allowing us to resume operations of Battlegrounds Mobile India (BGMI). We would like to extend our gratitude to our Indian gaming community for their support and patience over the past few months.&quot; He also conveyed his excitement in welcoming players back to the platform and emphasized the power of gaming to bring people together and create unforgettable experiences.</p>\n\n<p>Sohn further emphasized Krafton&#39;s commitment to the Indian gaming ecosystem: &quot;At KRAFTON, Inc., we are deeply committed to the Indian gaming ecosystem. Our approach has always been India-first, which serves as the foundation of all our efforts.&quot; He highlighted their investment in the Indian gaming industry, collaboration with local developers, and promotion of cutting-edge technologies to foster growth and innovation.</p>\n\n<p>Vibhor Kukreti, Head of Government Affairs at KRAFTON, Inc. India, said, &quot;We would like to express our deep appreciation and gratitude to the authorities for permitting us to restart the operations of BATTLEGROUNDS MOBILE INDIA (BGMI). KRAFTON, Inc. is a responsible South Korean organization that abides by the law and has put in place several measures to ensure compliance with all applicable regulations. We work tirelessly to ensure that India takes the lead in this domain by embracing innovative practices in collaboration with the gaming ecosystem to support, sustain and promote its growth.&quot;</p>\n\n<p>After accumulating over 100 million users in India, BGMI faced removal following India&#39;s 2020 ban on another popular Krafton game, PlayerUnknown&#39;s Battlegrounds (PUBG). The crackdown on PUBG was initiated by New Delhi, as part of a broader ban on over 100 mobile apps originating from China. This move came in the wake of a prolonged border standoff between the with China in Galwan Valley.</p>\n\n<p>BGMI claims that before the ban the game surpassed 100 million cumulative users in less than two years. The studio that created BGMI also claims that the game played a pivotal role in building the esports ecosystem in India by offering India-centric events and content.&nbsp;</p>\n', 'posted', '2023-06-19 06:15:34', 'en-GB', 0, 'bgmi'),
(51, 43, 11, 'biparjoy: a new cyclone comming ...', 'cyclone.jpeg', '<p><strong>Cyclone Biporjoy Update:&nbsp;</strong>If you are looking for the latest news about cyclone Biporjoy, You have come to the right place we have provided. All the important information about the cyclone from the cyclone Biporjoy route, live location, trajectory, speed, and the latest updates on the Ccylone Biporjoy. Scroll down below to know all the important information about Cyclone Biporjoy.&nbsp;</p>\n\n<p>&nbsp;</p>\n\n<h2><strong>Cyclone Biporjoy Update</strong></h2>\n\n<p>As of now, the Biporjoy route is&nbsp;<strong>715 km south of Karachi coast&nbsp;</strong>and it is expected to reach Gujarat and Mumbai coastal areas in the next couple of hours. All the people near the coastal areas mainly in the Gujarat and Mumbai are advised to stay at home or relocate from the coastal area for a few days.&nbsp;</p>\n\n<h3><strong>Cyclone Biporjoy Live Location&nbsp;</strong></h3>\n\n<p>Currently, Cyclone Biporjoy has been&nbsp;<strong>located 715 km south of Karachi Pakistan</strong>&nbsp;and now it is moving northward at&nbsp;<strong>9 km/h for the last 6 hours</strong>. All the people are advised to stay home and people near coastal Gujrat mainly Saurashtra and Kutch are advised to evacuate for a few hours from the coastal area.</p>\n\n<p>&nbsp;</p>\n\n<p>Cyclone Biporjoy is becoming intense and may cause some serious damage to properties and people around Gujarat and Mumbai coastal areas in the next couple of hours.&nbsp;</p>\n\n<p>&nbsp;</p>\n\n<h3><strong>Cyclone Biporjoy Speed&nbsp;</strong></h3>\n\n<p>The current cyclone Biporjoy speed is above 100 km per hour and it is expected to reach 150 km per hour in the next couple of hours. The cyclone is expected to cause severe massive destruction around Gujarat and Mumbai coastal areas and it is expected to reach the Gujarat and Mumbai coastal areas mainly Saurashtra and Kutch coasts of Gujarat.</p>\n\n<p>&nbsp;</p>\n\n<p>&nbsp;In the next couple of hours, all the people around Mumbai and Gujarat coastal areas mainly Saurashtra and Kutch coasts are advised to evacuate from the sea areas and strictly stated not to go into the sea by the IMD of India.&nbsp;</p>\n\n<p>And the Gujurat districts may see heavy rainfall on the 15th Thursday 2023. People are advised to stay home and people near the coastal area of the Gujurat are advised to evacuate for a few days from the Gujarat coast.&nbsp;</p>\n\n<h3><strong>Cyclone Biporjoy Wind</strong></h3>\n\n<p>Currently, cyclone Biporjoy wind speed is around 125 to 135 km per hour and it is expected to rise to 150 km per hour for the next few hours and it is expected to hit Gujarati coastal area on 15th Thursday evening.</p>\n', 'posted', '2023-06-19 06:20:13', 'en-GB', 1, 'bipaarjoy,cyclone'),
(52, 43, 10, 'R Ashwin exclusion in WTC final', 'exclusion.webp', '<p>Sachin Tendulkar, the renowned cricket legend, expressed his bewilderment at the exclusion of senior off-spinner Ravichandran Ashwin from India&#39;s playing XI in the World Test Championship final. Tendulkar emphasized that a spinner of Ashwin&#39;s caliber does not rely solely on conducive conditions to showcase his effectiveness.</p>\n\n<p>n the WTC final, Australia dominated India with a comprehensive 209-run victory. Coach Rahul Dravid justified Ashwin&#39;s absence by citing the overcast conditions that compelled the team to opt for a fourth specialist seamer, especially considering the presence of five left-handed batsmen in the opposition lineup.</p>\n\n<p>Throughout the five days of the match, bright sunshine prevailed, and Australia amassed a formidable total of 469 runs in their first innings, effectively shutting the doors on India&#39;s chances.</p>\n\n<p>Expressing his surprise, Tendulkar took to Twitter to express his thoughts, questioning the decision to exclude Ashwin from the playing XI. Tendulkar highlighted that Ashwin currently holds the top spot as the number one Test bowler in the world, making his absence even more perplexing.</p>\n\n<p>Tendulkar further emphasized that he found it difficult to believe that a bowler of Ashwin&#39;s caliber could not be utilized in conditions that favored seamers. He reiterated his earlier statement that skillful spinners do not solely rely on turning tracks but instead utilize variations in drift and bounce to deceive the batsmen. Tendulkar also noted that Australia had five left-handed batsmen among their top eight, making Ashwin&#39;s potential impact even more significant. It is worth mentioning that Ashwin had an impressive record, claiming 61 wickets in 13 Tests during the two-year cycle of the second edition of the World Test Championship.<br />\n&nbsp;</p>\n\n<p>&nbsp;</p>\n', 'posted', '2023-06-19 06:25:09', 'en-GB', 1, 'sachin tendulkar,sunil gavaskar,wtcfinal,R Ashwin,Exclusion'),
(53, 43, 12, 'Travelling is just fun!!', 'travelling-essay.png', '<p>Travelling is an amazing way to learn a lot of things in life. A lot of people around the world travel every year to many places. Moreover, it is important to travel to humans. Some travel to learn more while some travel to take a break from their life. No matter the reason, travelling opens a big door for us to explore the world beyond our imagination and indulge in many things. Therefore, through this Essay on Travel, we will go through everything that makes travelling great.</p>\n\n<h3><strong>Why Do We Travel?</strong></h3>\n\n<p>There are a lot of reasons to travel. Some people travel for fun while some do it for education purposes. Similarly, others have business reasons to travel. In order to travel, one must first get an idea of their financial situation and then proceed.</p>\n\n<p>Understanding your own reality helps people make good travel decisions. If people gave enough opportunities to travel, they set out on the journey. People going on educational tours get a first-hand experience of everything they&rsquo;ve read in the text.</p>\n\n<p>Similarly, people who travel for fun get to experience and indulge in refreshing things which may serve as a&nbsp;<a href=\"https://www.toppr.com/en-us/ask/question/what-is-stress-and-what-are-causes-of-stress/\">stress</a>&nbsp;reducer in their lives. The culture, architecture, cuisine and more of the place can open our mind to new things.</p>\n\n<h3><strong>The Benefits of Travelling</strong></h3>\n\n<p>There are numerous benefits to travelling if we think about it. The first one being, we get to meet new people. When you meet new people, you get the opportunity to make new friends. It may be a fellow traveller or the local you asked for directions.</p>\n\n<p>Moreover, new age technology has made it easier to keep in touch with them. Thus, it offers not only a great way to understand human nature but also explore new places with those friends to make your trip easy.</p>\n\n<p>Similar to this benefit, travelling makes it easier to understand people. You will learn how other people eat, speak, live and more. When you get out of your comfort zone, you will become more sensitive towards other cultures and the people.</p>\n\n<p>Another important factor which we learn when we travel is learning new skills. When you go to hilly areas, you will most likely trek and thus, trekking will be a new skill added to your list.</p>\n\n<p>Similarly, scuba diving or more can also be learned while travelling. A very important thing which travelling teaches us is to enjoy nature. It helps us appreciate the true beauty of the&nbsp;<a href=\"https://www.toppr.com/guides/geography/inside-our-earth/\">earth</a>.</p>\n', 'posted', '2023-06-19 06:30:03', 'en-GB', 4, 'travel,travelling');
INSERT INTO `blogs` (`blog_id`, `usid`, `bcid`, `blog_title`, `blog_cover_photo`, `blog_content`, `blog_status`, `blog_post_time`, `lcode`, `blog_view`, `tags`) VALUES
(54, 34, 14, 'design and development in Web', 'web-design-development-blog.jpg', '<p>There are many online platforms for&nbsp;<a href=\"https://www.digital4design.com/web-development-company-usa-uk-india/\">website development</a>, each with its own strengths and weaknesses. The best platform for website development will depend on your specific needs and goals. Here are some popular options:</p>\n\n<p><strong><a href=\"https://wordpress.com/\">WordPress</a>:</strong>&nbsp;WordPress is one of the most popular website development platforms. It is an open-source content management system (CMS) that allows users to create and manage websites with ease. WordPress offers thousands of templates and plugins, making it a versatile and customizable platform.</p>\n\n<p>WordPress is one of the best and effective development platform to develop custom websites that can effectively represent your business. Choice of choosing right&nbsp;<a href=\"https://www.crunchbase.com/organization/digital4design\">WordPress Development Company</a>&nbsp;you can enhance your business outcomes.</p>\n\n<p>There are several reasons why you may need a WordPress development company to build and manage your business website:</p>\n\n<ol>\n	<li>Expertise: A professional company will have experienced developers who are skilled in designing and building websites using WordPress. They can provide you with customized solutions that meet your specific business needs.</li>\n	<li>Time-saving: It can save you time by handling the technical aspects of building a website, leaving you free to focus on your business operations.</li>\n	<li>Customization: Professionals can create custom themes and plugins that match your brand and make your website unique. They can also help you integrate third-party tools and services that enhance your website&rsquo;s functionality.</li>\n	<li>Maintenance and Support: A reputed company can provide ongoing maintenance and support for your website, ensuring that it runs smoothly and stays up-to-date with the latest security patches and updates.</li>\n	<li>Scalability: WordPress is a scalable platform, which means that it can accommodate your business&rsquo;s growth and evolving needs. A WordPress development company can help you plan for future growth and ensure that your website can scale accordingly.</li>\n</ol>\n\n<p>Overall, working with a&nbsp;<a href=\"https://www.digital4design.com/web-development-company-usa-uk-india/wordpress-development-company-usa-uk-india/\">WordPress development company</a>&nbsp;can provide you with a professional, customized, and scalable website that supports your business goals and enhances your online presence.</p>\n\n<p><a href=\"https://www.wix.com/\"><strong>Wix</strong></a>: Wix is a drag-and-drop website builder that allows users to create websites without coding. It offers a range of customizable templates and features, making it easy to create a professional-looking website quickly.</p>\n\n<p><a href=\"https://www.squarespace.com/\"><strong>Squarespace</strong></a>: Squarespace is a website builder that offers a range of templates and design tools. It is a popular choice for e-commerce sites, as it integrates with a range of payment and shipping providers.</p>\n\n<p><a href=\"https://www.shopify.com/in\"><strong>Shopify</strong></a>: Shopify is an e-commerce platform that allows users to create and manage online stores. It offers a range of customizable templates and features, including payment and shipping options.</p>\n\n<p>&nbsp;</p>\n\n<p>Ultimately, the best online platform for website development will depend on your specific needs, goals, and technical abilities. It&rsquo;s a good idea to try out a few different platforms before committing to one.</p>\n\n<p>With the help of&nbsp;<a href=\"https://in.linkedin.com/company/digital4design\">professional web developers</a>&nbsp;you can make it much better for users and search engines that will enhance the overall presence of your business on web.</p>\n', 'posted', '2023-06-20 01:26:22', 'en-GB', 0, 'design,development,wd,web development,web design,designing,wordpress,wix'),
(55, 44, 19, 'Employee motivation', 'business.png', '<p>Employee Motivation is a significant leadership task and has always been an enigma with many avenues amidst adverse situations. There are no ubiquitous approach frameworks but unique solutions are needed for every set of employees based on their skillsets, environment and behavioural aspects. Leaders motivate through their long term vision and principles supported by incentives and reward systems. It is to be borne in mind that the leadership process itself is a major motivating factor, which stimulates the team towards the goals. There is no ideal motivation algorithm that can be applied uniformly to all the situations and hence they have to be tailor made based on a heuristic approach after understanding the team composition, strengths, weaknesses and progress inhibiting factors.</p>\n\n<p>People misconstrue Motivation as an exclusive leadership responsibility but it is ultimately the employees who need to achieve self motivation for progress and growth. It would be well nigh impossible for the Leader to apply different tools for motivating various individuals. Normally, the scope of the leader is to create a conducive environment, helpful and empathetic ecosystem and an equitable platform to enable people to perform and reach the set goals with ease and efficiency. Does Leadership scope ends with laying a fair and open system only ? This is where Goldilocks Rule comes into play, which states that &rdquo; Human beings experience motivation when working on tasks that are right on the edge of their current abilities ; Not too hard ; Not too easy ; Just Right &ldquo;. The role of leadership is to identify the right people for the right jobs and not square pegs in round holes to motivate the team to perform well.</p>\n\n<p>This path breaking rule specifies that a person gets motivated to achieve results only with the right job tuned to his capabilities with a little stretch. Tough assignments lure many achievers but it has to be within their circle of Competence. Too easy jobs end up in frustration and promote complacency. Job felicity of the individual and the adroit job assignment play crucial roles in individual motivation. Secondly, Leadership focus is always on grooming talent to adorn higher level roles. Many leaders commit the folly of grooming only the topmost performer for the higher role template. A leader should not only be an excellent performer but he should have the potential to lead the team towards success. People with leadership potential should be identified and groomed for line functions and top performers should be given challenging project assignments in order to motivate them towards higher success. This type of adept placement strategy works very well with Individual aspirations and the benefits for the organization.</p>\n\n<p>Thirdly, an interactive and transparent feedback sharing mechanism works wonders for employee morale and teamwork. An open atmosphere itself is a stimulator and motivates the team for higher efficiency levels. It is not just a question of motivating for career growth and higher rewards but creating a sense of belongingness and an aura of job importance also play a critical role in enhancing the level of enthusiasm of the individuals. It is essential to know what motivates the people, how they respond to feedback and what type of tasks fit them well. In this backdrop, McClelland&rsquo;s Human Motivation theory comes to the aid of the Leaders. He identified three common motivators, namely a need for achievement, a need for affiliation and a need for power. People&rsquo;s behavioural patterns and characteristics depend on their dominant motivator. One needs to identify the essential drivers, structure their approach accordingly to assign tasks and motivate the team for better results.</p>\n\n<p>In essence, the Managements need to have a paradigm shift from a reward based model to a need based motivation structure and devise their strategies for better employee engagement, scientific assignment of roles and create motivated teams in pursuit of excellence in all the spheres of activity.</p>\n', 'posted', '2023-06-20 01:33:58', 'en-GB', 19, 'business,emplyoee,motivation,path to success');



-- --------------------------------------------------------

--
-- Table structure for table `blog_categorys`
--

CREATE TABLE `blog_categorys` (
  `bcid` int(11) NOT NULL,
  `bcname` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blog_categorys`
--



-- --------------------------------------------------------

--
-- Table structure for table `blog_comments`
--

CREATE TABLE `blog_comments` (
  `blog_comment_id` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `usid` int(11) NOT NULL,
  `parent_comment_id` int(11) NOT NULL DEFAULT 0,
  `comment` longtext NOT NULL,
  `status_up_del` varchar(100) NOT NULL DEFAULT 'inserted',
  `time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blog_comments`
--


-- --------------------------------------------------------

--
-- Table structure for table `blog_comment_like_tb`
--

CREATE TABLE `blog_comment_like_tb` (
  `blog_comment_like_id` int(11) NOT NULL,
  `blog_comment_id` int(11) NOT NULL,
  `usid` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `status_clike` varchar(100) NOT NULL,
  `blog_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blog_comment_like_tb`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog_likes`
--

CREATE TABLE `blog_likes` (
  `blog_like_id` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `usid` int(11) NOT NULL,
  `status_like_dislike` varchar(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blog_likes`
--


-- --------------------------------------------------------

--
-- Table structure for table `blog_viewstb`
--

CREATE TABLE `blog_viewstb` (
  `blog_views_id` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `usid` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `blog_viewstb`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookmarktb`
--

CREATE TABLE `bookmarktb` (
  `bmid` int(11) NOT NULL,
  `usid` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `word` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pos` int(250) NOT NULL,
  `type` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `bookmarktb`
--



-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `chat_id` int(11) NOT NULL,
  `in_usid` int(11) NOT NULL,
  `out_usid` int(11) NOT NULL,
  `msg` mediumtext NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` mediumtext NOT NULL DEFAULT '\'seen,delete,update,singletick,doubletick\''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ctb`
--

CREATE TABLE `ctb` (
  `id` int(11) NOT NULL,
  `content` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ctb`
--

-- --------------------------------------------------------

--
-- Table structure for table `endorse`
--

CREATE TABLE `endorse` (
  `endorse_id` int(11) NOT NULL,
  `request_from_usid` int(11) NOT NULL,
  `request_to_blogger_usid` int(11) NOT NULL,
  `createtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `modify_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `status_of_subscribe` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `lcode` varchar(500) NOT NULL,
  `lname` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `languages`
--

-- --------------------------------------------------------

--
-- Table structure for table `lists`
--

CREATE TABLE `lists` (
  `list_id` int(11) NOT NULL,
  `usid` int(11) NOT NULL,
  `list_title` varchar(1000) NOT NULL,
  `time` datetime NOT NULL DEFAULT current_timestamp(),
  `list_status` varchar(20) NOT NULL DEFAULT 'private'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `lists`
--


-- --------------------------------------------------------

--
-- Table structure for table `lists_content`
--

CREATE TABLE `lists_content` (
  `lcid` int(11) NOT NULL,
  `list_id` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `contant_status` varchar(20) NOT NULL DEFAULT 'private'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `lists_content`
--



-- --------------------------------------------------------

--
-- Table structure for table `logins`
--

CREATE TABLE `logins` (
  `loginid` int(11) NOT NULL,
  `usid` int(11) NOT NULL,
  `last_act` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `usid` int(11) NOT NULL,
  `notify_type` varchar(100) NOT NULL,
  `notify_type_id` int(11) NOT NULL,
  `status_of_seen` varchar(100) NOT NULL DEFAULT 'new',
  `time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notification_id`, `usid`, `notify_type`, `notify_type_id`, `status_of_seen`, `time`) VALUES


-- --------------------------------------------------------

--
-- Table structure for table `readlists`
--

CREATE TABLE `readlists` (
  `readlist_id` int(11) NOT NULL,
  `usid` int(11) NOT NULL,
  `readlist_title` varchar(1000) NOT NULL,
  `description` varchar(10000) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `status_blogger_side_show_hide` int(11) DEFAULT NULL,
  `blogs_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `report_id` int(11) NOT NULL,
  `usid` int(11) NOT NULL,
  `report_type` varchar(100) NOT NULL,
  `report_type_id` int(11) NOT NULL,
  `reason` varchar(10000) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reports`
--



-- --------------------------------------------------------

--
-- Table structure for table `save_and_history_blogs`
--

CREATE TABLE `save_and_history_blogs` (
  `save_blog_id` int(11) NOT NULL,
  `usid` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `type_history_save` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `save_and_history_blogs`
--


-- --------------------------------------------------------

--
-- Table structure for table `searches`
--

CREATE TABLE `searches` (
  `search_id` int(11) NOT NULL,
  `usid` int(11) NOT NULL,
  `serch_type` varchar(100) NOT NULL,
  `serach_type_id` int(11) NOT NULL,
  `searched_text` varchar(10000) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `usid` int(11) NOT NULL,
  `ufname` varchar(100) DEFAULT NULL,
  `ulname` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(500) NOT NULL,
  `mbno` int(11) DEFAULT NULL,
  `password` varchar(1000) NOT NULL,
  `photo` varchar(10000) DEFAULT NULL,
  `onlinestatus` varchar(100) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `gender` varchar(100) DEFAULT NULL,
  `joindate` timestamp NULL DEFAULT current_timestamp(),
  `location_js` varchar(1000) DEFAULT NULL,
  `user_type` varchar(100) DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`usid`, `ufname`, `ulname`, `email`, `username`, `mbno`, `password`, `photo`, `onlinestatus`, `birthdate`, `gender`, `joindate`, `location_js`, `user_type`) VALUES
(1, NULL, NULL, 'kathanshah2210@gmail.com', 'user1', NULL, 'user111', NULL, NULL, NULL, 'other', '2023-04-01 11:10:54', NULL, 'deleted'),
(2, NULL, NULL, 'kathanshah2210@gmail.com', 'user2', NULL, 'user222', NULL, NULL, NULL, 'female', '2023-04-01 11:13:09', NULL, 'deleted'),
(3, NULL, NULL, 'kathanshah2210@gmail.com', 'user3', NULL, '', NULL, NULL, NULL, NULL, '2023-04-01 16:58:42', NULL, 'deleted'),
(4, NULL, NULL, 'kathanshah2210@gmail.com', 'user1234512', NULL, '', NULL, NULL, NULL, 'female', '2023-04-01 17:22:14', NULL, 'deleted'),
(5, NULL, NULL, 'kathanshah2210@gmail.com', 'user3', NULL, '', NULL, NULL, NULL, NULL, '2023-04-01 17:24:27', NULL, 'deleted'),
(6, NULL, NULL, 'kathanshah2210@gmail.com', 'user3', NULL, '', NULL, NULL, NULL, 'male', '2023-04-01 17:26:12', NULL, 'deleted'),
(7, NULL, NULL, 'kathanshah2210@gmail.com', 'user3', NULL, 'user3', NULL, NULL, NULL, NULL, '2023-04-01 17:30:53', NULL, NULL),
(8, NULL, NULL, 'kathanshah2210@gmail.com', 'user3', NULL, 'user3', NULL, NULL, NULL, 'other', '2023-04-01 17:32:56', NULL, NULL),
(9, NULL, NULL, 'kathanshah2210@gmail.com', 'user4', NULL, 'user544', NULL, NULL, NULL, NULL, '2023-04-02 04:34:59', NULL, NULL),
(10, NULL, NULL, 'kathanshah2210@gmail.com', 'users_12345', NULL, '', NULL, NULL, NULL, 'other', '2023-04-02 05:17:27', NULL, 'deleted'),
(11, NULL, NULL, 'kathanshah2210@gmail.com', 'user1234', NULL, 'User@1234', NULL, NULL, NULL, 'other', '2023-04-02 05:34:38', NULL, 'user'),
(12, NULL, NULL, 'kathanshah2210@gmail.com', 'abhay_12', NULL, '$2y$10$a4xhippO8qQOY22zt8nai.HCuCwc9O8DOKpamIuf9i1f7EFX0DRKu', NULL, NULL, NULL, 'other', '2023-04-02 05:44:19', NULL, 'blogger'),
(13, NULL, NULL, 'kathanshah2210@gmail.com', 'user11111', NULL, 'Usedr@123', NULL, NULL, NULL, NULL, '2023-04-02 05:47:12', NULL, NULL),
(14, NULL, NULL, 'kathanshah2210@gmail.com', 'user12345', NULL, 'Usera@123', NULL, NULL, NULL, NULL, '2023-04-02 06:00:24', NULL, 'blogger'),
(15, NULL, NULL, 'kathanshah2210@gmail.com', 'user11212', NULL, 'Userw@123', NULL, NULL, NULL, NULL, '2023-04-02 06:01:15', NULL, NULL),
(16, NULL, NULL, 'kathanshah2210@gmail.com', 'abcd1234', NULL, 'Abcde@1234', NULL, NULL, NULL, NULL, '2023-04-02 06:12:49', NULL, NULL),
(17, NULL, NULL, 'tanish@gmail.com', 'tanish1234', NULL, 'User@1111', NULL, NULL, NULL, NULL, '2023-04-04 14:04:35', NULL, 'user'),
(18, NULL, NULL, 'tryle1111@gmail.com', 'tryle1111', NULL, '$2y$10$bDDipzol', NULL, NULL, NULL, NULL, '2023-04-13 05:18:30', NULL, 'user'),
(19, NULL, NULL, 'kathanshah2210@gmail.com', 'user2210', NULL, '$2y$10$0XtrkvlO', NULL, NULL, NULL, NULL, '2023-04-13 05:43:19', NULL, 'user'),
(20, NULL, NULL, 'kathanshah2210@gmail.com', 'user1212', NULL, '$2y$10$8eJOZ/GA', NULL, NULL, NULL, NULL, '2023-04-13 05:57:19', NULL, 'user'),
(22, NULL, NULL, 'kathanshah2210@gmail.com', 'user12341', NULL, '$2y$10$7xPg8Zjwo7cezYdpKCArwOgQefOAYKqW8GRS9SR/4G3traip.reOm', NULL, NULL, NULL, NULL, '2023-04-13 13:42:55', NULL, 'user'),
(23, NULL, NULL, 'kathanshah2210@gmail.com', 'User@1231', NULL, '$2y$10$vHx9qJeB6BoPydlsc52PWecsQc5L6DlERWJsmRpQdEqrDjqPRBieW', NULL, NULL, NULL, NULL, '2023-04-13 13:44:23', NULL, 'blogger'),
(24, NULL, NULL, 'kathanshah2210@gmail.com', 'prajapati123', NULL, '$2y$10$BPRHbSBHqnSiq4sS0zBYaOko1ACw1ZpbfgwXNhRfBH7murX1mVjqi', NULL, NULL, NULL, NULL, '2023-04-19 03:22:13', NULL, 'user'),
(25, NULL, NULL, 'kathanshah2210@gmail.com', 'prajapati1234', NULL, '$2y$10$zlfeZbiDSRtsa8P0fgnxc.xJXvsIP8LnZXQMBtd8h.bBlc7wfjgXK', NULL, NULL, NULL, NULL, '2023-04-19 03:24:10', NULL, 'user'),
(26, NULL, NULL, 'kathanshah2210@gmail.com', 'Abhay1234', NULL, '$2y$10$N.yg7qZQhQ.O9ONM0fGS2OqYfgHPqsyHq4bWsP03ktFKRf019Aq86', NULL, NULL, NULL, NULL, '2023-04-19 04:07:30', NULL, 'blogger'),
(27, NULL, NULL, 'kathanshah2210@gmail.com', 'User@12w3', NULL, '$2y$10$fZqgPuKYxn/94EPSEPe0FeJrcM1GOUPGXioJQxKGouDNczGf/1OTm', NULL, NULL, NULL, NULL, '2023-04-19 06:15:00', NULL, 'user'),
(28, NULL, NULL, 'kathanshah2210@gmail.com', 'user@1234', NULL, '$2y$10$Mdl7iLLkc6RBg8ycKvmRSO.Gvzk6HgNXH8VOZcBxPZPjmJKgl3nIm', NULL, NULL, NULL, NULL, '2023-04-19 06:16:57', NULL, 'user'),
(29, NULL, NULL, 'kathanshah2210@gmail.com', 'User@1234567', NULL, '$2y$10$1V9a6LEnypz4SAorjge59uNzAi1HSN1ItY17vUN1V02HhnZdRRJh.', NULL, NULL, NULL, NULL, '2023-04-19 12:48:07', NULL, 'user'),
(30, NULL, NULL, 'kathanshah2210@gmail.com', 'User@123121', NULL, '$2y$10$StzfPDq.zpp8eLENz.FSvuhcFmJZIjS3SfxoKIt1phuBU0toZ2UCq', NULL, NULL, NULL, NULL, '2023-04-20 08:26:08', NULL, 'user'),
(31, NULL, NULL, 'kathanshah2210@gmail.com', 'abhay@gmail.com', NULL, '$2y$10$ONAqIkrIhTad36Y9/d4bYeNNSeq7uu4JIKQD.tKO2hC3tXIW.Zfxi', NULL, NULL, NULL, NULL, '2023-04-20 13:06:33', NULL, 'blogger'),
(32, NULL, NULL, 'kathanshah2210@gmail.com', 'kathan123', NULL, '$2y$10$.o4mVJxi5ffxwuYg3fMLmODJtWnjMvkO4T/mWE8R5aEWssSt8qgCG', NULL, NULL, NULL, NULL, '2023-04-30 09:53:48', NULL, 'user'),
(33, NULL, NULL, 'kathanshah2210@gmail.com', 'newuser1', NULL, '$2y$10$CYoXi7tt5NvyB3NViW3p3egO17w7h0868MMrzNJlYZD83QuAjQP9G', NULL, NULL, NULL, NULL, '2023-05-03 05:12:04', NULL, 'user'),
(34, 'kathan', 'shah', 'kathanshah2210@gmail.com', 'kathan9091', NULL, '$2y$10$Vi7WWLaVRellzbeIvPvQ8u7IewA90RQ92cx9E.S28NjvnELfJiQ0K', 'profile1688892930.png', NULL, NULL, 'male', '2023-05-03 05:14:18', NULL, 'blogger'),
(35, NULL, NULL, 'kathanshah2210@gmail.com', 'User@123', NULL, '$2y$10$oFYQ8jsGCOWk7WnoVNhnOu2vMC5VsZPkh0C5qLNbCrySpPprFhFHW', NULL, NULL, NULL, NULL, '2023-05-05 06:48:13', NULL, 'user'),
(36, NULL, NULL, 'kathanshah2210@gmail.com', 'admin2@gmail.com', NULL, '$2y$10$22MWnP23k7uYfw5SE61zZu8dJnFKlRxKjkQDtsMw9bs5DNtKi8Abe', NULL, NULL, NULL, NULL, '2023-05-08 06:40:57', NULL, 'user'),
(37, 'user', '123', 'kathanshah2210@gmail.com', 'kishan@123', NULL, '$2y$10$OxJwexCOjha7lsIfnJI7MODAF/i9kS1iCpgGU0kKM7fwBRB8GniDm', NULL, NULL, NULL, 'male', '2023-06-09 02:19:29', NULL, 'blogger'),
(38, NULL, NULL, 'kathanshah2210@gmail.com', 'newuser123', NULL, '$2y$10$Y5OcvaWVlpIPOl/gcGrAP.iNrQDk9tzQHUxY9YaYBQaNttt3SBNJe', NULL, NULL, NULL, NULL, '2023-06-13 05:29:06', NULL, 'user'),
(39, NULL, NULL, 'kathanshah2210@gmail.com', 'nisha123', NULL, '$2y$10$mychYlLJWBiyJEthCs0vge/0lBX.ZhNI84Tg979RQGq2Ip8JFkN3i', NULL, NULL, NULL, NULL, '2023-06-13 12:22:39', NULL, 'user'),
(40, NULL, NULL, 'kathanshah2210@gmail.com', 'abhay2210', NULL, '$2y$10$/.ToK9w/WypV9tr7cEGMaeVJO68ckvM2LU7Sy55Mau.6/6PpdMvMq', NULL, NULL, NULL, NULL, '2023-06-14 01:06:14', NULL, 'user'),
(41, NULL, NULL, 'kathanshah2210@gmail.com', 'newuser1294', NULL, '$2y$10$VaOyCyymbU51/es1cUHp2eVqWJHG8zXLI2tOtEOAX0kU3WcosG7zm', NULL, NULL, NULL, NULL, '2023-06-14 06:10:31', NULL, 'user'),
(42, NULL, NULL, 'kathanshah2210@gmail.com', 'abhay123', NULL, '$2y$10$43oDBbfRM7CoTPmhTcKf/OogA4FLtyCAVcTF3R1Kg2QbBsStn/Gr.', NULL, NULL, NULL, NULL, '2023-06-19 06:07:11', NULL, 'user'),
(43, NULL, NULL, 'kathanshah2210@gmail.com', 'abhay12345', NULL, '$2y$10$mhfOVpZl83kaAZKkNAHxWORuqi/o8AcTBSq.QKbJEySdGT7Xfo8Q6', 'profile1687155095.png', NULL, NULL, 'male', '2023-06-19 06:08:57', NULL, 'blogger'),
(44, NULL, NULL, 'kathanshah2210@gmail.com', 'chrishemsworth', NULL, '$2y$10$I3qfJWzMBX3oEeOvM4VZQOjFoIyXykJiiSZmH/h6xRucbL4FYb7Vu', 'profile1688903516.png', NULL, NULL, NULL, '2023-04-02 05:44:19', NULL, 'blogger'),
(45, 'Rohit', 'Sharma', 'kathanshah2210@gmail.com', 'rohitsharma', NULL, '$2y$10$5iJqOYBNcnUUh1Svj1jvrufFH.zg/35hzL0lRUz9n9X10zDLeuwJq', 'profile1687202222.png', NULL, NULL, 'male', '2023-06-19 19:15:59', NULL, 'blogger'),
(46, 'Mahendra Singh', 'Dhoni', 'kathanshah2210@gmail.com', 'mahidhoni', NULL, '$2y$10$5d0Uomf7daz2/0d.QoNFfOugp2r56Svy/5KUVPkUfpiFOMwsDdNSG', 'profile1687202367.png', NULL, NULL, 'male', '2023-06-19 19:18:42', NULL, 'user'),
(47, 'smit', 'parekh', 'kathanshah2210@gmail.com', 'smitparekh', NULL, '$2y$10$pM5LAeePDOArCUfsnUSrSe.Y8JUrvF.rO8aI0hg3SIb2cUjNR/mX2', 'profile1687202486.png', NULL, NULL, 'male', '2023-06-19 19:20:44', NULL, 'user'),
(48, 'Devraaj', 'Pandya', 'kathanshah2210@gmail.com', 'dp_pandya', NULL, '$2y$10$zZ/SzjNf2y1pXi5UlgAijuCIPWKNrYmDQG1k1REwlDyrqwATQWEqC', 'profile1687202647.png', NULL, NULL, NULL, '2023-06-19 19:22:40', NULL, 'user'),
(50, 'rishi', 'bhatt', 'kathanshah2210@gmail.com', 'rishibhatt', NULL, '$2y$10$b6flan269G61lNeUib8psuBGsAPl7f5K930Rc8bA7KdsL5Bnx3WBS', 'profile1687202880.png', NULL, NULL, 'male', '2023-06-19 19:27:00', NULL, 'user'),
(51, NULL, NULL, 'kathanshah2229@gmail.com', 'dhruvi_sharma', NULL, '$2y$10$reVPeOakrYK1rzFWFx7JSOtmprNVvbBlH.PLgFZkOO6wq9kP2anSK', NULL, NULL, NULL, NULL, '2024-04-16 20:13:59', NULL, 'user'),
(52, NULL, NULL, '202312006@daiict.ac.in', 'sakshi_rangwala', NULL, '$2y$10$hOWA3KD3YFA2g2yUug/aEOFMmNj1P/6pFaf7/DJCyBjgGzvMMgrYC', NULL, NULL, NULL, NULL, '2024-04-17 04:05:10', NULL, 'user'),
(53, NULL, NULL, 'kathanshah2215@gmail.com', 'Blogger_Rohit', NULL, '$2y$10$6xaTez7bE7BsapBKnG2Xnek4Af3FyCYsHbeilQHJU9ZPeGAxejFDe', NULL, NULL, NULL, NULL, '2024-04-23 03:12:39', NULL, 'user'),
(54, NULL, NULL, 'kathanshah2215@gmail.com', 'jetal_savani', NULL, '$2y$10$uydFR3I9W7LCsRs5A519B.8SrfDOiwyydBFD6t3AAqDWaeRGWFWoC', NULL, NULL, NULL, NULL, '2024-04-23 03:16:22', NULL, 'user');


--
-- Indexes for dumped tables
--

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`blog_id`),
  ADD KEY `bcid` (`bcid`),
  ADD KEY `usid` (`usid`);

--
-- Indexes for table `blog_categorys`
--
ALTER TABLE `blog_categorys`
  ADD PRIMARY KEY (`bcid`);

--
-- Indexes for table `blog_comments`
--
ALTER TABLE `blog_comments`
  ADD PRIMARY KEY (`blog_comment_id`),
  ADD KEY `blog_comments_ibfk_1` (`blog_id`),
  ADD KEY `blog_comments_ibfk_2` (`usid`);

--
-- Indexes for table `blog_comment_like_tb`
--
ALTER TABLE `blog_comment_like_tb`
  ADD PRIMARY KEY (`blog_comment_like_id`),
  ADD KEY `blog_comment_id` (`blog_comment_id`),
  ADD KEY `usid` (`usid`),
  ADD KEY `blog_id` (`blog_id`);

--
-- Indexes for table `blog_likes`
--
ALTER TABLE `blog_likes`
  ADD PRIMARY KEY (`blog_like_id`),
  ADD KEY `blog_id` (`blog_id`),
  ADD KEY `usid` (`usid`);

--
-- Indexes for table `blog_viewstb`
--
ALTER TABLE `blog_viewstb`
  ADD PRIMARY KEY (`blog_views_id`),
  ADD KEY `usid` (`usid`),
  ADD KEY `blog_id` (`blog_id`);

--
-- Indexes for table `bookmarktb`
--
ALTER TABLE `bookmarktb`
  ADD PRIMARY KEY (`bmid`),
  ADD KEY `blog_id` (`blog_id`),
  ADD KEY `usid` (`usid`);

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`chat_id`);

--
-- Indexes for table `ctb`
--
ALTER TABLE `ctb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`lcode`);

--
-- Indexes for table `lists`
--
ALTER TABLE `lists`
  ADD PRIMARY KEY (`list_id`),
  ADD KEY `lists_ibfk_1` (`usid`);

--
-- Indexes for table `lists_content`
--
ALTER TABLE `lists_content`
  ADD PRIMARY KEY (`lcid`),
  ADD KEY `lists_content_ibfk_1` (`blog_id`),
  ADD KEY `lists_content_ibfk_2` (`list_id`);

--
-- Indexes for table `logins`
--
ALTER TABLE `logins`
  ADD PRIMARY KEY (`loginid`),
  ADD KEY `usid` (`usid`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `usid` (`usid`);

--
-- Indexes for table `readlists`
--
ALTER TABLE `readlists`
  ADD PRIMARY KEY (`readlist_id`),
  ADD KEY `usid` (`usid`),
  ADD KEY `blogs_id` (`blogs_id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`report_id`),
  ADD KEY `usid` (`usid`);

--
-- Indexes for table `save_and_history_blogs`
--
ALTER TABLE `save_and_history_blogs`
  ADD PRIMARY KEY (`save_blog_id`),
  ADD KEY `blog_id` (`blog_id`),
  ADD KEY `usid` (`usid`);

--
-- Indexes for table `searches`
--
ALTER TABLE `searches`
  ADD PRIMARY KEY (`search_id`),
  ADD KEY `usid` (`usid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`usid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `blog_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `blog_categorys`
--
ALTER TABLE `blog_categorys`
  MODIFY `bcid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `blog_comments`
--
ALTER TABLE `blog_comments`
  MODIFY `blog_comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=292;

--
-- AUTO_INCREMENT for table `blog_comment_like_tb`
--
ALTER TABLE `blog_comment_like_tb`
  MODIFY `blog_comment_like_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `blog_likes`
--
ALTER TABLE `blog_likes`
  MODIFY `blog_like_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `blog_viewstb`
--
ALTER TABLE `blog_viewstb`
  MODIFY `blog_views_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- AUTO_INCREMENT for table `bookmarktb`
--
ALTER TABLE `bookmarktb`
  MODIFY `bmid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `chat_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ctb`
--
ALTER TABLE `ctb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `lists`
--
ALTER TABLE `lists`
  MODIFY `list_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `lists_content`
--
ALTER TABLE `lists_content`
  MODIFY `lcid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2058;

--
-- AUTO_INCREMENT for table `logins`
--
ALTER TABLE `logins`
  MODIFY `loginid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=749;

--
-- AUTO_INCREMENT for table `readlists`
--
ALTER TABLE `readlists`
  MODIFY `readlist_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `save_and_history_blogs`
--
ALTER TABLE `save_and_history_blogs`
  MODIFY `save_blog_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=876;

--
-- AUTO_INCREMENT for table `searches`
--
ALTER TABLE `searches`
  MODIFY `search_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `usid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blogs`
--
ALTER TABLE `blogs`
  ADD CONSTRAINT `blogs_ibfk_1` FOREIGN KEY (`bcid`) REFERENCES `blog_categorys` (`bcid`),
  ADD CONSTRAINT `blogs_ibfk_2` FOREIGN KEY (`usid`) REFERENCES `users` (`usid`);

--
-- Constraints for table `blog_comments`
--
ALTER TABLE `blog_comments`
  ADD CONSTRAINT `blog_comments_ibfk_1` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`blog_id`),
  ADD CONSTRAINT `blog_comments_ibfk_2` FOREIGN KEY (`usid`) REFERENCES `users` (`usid`);

--
-- Constraints for table `blog_comment_like_tb`
--
ALTER TABLE `blog_comment_like_tb`
  ADD CONSTRAINT `blog_comment_like_tb_ibfk_1` FOREIGN KEY (`blog_comment_id`) REFERENCES `blog_comments` (`blog_comment_id`),
  ADD CONSTRAINT `blog_comment_like_tb_ibfk_2` FOREIGN KEY (`usid`) REFERENCES `users` (`usid`),
  ADD CONSTRAINT `blog_comment_like_tb_ibfk_3` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`blog_id`);

--
-- Constraints for table `blog_likes`
--
ALTER TABLE `blog_likes`
  ADD CONSTRAINT `blog_likes_ibfk_1` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`blog_id`),
  ADD CONSTRAINT `blog_likes_ibfk_2` FOREIGN KEY (`usid`) REFERENCES `users` (`usid`);

--
-- Constraints for table `blog_viewstb`
--
ALTER TABLE `blog_viewstb`
  ADD CONSTRAINT `blog_viewstb_ibfk_1` FOREIGN KEY (`usid`) REFERENCES `users` (`usid`),
  ADD CONSTRAINT `blog_viewstb_ibfk_2` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`blog_id`);

--
-- Constraints for table `bookmarktb`
--
ALTER TABLE `bookmarktb`
  ADD CONSTRAINT `bookmarktb_ibfk_1` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`blog_id`),
  ADD CONSTRAINT `bookmarktb_ibfk_2` FOREIGN KEY (`usid`) REFERENCES `users` (`usid`);

--
-- Constraints for table `lists`
--
ALTER TABLE `lists`
  ADD CONSTRAINT `lists_ibfk_1` FOREIGN KEY (`usid`) REFERENCES `users` (`usid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `lists_content`
--
ALTER TABLE `lists_content`
  ADD CONSTRAINT `lists_content_ibfk_1` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`blog_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lists_content_ibfk_2` FOREIGN KEY (`list_id`) REFERENCES `lists` (`list_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `logins`
--
ALTER TABLE `logins`
  ADD CONSTRAINT `logins_ibfk_1` FOREIGN KEY (`usid`) REFERENCES `users` (`usid`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`usid`) REFERENCES `users` (`usid`);

--
-- Constraints for table `readlists`
--
ALTER TABLE `readlists`
  ADD CONSTRAINT `readlists_ibfk_1` FOREIGN KEY (`usid`) REFERENCES `users` (`usid`),
  ADD CONSTRAINT `readlists_ibfk_2` FOREIGN KEY (`blogs_id`) REFERENCES `blogs` (`blog_id`);

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`usid`) REFERENCES `users` (`usid`);

--
-- Constraints for table `save_and_history_blogs`
--
ALTER TABLE `save_and_history_blogs`
  ADD CONSTRAINT `save_and_history_blogs_ibfk_1` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`blog_id`),
  ADD CONSTRAINT `save_and_history_blogs_ibfk_2` FOREIGN KEY (`usid`) REFERENCES `users` (`usid`);

--
-- Constraints for table `searches`
--
ALTER TABLE `searches`
  ADD CONSTRAINT `searches_ibfk_1` FOREIGN KEY (`usid`) REFERENCES `users` (`usid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
-- (SQL commands omitted for brevity)

## 4. **Project Directory Setup**

Navigate to `C:\xampp\htdocs` (Windows) or `/Applications/XAMPP/htdocs` (macOS) or `/opt/lampp/htdocs` (Linux).

1. Create a folder named `mycode`.
2. Inside `mycode`, create another folder named `template`.
3. Inside `template`, create another folder named `star1`.
4. Place your project files, such as `pages` folder, etc., inside the `star1` folder.

Now, you're all set to run the project. Open your web browser and navigate to `http://localhost/mycode/template/star1` to view your project.
