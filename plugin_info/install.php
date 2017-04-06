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

require_once dirname(__FILE__) . '/../../../core/php/core.inc.php';


function Telejee_install() {
    $cron = cron::byClassAndFunction('Telejee', 'progAtTheMoment');
    if (!is_object($cron)) {
        $cron = new cron();
        $cron->setClass('Telejee');
        $cron->setFunction('progAtTheMoment');
        $cron->setEnable(1);
		$cron->setSchedule('*/5 * * * *');
        $cron->save();
    }
	
    $cron = cron::byClassAndFunction('Telejee', 'progToTheNight');
    if (!is_object($cron)) {
        $cron = new cron();
        $cron->setClass('Telejee');
        $cron->setFunction('progToTheNight');
        $cron->setEnable(1);
		$cron->setSchedule('2 1,3,12,18 * * *');
        $cron->save();
    }

}

function Telejee_update() {
    $cron = cron::byClassAndFunction('Telejee', 'progAtTheMoment');
    if (!is_object($cron)) {
        $cron = new cron();
        $cron->setClass('Telejee');
        $cron->setFunction('progAtTheMoment');
        $cron->setEnable(1);
		$cron->setSchedule('*/5 * * * *');
        $cron->save();
    }
	$cron->stop();
	
    $cron = cron::byClassAndFunction('Telejee', 'progToTheNight');
    if (!is_object($cron)) {
        $cron = new cron();
        $cron->setClass('Telejee');
        $cron->setFunction('progToTheNight');
        $cron->setEnable(1);
		$cron->setSchedule('2 0,1,3,12,18 * * *');
        $cron->save();
    }
	$cron->stop();	
	Telejee::update_data();
	log::add('Telejee', 'error', '!!!Bien lire le changelog et surtout la doc');

}

function Telejee_remove() {
    $cron = cron::byClassAndFunction('Telejee', 'progAtTheMoment');
    if (is_object($cron)) {
        $cron->remove();
    }
    $cron = cron::byClassAndFunction('Telejee', 'progToTheNight');
    if (is_object($cron)) {
        $cron->remove();
    }	
	
}
?>
