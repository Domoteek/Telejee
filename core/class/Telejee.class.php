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
require_once dirname(__FILE__) . '/../../3rdparty/conversion.php';

class Telejee extends eqLogic {
    /*     * *************************Attributs****************************** */

	public static $_widgetPossibility = array('custom' => true);

    /*     * ***********************Methode static*************************** */
	 public static function pull($_options) {

	 }
	
    /*     * *********************Methode d'instance************************* */
    public function getChainesconfig() {
		 $results = array();
		 $i = 0;
		 foreach (Telejee::byType('Telejee') as $Telejee) {
			if ($Telejee->getConfiguration('type') == 'soir' || $Telejee->getConfiguration('type') == 'config') {
			 $results[$i]['id'] = $Telejee->getId();	 
			 $i++;
			}
		 }
		  
		  return $results;
	}
	
	 public static function update_data() {
		 if (config::byKey('choix_icon', 'Telejee') != '') {
			 log::add('Telejee','info', 'update pas besoin');
			 return false;
			 
		 }
			
		 foreach (Telejee::byType('Telejee') as $Telejee) {
			 $chaine = $Telejee->getName();
			 $chaine = string_conversion($chaine);
			   if (is_object($Telejee) && $Telejee->getConfiguration('type') == 'soir') {
				   $Telejee->setName($chaine);
				   $Telejee->setConfiguration('logo', 'plugins/Telejee/core/template/dashboard/themes/Simple/'.$chaine.'.gif');
				   $Telejee->setConfiguration('vignette', 'plugins/Telejee/core/template/dashboard/themes/Simple/'.$chaine.'.gif');
				   $Telejee->save();
			   }
			   if (is_object($Telejee) && $Telejee->getConfiguration('type') == 'moment') {
				   $Telejee->setName($chaine);
				   $icone = str_replace('moment_' , "", $chaine);
				   $Telejee->setConfiguration('logo', 'plugins/Telejee/core/template/dashboard/themes/Simple/'.$icone.'.gif');
				   $Telejee->setConfiguration('vignette', 'plugins/Telejee/core/template/dashboard/themes/Simple/'.$icone.'.gif');
				   $Telejee->save();
			   }
		  }

	 }
	 public static function editIconTele() {
		 	switch(config::byKey('choix_icon', 'Telejee')) {
			   case 1: $icon_tv = "Simple"; break;
			   case 2: $icon_tv = "Glossy"; break;
			   case 3: $icon_tv = ""; break;
			   case 4: $icon_tv = ""; break;
			}
		 foreach (Telejee::byType('Telejee') as $Telejee) {
			 $chaine = $Telejee->getName();
			 $chaine = string_conversion($chaine);
			   if (is_object($Telejee) && $Telejee->getConfiguration('type') == 'soir') {
		          $Telejee->setConfiguration('logo', 'plugins/Telejee/core/template/dashboard/themes/'.$icon_tv.'/'.$chaine.'.gif');
				   $Telejee->save();
			   }
			   if (is_object($Telejee) && $Telejee->getConfiguration('type') == 'moment') {
				   $icone = str_replace('moment_' , "", $chaine);
		            $Telejee->setConfiguration('logo', 'plugins/Telejee/core/template/dashboard/themes/'.$icon_tv.'/'.$icone.'.gif');
				   $Telejee->save();
			   }
		  }
	 }
	
