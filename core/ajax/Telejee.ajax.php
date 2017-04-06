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
	
	if (init('action') == 'addTelco') {
	    Telejee::newTel(init('name'));
        ajax::success();
    }	
	
	if (init('action') == 'LaunchAction') {
		 log::add('Telejee','debug', 'ajax launch action');
        Telejee::LaunchAction(init('id'),init('cmd'));
		ajax::success();
    } elseif (init('action') == 'getTelejee')  {
		if (init('object_id') == '') {
			$object = object::byId($_SESSION['user']->getOptions('defaultDashboardObject'));
		} else {
			$object = object::byId(init('object_id'));
		}
		if (!is_object($object)) {
			$object = object::rootObject();
		}
		$return = array();
		$return['eqLogics'] = array();
		if (init('object_id') == '') {
			foreach (object::all() as $object) {
				foreach ($object->getEqLogic(true, false, 'Telejee') as $telejee) {
					$return['eqLogics'][] = $telejee->toHtml(init('version'));
				}
			}
		} else {
			foreach ($object->getEqLogic(true, false, 'Telejee') as $telejee) {
				$return['eqLogics'][] = $telejee->toHtml(init('version'));
			}
			foreach (object::buildTree($object) as $child) {
				$telejees = $child->getEqLogic(true, false, 'Telejee');
				if (count($telejees) > 0) {
					foreach ($telejees as $telejee) {
						$return['eqLogics'][] = $telejee->toHtml(init('version'));
					}
				}
			}
		}
		ajax::success($return);
			
	}
		
	
	 throw new Exception(__('Aucune methode correspondante à : ', __FILE__) . init('action'));
    /*     * *********Catch exeption*************** */
} catch (Exception $e) {
    ajax::error(displayExeption($e), $e->getCode());
}
?>
