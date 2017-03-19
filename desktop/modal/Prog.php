<?php

/* This file is part of Jeedom.
*
* Jeedom is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* Jeedom is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
*/


require_once dirname(__FILE__) . '/../../../../core/php/core.inc.php';
include_file('core', 'authentification', 'php');

if (!isConnect()) {
	 throw new Exception(__('401 - Accès non autorisé', __FILE__));
	die();
}



		
        $data = file_get_contents('http://www.programme-tv.net/'.init('id').'');
		@$dom = new DOMDocument();
		libxml_use_internal_errors(true);
		$dom->loadHTML('<?xml encoding="UTF-8">' .$data);
			if (!$dom->loadHTML($data))
		{
			$errors="";
			foreach (libxml_get_errors() as $error)  {
				$errors.=$error->message."<br/>";
			}
			libxml_clear_errors();
			print "libxml errors:<br>$errors";
			return;
		}
		$xpath = new DOMXPath($dom);
	//	$divs = $xpath->query('//div[@class="editorial-content"]');
		$divs = $xpath->query('//div[@class="episode-synopsis mb-md pb-md bb-grey-3 clearfix"]');
		foreach ($divs as $div) { 
		    $doc = new DOMDocument();
			$copie = $div->cloneNode(TRUE);
			$doc->appendChild($doc->importNode($copie, True));
			$xpath = new DOMXPath($doc);
			//$images = $xpath->query('//img[@class="pull-right"]/@src');
			$images = $xpath->query('//img/@data-src');
			$titres = $xpath->query('//div[@class="d-b"]');
	        $image = '<img src="'.$images->item(0)->nodeValue.'" /> ';
	 		$titre = $titres->item(0)->nodeValue;
			
			break;
         }
		 
		
		
?>


<div id="resume"><?php echo $image; ?> <br/></div>

<div id="resume" style="font-weight:bold"><?php echo $titre; ?> </div>



<style>

</style>