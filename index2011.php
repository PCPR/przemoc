<?php
if (!ini_get ('zlib.output_compression')) {
  if (substr_count ($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) {
    ini_set ('zlib.output_compression_level', 1);
    ob_start ('ob_gzhandler');
  }
}
?>
<?php

$dzis=date('Y-m-d');
?>
<?php require_once('Connections/konect.php'); 
require_once("DB.php"); 
$dbh=DB::connect("$log");
$banerySrc='banery/';
//==============opis znaczników meta====================================================
$queryMeta="SELECT wartosc FROM config ORDER BY id";
$wynikMeta=$dbh->query($queryMeta);
$i=1;
while($row=$wynikMeta->fetchRow())
{
	 $meta[$i]=$row[0];
	 $i++;
}
$domena=$meta[10];
$Lewa=$meta[11];
$Centralna=$meta[12];
$Prawa=$meta[13];
//=====================koniec meta======================================================
//---------------------jaki układ strony-----------------------------------------------
$queryUklad="SELECT id FROM uklad_strona_g WHERE wartosc='@'";
$uklad=$dbh->getRow($queryUklad);
$numerUkladu=$uklad[0];

//-------------------------------------------------------------------------------------
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><? echo $meta[1]; ?></title>
<meta name="description" content="<? echo $meta[2]; ?>" />
<meta name="keywords" content="<? echo $meta[3]; ?>" />
<link href="<? echo $domena;?>css/main.css" rel="stylesheet" type="text/css" />
<link href="<? echo $domena;?>css/menuBoczne.css" rel="stylesheet" type="text/css" />
<script src="<? echo $domena;?>SpryAssets/SpryMenuBar.js" type="text/javascript"></script>

</head>

<body class="kontener">
<div id="kontenerGlowny">

<!-- BANER-->
<div id="kontenerNaglowek">
<div id="kontenerBaner">
<div id="baner">
<?
$queryBanerG="SELECT baner.zdjecie, baner.width, baner.height FROM baner WHERE id_kat=8 AND id=1";
$wynikBanerG=$dbh->getRow($queryBanerG);
  $width=$wynikBanerG[1];
  $height=$wynikBanerG[2];

if (! empty($wynikBanerG[0])) {
	
  //baner jest flashem
  if(ereg('.swf',$wynikBanerG[0]))
  {?>
		  <object id="FlashID" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="<?php echo $width; ?>" height="<?php echo $height; ?>">
		  <param name="movie" value="<?php echo $domena.'banery/'.$wynikBanerG[0]; ?>" />
		  <param name="quality" value="high" />
		  <param name="wmode" value="opaque" />
		  <param name="swfversion" value="7.0.70.0" />
		  <!-- This param tag prompts users with Flash Player 6.0 r65 and higher to download the latest version of Flash Player. Delete it if you don't want users to see the prompt. -->
		  <param name="expressinstall" value="<? echo $domena;?>Scripts/expressInstall.swf" />
		  <!-- Next object tag is for non-IE browsers. So hide it from IE using IECC. -->
		  <!--[if !IE]>-->
		  <object type="application/x-shockwave-flash" data="<?php echo $domena.'banery/'.$wynikBanerG[0]; ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>">
			<!--<![endif]-->
			<param name="quality" value="high" />
			<param name="wmode" value="opaque" />
			<param name="swfversion" value="7.0.70.0" />
			<param name="expressinstall" value="<? echo $domena;?>Scripts/expressInstall.swf" />
			<!-- The browser displays the following alternative content for users with Flash Player 6.0 and older. -->
			<div>
			  <h4>Content on this page requires a newer version of Adobe Flash Player.</h4>
			  <p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" width="112" height="33" /></a></p>
			</div>
			<!--[if !IE]>-->
		  </object>
		  <!--<![endif]-->
		</object>
  <? 
  }
  else
  {

     echo '<a href="'.$domena.'" title="'.$meta[1].'"><img src="'.$domena.'banery/'.$wynikBanerG[0].'" alt="'.$meta[1].'" border="0"/></a>';  
   }
?>
<?
}
else
{
	//wyświetlanie rotatora jeśli nie ma banera głównego
?>

<div class="container">
 <div id="containerr"><a href="http://www.macromedia.com/go/getflashplayer" target="_blank">Pobierz Flash Player</a> aby wy&#347;wietli&#263; baner.</div>
            <script type="text/javascript" src="<? echo $domena;?>imagerotator/swfobject.js"></script>
<script type="text/javascript">
		var s1 = new SWFObject("<? echo $domena;?>imagerotator/imagerotator.swf","rotator","1000","377","7","transparent");
		s1.addParam("allowfullscreen","bgfalse");
		s1.addVariable("file","<? echo $domena;?>imagerotator/naglowek.xml");
		s1.addVariable("width","1000");
		s1.addVariable("height","377"); 
		s1.addVariable("screencolor","0xffffff");
		s1.addVariable("transition","fade");
		s1.addVariable("shownavigation","false");
		s1.addVariable("wmode","transparent");
		s1.write("containerr");
</script>
</div>
<? }?>
</div>
</div>
</div>
<!-- KONIEC NAGŁÓWKA-->
<!-- MENU GŁÓWNE -->
<? 
//sprawdzenie czy wyświetlać menu główne(włączona widocznosc
$queryMenuG="SELECT widocznosc FROM kategoria_0 WHERE id=1";	
$wynikG=$dbh->getRow($queryMenuG);
if ($wynikG[0]==1) require_once("menuG.php"); ?>
<!-- KONIEC MENU GŁÓWNE-->
<div class="kolumny">

<!-- START SIDEBAR LEFT -->
<div id="SidebarLeft">
<?
//pobranie inforamcji o zawartosci i kolejności elementów w lewej kolumnie
$queryUklad="SELECT id, strona FROM kategoria WHERE id_kat=3 ORDER BY kol, id";
$wynikUklad=$dbh->query($queryUklad);
while($rowUklad=$wynikUklad->fetchRow())
{
	$idElementu=$rowUklad[0];
	$element=$rowUklad[1]; //5-baner, 8 -treść, 2 -kategoria, 10 -menu boczne1, 19 -menu boczne2, 1 -menu glowne
	if ($element==5)
	{
		//BANER	
		$queryBan="SELECT baner.zdjecie, baner.nazwa, baner.rodzaj_linku, baner.align, baner.width, baner.height, baner.link, baner.align FROM baner WHERE baner.id_kat='$idElementu' AND (caly_czas=1 OR ( od<='$dzis' AND do>='$dzis'))";	
		$wynikBan=$dbh->getRow($queryBan);
		
		$banerL=$wynikBan[0];
		$banerDoWyswietlenia=$domena.$banerySrc.$banerL;
		$nazwa=htmlspecialchars(stripslashes($wynikBan[1]));
		$target=$wynikBan[2];
		$align=$wynikBan[3];
		$width=$wynikBan[4];
		$height=$wynikBan[5];
		$link=$wynikBan[6];
		$align=$wynikBan[7];
		
		if (! empty($banerL)) {
			//baner jest flashem
			if(ereg('.swf',$banerL))
			{?>
					<object id="FlashID" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="<?php echo $width; ?>" height="<?php echo $height; ?>">
					<param name="movie" value="<?php echo $banerDoWyswietlenia; ?>" />
					<param name="quality" value="high" />
					<param name="wmode" value="opaque" />
					<param name="swfversion" value="7.0.70.0" />
					<!-- This param tag prompts users with Flash Player 6.0 r65 and higher to download the latest version of Flash Player. Delete it if you don’t want users to see the prompt. -->
					<param name="expressinstall" value="<? echo $domena;?>Scripts/expressInstall.swf" />
					<!-- Next object tag is for non-IE browsers. So hide it from IE using IECC. -->
					<!--[if !IE]>-->
					<object type="application/x-shockwave-flash" data="<?php echo $banerDoWyswietlenia; ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>">
					  <!--<![endif]-->
					  <param name="quality" value="high" />
					  <param name="wmode" value="opaque" />
					  <param name="swfversion" value="7.0.70.0" />
					  <param name="expressinstall" value="<? echo $domena;?>Scripts/expressInstall.swf" />
					  <!-- The browser displays the following alternative content for users with Flash Player 6.0 and older. -->
					  <div>
						<h4>Content on this page requires a newer version of Adobe Flash Player.</h4>
						<p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" width="112" height="33" /></a></p>
					  </div>
					  <!--[if !IE]>-->
					</object>
					<!--<![endif]-->
				  </object>
			<? 
			}
			else
			{
				echo'<div style="margin-top:2px;margin-bottom:2px;"  align="'.$align.'">';
				if(!empty($link)){echo'<a href="'.$link.'" target="'.$target.'" title="'.$nazwa.'">';}
				echo'<img src="'.$banerDoWyswietlenia.'" alt="'.$nazwa.'" border="0"/>';	
				if(!empty($link)){echo'</a>';}
				echo'</div>';
			}
		}//koniec empty $banerL
	}
	if ($element==6)//MODUŁ
	{
		  //wyswietla wszystko co jest modułem
		  $queryMod="SELECT kod, rodzaj_wyswietlania, width, height FROM modul WHERE id_kat='$idElementu' AND akt=1 ORDER BY kol, id";
		  $wynikMod=$dbh->query($queryMod);
		  while($rowM=$wynikMod->fetchRow()){
			  $plik=$rowM[0];
			  $rodzajW=$rowM[1];
			  $width=$rowM[2];
			  $height=$rowM[3];
			  
			  if ($rodzajW==2){
				  //require
				  require("modules/".$plik);
			  }
			  else
			  {
				  //iframe
				  echo'	<iframe src="'.$domena.'modules/'.$plik.'" frameborder="0"  width="'.$width.'" height="'.$height.'"  id="modul_'.$width.'" name="modul_'.$width.'"></iframe>';
			  }
			  
		  }//koniec while $rowM...
		  
	  }//koniec strona=6- wyświetlania modułu

	if ($element==8)
	{
		//TREŚĆ
		//pobranie informacji o treści i wyświetlenie jej
		$queryTresc="SELECT strona.tytul, strona.tresc, strona.szczegolnie_polecamy FROM strona WHERE strona.id_kat='$idElementu'  AND ukryj=0 ";
		$wynikT=$dbh->getRow($queryTresc);
		$tytulT1=htmlspecialchars(stripslashes($wynikT[0]));
		$trescT1=stripslashes($wynikT[1]);
		$wybrany=$wynikT[2];
		if (! empty($trescT1)){
			  if ($wybrany==0){
				echo'<div class="boxInfo">';
				echo'<p class="boxInfoTitle">';
				if (($tytulT1<>'Brak tytułu')AND(! empty($tytulT1))) echo $tytulT1;
				echo'</p>';
				echo $trescT1;
				echo'</div>';
			  }
			  if ($wybrany==1){
				echo'<div class="boxInfoWybranyL">';
				echo'<p class="boxInfoTitleWybrany">';
				if (($tytulT1<>'Brak tytułu')AND(! empty($tytulT1))) echo $tytulT1;
				echo'</p>';
				echo $trescT1;
				echo'</div>';
				  
			  }
		}//koniec empty
	}
	if ($element==2)//KATEGORIA MENU
	{
		$queryMenuK="SELECT kategoria.nazwa, kategoria.strona, kategoria.id, kol FROM kategoria WHERE kategoria.id='$idElementu' AND ukryj=0 ORDER BY kol";
		$wynik_G=$dbh->query($queryMenuK);
		
		if (DB::isError($wynik_G))
		{
		   echo'Błąd pobrania głównych kategorii menu! ';
		   echo $wynik_G->getMessage();
		   echo $wynik_G->getdebuginfo();
		   exit(1);
		}

		$liczba_wierszyMK0=$wynik_G->numRows();
		if ($liczba_wierszyMK0>0)
		{
			while($rowMK0=$wynik_G->fetchRow())
			{
				$nazwaMK0=htmlspecialchars(stripslashes($rowMK0[0]),ENT_COMPAT);
				$idMK0=$rowMK0[2];
				$kolMK0=$rowMK0[3];
				//echo $nazwaMK0;
				if ($kolMK0>=100) echo'
				<div class="menuKL">
				<ul class="poziom1L">';
				else
				echo'
				<div class="menuKL0">
				<ul class="poziom1L0">';
				
				echo'<li>';
				//podmenu do nazwaMK0
				$queryMenuK0="SELECT kategoria.nazwa, kategoria.strona, kategoria.id, kategoria.nazwaht FROM kategoria WHERE kategoria.id_kat='$idMK0' AND ukryj=0 ORDER BY kol";
				$wynik_G1=$dbh->query($queryMenuK0);
				
				if (DB::isError($wynik_G1))
				{
				   echo'Błąd pobrania głównych kategorii menu! ';
				   echo $wynik_G1->getMessage();
				   echo $wynik_G1->getdebuginfo();
				   exit(1);
				}
		
				$liczba_wierszyMK1=$wynik_G1->numRows(); 
				if ($liczba_wierszyMK1>0)
				{
					if ($kolMK0>=100)echo'
					<ul class="poziom2L">';
					else 
					echo'
					<ul class="poziom2L0">';
					while($rowMK1=$wynik_G1->fetchRow())
					{
							$nazwaMK=htmlspecialchars(stripslashes($rowMK1[0]),ENT_COMPAT);
							$stronaMK=$rowMK1[1];
							$idMK=$rowMK1[2];
							$nazwahtKat=$rowMK1[3];
							if (($stronaMK==1) OR  ($stronaMK==4))//tzn. element jest stroną lub strona linkiem
							{
								//sprawdz czy nie jest on wyłącznie linkiem 
								$queryLink="SELECT id, link, rodzaj_linku, nazwaht FROM  strona WHERE id_kat='$idMK' ORDER BY kol";
								$wynikLink=$dbh->getRow($queryLink);
								if (DB::isError($wynikLink))
								{
								   echo'Błąd pobrania informacji o stronie!';
								   echo $wynik->getMessage();
								   echo $wynik->getdebuginfo();
								   exit(1);
								}
								$idStrony=$wynikLink[0];
								$rodzaj=$wynikLink[2];//target
								$url=$wynikLink[1];
								$nazwaht=$wynikLink[3];
								if (empty($url)) $url=$domena.$nazwaht.'-'.$idStrony.'.htm';
								if (empty($rodzaj)) $rodzaj='_parent';
								echo'<li>';
								echo'<a href="'.$url.'" target="'.$rodzaj.'" title="'.$nazwaMK.'">';
								echo $nazwaMK;
								echo'</a>';
							}
							  
							  if(($stronaMK==3) OR ($stronaMK==2))//element jest kategorią linkiem do strony z zawartością gdzie inne elementy kategorii sa prezentowane jak np. newsy
							  {
								$url=$domena.$listaKategorii.$nazwahtKat.'-'.$idMK.'.htm';
								$rodzaj='_parent';
								echo'<li>';
								echo'<a href="'.$url.'" target="'.$rodzaj.'" title="'.$nazwaMK.'">';
								echo $nazwaMK;
								echo'</a>';
							  }
							echo'</li>';
						}//koniec while
						echo'</ul>';
					}//koniec ilosc_wierszy MK
				  echo'</li></ul></div>';
				}//koniec while
		}//koniec if ilosc_wierszyMK0
	}//if strona=2
	
	if ($element==10)
	{
		//MENU BOCZNE 1	
		//sprawdzenie czy wyświetlać menu boczne 1 (włączona widocznosc
		$queryMenuB1="SELECT widocznosc FROM kategoria_0 WHERE id=10";	
		$wynikB1=$dbh->getRow($queryMenuB1);
		 if ($wynikB1[0]==1)require_once("menuB.php");echo'<br class="clearfloat" />';
	}
	
	if ($element==19)
	{
		//MENU BOCZNE 2
		//sprawdzenie czy wyświetlać menu boczne 2 (włączona widocznosc
		$queryMenuB2="SELECT widocznosc FROM kategoria_0 WHERE id=19";	
		$wynikB2=$dbh->getRow($queryMenuB2);
		if ($wynikB2[0]==1) require_once("menuB2.php"); echo'<br class="clearfloat"/>';
	}
	
}
?>
</div>
<!-- KONIEC SIDEBAR LEFT -->
<!-- KONIEC SIDEBAR CENTRAL -->
<!-- START SIDEBAR RIGHT -->
<div id="SidebarRight">
  <?
  $queryKatZaw="SELECT id, strona FROM kategoria WHERE id_kat=5 ORDER BY kol";
  $wynikKatZaw=$dbh->query($queryKatZaw);
  while($rowKatZ=$wynikKatZaw->fetchRow())
  {
	  $id=$rowKatZ[0];
	  $strona=$rowKatZ[1];
	  
	  if ($strona==8){//TREŚC
		//wyświetla wszystko co jest treścią
		$queryZawartosc="SELECT strona.tytul, strona.tresc, strona.szczegolnie_polecamy FROM strona WHERE strona.id_kat='$id' AND ukryj=0 ORDER BY strona.kol,strona.id";
		$wynikZawartosc=$dbh->query($queryZawartosc);
		while ($rowZ=$wynikZawartosc->fetchRow())
		{
			$tytul=htmlspecialchars(stripslashes($rowZ[0]));
			$tresc=stripslashes($rowZ[1]);
			$wybrany=$rowZ[2];
			if (! empty($tresc)){
			  if ($wybrany==0){
				echo'<div class="boxInfo">';
				echo'<p class="boxInfoTitle">';
				if (($tytul<>'Brak tytułu')AND(! empty($tytul))) echo $tytul;
				echo'</p>';
				echo $tresc;
				echo'</div>';
			  }
			  if ($wybrany==1){
				echo'<div class="boxInfoWybranyP">';
				echo'<p class="boxInfoTitleWybrany">';
				if (($tytul<>'Brak tytułu')AND(! empty($tytul))) echo $tytul;
				echo'</p>';
				echo $tresc;
				echo'</div>';
				  
			  }
			}//koniec empty

		}//koniec while $rowZ=.. - wyświetlania treści
	  }//koniec if($strona==8)
	if ($strona==2)//KATEGORIA MENU
	{
		$queryMenuK="SELECT kategoria.nazwa, kategoria.strona, kategoria.id FROM kategoria WHERE kategoria.id='$id' AND ukryj=0 ORDER BY kol";
		$wynik_G=$dbh->query($queryMenuK);
		
		if (DB::isError($wynik_G))
		{
		   echo'Błąd pobrania głównych kategorii menu! ';
		   echo $wynik_G->getMessage();
		   echo $wynik_G->getdebuginfo();
		   exit(1);
		}

		$liczba_wierszyMK0=$wynik_G->numRows();
		if ($liczba_wierszyMK0>0)
		{
			while($rowMK0=$wynik_G->fetchRow())
			{
				echo'
				<div class="menuK">
				<ul class="poziom1">';
				$nazwaMK0=htmlspecialchars(stripslashes($rowMK0[0]),ENT_COMPAT);
				$idMK0=$rowMK0[2];
				echo'<li>&nbsp;'.$nazwaMK0;
				//podmenu do nazwaMK0
				$queryMenuK0="SELECT kategoria.nazwa, kategoria.strona, kategoria.id, kategoria.nazwaht FROM kategoria WHERE kategoria.id_kat='$idMK0' AND ukryj=0 ORDER BY kol";
				$wynik_G1=$dbh->query($queryMenuK0);
				
				if (DB::isError($wynik_G1))
				{
				   echo'Błąd pobrania głównych kategorii menu! ';
				   echo $wynik_G1->getMessage();
				   echo $wynik_G1->getdebuginfo();
				   exit(1);
				}
		
				$liczba_wierszyMK1=$wynik_G1->numRows(); 
				if ($liczba_wierszyMK1>0)
				{
					echo'
					<ul class="poziom2">';
					while($rowMK1=$wynik_G1->fetchRow())
					{
							$nazwaMK=htmlspecialchars(stripslashes($rowMK1[0]),ENT_COMPAT);
							$stronaMK=$rowMK1[1];
							$idMK=$rowMK1[2];
							$nazwahtKat=$rowMK1[3];
							if (($stronaMK==1) OR  ($stronaMK==4))//tzn. element jest stroną lub strona linkiem
							{
								//sprawdz czy nie jest on wyłącznie linkiem 
								$queryLink="SELECT id, link, rodzaj_linku, nazwaht FROM  strona WHERE id_kat='$idMK' ORDER BY kol";
								$wynikLink=$dbh->getRow($queryLink);
								if (DB::isError($wynikLink))
								{
								   echo'Błąd pobrania informacji o stronie!';
								   echo $wynik->getMessage();
								   echo $wynik->getdebuginfo();
								   exit(1);
								}
								$idStrony=$wynikLink[0];
								$rodzaj=$wynikLink[2];//target
								$url=$wynikLink[1];
								$nazwaht=$wynikLink[3];
								if (empty($url)) $url=$domena.$nazwaht.'-'.$idStrony.'.htm';
								if (empty($rodzaj)) $rodzaj='_parent';
								echo'<li>';
								echo'<a href="'.$url.'" target="'.$rodzaj.'" title="'.$nazwaMK.'">';
								echo $nazwaMK;
								echo'</a>';
							}
							  
							  if(($stronaMK==3) OR ($stronaMK==2))//element jest kategorią linkiem do strony z zawartością gdzie inne elementy kategorii sa prezentowane jak np. newsy
							  {
								$url=$domena.$listaKategorii.$nazwahtKat.'-'.$idMK.'.htm';
								$rodzaj='_parent';
								echo'<li>';
								echo'<a href="'.$url.'" target="'.$rodzaj.'" title="'.$nazwaMK.'">';
								echo $nazwaMK;
								echo'</a>';
							  }
							echo'</li>';
						}//koniec while
						echo'</ul>';
					}//koniec ilosc_wierszy MK
				  echo'</li></ul>';
				  echo'</div>';
				}//koniec while
		}//koniec if ilosc_wierszyMK0
	}//if strona=2
	  
	  if ($strona==6)//MODUŁ
	  {
		  //wyswietla wszystko co jest modułem
		  $queryMod="SELECT kod, rodzaj_wyswietlania, width, height FROM modul WHERE id_kat='$id' AND akt=1 ORDER BY kol, id";
		  $wynikMod=$dbh->query($queryMod);
		  while($rowM=$wynikMod->fetchRow()){
			  $plik=$rowM[0];
			  $rodzajW=$rowM[1];
			  $width=$rowM[2];
			  $height=$rowM[3];
			  
			  if ($rodzajW==2){
				  //require
				  require("modules/".$plik);
			  }
			  else
			  {
				  //iframe
				  echo'	<iframe src="'.$domena.'modules/'.$plik.'" frameborder="0"  width="'.$width.'" height="'.$height.'"  id="modul_'.$width.'" name="modul_'.$width.'"></iframe>';
			  }
			  
		  }//koniec while $rowM...
		  
	  }//koniec strona=6- wyświetlania modułu
	
	if ($strona==5){//BANER
		$queryBan="SELECT baner.zdjecie, baner.nazwa, baner.rodzaj_linku, baner.align, baner.width, baner.height, baner.link, baner.align FROM baner WHERE baner.id_kat='$id' AND (caly_czas=1 OR ( od<='$dzis' AND do>='$dzis')) ";
		$wynikBan=$dbh->getRow($queryBan);
		
		$banerL=$wynikBan[0];
		$banerDoWyswietlenia=$domena.$banerySrc.$banerL;
		$nazwa=htmlspecialchars(stripslashes($wynikBan[1]));
		$target=$wynikBan[2];
		$align=$wynikBan[3];
		$width=$wynikBan[4];
		$height=$wynikBan[5];
		$link=$wynikBan[6];
		$align=$wynikBan[7];
		
		//baner jest flashem
		if(ereg('.swf',$banerL))
		{?>
                <object id="FlashID" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="<?php echo $width; ?>" height="<?php echo $height; ?>">
                <param name="movie" value="<?php echo $banerDoWyswietlenia; ?>" />
                <param name="quality" value="high" />
                <param name="wmode" value="opaque" />
                <param name="swfversion" value="7.0.70.0" />
                <!-- This param tag prompts users with Flash Player 6.0 r65 and higher to download the latest version of Flash Player. Delete it if you don’t want users to see the prompt. -->
                <param name="expressinstall" value="<? echo $domena;?>Scripts/expressInstall.swf" />
                <!-- Next object tag is for non-IE browsers. So hide it from IE using IECC. -->
                <!--[if !IE]>-->
                <object type="application/x-shockwave-flash" data="<?php echo $banerDoWyswietlenia; ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>">
                  <!--<![endif]-->
                  <param name="quality" value="high" />
                  <param name="wmode" value="opaque" />
                  <param name="swfversion" value="7.0.70.0" />
                  <param name="expressinstall" value="<? echo $domena;?>Scripts/expressInstall.swf" />
                  <!-- The browser displays the following alternative content for users with Flash Player 6.0 and older. -->
                  <div>
                    <h4>Content on this page requires a newer version of Adobe Flash Player.</h4>
                    <p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" width="112" height="33" /></a></p>
                  </div>
                  <!--[if !IE]>-->
                </object>
                <!--<![endif]-->
              </object>
		<? 
		}
		else
		{
			echo'<div style="margin-top:2px;margin-bottom:2px;" align="'.$align.'">';
			if(!empty($link)){echo'<a href="'.$link.'" target="'.$target.'" title="'.$nazwa.'">';}
			echo'<img src="'.$banerDoWyswietlenia.'" alt="'.$nazwa.'" border="0"/>';	
			if(!empty($link)){echo'</a>';}
			echo'</div>';
		}
	}//koniec wyswietlania banera
	  
  }
  ?>
</div>

<!-- KONIEC SIDEBAR RIGHT -->
<br class="clearfloat" />
</div>
<!-- STOPKA-->
<div class="kontenerStopka">
<? $stopka=$dbh->getOne("SELECT tresc FROM modul_info "); echo $stopka; ?>
<br class="clearfloat" />
</div>
<!-- KONIEC STOPKA-->

<div class="validate">
&nbsp; <a href="http://www.onavi.pl">Tworzenie stron internetowych ONAVI</a></div>
</div>

<script type="text/javascript">
<!--
<? if ($wynikG[0]==1){?>var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"<? echo $domena;?>SpryAssets/SpryMenuBarDownHover.gif", imgRight:"<? echo $domena;?>SpryAssets/SpryMenuBarRightHover.gif"});<? }?>
<? if ($wynikB1[0]==1){?>var MenuBar2 = new Spry.Widget.MenuBar("MenuBar2", {imgRight:"<? echo $domena;?>SpryAssets/SpryMenuBarRightHover.gif"});<? }?>
<? if ($wynikB2[0]==1){?>var MenuBar3 = new Spry.Widget.MenuBar("MenuBar3", {imgRight:"<? echo $domena;?>SpryAssets/SpryMenuBarRightHover.gif"});<? }?>
//-->
</script>
<? echo stripslashes($meta[17]);?>
</body>
</html>