		public static function createChaine($chaines) {
			switch(config::byKey('choix_icon', 'Telejee')) {
			   case 1: $icon_tv = "Simple"; break;
			   case 2: $icon_tv = "Glossy"; break;
			   case 3: $icon_tv = ""; break;
			   case 4: $icon_tv = ""; break;
			}
						
            $chaines   =   json_decode("$chaines",true);
			foreach ($chaines as $chaine) {
                $chaine = string_conversion($chaine);
			 				
	            $eqLogic = new eqLogic();
	            $eqLogic->setEqType_name('Telejee');
	            $eqLogic->setIsEnable(1);
		     	$eqLogic->setIsVisible(0);
	            $eqLogic->setName($chaine);
				$eqLogic->setConfiguration('type', 'soir');
				$eqLogic->setConfiguration('tag', 'nom'.$chaine.'');
				$eqLogic->setConfiguration('categ', 'chaine_sat');
		        $eqLogic->setConfiguration('logo', 'plugins/Telejee/core/template/dashboard/themes/'.$icon_tv.'/'.$chaine.'.gif');
		        $eqLogic->setConfiguration('heure1', '');
                $eqLogic->setConfiguration('image1', '');
		        $eqLogic->setConfiguration('titre1', '');
		        $eqLogic->setConfiguration('heure2', '');
                $eqLogic->setConfiguration('image2', '');
		        $eqLogic->setConfiguration('titre2', '');	
				$eqLogic->setConfiguration('lien1', '');	
				$eqLogic->setConfiguration('lien2', '');
		        $eqLogic->setConfiguration('vignette', 'plugins/Telejee/core/template/dashboard/themes/'.$icon_tv.'/'.$chaine.'.gif');
				$eqLogic->save();
	            $eqLogic = self::byId($eqLogic->getId());	
				
				$eqLogic = new eqLogic();
				$eqLogic->setEqType_name('Telejee');
				$eqLogic->setIsEnable(1);
				$eqLogic->setIsVisible(0);
				$eqLogic->setName('moment_'.$chaine);
				$eqLogic->setConfiguration('tag', 'nomoment'.$chaine.'');
				$eqLogic->setConfiguration('type', 'moment');
				$eqLogic->setConfiguration('titre', '');
				$eqLogic->setConfiguration('heure', '');
				$eqLogic->setConfiguration('image', '');
				$eqLogic->setConfiguration('lien', '');
		        $eqLogic->setConfiguration('logo', 'plugins/Telejee/core/template/dashboard/themes/'.$icon_tv.'/'.$chaine.'.gif');
				$eqLogic->save();
				$eqLogic = self::byId($eqLogic->getId());
				
				}
			Telejee::progAtTheMoment();
			Telejee::progToTheNight();	
			
		}
				
    public function getChaines() {
				
		 $results = array();
		 $i = 0;
		 foreach (Telejee::byType('Telejee') as $Telejee) {
			 if ($Telejee->getIsenable() == 1 && $Telejee->getConfiguration('type') == 'soir') {
			 $results[$i]['id'] = $Telejee->getId();
			 $results[$i]['heure1'] = $Telejee->getconfiguration("heure1");
			 $results[$i]['logo'] = $Telejee->getconfiguration("logo");
			 $results[$i]['image1'] = $Telejee->getconfiguration("image1");
             $results[$i]['titre1'] = $Telejee->getconfiguration("titre1");
			 $results[$i]['lien1'] = $Telejee->getconfiguration("lien1");
			 $results[$i]['lien2'] = $Telejee->getconfiguration("lien2");
			 $results[$i]['heure2'] = $Telejee->getconfiguration("heure2");
			 $results[$i]['image2'] = $Telejee->getconfiguration("image2");
             $results[$i]['titre2'] = $Telejee->getconfiguration("titre2");			 
			 $i++;
		     }
		 }
		  
		  return $results;
	}
	
    public function getMoment() {
		 $results = array();
		 $i = 0;
		 foreach (Telejee::byType('Telejee') as $Telejee) {
			 if ($Telejee->getIsenable() == 1 && $Telejee->getConfiguration('type') == 'moment') {
			 $results[$i]['id'] = $Telejee->getId();
			 $results[$i]['heure'] = $Telejee->getconfiguration("heure");
			 $results[$i]['image'] = $Telejee->getconfiguration("image");
             $results[$i]['titre'] = $Telejee->getconfiguration("titre");
			 $results[$i]['logo'] = $Telejee->getconfiguration("logo");
			 $results[$i]['lien'] = $Telejee->getconfiguration("lien");
			 $i++;
		     }
		 }
		  
		  return $results;
	}
	 public function getResume($id) {
		$results = array();
        $data = file_get_contents('http://www.programme-tv.net/'.$id);
		@$dom = new DOMDocument();
		libxml_use_internal_errors(true);
		$dom->loadHTML('<?xml encoding="UTF-8">' .$data);
			if (!$dom->loadHTML($data))
		{
			$errors="";
			foreach (libxml_get_errors() as $error)  {
				$errors.=$error->message."<br/>";
				log::add('Telejee', 'debug', $errors);
			}
			libxml_clear_errors();
			log::add('Telejee', 'debug', $errors);
			//print "libxml errors:<br>$errors";
			return;
		}
		$xpath = new DOMXPath($dom);
		$divs = $xpath->query('//div[@class="editorial-content"]');
		foreach ($divs as $div) { 
		    $doc = new DOMDocument();
			$copie = $div->cloneNode(TRUE);
			$doc->appendChild($doc->importNode($copie, True));
			$xpath = new DOMXPath($doc);
			
			$images = $xpath->query('//img[@class="pull-right"]/@src');
		 $results['image'] = '<img style="float:left;" src="'.$image = $images->item(0)->nodeValue.'" >';
		 $results['resume'] =  $div->nodeValue;
         }
		 return $results;
		 
	 }
	
	
	
