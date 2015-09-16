<?php
include "style.php";
?>

<html>
<head>
   <?php Style_Inline(); ?>
</head>
<body>
   <center>
   <table border=1>
      <tr bgcolor=<?php Bg_Color_One();?>>
         <td>
            <center><b><font size="5">Pomoc</font></b></br>
            <img src="img/pomoc.png" alt="Pomoc" width="200" height="200">
            </center><br/>
         </td>
      </tr>
      <tr align="center" bgcolor=<?php Bg_Color_Two();?>>
         <td>
            <center></br><i>
            Celem gry jest rozwój własnego kampusu, zbieranie surowców, budowa wojsk i wreszcie podbijanie kampusów innych.</br>
            Każdy gracz na początku rozpoczyna z jednym, początkowym kampusem. Musi on zbierać surowce na jego rozbudowę </br>
            oraz rekrutację wojsk. </br> 
            W grze mamy 3 rodzaje surowców: Wódka <img src="img/wodka.png" alt="Wodka" width="30" height="30">, Kebab <img src="img/kebab.png" alt="Kebab" width="30" height="30"> i Wifi <img src="img/wifi.png" alt="Wifi" width="30" height="30">.</br>
            Co godzinę otrzymujesz określoną ilość każdego z nich, zależną od poziomu budynków je wytwarzających, odpowiednio: </br>
            Gorzelnia, Doner Kebab i Spot Wifi. </br>
            Budynki można rozbudowywać w rektoracie. Budynki wytwarzające surowce można rozbudować do poziomu 10, budynki </br>
            rekrutujące wojska można zbudować i ulepszyć, budynki specjalne tylko zbudować. </br>
            Budynki rekrutujące wojska pozwalają na rekrutację 2 typów jednostek, podstawowa wersja pozwala na rekrutację słabszej </br>
            wersji, budynek ulepszony pozwala na rekrutację także tej silniejszej. Przykładowo Akademik pozwala rekrutować Studentów, </br>
            a Akademik po Remoncie także Studentów Spadochroniarzy. </br>
            Budynki specjalne, a są nimi Ławeczka, Zajezdnia i Parking podwajają maksymalny limit jednostek pochodzących odpowiednio z </br>
            Monopolowego, Autobusów oraz WI1. </br>
            Każda z jednostek ma swój koszt oraz inne parametry, co czyni ją efektywną w walce przeciw pewnym jednostkom, a nieefektywną </br>
            przeciw innym. </br>
            Typy wojsk to Lekka piechota <img src="img/light.png" alt="Lekka" width="30" height="30">, Ciężka piechota <img src="img/heavy.png" alt="Ciężka" width="30" height="30"> i Kawaleria <img src="img/cavalry.png" alt="Kawaleria" width="30" height="30">.</br>
            Lekka piechota jest skuteczna przeciw Ciężkiej, Ciężka przeciw Kawalerii, a Kawaleria przeciw Lekkiej. </br>
            Ikony <img src="img/attackvslight.png" alt="Atak lekka" width="30" height="30">, <img src="img/attackvsheavy.png" alt="Atak ciężka" width="30" height="30"> i <img src="img/attackvscavalry.png" alt="Atak kawaleria" width="30" height="30"> określają siłę jednostki odpowiednio przeciwko danym typom. </br>
            Ikona <img src="img/health.png" alt="Zycie" width="30" height="30"> określa ilość punktów HP jednostki. </br> 
            Ikona <img src="img/speed.png" alt="Szybkosc" width="30" height="30"> określa szybkość jednostki w minutach na pole gry na mapie. Im mniej, tym lepiej. </br>
            Ikona <img src="img/sack.png" alt="Udzwig" width="30" height="30"> określa udźwig jednostki - ile sztuk surowców może ukraść po zwycięskim napadzie na cudzy kampus. </br>
            Szczegóły na temat jednostek możesz sprawdzić klikając na ich ikony np. na belce u góry strony głównej. Belka ta informuje, ile wojsk jest w tym kampusie. </br>
            Zarówno twoich, jak i przysłanych jako wsparcie. </br>
            Ikona mieczy <img src="img/crossed_swords.png" alt="Centrum atakow" width="30" height="30"> pozwala przejść do centrum ataków. Możesz tam wysłać wojska w celu ataku bądź wsparcia </br>
            oraz sprawdzić ruchy i miejsce przebywania twoich wojsk oraz sprawdzić, czy do tego kampusu idą jakieś wojska.</br>
            Liczba w nawiasach informuje o ilości ataków zmierzających na ten kampus. </br>
            Po zarejestrowaniu obejmuje Cię 48 godzinna ochrona początkujących, podczas której nie możesz zostać zaatakowany.</br>
            Gdy wojska dotrą do kampusu, rozegra się bitwa. W bitwie zawsze agresor ma przewagę, jest ona większa lub mniejsza. Zależy to od szczęścia. </br>
            W godzinach nocnych, tj. od 22 do 6 znaczną przewagę ma natomiast obrońca. Wynik bitwy zostanie zawarty w raporcie, który otrzymają zarówno agresor, jak i broniący się.</br>
            Wojska przysłane jako wsparcie będą walczyć w obronie danego kampusu, ale właściciel kampusu nie może ich wykorzystać do ataku. Może jedynie nakazać im powrót do własnego kampusu.</br>
            Wojska do innych kampusów możesz także wysłać za pomocą mapy, ikona <img src="img/map.png" alt="Mapa" width="30" height="30">. Pozwala ona także rozejrzeć się po okolicy i sprawdzić swoje położenie. </br>
            Położenie twojego kampusu wyznaczają współrzędne X i Y, przyjmujące wartości od 1 do 100. </br>
            Każda wioska ma swoje poparcie w skali od 1-100. Symbolizuje je ikona <img src="img/crown.png" alt="Poparcie" width="30" height="30">. Szczegóły na ten temat uzyskasz po kliknięciu na nią. </br>
            Ikona <img src="img/edytuj.png" alt="Edytuj" width="30" height="30"> pozwala zmienić nazwę obecnego kampusu. </br>
            Ikona <img src="img/switch.png" alt="Przelacz" width="30" height="30"> pozwala przełączać się między posiadanymi przez Ciebie kampusami. </br>
            Ikona <img src="img/noraport.png" alt="Raporty" width="30" height="30"> pozwala sprawdzić raporty informujące o wydarzeniach takich jak np. rozegrane bitwy. </br>
            Ikona <img src="img/nomsg.png" alt="Wiadomości" width="30" height="30"> pozwala wysyłać i odbierać wiadomości od innych graczy. </br>
            </i></center></br>
         </td>
      </tr>
   </table>

   <a href="?l=main">Powrót</a>
   </center>
</body>
</html>