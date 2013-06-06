<?php
	$Info = $xml->createElement("Info");
	$InfoAreaAttribute = $xml->createAttribute("area");
	$InfoAreaAttribute->value = $xmlFromFile->Info->Area;
	$Info->appendChild($InfoAreaAttribute);
	$InfoTimeAttribute = $xml->createAttribute("time");
	$InfoTimeAttribute->value = $xmlFromFile->Info['time'];
	$Info->appendChild($InfoTimeAttribute);

	$Area = $xml->createElement("Area");
	$AreaText = $xml->createTextNode($xmlFromFile->Info->Area);
	$Area->appendChild($AreaText);

	$Daily = $xml->createElement("Daily");

	$date = $xml->createElement("date");
	$dateText = $xml->createTextNode($xmlFromFile->Info->Daily_1->date);
	$date->appendChild($dateText);
	$Daily->appendChild($date);

	$wea = $xml->createElement("wea");
	$weaText = $xml->createTextNode($xmlFromFile->Info->Daily_1->wea);
	$wea->appendChild($weaText);
	$Daily->appendChild($wea);

	$code = $xml->createElement("code");
	$codeText = $xml->createTextNode($xmlFromFile->Info->Daily_1->code);
	$code->appendChild($codeText);
	$Daily->appendChild($code);

	$n_t = $xml->createElement("n_t");
	$n_tText = $xml->createTextNode($xmlFromFile->Info->Now->n_t);
	$n_t->appendChild($n_tText);
	$Daily->appendChild($n_t);

	$t_min = $xml->createElement("t_min");
	$t_minText = $xml->createTextNode($xmlFromFile->Info->Daily_1->t_low);
	$t_min->appendChild($t_minText);
	$Daily->appendChild($t_min);

	$t_max = $xml->createElement("t_max");
	$t_maxText = $xml->createTextNode($xmlFromFile->Info->Daily_1->t_high);
	$t_max->appendChild($t_maxText);
	$Daily->appendChild($t_max);

	$p_rain = $xml->createElement("p_rain");
	$p_rainText = $xml->createTextNode($xmlFromFile->Info->Daily_1->p_rain);
	$p_rain->appendChild($p_rainText);
	$Daily->appendChild($p_rain);

	$Info->appendChild($Area);
	$Info->appendChild($Daily);

	$root->appendChild($Info);

	$xml->formatOutput = true;

	$xml->save("mybooks.xml") or die("Error");