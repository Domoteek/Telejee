<?php
if (!isConnect('admin')) {
    throw new Exception('{{401 - Accès non autorisé}}');
}

sendVarToJS('eqType', 'Telejee');
$eqLogics = eqLogic::byType('Telejee');
?>

<div class="row row-overflow">
  <div class="col-md-2">
    <div class="bs-sidebar">
      <ul id="ul_eqLogic" class="nav nav-list bs-sidenav">
        <a class="btn btn-default eqLogicAction" style="width : 100%;margin-top : 5px;margin-bottom: 5px;" data-action="chargePlug"><i class="fa fa-plus-circle"></i> {{charger le plugin}}</a> <a class="btn btn-default eqLogicAction" style="width : 100%;margin-top : 5px;margin-bottom: 5px;" data-action="add_chaine"><i class="fa fa-plus-circle"></i> {{Ajouter des chaînes}}</a>
        <li class="filter" style="margin-bottom: 5px;">
          <input class="filter form-control input-sm" placeholder="{{Rechercher}}" style="width: 100%"/>
        </li>
        <?php
                foreach ($eqLogics as $eqLogic) {
					
					if ($eqLogic->getConfiguration('type') != 'moment' ) {
						 echo '<li class="cursor li_eqLogic" data-eqLogic_id="' . $eqLogic->getId() . '"><a>' . $eqLogic->getHumanName(True,True) . '</a></li>';
					}
                   
               }
                ?>
      </ul>
    </div>
  </div>
  
  <div class="col-lg-10 col-md-9 col-sm-8 eqLogicThumbnailDisplay" style="border-left: solid 1px #EEE; padding-left: 25px;">
   <div class="eqLogicThumbnailContainer">
   <div class="cursor eqLogicAction" data-action="add_chaine" style="background-color : #ffffff; height : 140px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;" >
     <center>
      <i class="fa fa-plus-circle" style="font-size : 5em;color:#00A9EC;"></i>
    </center>
    <span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;color:#00A9EC"><center>{{Ajouter des chaînes}}</center></span>
  </div>
  <div class="cursor eqLogicAction" data-action="gotoPluginConf" style="background-color : #ffffff; height : 120px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;">
    <center>
      <i class="fa fa-wrench" style="font-size : 5em;color:#767676;"></i>
    </center>
    <span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;color:#767676"><center>{{Configuration}}</center></span>
  </div>
