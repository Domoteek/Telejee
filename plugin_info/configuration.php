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
include_file('core', 'authentification', 'php');
if (!isConnect()) {
    include_file('desktop', '404', 'php');
    die();
}


?>

<form class="form-horizontal">
    <fieldset>
        <legend><i class="fa fa-list-alt"></i> {{Général}}</legend>  
		<div class="form-group">
            <label class="col-lg-1 control-label">Bouquets: </label>
            <div class="col-lg-4">
				<select class="configKey form-control" id="select_sat" data-l1key="choix_op">
                    <option value="0">TNT</option>
                    <option value="1">Orange</option>
					<option value="2">Free</option>
                    <option value="3">Sfr</option>
                    <option value="4">Numericable</option>
                    <option value="5">Canal Sat</option>
                    <option value="6">Cablecom Suisse</option>
                    <option value="7">Numericable belux</option>
                    
                </select>
            </div>
        </div>
		<div class="form-group">
            <label class="col-lg-1 control-label">Icones: </label>
            <div class="col-lg-4">
				<select class="configKey form-control" id="select_icon" data-l1key="choix_icon">
                    <option value="1">Simple</option>
					<option value="2">Glossy</option>
                    <option value="3">Non dispo</option>
                    <option value="4">Non dispo</option>

                </select>
            </div>
        </div>
    	<legend><i class="fa fa-list-alt"></i> {{Localisation}}</legend>
        <div id="div_node" class="alert alert-success">{{Pour le format aller voir ==> http://php.net/manual/fr/timezones.php}}</div>
        
         <div class="form-group">
             <label class="col-lg-1 control-label">{{Code localisation}}</label>
             <div class="col-lg-4">
                 <input class="configKey form-control" data-l1key="code_local" />
             </div>
             <div class="col-lg-4" style="color:red">
             	 {{Ne pas remplir si votre fuseau correspond à celui des chaînes TV}}
             </div>
         </div>          
    </fieldset>
</form>		