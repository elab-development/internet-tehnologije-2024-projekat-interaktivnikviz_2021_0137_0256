<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;
use App\Models\QuestionCategory;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {
        $questions = [
            // Istorija
            [
                'category' => 'Istorija',
                'question' => 'Ko je bio prvi srpski arhiepiskop?',
                'options' => ['Sveti Sava', 'Stefan Nemanja', 'Car Dušan', 'Vuk Karadžić'],
                'answer' => 'Sveti Sava',
            ],
            [
                'category' => 'Istorija',
                'question' => 'Koje godine je počeo Prvi svetski rat?',
                'options' => ['1912', '1914', '1918', '1939'],
                'answer' => '1914',
            ],
            [
                'category' => 'Istorija',
                'question' => 'Ko je bio vođa Prvog srpskog ustanka?',
                'options' => ['Miloš Obrenović', 'Karađorđe Petrović', 'Knez Lazar', 'Nikola Tesla'],
                'answer' => 'Karađorđe Petrović',
            ],
            [
                'category' => 'Istorija',
                'question' => 'Ko je bio vođa Drugog srpskog ustanka?',
                'options' => ['Karađorđe', 'Miloš Obrenović', 'Petar I Karađorđević', 'Kralj Aleksandar'],
                'answer' => 'Miloš Obrenović',
            ],
            [
                'category' => 'Istorija',
                'question' => 'Kosovska bitka odigrala se koje godine?',
                'options' => ['1219', '1389', '1453', '1804'],
                'answer' => '1389',
            ],[
    'category' => 'Istorija',
    'question' => 'Ko je bio prvi srpski kralj koji je krunisan od strane pape?',
    'options' => ['Stefan Nemanja', 'Stefan Prvovenčani', 'Knez Lazar', 'Stefan Uroš I'],
    'answer' => 'Stefan Prvovenčani',
],

[
    'category' => 'Istorija',
    'question' => 'Ko je izdao "Načertanije"?',
    'options' => ['Ilija Garašanin', 'Vuk Karadžić', 'Dositej Obradović', 'Petar II Petrović Njegoš'],
    'answer' => 'Ilija Garašanin',
],

[
    'category' => 'Istorija',
    'question' => 'Ko je bio knez Srbije posle Drugog srpskog ustanka?',
    'options' => ['Karađorđe', 'Miloš Obrenović', 'Stefan Nemanja', 'Petar I Karađorđević'],
    'answer' => 'Miloš Obrenović',
],

[
    'category' => 'Istorija',
    'question' => 'Ko je bio poznat kao vođa u borbi protiv Turaka u Prvom srpskom ustanku?',
    'options' => ['Stefan Nemanja', 'Karađorđe Petrović', 'Miloš Obrenović', 'Knez Lazar'],
    'answer' => 'Karađorđe Petrović',
],

[
    'category' => 'Istorija',
    'question' => 'Koja godina se smatra početkom Drugog srpskog ustanka?',
    'options' => ['1804', '1815', '1830', '1389'],
    'answer' => '1815',
],

[
    'category' => 'Istorija',
    'question' => 'Ko je bio poslednji vladar Nemanjićke dinastije?',
    'options' => ['Stefan Dušan', 'Stefan Uroš V', 'Knez Lazar', 'Stefan Prvovenčani'],
    'answer' => 'Stefan Uroš V',
],

[
    'category' => 'Istorija',
    'question' => 'Ko je predvodio bitku na Čegar planini?',
    'options' => ['Karađorđe', 'Stefan Nemanja', 'Stefan Lazarević', 'Stevan Sinđelić'],
    'answer' => 'Stevan Sinđelić',
],

[
    'category' => 'Istorija',
    'question' => 'Ko je osnovao manastir Hilandar na Svetoj Gori?',
    'options' => ['Sveti Sava', 'Stefan Nemanja', 'Car Dušan', 'Knez Lazar'],
    'answer' => 'Sveti Sava',
],

[
    'category' => 'Istorija',
    'question' => 'Koja bitka se smatra prekretnicom u oslobađanju Srbije od Turaka?',
    'options' => ['Bitka na Mišaru', 'Bitka na Kosovu', 'Bitka kod Marice', 'Bitka kod Pirota'],
    'answer' => 'Bitka na Mišaru',
],

[
    'category' => 'Istorija',
    'question' => 'Ko je bio srpski vladar u vreme Kosovske bitke?',
    'options' => ['Stefan Nemanja', 'Knez Lazar', 'Stefan Dušan', 'Miloš Obrenović'],
    'answer' => 'Knez Lazar',
],

[
    'category' => 'Istorija',
    'question' => 'Koji je dokument potvrdio autonomiju Srbije 1830. godine?',
    'options' => ['Hatt-i Šerif', 'Načertanije', 'Cetinjski statut', 'Dejanova povelja'],
    'answer' => 'Hatt-i Šerif',
],

[
    'category' => 'Istorija',
    'question' => 'Ko je bio prvi vladar Srbije pod Osmanlijama koji je utemeljio autonomiju?',
    'options' => ['Stefan Nemanja', 'Miloš Obrenović', 'Karađorđe', 'Knez Lazar'],
    'answer' => 'Miloš Obrenović',
],

[
    'category' => 'Istorija',
    'question' => 'Ko je predvodio Prvi srpski ustanak 1804. godine?',
    'options' => ['Karađorđe Petrović', 'Miloš Obrenović', 'Knez Lazar', 'Stefan Nemanja'],
    'answer' => 'Karađorđe Petrović',
],

[
    'category' => 'Istorija',
    'question' => 'Ko je bio poznat kao "Srpski pesnik i reformator jezika"?',
    'options' => ['Vuk Karadžić', 'Dositej Obradović', 'Branko Radičević', 'Jovan Jovanović Zmaj'],
    'answer' => 'Vuk Karadžić',
],

[
    'category' => 'Istorija',
    'question' => 'Ko je bio srpski knez koji je vladao posle Miloša Obrenovića?',
    'options' => ['Milan Obrenović', 'Aleksandar Karađorđević', 'Petar I Karađorđević', 'Stefan Uroš V'],
    'answer' => 'Milan Obrenović',
],
            // Geografija
            [
                'category' => 'Geografija',
                'question' => 'Koja je najveća reka na svetu?',
                'options' => ['Nil', 'Amazon', 'Misisipi', 'Jangce'],
                'answer' => 'Amazon',
            ],
            [
                'category' => 'Geografija',
                'question' => 'Koja je prestonica Francuske?',
                'options' => ['London', 'Pariz', 'Rim', 'Berlin'],
                'answer' => 'Pariz',
            ],
            [
                'category' => 'Geografija',
                'question' => 'Koji kontinent je najveći po površini?',
                'options' => ['Afrika', 'Evropa', 'Azija', 'Antarktik'],
                'answer' => 'Azija',
            ],
            [
                'category' => 'Geografija',
                'question' => 'Koji je najviši vrh sveta?',
                'options' => ['K2', 'Kilimandžaro', 'Everest', 'Mont Blanc'],
                'answer' => 'Everest',
            ],
            [
                'category' => 'Geografija',
                'question' => 'Koja je najveća zemlja u Africi po površini?',
                'options' => ['Alžir', 'Niger', 'Sudan', 'Libija'],
                'answer' => 'Alžir',
            ],

            [
                'category' => 'Geografija',
                'question' => 'Koja reka protiče kroz Pariz?',
                'options' => ['Seina', 'Temza', 'Rajna', 'Dunav'],
                'answer' => 'Seina',
            ],

            [
                'category' => 'Geografija',
                'question' => 'Koja država ima najviše vulkana?',
                'options' => ['Indonezija', 'Japan', 'Italija', 'Filipini'],
                'answer' => 'Indonezija',
            ],

            [
                'category' => 'Geografija',
                'question' => 'Koja je prestonica Kanade?',
                'options' => ['Toronto', 'Ottawa', 'Montreal', 'Vankuver'],
                'answer' => 'Ottawa',
            ],

            [
                'category' => 'Geografija',
                'question' => 'Koja država se nalazi na dva kontinenta?',
                'options' => ['Turska', 'Egipat', 'Rusija', 'Gruzija'],
                'answer' => 'Turska',
            ],

            [
                'category' => 'Geografija',
                'question' => 'Koji je najveći okean na svetu?',
                'options' => ['Atlantski', 'Tihi', 'Indijski', 'Severni ledeni'],
                'answer' => 'Tihi',
            ],

            [
                'category' => 'Geografija',
                'question' => 'Koja država je najmanja na svetu?',
                'options' => ['Vatikan', 'Monako', 'San Marino', 'Lihtenštajn'],
                'answer' => 'Vatikan',
            ],

            [
                'category' => 'Geografija',
                'question' => 'Koji kontinent je najmanji po površini?',
                'options' => ['Evropa', 'Australija', 'Antarktik', 'Južna Amerika'],
                'answer' => 'Australija',
            ],

            [
                'category' => 'Geografija',
                'question' => 'Koja reka protiče kroz Egipat?',
                'options' => ['Nil', 'Dunav', 'Amazon', 'Tigar'],
                'answer' => 'Nil',
            ],

            [
                'category' => 'Geografija',
                'question' => 'Koji je glavni grad Australije?',
                'options' => ['Sidnej', 'Melburn', 'Canberra', 'Perth'],
                'answer' => 'Canberra',
            ],

            [
                'category' => 'Geografija',
                'question' => 'Koja planina deli Francusku i Španiju?',
                'options' => ['Alpi', 'Pirineji', 'Karpati', 'Apalači'],
                'answer' => 'Pirineji',
            ],

            [
                'category' => 'Geografija',
                'question' => 'Koja država je poznata po fjordovima?',
                'options' => ['Norveška', 'Švedska', 'Island', 'Finska'],
                'answer' => 'Norveška',
            ],

            [
                'category' => 'Geografija',
                'question' => 'Koja država ima oblik čizme?',
                'options' => ['Italija', 'Grčka', 'Španija', 'Portugal'],
                'answer' => 'Italija',
            ],

            [
                'category' => 'Geografija',
                'question' => 'Koja je najveća pustinja na svetu po površini?',
                'options' => ['Sahara', 'Gobi', 'Arabijska', 'Kalahari'],
                'answer' => 'Sahara',
            ],

            [
                'category' => 'Geografija',
                'question' => 'Koja zemlja ima najviše jezera?',
                'options' => ['Kanada', 'Rusija', 'SAD', 'Brazil'],
                'answer' => 'Kanada',
            ],

            [
                'category' => 'Geografija',
                'question' => 'Koja država se nalazi u Južnoj Americi?',
                'options' => ['Brazil', 'Egipat', 'Portugal', 'Indija'],
                'answer' => 'Brazil',
            ],

            // Filmovi i serije
            [
                'category' => 'Filmovi i serije',
                'question' => 'Ko je režirao film "Titanik"?',
                'options' => ['Stiven Spilberg', 'Džejms Kameron', 'Martin Skorseze', 'Kristofer Nolan'],
                'answer' => 'Džejms Kameron',
            ],
            [
                'category' => 'Filmovi i serije',
                'question' => 'Ko glumi Harija Potera?',
                'options' => ['Daniel Redklif', 'Rupert Grint', 'Tom Felton', 'Elijah Wood'],
                'answer' => 'Daniel Redklif',
            ],
            [
                'category' => 'Filmovi i serije',
                'question' => 'Koja serija ima likove Ross i Rachel?',
                'options' => ['Friends', 'The Office', 'How I Met Your Mother', 'Big Bang Theory'],
                'answer' => 'Friends',
            ],
            [
                'category' => 'Filmovi i serije',
                'question' => 'Ko je režirao film "Pulp Fiction"?',
                'options' => ['Kventin Tarantino', 'Martin Skorseze', 'Stiven Spilberg', 'Kristofer Nolan'],
                'answer' => 'Kventin Tarantino',
            ],

            [
                'category' => 'Filmovi i serije',
                'question' => 'Ko glumi Volda Morta u serijalu o Hariju Poteru?',
                'options' => ['Ralf Fajnz', 'Alan Rikman', 'Ruper Grint', 'Daniel Redklif'],
                'answer' => 'Ralf Fajnz',
            ],

            [
                'category' => 'Filmovi i serije',
                'question' => 'Ko režira filmove trilogije "The Lord of the Rings"?',
                'options' => ['Peter Džekson', 'Kristofer Nolan', 'Stiven Spilberg', 'Džejms Kameron'],
                'answer' => 'Peter Džekson',
            ],

            [
                'category' => 'Filmovi i serije',
                'question' => 'Ko glumi Gladuatora Maksimusa?',
                'options' => ['Russell Crowe', 'Brad Pitt', 'Tom Cruise', 'Leonardo Dikaprio'],
                'answer' => 'Russell Crowe',
            ],

            [
                'category' => 'Filmovi i serije',
                'question' => 'Koja serija ima likove Walter White i Jesse Pinkman?',
                'options' => ['Breaking Bad', 'Better Call Saul', 'Ozark', 'Narcos'],
                'answer' => 'Breaking Bad',
            ],

            [
                'category' => 'Filmovi i serije',
                'question' => 'Ko glumi Kapetana Amerika u MCU filmovima?',
                'options' => ['Kris Evans', 'Robert Dauni Džunior', 'Hju Džekman', 'Mark Rufalo'],
                'answer' => 'Kris Evans',
            ],

            [
                'category' => 'Filmovi i serije',
                'question' => 'Ko režira film "Inception"?',
                'options' => ['Kristofer Nolan', 'Stiven Spilberg', 'Džejms Kameron', 'Martin Skorseze'],
                'answer' => 'Kristofer Nolan',
            ],

            [
                'category' => 'Filmovi i serije',
                'question' => 'Ko glumi lik Džokera u filmu "The Dark Knight"?',
                'options' => ['Hit Ledžer', 'Haoakin Finiks', 'Džared Leto', 'Džek Nikolson'],
                'answer' => 'Hit Ledžer',
            ],

            [
                'category' => 'Filmovi i serije',
                'question' => 'Koja serija prati porodicu Stark?',
                'options' => ['Game of Thrones', 'Vikings', 'The Witcher', 'Breaking Bad'],
                'answer' => 'Game of Thrones',
            ],

            [
                'category' => 'Filmovi i serije',
                'question' => 'Ko glumi Glenu u seriji "The Walking Dead"?',
                'options' => ['Steven Yeun', 'Norman Reedus', 'Andrew Lincoln', 'Danai Gurira'],
                'answer' => 'Steven Yeun',
            ],

            [
                'category' => 'Filmovi i serije',
                'question' => 'Ko je režirao film "The Matrix"?',
                'options' => ['Lana i Lili Vahovski', 'Stiven Spilberg', 'Kventin Tarantino', 'Džejms Kameron'],
                'answer' => 'Lana i Lili Vahovski',
            ],

            [
                'category' => 'Filmovi i serije',
                'question' => 'Ko glumi lik Džona Snoua u "Game of Thrones"?',
                'options' => ['Kit Harington', 'Emilia Clarke', 'Peter Dinklage', 'Nikolaj Coster-Waldau'],
                'answer' => 'Kit Harington',
            ],

            [
                'category' => 'Filmovi i serije',
                'question' => 'Koja serija prati doktore u bolnici Seattle Grace?',
                'options' => ['Grey\'s Anatomy', 'Scrubs', 'House', 'ER'],
                'answer' => 'Grey\'s Anatomy',
            ],

            [
                'category' => 'Filmovi i serije',
                'question' => 'Ko glumi lik Han Solo u Star Wars filmovima?',
                'options' => ['Harrison Ford', 'Mark Hamill', 'Carrie Fisher', 'Ewan McGregor'],
                'answer' => 'Harrison Ford',
            ],

            [
                'category' => 'Filmovi i serije',
                'question' => 'Ko režira film "Jurassic Park"?',
                'options' => ['Stiven Spilberg', 'Džejms Kameron', 'Kristofer Nolan', 'Martin Skorseze'],
                'answer' => 'Stiven Spilberg',
            ],

            [
                'category' => 'Filmovi i serije',
                'question' => 'Ko glumi Iron Mana/Tonija Starka u MCU filmovima?',
                'options' => ['Robert Dauni Džunior', 'Kris Evans', 'Mark Rufalo', 'Hju Džekman'],
                'answer' => 'Robert Dauni Džunior',
            ],

            // Sport
            [
                'category' => 'Sport',
                'question' => 'Ko je poznat kao "Kralj fudbala"?',
                'options' => ['Mesi', 'Ronaldo', 'Pele', 'Maradona'],
                'answer' => 'Pele',
            ],
            [
                'category' => 'Sport',
                'question' => 'Koliko igrača ima fudbalski tim na terenu?',
                'options' => ['10', '11', '12', '9'],
                'answer' => '11',
            ],
            [
                'category' => 'Sport',
                'question' => 'Ko je najbrži čovek na svetu?',
                'options' => ['Usain Bolt', 'Tyson Gay', 'Yohan Blake', 'Carl Lewis'],
                'answer' => 'Usain Bolt',
            ],
            [
                'category' => 'Sport',
                'question' => 'Ko je osvojio najviše titula na Wimbledonu?',
                'options' => ['Rodžer Federer', 'Rafael Nadal', 'Novak Đoković', 'Pete Sampras'],
                'answer' => 'Rodžer Federer',
            ],

            [
                'category' => 'Sport',
                'question' => 'Ko je poznat kao "CR7"?',
                'options' => ['Kristijano Ronaldo', 'Lionel Mesi', 'Neymar', 'Kilian Mbape'],
                'answer' => 'Kristijano Ronaldo',
            ],

            [
                'category' => 'Sport',
                'question' => 'Ko je najpoznatiji NBA igrač svih vremena?',
                'options' => ['Majkl Džordan', 'Lebron Džejms', 'Kobi Brajant', 'Šekil O\'Nil'],
                'answer' => 'Majkl Džordan',
            ],

            [
                'category' => 'Sport',
                'question' => 'Koliko igrača ima tim u rukometu?',
                'options' => ['6', '7', '11', '5'],
                'answer' => '7',
            ],

            [
                'category' => 'Sport',
                'question' => 'Ko je poznat po rekordima u sprintu na 100m?',
                'options' => ['Usain Bolt', 'Carl Lewis', 'Justin Gatlin', 'Tyson Gay'],
                'answer' => 'Usain Bolt',
            ],

            [
                'category' => 'Sport',
                'question' => 'Ko je najtrofejniji fudbaler u istoriji?',
                'options' => ['Lionel Mesi', 'Kristijano Ronaldo', 'Dijego Maradona', 'Pele'],
                'answer' => 'Lionel Mesi',
            ],

            [
                'category' => 'Sport',
                'question' => 'Ko je osvojio Tour de France najviše puta?',
                'options' => ['Edi Merks', 'Bernard Hinault', 'Migel Indurain', 'Luk Armstrong'],
                'answer' => 'Bernard Hinault',
            ],

            [
                'category' => 'Sport',
                'question' => 'Ko je poznat kao "Kralj fudbala"?',
                'options' => ['Pele', 'Maradona', 'Lionel Mesi', 'Kristijano Ronaldo'],
                'answer' => 'Pele',
            ],

            [
                'category' => 'Sport',
                'question' => 'Ko je osvojio Super Bowl 2020. godine?',
                'options' => ['Kansas City Chiefs', 'San Francisco 49ers', 'New England Patriots', 'Seattle Seahawks'],
                'answer' => 'Kansas City Chiefs',
            ],

            [
                'category' => 'Sport',
                'question' => 'Ko je najpoznatiji plivač sa najviše olimpijskih medalja?',
                'options' => ['Majkl Phelps', 'Ryan Lochte', 'Ian Thorpe', 'Mark Spitz'],
                'answer' => 'Majkl Phelps',
            ],

            [
                'category' => 'Sport',
                'question' => 'Koji sport koristi palicu i lopticu na ledu?',
                'options' => ['Hokej', 'Fudbal', 'Košarka', 'Ragbi'],
                'answer' => 'Hokej',
            ],

            [
                'category' => 'Sport',
                'question' => 'Ko je osvojio najviše medalja na Olimpijadi 2016?',
                'options' => ['Majkl Phelps', 'Usain Bolt', 'Simone Biles', 'Katie Ledecky'],
                'answer' => 'Majkl Phelps',
            ],

            [
                'category' => 'Sport',
                'question' => 'Ko je najpoznatiji maratonac?',
                'options' => ['Eliud Kipčoge', 'Haile Gebrselassie', 'Mo Farah', 'Usain Bolt'],
                'answer' => 'Eliud Kipčoge',
            ],

            [
                'category' => 'Sport',
                'question' => 'Koja država je domaćin Olimpijskih igara 2021?',
                'options' => ['Japan', 'Kina', 'Brazil', 'Rusija'],
                'answer' => 'Japan',
            ],

            [
                'category' => 'Sport',
                'question' => 'Ko je poznat kao "The GOAT" u tenisu?',
                'options' => ['Rodžer Federer', 'Rafael Nadal', 'Novak Đoković', 'Pete Sampras'],
                'answer' => 'Novak Đoković',
            ],

            [
                'category' => 'Sport',
                'question' => 'Ko igra fudbal za PSG 2021?',
                'options' => ['Lionel Mesi', 'Kristijano Ronaldo', 'Neymar', 'Mbape'],
                'answer' => 'Lionel Mesi',
            ],

            // Muzika
            [
                'category' => 'Muzika',
                'question' => 'Ko je pevao "Thriller"?',
                'options' => ['Majkl Džekson', 'Elvis Prisli', 'Freddie Mercury', 'Madona'],
                'answer' => 'Majkl Džekson',
            ],
            [
                'category' => 'Muzika',
                'question' => 'Ko je pevao "Shape of You"?',
                'options' => ['Ed Širan', 'Justin Bieber', 'Shawn Mendes', 'Adele'],
                'answer' => 'Ed Širan',
            ],
            [
                'category' => 'Muzika',
                'question' => 'Ko je bio član grupe Queen?',
                'options' => ['Freddie Mercury', 'Elvis Prisli', 'Mick Jagger', 'Paul McCartney'],
                'answer' => 'Freddie Mercury',
            ],
                        [
                'category' => 'Muzika',
                'question' => 'Ko je pevao "Thriller"?',
                'options' => ['Majkl Džekson', 'Elvis Prisli', 'Freddie Mercury', 'Madona'],
                'answer' => 'Majkl Džekson',
            ],

            [
                'category' => 'Muzika',
                'question' => 'Ko je pevao "Shape of You"?',
                'options' => ['Ed Širan', 'Justin Bieber', 'Shawn Mendes', 'Adele'],
                'answer' => 'Ed Širan',
            ],

            [
                'category' => 'Muzika',
                'question' => 'Ko je bio član grupe Queen?',
                'options' => ['Freddie Mercury', 'Elvis Prisli', 'Mick Jagger', 'Paul McCartney'],
                'answer' => 'Freddie Mercury',
            ],

            [
                'category' => 'Muzika',
                'question' => 'Ko je komponovao "Mesečevu sonatu"?',
                'options' => ['Betoven', 'Mocart', 'Brahms', 'Čajkovski'],
                'answer' => 'Betoven',
            ],

            [
                'category' => 'Muzika',
                'question' => 'Koja grupa je snimila "Bohemian Rhapsody"?',
                'options' => ['Queen', 'ABBA', 'The Beatles', 'Rolling Stones'],
                'answer' => 'Queen',
            ],

            [
                'category' => 'Muzika',
                'question' => 'Koja pevačica je izvodila "Rolling in the Deep"?',
                'options' => ['Adele', 'Beyonce', 'Lady Gaga', 'Rihanna'],
                'answer' => 'Adele',
            ],

            [
                'category' => 'Muzika',
                'question' => 'Koja grupa je izvela pesmu "Hey Jude"?',
                'options' => ['The Beatles', 'Queen', 'ABBA', 'Nirvana'],
                'answer' => 'The Beatles',
            ],

            [
                'category' => 'Muzika',
                'question' => 'Ko je poznat kao "Kralj popa"?',
                'options' => ['Majkl Džekson', 'Elvis Prisli', 'Prince', 'Madonna'],
                'answer' => 'Majkl Džekson',
            ],

            [
                'category' => 'Muzika',
                'question' => 'Koja pevačica je izvodila "Like a Virgin"?',
                'options' => ['Madona', 'Britni Spirs', 'Rihanna', 'Lady Gaga'],
                'answer' => 'Madona',
            ],

            [
                'category' => 'Muzika',
                'question' => 'Ko je komponovao "Odu radosti"?',
                'options' => ['Betoven', 'Mocart', 'Šopen', 'Brahms'],
                'answer' => 'Betoven',
            ],

            [
                'category' => 'Muzika',
                'question' => 'Ko je izveo pesmu "Bad Guy"?',
                'options' => ['Billie Eilish', 'Ariana Grande', 'Taylor Swift', 'Dua Lipa'],
                'answer' => 'Billie Eilish',
            ],

            [
                'category' => 'Muzika',
                'question' => 'Koja grupa je snimila album "Abbey Road"?',
                'options' => ['The Beatles', 'Pink Floyd', 'Queen', 'Nirvana'],
                'answer' => 'The Beatles',
            ],

            [
                'category' => 'Muzika',
                'question' => 'Ko je pevao "Hello"?',
                'options' => ['Adele', 'Beyonce', 'Lady Gaga', 'Rihanna'],
                'answer' => 'Adele',
            ],

            [
                'category' => 'Muzika',
                'question' => 'Koja pevačica je izvodila "Poker Face"?',
                'options' => ['Lady Gaga', 'Madona', 'Britni Spirs', 'Rihanna'],
                'answer' => 'Lady Gaga',
            ],

            [
                'category' => 'Muzika',
                'question' => 'Ko je komponovao "Malu noćnu muziku"?',
                'options' => ['Mocart', 'Betoven', 'Brahms', 'Šopen'],
                'answer' => 'Mocart',
            ],

            [
                'category' => 'Muzika',
                'question' => 'Koja grupa je poznata po pesmi "Smells Like Teen Spirit"?',
                'options' => ['Nirvana', 'Queen', 'The Beatles', 'ABBA'],
                'answer' => 'Nirvana',
            ],

            // Nauka
            [
                'category' => 'Nauka',
                'question' => 'Koja planeta je najbliža Suncu?',
                'options' => ['Merkur', 'Venera', 'Mars', 'Zemlja'],
                'answer' => 'Merkur',
            ],
            [
                'category' => 'Nauka',
                'question' => 'Koja planeta je najveća u Sunčevom sistemu?',
                'options' => ['Jupiter', 'Saturn', 'Mars', 'Neptun'],
                'answer' => 'Jupiter',
            ],
            [
                'category' => 'Nauka',
                'question' => 'Koja naučna disciplina proučava biljke?',
                'options' => ['Botanika', 'Zoologija', 'Hemija', 'Fizika'],
                'answer' => 'Botanika',
                        ],[
                'category' => 'Nauka',
                'question' => 'Koja planeta je najbliža Suncu?',
                'options' => ['Merkur', 'Venera', 'Mars', 'Zemlja'],
                'answer' => 'Merkur',
            ],

            [
                'category' => 'Nauka',
                'question' => 'Koja planeta je najveća u Sunčevom sistemu?',
                'options' => ['Jupiter', 'Saturn', 'Mars', 'Neptun'],
                'answer' => 'Jupiter',
            ],

            [
                'category' => 'Nauka',
                'question' => 'Koja naučna disciplina proučava biljke?',
                'options' => ['Botanika', 'Zoologija', 'Hemija', 'Fizika'],
                'answer' => 'Botanika',
            ],

            [
                'category' => 'Nauka',
                'question' => 'Koja čestica nosi negativan elektricitet?',
                'options' => ['Elektron', 'Proton', 'Neutron', 'Fotoni'],
                'answer' => 'Elektron',
            ],

            [
                'category' => 'Nauka',
                'question' => 'Koja je hemijska formula vode?',
                'options' => ['H2O', 'CO2', 'O2', 'NaCl'],
                'answer' => 'H2O',
            ],

            [
                'category' => 'Nauka',
                'question' => 'Koja planeta je poznata kao Crvena planeta?',
                'options' => ['Mars', 'Venera', 'Jupiter', 'Merkur'],
                'answer' => 'Mars',
            ],

            [
                'category' => 'Nauka',
                'question' => 'Koja naučna disciplina proučava životinje?',
                'options' => ['Zoologija', 'Botanika', 'Hemija', 'Fizika'],
                'answer' => 'Zoologija',
            ],

            [
                'category' => 'Nauka',
                'question' => 'Koja sila drži planete u orbiti?',
                'options' => ['Gravitacija', 'Magnetizam', 'Elektricitet', 'Talasna sila'],
                'answer' => 'Gravitacija',
            ],

            [
                'category' => 'Nauka',
                'question' => 'Koja planeta ima prstenove?',
                'options' => ['Saturn', 'Jupiter', 'Mars', 'Venera'],
                'answer' => 'Saturn',
            ],

            [
                'category' => 'Nauka',
                'question' => 'Ko je otkrio gravitaciju?',
                'options' => ['Isak Njutn', 'Albert Ajnštajn', 'Galileo Galilej', 'Nikola Tesla'],
                'answer' => 'Isak Njutn',
            ],

            [
                'category' => 'Nauka',
                'question' => 'Koja naučna disciplina proučava materijal i energiju?',
                'options' => ['Fizika', 'Hemija', 'Biologija', 'Geografija'],
                'answer' => 'Fizika',
            ],

            [
                'category' => 'Nauka',
                'question' => 'Koja je najmanja jedinica života?',
                'options' => ['Ćelija', 'Atom', 'Molekul', 'Organel'],
                'answer' => 'Ćelija',
            ],

            [
                'category' => 'Nauka',
                'question' => 'Koja planeta je poznata po plavoj boji?',
                'options' => ['Neptun', 'Venera', 'Mars', 'Merkur'],
                'answer' => 'Neptun',
            ],

            [
                'category' => 'Nauka',
                'question' => 'Koja naučna disciplina proučava materije i njihove reakcije?',
                'options' => ['Hemija', 'Biologija', 'Fizika', 'Astronomija'],
                'answer' => 'Hemija',
            ],

            [
                'category' => 'Nauka',
                'question' => 'Ko je formulirao teoriju relativnosti?',
                'options' => ['Albert Ajnštajn', 'Isaac Njutn', 'Galileo Galilej', 'Nikola Tesla'],
                'answer' => 'Albert Ajnštajn',
            ],

            [
                'category' => 'Nauka',
                'question' => 'Koja planeta je poznata po svom crvenom prahu i pustinji?',
                'options' => ['Mars', 'Venera', 'Jupiter', 'Merkur'],
                'answer' => 'Mars',
            ],

        ];

        foreach ($questions as $q) {
            $category = QuestionCategory::where('name', $q['category'])->first();

            if (!$category) {
                echo "Kategorija '{$q['category']}' ne postoji.\n";
                continue;
            }

            Question::create([
                'category_id' => $category->id,
                'question' => $q['question'],
                'options' => $q['options'], // ❗ NE json_encode
                'answer' => $q['answer'],
                'points' => 10,
            ]);
        }
    }
}
