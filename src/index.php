<?php

use Ethanrobins\Chatbridge\Assets\SVG;
use Ethanrobins\Chatbridge\Exception\LanguageException;
use Ethanrobins\Chatbridge\Language\Lang;
use Ethanrobins\Chatbridge\Language\LangSet;
use Ethanrobins\Chatbridge\Utils;

require __DIR__ . '/../vendor/autoload.php';

Utils::displayErrors();
Utils::phpInit();
$lang = Utils::getStoredLang();


$title = new LangSet();
$description = new LangSet();
$url = "https://chatbridge.app/" . $_GET['lang'] . "/";
$image = "https://chatbridge.app/assets/chatbridge/icon.png";
$imageType = "image/png";
$imageAlt = new LangSet();
$color = "#228fef";
try {
    // TITLE
    $title->set(Lang::BULGARIAN, "ChatBridge - Преводач на съобщения за Discord");
    $title->set(Lang::CHINESE_CHINA, "ChatBridge - 消息翻译器，用于 Discord");
    $title->set(Lang::CHINESE_TAIWAN, "ChatBridge - 訊息翻譯器，適用於 Discord");
    $title->set(Lang::CROATIAN, "ChatBridge - Prevoditelj poruka za Discord");
    $title->set(Lang::CZECH, "ChatBridge - Překladač zpráv pro Discord");
    $title->set(Lang::DANISH, "ChatBridge - Beskedoversætter til Discord");
    $title->set(Lang::DUTCH, "ChatBridge - Berichtvertaler voor Discord");
    $title->set(Lang::ENGLISH_UK, "ChatBridge - Message Translator for Discord");
    $title->set(Lang::ENGLISH_US, "ChatBridge - Message Translator for Discord");
    $title->set(Lang::FINNISH, "ChatBridge - Viestikääntäjä Discordille");
    $title->set(Lang::FRENCH, "ChatBridge - Traducteur de messages pour Discord");
    $title->set(Lang::GERMAN, "ChatBridge - Nachrichtenübersetzer für Discord");
    $title->set(Lang::GREEK, "ChatBridge - Μεταφραστής μηνυμάτων για Discord");
    $title->set(Lang::HINDI, "ChatBridge - Discord के लिए संदेश अनुवादक");
    $title->set(Lang::HUNGARIAN, "ChatBridge - Üzenetfordító Discordhoz");
    $title->set(Lang::INDONESIAN, "ChatBridge - Penerjemah Pesan untuk Discord");
    $title->set(Lang::ITALIAN, "ChatBridge - Traduttore di messaggi per Discord");
    $title->set(Lang::JAPANESE, "ChatBridge - Discord用メッセージ翻訳ツール");
    $title->set(Lang::KOREAN, "ChatBridge - Discord 메시지 번역기");
    $title->set(Lang::LITHUANIAN, "ChatBridge - Žinučių vertėjas skirta Discord");
    $title->set(Lang::NORWEGIAN, "ChatBridge - Meldingsoversetter for Discord");
    $title->set(Lang::POLISH, "ChatBridge - Tłumacz wiadomości dla Discord");
    $title->set(Lang::PORTUGUESE_BRAZILIAN, "ChatBridge - Tradutor de mensagens para Discord");
    $title->set(Lang::ROMANIAN_ROMANIA, "ChatBridge - Traducător de mesaje pentru Discord");
    $title->set(Lang::RUSSIAN, "ChatBridge - Переводчик сообщений для Discord");
    $title->set(Lang::SPANISH, "ChatBridge - Traductor de mensajes para Discord");
    $title->set(Lang::SPANISH_LATAM, "ChatBridge - Traductor de mensajes para Discord");
    $title->set(Lang::SWEDISH, "ChatBridge - Meddelandeöversättare för Discord");
    $title->set(Lang::THAI, "ChatBridge - เครื่องมือแปลข้อความสำหรับ Discord");
    $title->set(Lang::TURKISH, "ChatBridge - Mesaj Çevirici Discord için");
    $title->set(Lang::UKRAINIAN, "ChatBridge - Перекладач повідомлень для Discord");
    $title->set(Lang::VIETNAMESE, "ChatBridge - Trình dịch tin nhắn cho Discord");

    // DESCRIPTION
    $description->set(Lang::BULGARIAN, "Приложение за Discord, създадено да премахва езиковите бариери чрез безпроблемен, контекстуален превод на съобщения.

Задвижвано от ChatGPT, то запазва тон, намерение и нюанс за естествена комуникация.

Нашата мисия е да създадем по-свързана и приобщаваща онлайн общност, където езиковите различия вече не възпрепятстват разговорите.");
    $description->set(Lang::CHINESE_CHINA, "一款专为 Discord 设计的应用，利用无缝、上下文感知的消息翻译来打破语言障碍。

由 ChatGPT 提供支持，能保留语气、意图和细微差别，实现自然的沟通。

我们的使命是打造一个更加紧密、包容的线上社区，让语言差异不再妨碍交流。");
    $description->set(Lang::CHINESE_TAIWAN, "一款專為 Discord 設計的應用程式，透過順暢且具上下文理解的訊息翻譯打破語言障礙。

由 ChatGPT 驅動，可保留語氣、意圖和細微差異，確保自然的溝通。

我們的使命是打造一個更緊密且包容的線上社群，讓語言差異不再阻礙交流。");
    $description->set(Lang::CROATIAN, "Discord aplikacija osmišljena za uklanjanje jezičnih barijera putem neometanog, kontekstualnog prevođenja poruka.

Pokreće je ChatGPT, čuvajući ton, namjeru i nijanse za prirodnu komunikaciju.

Naša misija je stvoriti povezaniju i inkluzivniju internetsku zajednicu u kojoj jezične razlike više ne ometaju razgovore.");
    $description->set(Lang::CZECH, "Aplikace pro Discord navržená k odstraňování jazykových bariér pomocí plynulého, kontextově uvědomělého překladu zpráv.

Díky ChatGPT zachovává tón, záměr a nuance pro přirozenou komunikaci.

Naším posláním je vytvořit propojenou a inkluzivní online komunitu, kde jazykové rozdíly již nebrání v konverzaci.");
    $description->set(Lang::DANISH, "En Discord-applikation designet til at bryde sprogbarrierer med sømløs, kontekstbevidst oversættelse af beskeder.

Drevet af ChatGPT bevares tone, hensigt og nuancer for en naturlig kommunikation.

Vores mission er at skabe et mere forbundet og inkluderende online fællesskab, hvor sprogforskelle ikke længere hindrer samtaler.");
    $description->set(Lang::DUTCH, "Een Discord-applicatie die is ontworpen om taalbarrières te doorbreken met naadloze, contextgevoelige berichtvertaling.

Aangedreven door ChatGPT, behoudt het de toon, intentie en nuances voor natuurlijke communicatie.

Onze missie is om een meer verbonden en inclusieve online gemeenschap te creëren waar taalverschillen geen belemmering meer vormen voor gesprekken.");
    $description->set(Lang::ENGLISH_UK, "A Discord application designed to break language barriers with seamless, context-aware message translation.

Powered by ChatGPT, it preserves tone, intent, and nuance for natural communication.

Our mission is to create a more connected and inclusive online community where language differences no longer hinder conversations.");
    $description->set(Lang::ENGLISH_US, "A Discord application designed to break language barriers with seamless, context-aware message translation. 

Powered by ChatGPT, it preserves tone, intent, and nuance for natural communication.

Our mission is to create a more connected and inclusive online community where language differences no longer hinder conversations.");
    $description->set(Lang::FINNISH, "Discord-sovellus, joka on suunniteltu poistamaan kielimuurit saumattomalla, kontekstia ymmärtävällä viestien käännöksellä.

ChatGPT:n voimin säilyy viestien sävy, tarkoitus ja vivahteet luonnollisen viestinnän takaamiseksi.

Tavoitteenamme on luoda yhteenkuuluvampi ja osallistavampi verkkoyhteisö, jossa kielierot eivät enää estä keskusteluita.");
    $description->set(Lang::FRENCH, "Une application Discord conçue pour briser les barrières linguistiques grâce à une traduction de messages fluide et contextuelle.

Alimentée par ChatGPT, elle préserve le ton, l'intention et les nuances pour une communication naturelle.

Notre mission est de créer une communauté en ligne plus connectée et inclusive, où les différences de langue ne freinent plus les conversations.");
    $description->set(Lang::GERMAN, "Eine Discord-Anwendung, die Sprachbarrieren mit nahtloser, kontextbewusster Nachrichtenübersetzung überwindet.

Angetrieben von ChatGPT bewahrt sie Ton, Absicht und Nuancen für eine natürliche Kommunikation.

Unsere Mission ist es, eine stärker verbundene und inklusivere Online-Community zu schaffen, in der Sprachunterschiede keine Gespräche mehr behindern.");
    $description->set(Lang::GREEK, "Μια εφαρμογή για το Discord, σχεδιασμένη να καταργεί τα γλωσσικά εμπόδια με αβίαστη, συμφραζόμενη μετάφραση μηνυμάτων.

Χάρη στο ChatGPT, διατηρεί τον τόνο, την πρόθεση και τις αποχρώσεις για μια φυσική επικοινωνία.

Αποστολή μας είναι να δημιουργήσουμε μια πιο ενωμένη και χωρίς αποκλεισμούς διαδικτυακή κοινότητα, όπου οι γλωσσικές διαφορές δεν εμποδίζουν πλέον τις συζητήσεις.");
    $description->set(Lang::HINDI, "एक Discord एप्लिकेशन जो निर्बाध, संदर्भ-आधारित संदेश अनुवाद के माध्यम से भाषा की बाधाओं को तोड़ने के लिए डिज़ाइन किया गया है।

ChatGPT द्वारा संचालित, यह स्वाभाविक संवाद के लिए भाव, आशय और बारीकियों को सुरक्षित रखता है।

हमारा मिशन एक अधिक जुड़ा और समावेशी ऑनलाइन समुदाय बनाना है जहाँ भाषायी अंतर बातचीत में बाधा न बनें।");
    $description->set(Lang::HUNGARIAN, "Egy Discord alkalmazás, melyet azért terveztünk, hogy zökkenőmentes, kontextusérzékeny üzenetfordítással lebontsa a nyelvi akadályokat.

A ChatGPT erejével megőrzi a hangnemet, a szándékot és az árnyalatokat a természetes kommunikáció érdekében.

Küldetésünk egy összekapcsoltabb és befogadóbb online közösség létrehozása, ahol a nyelvi különbségek többé nem akadályozzák a társalgást.");
    $description->set(Lang::INDONESIAN, "Sebuah aplikasi Discord yang dirancang untuk menghilangkan hambatan bahasa dengan terjemahan pesan yang mulus dan kontekstual.

Ditenagai oleh ChatGPT, ini mempertahankan nada, maksud, dan nuansa untuk komunikasi yang alami.

Misi kami adalah menciptakan komunitas online yang lebih terhubung dan inklusif, di mana perbedaan bahasa tidak lagi menghalangi percakapan.");
    $description->set(Lang::ITALIAN, "Un'applicazione Discord progettata per abbattere le barriere linguistiche con una traduzione dei messaggi fluida e basata sul contesto.

Basato su ChatGPT, preserva tono, intenzione e sfumature per una comunicazione naturale.

La nostra missione è creare una comunità online più connessa e inclusiva in cui le differenze linguistiche non ostacolino più le conversazioni.");
    $description->set(Lang::JAPANESE, "言語の壁を取り除くために設計されたDiscordアプリで、シームレスかつ文脈に応じたメッセージ翻訳を提供します。

ChatGPTにより動作し、自然なコミュニケーションのためにトーン、意図、ニュアンスを保ちます。

私たちの使命は、言語の違いが会話の障害とならない、よりつながりがあり包括的なオンラインコミュニティを作り出すことです。");
    $description->set(Lang::KOREAN, "언어 장벽을 허물기 위해 설계된 디스코드 애플리케이션으로, 원활하고 문맥을 고려한 메시지 번역을 제공합니다.

ChatGPT로 구동되어 톤, 의도, 뉘앙스를 유지하며 자연스러운 소통을 가능하게 합니다.

우리의 사명은 언어적 차이가 대화를 방해하지 않도록, 더욱 연결되고 포용적인 온라인 커뮤니티를 만드는 것입니다.");
    $description->set(Lang::LITHUANIAN, "„Discord“ programa, sukurta pašalinti kalbos barjerus naudojant sklandų, kontekstinį pranešimų vertimą.

Naudojant „ChatGPT“, išsaugomas tonas, ketinimas ir niuansai, kad bendravimas būtų natūralus.

Mūsų misija – kurti labiau susietą ir įtraukiančią interneto bendruomenę, kurioje kalbos skirtumai nebevaržytų pokalbių.");
    $description->set(Lang::NORWEGIAN, "En Discord-applikasjon designet for å bryte ned språkbarrierer med sømløs, kontekstsensitiv meldingsoversettelse.

Drevet av ChatGPT, bevares tone, hensikt og nyanser for naturlig kommunikasjon.

Vår misjon er å skape et mer sammenkoblet og inkluderende nettfellesskap der språklige forskjeller ikke lenger hindrer samtaler.");
    $description->set(Lang::POLISH, "Aplikacja Discord zaprojektowana, by przełamywać bariery językowe dzięki płynnemu i kontekstowemu tłumaczeniu wiadomości.

Zasilana przez ChatGPT, zachowuje ton, intencję i niuanse, umożliwiając naturalną komunikację.

Naszą misją jest tworzenie bardziej zintegrowanej i inkluzywnej społeczności online, w której różnice językowe nie będą już utrudniać rozmów.");
    $description->set(Lang::PORTUGUESE_BRAZILIAN, "Um aplicativo do Discord projetado para quebrar barreiras linguísticas com tradução de mensagens contínua e contextual.

Com a tecnologia do ChatGPT, ele preserva o tom, a intenção e as nuances para uma comunicação natural.

Nossa missão é criar uma comunidade online mais conectada e inclusiva, onde as diferenças de idioma não impeçam mais as conversas.");
    $description->set(Lang::ROMANIAN_ROMANIA, "O aplicație Discord concepută pentru a elimina barierele lingvistice prin traducerea fără întreruperi și conștientă de context a mesajelor.

Alimentată de ChatGPT, păstrează tonul, intenția și nuanțele pentru o comunicare naturală.

Misiunea noastră este să creăm o comunitate online mai conectată și mai incluzivă, unde diferențele de limbă să nu mai împiedice conversațiile.");
    $description->set(Lang::RUSSIAN, "Приложение для Discord, разработанное для преодоления языковых барьеров посредством беспрерывного, контекстно-ориентированного перевода сообщений.

Работает на базе ChatGPT, сохраняя тон, намерение и нюансы для естественного общения.

Наша миссия — создать более сплочённое и инклюзивное онлайн-сообщество, где языковые различия больше не мешают общению.");
    $description->set(Lang::SPANISH, "Una aplicación de Discord diseñada para derribar barreras idiomáticas con una traducción de mensajes fluida y basada en el contexto.

Impulsada por ChatGPT, conserva el tono, la intención y los matices para una comunicación natural.

Nuestra misión es crear una comunidad en línea más conectada e inclusiva, donde las diferencias de idioma ya no dificulten las conversaciones.");
    $description->set(Lang::SPANISH_LATAM, "Una aplicación de Discord diseñada para eliminar barreras de idioma mediante traducciones de mensajes fluidas y con conciencia de contexto.

Impulsada por ChatGPT, mantiene el tono, la intención y los matices para una comunicación natural.

Nuestra misión es construir una comunidad en línea más conectada e inclusiva, donde las diferencias de idioma ya no obstaculicen las conversaciones.");
    $description->set(Lang::SWEDISH, "En Discord-applikation utformad för att bryta språkbarriärer med sömlös, kontextmedveten meddelandeöversättning.

Drivs av ChatGPT och bevarar ton, avsikt och nyanser för naturlig kommunikation.

Vår mission är att skapa en mer sammanlänkad och inkluderande onlinegemenskap där språkskillnader inte längre hindrar konversationer.");
    $description->set(Lang::THAI, "แอปพลิเคชัน Discord ที่ออกแบบมาเพื่อขจัดอุปสรรคทางภาษา ด้วยการแปลข้อความแบบไร้รอยต่อและเข้าใจบริบท

ขับเคลื่อนด้วย ChatGPT ช่วยรักษาน้ำเสียง เจตนา และความละเอียดอ่อน เพื่อการสื่อสารที่เป็นธรรมชาติ

พันธกิจของเราคือการสร้างชุมชนออนไลน์ที่เชื่อมถึงกันมากขึ้นและมีความเป็นหนึ่งเดียว ซึ่งความแตกต่างด้านภาษาไม่เป็นอุปสรรคอีกต่อไป");
    $description->set(Lang::TURKISH, "Discord için tasarlanmış, sorunsuz ve bağlam odaklı mesaj çevirisiyle dil engellerini kaldıran bir uygulama.

ChatGPT tarafından desteklenerek ton, niyet ve nüansları koruyarak doğal iletişim sağlar.

Amacımız, dil farklılıklarının artık sohbetlere engel olmadığı, daha bağlantılı ve kapsayıcı bir çevrimiçi topluluk yaratmaktır.");
    $description->set(Lang::UKRAINIAN, "Додаток для Discord, створений, щоб долати мовні бар’єри за допомогою безперервного, контекстно-залежного перекладу повідомлень.

Працює на базі ChatGPT, зберігаючи тон, наміри та нюанси для природної комунікації.

Наша місія — створити більш єдину та інклюзивну онлайн-спільноту, де мовні відмінності більше не перешкоджають спілкуванню.");
    $description->set(Lang::VIETNAMESE, "Một ứng dụng Discord được thiết kế để xóa bỏ rào cản ngôn ngữ thông qua dịch tin nhắn liền mạch và có ngữ cảnh.

Được hỗ trợ bởi ChatGPT, ứng dụng vẫn giữ được tông giọng, ý định và sắc thái để giao tiếp tự nhiên.

Sứ mệnh của chúng tôi là xây dựng một cộng đồng trực tuyến gắn kết và hòa nhập hơn, nơi sự khác biệt về ngôn ngữ không còn cản trở các cuộc trò chuyện.");

    // IMAGE ALT
    $imageAlt->set(Lang::BULGARIAN, "Икона на ChatBridge");
    $imageAlt->set(Lang::CHINESE_CHINA, "图标：ChatBridge");
    $imageAlt->set(Lang::CHINESE_TAIWAN, "圖示：ChatBridge");
    $imageAlt->set(Lang::CROATIAN, "ChatBridge ikona");
    $imageAlt->set(Lang::CZECH, "Ikona ChatBridge");
    $imageAlt->set(Lang::DANISH, "ChatBridge-ikon");
    $imageAlt->set(Lang::DUTCH, "ChatBridge-pictogram");
    $imageAlt->set(Lang::ENGLISH_UK, "ChatBridge Icon");
    $imageAlt->set(Lang::ENGLISH_US, "ChatBridge Icon");
    $imageAlt->set(Lang::FINNISH, "ChatBridge-kuvake");
    $imageAlt->set(Lang::FRENCH, "Icône ChatBridge");
    $imageAlt->set(Lang::GERMAN, "ChatBridge-Symbol");
    $imageAlt->set(Lang::GREEK, "Εικονίδιο ChatBridge");
    $imageAlt->set(Lang::HINDI, "ChatBridge आइकन");
    $imageAlt->set(Lang::HUNGARIAN, "ChatBridge ikon");
    $imageAlt->set(Lang::INDONESIAN, "Ikon ChatBridge");
    $imageAlt->set(Lang::ITALIAN, "Icona di ChatBridge");
    $imageAlt->set(Lang::JAPANESE, "ChatBridge アイコン");
    $imageAlt->set(Lang::KOREAN, "ChatBridge 아이콘");
    $imageAlt->set(Lang::LITHUANIAN, "ChatBridge piktograma");
    $imageAlt->set(Lang::NORWEGIAN, "ChatBridge-ikon");
    $imageAlt->set(Lang::POLISH, "Ikona ChatBridge");
    $imageAlt->set(Lang::PORTUGUESE_BRAZILIAN, "Ícone do ChatBridge");
    $imageAlt->set(Lang::ROMANIAN_ROMANIA, "Pictograma ChatBridge");
    $imageAlt->set(Lang::RUSSIAN, "Значок ChatBridge");
    $imageAlt->set(Lang::SPANISH, "Ícono de ChatBridge");
    $imageAlt->set(Lang::SPANISH_LATAM, "Ícono de ChatBridge");
    $imageAlt->set(Lang::SWEDISH, "ChatBridge-ikon");
    $imageAlt->set(Lang::THAI, "ไอคอน ChatBridge");
    $imageAlt->set(Lang::TURKISH, "ChatBridge Simgesi");
    $imageAlt->set(Lang::UKRAINIAN, "Значок ChatBridge");
    $imageAlt->set(Lang::VIETNAMESE, "Biểu tượng ChatBridge");
} catch (LanguageException $e) {
    die($e->getMessage());
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta content="<?php echo $title->get(Lang::fromLocale(str_replace('_', '-', $_GET['lang'])))->getString(); ?>" property="og:title" lang="en"/>
    <meta content="<?php echo $description->get(Lang::fromLocale(str_replace('_', '-', $_GET['lang'])))->getString(); ?>" property="og:description" lang="en"/>
    <meta content="<?php echo $url; ?>" property="og:url"/>
    <meta content="<?php echo $image; ?>" property="og:image"/>
    <meta content="<?php echo $imageType ?>" property="og:image:type"/>
    <meta content="<?php echo $imageAlt->get(Lang::fromLocale(str_replace('_', '-', $_GET['lang'])))->getString(); ?>" property="og:image:alt"/>
    <meta content="<?php echo $color; ?>" data-react-helmet="true" name="theme-color"/>
    <meta content="ChatBridge" property="og:site_name"/>

    <?php echo Utils::headInit(); ?>
    <title><?php echo $title->get(Lang::fromLocale(str_replace('_', '-', $_GET['lang'])))->getString(); ?></title>
</head>
<body>
    <?php
    echo SVG::CHATBRIDGE_ICON->get("50vh", "50vh") . "<br>";
    echo SVG::CHATBRIDGE_LOGO->get(null, "50vh") . "<br>";
    ?>
</body>
</html>
