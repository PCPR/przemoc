<ul class="menu">    
    <li <?php if ($selected == 'aktualnosci') print $current; ?> >
        <a class="a1" href="http://przemocymowimynie.pcpr.suwalski.pl/index.php">Aktualności</a>
    </li>
    <li <?php if ($selected == 'o-projekcie') print $current; ?> >
        <a class="a1">O projekcie</a>
        <ul class="sub-menu">
            <li><a href="<?php if($selected == "aktualnosci")
                {print("2013/");} ?>opis-projektu.php">Opis projektu</a></li>
            <li><a href="<?php if($selected == "aktualnosci")
                {print("2013/");} ?>partnerzy.php">Partnerzy</a></li>
        </ul>
    </li>
    <li <?php if ($selected == '3') print $current; ?> >
        <a class="a1">Działania systemowe</a>
        <ul class="sub-menu">
            <li><a href="<?php if($selected == "aktualnosci")
                {print("2013/");} ?>diagnoza-systemu.php">Diagnoza systemu</a></li>
            <li><a>Superwizja systemu</a></li>
            <li><a>Szkolenia</a></li>
            <li><a>Spotkanie Członków ZI</a></li>
            <li><a>Pogadanki</a></li>
        </ul>
    </li>
    <li <?php if ($selected == '4') print $current; ?> >
        <a class="a1" href="index.php">Oferta pomocy</a>
        <ul class="sub-menu">
            <li><a>Poradnictwo</a></li>
            <li><a>Program dla młodzieży</a></li>
            <li><a>Program dla kobiet</a></li>
            <li><a>Akademia Dobrego Rodzica</a></li>
        </ul>
    </li>
    <li <?php if ($selected == '5') print $current; ?> >
        <a class="a1" href="index.php">Kontakt</a>
    </li>
    
</ul>
            