	 public static function launchActionChaine($id,$type) {
		 $Telejee = Telejee::byId($id);
		  if (is_object($Telejee)) {
			  
			  $events = $Telejee->getConfiguration('action_'.$type.'');
				foreach ($events as $event) {
					try {
						scenarioExpression::createAndExec('action', $event['cmd'], $event['options']);
					} catch (Exception $e) {
						log::add('Telejee', 'error', __('Erreur lors de l\'éxecution de ', __FILE__) . $event['cmd'] . __('. Détails : ', __FILE__) . $e->getMessage());
					}
				}
		  }
			  
		  
	 }		
	

	
	 public function postSave() {
       $etat = $this->getIsEnable();
	   $id = $this->getId()+25;
		if ($etat == 0) {
			foreach (Telejee::byType('Telejee') as $Telejee) {
				if ($Telejee->getId() == $id) {
					$Telejee->setIsEnable(0);
					$Telejee->save();
				}
			}
		} else {
			foreach (Telejee::byType('Telejee') as $Telejee) {
				if ($Telejee->getId() == $id) {
					$Telejee->setIsEnable(1);
					$Telejee->save();
					
				}
			}		  
		}
	 }

   
   public function chargePlug() {
 
		$eqLogics = eqLogic::byType('Telejee');
		
	    foreach($eqLogics as $eqLogic) {
            $eqLogic->remove();
		};
		
			$eqLogic = new eqLogic();
			$eqLogic->setEqType_name('Telejee');
			$eqLogic->setIsEnable(1);
			$eqLogic->setIsVisible(1);
			$eqLogic->setName('Configuration');
			$eqLogic->setConfiguration('type', 'config');
			$eqLogic->setConfiguration('logo', 'plugins/Telejee/desktop/img/icones/defaut.png');
			$eqLogic->save();
	}
	
    public function preRemove() {
		if ($this->getConfiguration('tag') == 'nom'.$this->getName()) {
			$chaines_remove  = Telejee::byTypeAndSearhConfiguration( 'Telejee', 'nomoment'.$this->getName());
				foreach($chaines_remove as $chaine) {
					$chaine->remove();
				}
		}
	}
		
