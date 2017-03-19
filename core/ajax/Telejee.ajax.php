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

try {
    require_once dirname(__FILE__) . '/../../../../core/php/core.inc.php';
    include_file('core', 'authentification', 'php');

	if (!isConnect()) {
		 throw new Exception(__('401 - Accès non autorisé', __FILE__));
		die();
	}

     if (init('action') == 'getAllChaine') {
		$return = Telejee::getChaines();
		ajax::success($return);		
	}
     if (init('action') == 'getAllMoment') {
		$return = Telejee::getMoment();
		ajax::success($return);		
	}
	
     if (init('action') == 'getResume') {
		$return = Telejee::getResume(init('id'));
		ajax::success($return);		
	}	
    if (init('action') == 'launchActionChaine') {
		$return = Telejee::launchActionChaine(init('id'),init('type'));
		ajax::success();		
	}	
    if (init('action') == 'Createchaine') {
        Telejee::createChaine(init('chaines'));
        ajax::success();
    }

	if (init('action') == 'editIconTele') {
        Telejee::editIconTele();     
        ajax::success();
    }
	
	if (init('action') == 'chargePlug') {
        Telejee::chargePlug();     
        ajax::success();
    }	
	
	 throw new Exception(__('Aucune methode correspondante à : ', __FILE__) . init('action'));
    /*     * *********Catch exeption*************** */
} catch (Exception $e) {
    ajax::error(displayExeption($e), $e->getCode());
}
?>
