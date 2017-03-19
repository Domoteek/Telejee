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

/* * ***************************Includes********************************* */


require_once dirname(__FILE__) . '/../../../../core/php/core.inc.php';
include_file('core', 'authentification', 'php');

if (!isConnect('admin')) {
	 throw new Exception(__('401 - Accès non autorisé', __FILE__));
	die();
}

			switch(config::byKey('choix_op', 'Telejee')) {
			   case 0: $url = "http://www.programme-tv.net/programme/programme-tnt.html"; break;
			   case 1: $url = "http://www.programme-tv.net/programme/orange-12/"; break;
			   case 2: $url = "http://www.programme-tv.net/programme/free-13/"; break;
			   case 3: $url = "http://www.programme-tv.net/programme/sfr-25/"; break;
			   case 4: $url = "http://www.programme-tv.net/programme/numericable-7/"; break;
			   case 5: $url = "http://www.programme-tv.net/programme/canalsat-5/"; break;
			   case 6: $url = "http://www.programme-tv.net/programme/cablecom-suisse-32/"; break;
			   case 7: $url = "http://www.programme-tv.net/programme/numericable-belux-19/"; break; 

			}

?>
<div class="form-group" id="listChaine">
<?php
        $chaines_sat = array();
		$data = file_get_contents($url);
		$dom = new DOMDocument();
		@$dom->loadHTML('<?xml encoding="UTF-8">' .$data);
		$xpath = new DOMXPath($dom);
        $divs = $xpath->query('//div[@class="f-l w-10 p-h-sm c-grey-2"]');	
		 foreach ($divs as $div) {
			$doc = new DOMDocument();
			$copie = $div->cloneNode(TRUE);
			$doc->appendChild($doc->importNode($copie, True));
			$xpath = new DOMXPath($doc);
			$chaines =  $xpath->query('//a[@class="channel_label d-b fs-1 c-grey-2 td-n ta-c pt-xs o-h"]/@title');
			$chaine = str_replace("Programme de ","",$chaines->item(0)->nodeValue);
			array_push($chaines_sat, $chaine);
			
		 }
		 
		 
		 
				  
 

 foreach ($chaines_sat as $chaine) {
	 $chaine_sat  = Telejee::byTypeAndSearhConfiguration('Telejee','nom'.$chaine.'');
	 
	 if (count($chaine_sat) == 0) {
					   echo '<label class="col-lg-3 " >'.$chaine.'</label>';
					   echo '<div class="col-lg-1">';
					   echo  '<input type="checkbox"  value="'.$chaine.'" />';
					   echo '</div>';		 
	 } else {
	 }
 }

 ?>
 </div>
  <a class="btn btn-xs btn-success pull-right" id="saveCreatechaine" style="color: white;"><i class="fa fa-check-circle"></i> {{Sauver}}</a>

<script>
	$('#saveCreatechaine').on('click', function () {
		listChaine=new Array();
		$("#listChaine :checked").each(function(){
		   listChaine.push( $(this).val() );
		})

 	$.ajax({
		type: 'POST',
		url: 'plugins/Telejee/core/ajax/Telejee.ajax.php',
		data: {
			action: 'Createchaine',
			chaines: JSON.stringify(listChaine)

		},
		dataType: 'json',
		error: function (request, status, error) {
			handleAjaxError(request, status, error, $('#div_eventEditAlert'));
		},
		success: function (data) {
			if (data.state != 'ok') {
				$('#div_eventEditAlert').showAlert({message: data.result, level: 'danger'});
				return;
			}
			  modifyWithoutSave=false;
			 window.location.reload();
		}
		
	});				
	})

</script>