   public function progToTheNight() {
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
			switch(config::byKey('choix_icon', 'Telejee')) {
			   case 1: $icon_tv = "Simple"; break;
			   case 2: $icon_tv = "Glossy"; break;
			   case 3: $icon_tv = ""; break;
			   case 4: $icon_tv = ""; break;
			}
			
							
		$data = file_get_contents($url);
		@$dom = new DOMDocument();
		libxml_use_internal_errors(true);
		$dom->loadHTML('<?xml encoding="UTF-8">' .$data);
			if (!$dom->loadHTML($data))
		{
			$errors="";
			foreach (libxml_get_errors() as $error)  {
				$errors.=$error->message."<br/>";
				log::add('Telejee', 'debug', $errors);
			}
			libxml_clear_errors();
			log::add('Telejee', 'debug', $errors);
			//print "libxml errors:<br>$errors";
			return;
		}
		$xpath = new DOMXPath($dom);
        $divs = $xpath->query('//div[@class="clearfix p-v-md bgc-white bb-grey-3"]');	
		$chaines_sat  = Telejee::byTypeAndSearhConfiguration( 'Telejee', 'chaine_sat');
		 $stack = array();
		 if (count($chaines_sat) > 0) {
			foreach ($chaines_sat as $chaine) {
				array_push($stack, $chaine->getName());
			}
		 }	
		 
		 foreach ($divs as $div) {
			$doc = new DOMDocument();
			$copie = $div->cloneNode(TRUE);
			$doc->appendChild($doc->importNode($copie, True));
			$xpath = new DOMXPath($doc);
			$chaines = $xpath->query('//a[@class="channel_label d-b fs-1 c-grey-2 td-n ta-c pt-xs o-h"]/@title');
			$chaine = str_replace("Programme de ","",$chaines->item(0)->nodeValue);
			$chaine = string_conversion($chaine);
		  
			$Telejee = telejee::byTypeAndSearhConfiguration( 'Telejee', 'nom'.$chaine);
				 if (in_array($chaine,$stack)) {

						$titre1 = $xpath->query('.//a[@class="prog_name c-red-hover c-red fw-700 fs-3"]')->item(0)->nodeValue;
						$titre2 = $xpath->query('.//a[@class="prog_name c-red-hover c-red fw-700 fs-3"]')->item(1)->nodeValue;
						$lien1 = $xpath->query('.//a[@class="prog_name c-red-hover c-red fw-700 fs-3"]/@href')->item(0)->nodeValue ;
						$lien2 = $xpath->query('.//a[@class="prog_name c-red-hover c-red fw-700 fs-3"]/@href')->item(1)->nodeValue ;
						$image_prog1 = $xpath->query('.//img/@data-src')->item(1)->nodeValue;
						$image_prog2 = $xpath->query('.//img/@data-src')->item(2)->nodeValue;
						$heure_prog1 =  $xpath->query('.//span[@class="prog_heure f-l fw-700 mr-xs"]')->item(0)->nodeValue;
						$heure_prog2 =  $xpath->query('.//span[@class="prog_heure f-l fw-700 mr-xs"]')->item(1)->nodeValue;
						if (config::byKey('code_local', 'Telejee') != '') {
							$date = new DateTime(date("Y-m-d") . $heure_prog2, new DateTimeZone('Europe/Paris'));
							date_default_timezone_set(config::byKey('code_local', 'Telejee'));
							$heure_prog2 = date("H:i", $date->format('U'));	
							$date = new DateTime(date("Y-m-d") . $heure_prog1, new DateTimeZone('Europe/Paris'));
							date_default_timezone_set(config::byKey('code_local', 'Telejee'));
							$heure_prog1 = date("H:i", $date->format('U'));		
						}
						$Telejee[0]->setConfiguration('heure1', $heure_prog1);
						$Telejee[0]->setConfiguration('image1', $image_prog1);
						$Telejee[0]->setConfiguration('titre1', $titre1);
						$Telejee[0]->setConfiguration('heure2', $heure_prog2);
						$Telejee[0]->setConfiguration('image2', $image_prog2);
						$Telejee[0]->setConfiguration('titre2', $titre2);	
						$Telejee[0]->setConfiguration('lien1', $lien1);	
						$Telejee[0]->setConfiguration('lien2', $lien2);
		                $Telejee[0]->setConfiguration('logo', 'plugins/Telejee/core/template/dashboard/themes/'.$icon_tv.'/'.$chaine.'.gif');
						$Telejee[0]->save();
				}				
		}
	}