</div>  
   <legend>{{Mes chaînes}} </legend>
    <?php
            $chaines = Telejee::getChainesconfig();
			function cmp($a, $b)
			{
				return strcmp($a["id"], $b["id"]);
			}
			
			usort($chaines, "cmp");
			echo '<div class="eqLogicThumbnailContainer">';
			$i =1;
			while (list($key, $value) = each($chaines)) {
				$Telejee = Telejee::byId($value["id"]);
				echo '<div class="eqLogicDisplayCard cursor" data-eqLogic_id="' . $Telejee->getId() . '" style="/*border:1px solid lightgray;*/ background-color : #ffffff; height : 100px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 100px;margin-left : 10px;" >';
				echo "<center>";
				echo '<img src="' . $Telejee->getConfiguration('logo') . '" height="50" width="50" />';
				echo "</center>";
				//echo '<span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;"><center>' . $Telejee->getHumanName(true) . '</center></span>';
				echo '</div>';
				$i++;
				
			}
			echo '</div>';
			


		?>
  </div>
  <div class="col-md-10 eqLogic" style="border-left: solid 1px #EEE; padding-left: 25px;display: none;">
    <form class="form-horizontal">
      <fieldset>
        <legend> <i class="fa fa-arrow-circle-left eqLogicAction cursor" data-action="returnToThumbnailDisplay"></i> {{Général}} 
        <!--i class="fa fa-arrow-circle-left eqLogicAction cursor" data-action="refresh"></i> {{Général}}--> 
        <i class='fa fa-cogs eqLogicAction pull-right cursor expertModeVisible' data-action='configure'></i> </legend>
        <div class="form-group">
          <label class="col-md-2 control-label">{{Nom}}</label>
          <div class="col-md-3">
            <input type="text" class="eqLogicAttr form-control" data-l1key="id" style="display : none;" />
            <input type="text" class="eqLogicAttr form-control" data-l1key="name" placeholder="{{Nom de l'équipement }}"/>
          </div>
        </div>
        <div class="form-group object_prog">
          <label class="col-md-2 control-label" >{{Objet parent}}</label>
          <div class="col-md-3">
            <select id="sel_object" class="eqLogicAttr form-control" data-l1key="object_id">
              <option value="">{{Aucun}}</option>
              <?php
                            foreach (object::all() as $object) {
                                echo '<option value="' . $object->getId() . '">' . $object->getName() . '</option>';
                            }
                            ?>
            </select>
          </div>
        </div>
        <div class="category form-group">
          <label class="col-md-2 control-label">{{Catégorie}}</label>
          <div class="col-md-8">
            <?php
                                foreach (jeedom::getConfiguration('eqLogic:category') as $key => $value) {
                                    echo '<label class="checkbox-inline">';
                                    echo '<input type="checkbox" class="eqLogicAttr" data-l1key="category" data-l2key="' . $key . '" />' . $value['name'];
                                    echo '</label>';
                                }
                                ?>
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label" >{{Activer}}</label>
          <div class="col-md-1">
            <input type="checkbox" class="eqLogicAttr checkbox-inline" data-label-text="{{Activer}}" data-l1key="isEnable" checked/>
          </div>
          <label class="col-md-2 control-label prog_visible" >{{Visible}}</label>
          <div class="col-md-1 prog_visible">
            <input type="checkbox" class="eqLogicAttr checkbox-inline" data-label-text="{{Visible}}" data-l1key="isVisible" checked/>
          </div>
        </div>
      </fieldset>
    </form>
    <form class="form-horizontal legend_action">
      <legend> {{Action(s) à executer sur le logo de la chaine :}} <a class="btn btn-success btn-xs" id="addEventLogo" style="margin-left: 5px;"><i class="fa fa-plus-circle"></i> {{Ajouter Action}}</a> </legend>
      <div id="div_action_logo"></div>
      <legend> {{Action(s) à executer sur le bouton play :}} <a class="btn btn-success btn-xs" id="addEventPlay" style="margin-left: 5px;"><i class="fa fa-plus-circle"></i> {{Ajouter Action}}</a> </legend>
      <div id="div_action_play"></div>
      <div class="form-group  ">
        <div class="alert alert-info"> {{
          - Pour la recherche mettre , séparer avec une virgule<br/>
          }} </div>
        <label class="col-md-1 control-label">{{Recherche}}</label>
        <div class="col-md-6">
          <input type="text" id="search_tv" class="eqLogicAttr configuration form-control" data-l1key="configuration" data-l2key="search_tv" placeholder="Texte"/>
        </div>
        <span >(Emission à rechercher)</span> </div>
      <legend> {{Action(s) à executer lorsque l'émission est en cours de diffusion :}} <a class="btn btn-success btn-xs" id="addEventSearch" style="margin-left: 5px;"><i class="fa fa-plus-circle"></i> {{Ajouter Action}}</a> </legend>
      <div id="div_action_search"></div>
    </form>
    <form class="form-horizontal widget-size">
      <div class="form-group ">
        <label class="col-md-2 control-label">{{Hauteur du widget dans le mode vue}}</label>
        <div class="col-md-1">
          <input type="text" id="widget-size" class="eqLogicAttr configuration form-control" data-l1key="configuration" data-l2key="widget-size" placeholder="size"/>
        </div>
        <span >(hauteur du widget en pixel. Par défaut 250px)</span> </div>    
      <div class="form-group">
        <label class="col-md-2 control-label">{{Mettre à jour les icônes}}</label>
        <div class="col-md-1"> <a class="btn btn-default eqLogicAction "  style="width : 100%;margin-top : 5px;margin-bottom: 5px;" data-action="editIcon"><i ></i> {{Icones}}</a> </div>
      </div>
    </form>
    <form class="form-horizontal">
      <fieldset>
        <div class="form-actions"> <a class="btn btn-danger eqLogicAction" data-action="remove"><i class="fa fa-minus-circle"></i> {{Supprimer}}</a> <a class="btn btn-success eqLogicAction" data-action="save"><i class="fa fa-check-circle"></i> {{Sauvegarder}}</a> </div>
      </fieldset>
    </form>
  </div>
</div>
<?php include_file('desktop', 'Telejee', 'js', 'Telejee'); ?>
<?php include_file('core', 'plugin.template', 'js'); ?>