	public function progAtTheMoment() {

			switch(config::byKey('choix_op', 'Telejee')) {
			   case 0: $url = "http://www.programme-tv.net/programme/programme-tnt/"; break;
			   case 1: $url = "http://www.programme-tv.net/programme/orange-12/"; break;
			   case 2: $url = "http://www.programme-tv.net/programme/free-13/"; break;
			   case 3: $url = "http://www.programme-tv.net/programme/sfr-25/"; break;
			   case 4: $url = "http://www.programme-tv.net/programme/numericable-7/"; break;
			   case 5: $url = "http://www.programme-tv.net/programme/canalsat-5/"; break;
			   case 6: $url = "http://www.programme-tv.net/programme/cablecom-suisse-32/"; break;
			   case 7: $url = "http://www.programme-tv.net/programme/numericable-belux-19/"; break; 

			}
			switch(config::byKey('choix_icon', 'Telejee')) {
			   case 1: $icon_tv = "Simple"; break;
			   case 2: $icon_tv = "Glossy"; break;
			   case 3: $icon_tv = ""; break;
			   case 4: $icon_tv = ""; break;
			}
						
					
	    $data = file_get_contents($url.'en-ce-moment.html');
        @$dom = new DOMDocument();
		libxml_use_internal_errors(true);
		$dom->loadHTML('<?xml encoding="UTF-8">' .$data);
			if (!$dom->loadHTML($data))
		{
			$errors="";
			foreach (libxml_get_errors() as $error)  {
				$errors.=$error->message."<br/>";
				echo $errors;
			}
			libxml_clear_errors();
			log::add('Telejee', 'debug', $errors);
			echo $errors;
			//print "libxml errors:<br>$errors";
			return;
		}
		$xpath = new DOMXPath($dom);
		$divs = $xpath->query('//div[@class="clearfix p-v-md bgc-white bb-grey-3"]');
        $chaines_sat  = Telejee::byTypeAndSearhConfiguration( 'Telejee', 'chaine_sat');
		 $stack = array();
		 if (count($chaines_sat) > 0) {
			foreach ($chaines_sat as $chaine) {
				array_push($stack, $chaine->getName());
			}
		 }
		 if($divs->length > 0){ 
				 foreach ($divs as $div) {
							$doc = new DOMDocument();
							$copie = $div->cloneNode(TRUE);
							$doc->appendChild($doc->importNode($copie, True));
							$xpath = new DOMXPath($doc);		
							$chaines =  $xpath->query('//a[@class="channel_label d-b fs-1 c-grey-2 td-n ta-c pt-xs o-h"]/@title');
							$chaine = str_replace("Programme de ","",$chaines->item(0)->nodeValue);
							$chaine = string_conversion($chaine);
						if (in_array($chaine,$stack)) {
							$Telejee = telejee::byTypeAndSearhConfiguration( 'Telejee', 'nom'.$chaine);
							$search_title = $Telejee[0]->getConfiguration('search_tv');
							$events = $Telejee[0]->getConfiguration('action_search');
							
							$Telejee = telejee::byTypeAndSearhConfiguration( 'Telejee', 'nomoment'.$chaine);
							$Telejee[0]->setConfiguration('logo', 'plugins/Telejee/core/template/dashboard/themes/'.$icon_tv.'/'.$chaine.'.gif');
							$Telejee[0]->save();
							$chaine;
							$heure = $xpath->query('.//span[@class="prog_heure f-l fw-700 mr-xs"]')->item(0)->nodeValue;
							if (config::byKey('code_local', 'Telejee') != '') {
								$date = new DateTime(date("Y-m-d") . $heure, new DateTimeZone('Europe/Paris'));
								date_default_timezone_set(config::byKey('code_local', 'Telejee'));
								$heure = date("H:i", $date->format('U'));					
								
							}							 

								 
							  $titre = $xpath->query('.//a[@class="prog_name c-red-hover c-red fw-700 fs-3"]')->item(0)->nodeValue;
							  log::add('Telejee', 'debug', 'titre: '. $titre);
								 

							  $lien =  $xpath->query('.//a[@class="prog_name c-red-hover c-red fw-700 fs-3"]/@href')->item(0)->nodeValue ;
							  log::add('Telejee', 'debug', 'lien: '. $lien);							

							  $image =  $xpath->query('.//img/@data-src')->item(1)->nodeValue;
							  log::add('Telejee', 'debug', 'image: '. $image);
							  $Telejee[0]->setConfiguration('titre', $titre);
							  $Telejee[0]->setConfiguration('heure', $heure);
							  $Telejee[0]->setConfiguration('image', $image);
							  $Telejee[0]->setConfiguration('lien', $lien);
							  $Telejee[0]->save();
							  
									if 	($search_title != '') {
										$datas = explode( ',', $search_title );
										 foreach ($datas as $data) {
											if (strstr(strtolower($titre),strtolower($data))) {
												if ($Telejee[0]->getConfiguration('exec_event') == '' || time()-$Telejee[0]->getConfiguration('exec_event')>1800) {
													log::add('Telejee', 'info', 'recherche ok mais temps suprieure a 1h');
													foreach ($events as $event) {
														try {
															scenarioExpression::createAndExec('action', $event['cmd'], $event['options']);
														} catch (Exception $e) {
															log::add('Telejee', 'error', __('Erreur lors de l\'éxecution de ', __FILE__) . $event['cmd'] . __('. Détails : ', __FILE__) . $e->getMessage());
														}
													}
													$Telejee[0]->setConfiguration('exec_event', time());
													$Telejee[0]->save();
													break;
												} else {
													log::add('Telejee', 'info', 'recherche ok mais temps inferieure a 1h' . $titre);
												}
															
											}
										 }
									}

						} 
				}
		 }
	}
	
	
	
	public function toHtml($_version = 'dashboard') {
		$replace = $this->preToHtml($_version);
		if (!is_array($replace)) {
			return $replace;
		}		
		$_version = jeedom::versionAlias($_version);
		if ($_version == 'mobile') {
		   if ($this->getConfiguration('widget-size') == '') {
			   $size=250;
		   } else {
			  $size= $this->getConfiguration('widget-size');
		   };	
		   $replace['#size#'] = $size.'px';		
		}
		$html = template_replace($replace, getTemplate('core', $_version, 'prog', 'Telejee'));
		cache::set('TelejeeWidget' . $_version . $this->getId(), $html, 0);
		return $html;

	} 
}

class TelejeeCmd extends cmd {

    public function dontRemoveCmd() {
        return true;
    }
	
	public function execute($_options = array()) {
    }

}

?>