<?php
if (!isConnect('admin')) {
    throw new Exception('{{401 - Accès non autorisé}}');
}

sendVarToJS('eqType', 'Telejee');
$eqLogics = eqLogic::byType('Telejee');
$eqLogicsSorted['telco'] = array();
$eqLogicsSorted['chaines'] = array();

foreach ($eqLogics as $eqLogic) {
	
	if ($eqLogic->getConfiguration('type') == 'telco') {
		array_push($eqLogicsSorted['telco'], $eqLogic);
	} else {
		array_push($eqLogicsSorted['chaines'], $eqLogic);
	}
}





?>

<div class="row row-overflow">

  <div class="col-md-2">
    <div class="bs-sidebar">
      <ul id="ul_eqLogic" class="nav nav-list bs-sidenav">
        <a class="btn btn-default eqLogicAction" style="width : 100%;margin-top : 5px;margin-bottom: 5px;" data-action="chargePlug"><i class="fa fa-plus-circle"></i> {{Activer les chaînes}}</a> 
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
			<span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;color:#00A9EC"><center>{{Ajouter des chaînes}}				</center></span>
			</div>
			<div class="cursor eqLogicAction" data-action="addTel" style="background-color : #ffffff; height : 140px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;" >
            <center>
              <i class="fa fa-plus-circle" style="font-size : 5em;color:#00A9EC;"></i>
            </center>
			<span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;color:#00A9EC"><center>{{Télécommande}}				</center></span>
			</div>            
            
			<div class="cursor eqLogicAction" data-action="gotoPluginConf" style="background-color : #ffffff; height : 120px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;">
            <center>
            <i class="fa fa-wrench" style="font-size : 5em;color:#767676;"></i>
            </center>
    		<span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;color:#767676"><center>{{Configuration}}</center></span>
			</div>        
            
		</div>  
        
        <div class="eqLogicThumbnailContainer" >
      
					<?php
					
					foreach ($eqLogicsSorted as $state => $eqLogicList) {
						if ($state == 'telco') {
							echo "<legend>{{Mes télécommandes}}</legend>";
							foreach ($eqLogicList as $type) {

							echo '<div class="eqLogicDisplayCard cursor" data-eqLogic_id="' . $type->getId() . '" style="background-color : #ffffff; height : 200px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px; " >';
							echo "<center>";
							echo '<img src="plugins/Telejee/doc/images/telejee_icon.png" height="105" width="95" />';
							echo "</center>";
							echo '<span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;" ><center>' . $type->getHumanName(true, true) . '</center></span>';
							echo '</div>';								
								
							}
						} else {
							echo "<legend>{{Mes chaines}}</legend>";
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
						}					
					}

    
           			 ?> 
        </div>
    </div>  

  <div class="col-md-10 eqLogic" style="border-left: solid 1px #EEE; padding-left: 25px;display: none;">
  
  
     <a class="btn btn-success eqLogicAction pull-right" data-action="save"><i class="fa fa-check-circle"></i> {{Sauvegarder}}</a>
    <a class="btn btn-danger eqLogicAction pull-right telco" data-action="remove"><i class="fa fa-minus-circle"></i> {{Supprimer}}</a>
     <ul class="nav nav-tabs" role="tablist">
      <li role="presentation"><a href="#" class="eqLogicAction" aria-controls="home" role="tab" data-toggle="tab" data-action="returnToThumbnailDisplay"><i class="fa fa-arrow-circle-left"></i></a></li>
      <li role="presentation" class="active"><a href="#eqlogictab" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-tachometer"></i> {{Equipement}}</a></li>
      <li role="presentation"><a href="#infocmd" aria-controls="profile" role="tab" data-toggle="tab"><i class="fa fa-list-alt"></i> {{Commandes}}</a></li>
      <i class='fa fa-cogs eqLogicAction pull-right cursor expertModeVisible' data-action='configure'></i>
    </ul>
	<div class="tab-content" style="height:calc(100% - 50px);overflow:auto;overflow-x: hidden;">
		<div role="tabpanel" class="tab-pane active" id="eqlogictab">   
    <form class="form-horizontal">
      <fieldset>
      	<br/>

        <div class="form-group">
          <label class="col-md-2 control-label">{{Nom}}</label>
          <div class="col-md-3">
            <input id="id_telejee" type="text" class="eqLogicAttr form-control" data-l1key="id" style="display : none;" />
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
        <div class="form-group telco">
          <label class="col-md-2 control-label" >{{Telecommande}}</label>
          <div class="col-md-1">
            <select id="sel_telco" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="telco_type">
              <option selected>{{Universelle}}</option>
              <option  >{{TV}}</option>
			  <option  disabled>{{Video}}</option>
            </select>
          </div>
        </div> 
        
        <div class="row">
        	<div class="col-md-6 col-md-offset-4">
                <div  id="tv" class="telco" style="text-align:center;"  >
<br/> 
                    <div class="verticalAlign" style="text-align:center;" >
                    		<button   name="poweroff" style="color:red;"  ><i class="fa  fa-power-off"></i></button>
                            <button   name="poweroff" style="color:green;"  ><i class="fa  fa-bars"></i></button>
                            <button   name="poweroff" style="color:yellow;"  ><i class="fa  fa-home"></i></button>
                            <button   style="color:#0099ff;" name="source" >hdmi</i></button> 
                    </div>
                    <br/>
                    <div class="verticalAlign" style="text-align:center;">
                            <button   name="un"   >1</button>
                            <button    name="deux" >2</button>
                            <button    name="trois" >3</button> 
                    </div> 
                    <div class="verticalAlign" style="text-align:center;">
                            <button   name="quatre"   >4</button>
                            <button    name="cinq" >5</button>
                            <button   name="six" >6</button> 
                    </div>  
                    <div class="verticalAlign" style="text-align:center;">
                            <button   name="sept"   >7</button>
                            <button    name="huit" >8</button>
                            <button    name="neuf" >9</button> 
                    </div> 
                    <div class="verticalAlign" style="text-align:center;">
                            <button   name="zero"   >0</button>
                    </div> 
                    <br/> 
                    <div class="verticalAlign" style="text-align:center;">
                            <button   class="red" name="red"  style="background:#cc6666" ></button>
                            <button   class="green"  name="green"  class="button_color" style="background:#99cc33" ></button>
                            <button    class="yellow"  name="yellow" class="button_color" style="background:#ffcc33"></button> 
                            <button   class="blue"  name="blue" class="button_color" style="background:#33ccff"></button> 
                    </div> 
                    <br/>
                     <div class="verticalAlign" style="text-align:center;">
                        <button   name="plus"  ><i class="fa  fa-volume-up"></i></button>
                         <button   name="chevron-down"  ><i class="fa  fa-chevron-up"></i></button>
                        <button   name="play"  style="color:#00cc99;"><i class="fa  fa-play"></i></button>
                        <button   name="pause" ><i class="fa  fa-pause"></i></button>
					</div>
                    <div class="verticalAlign" style="text-align:center;">
                    	 <button   name="minus"  ><i class="fa  fa-volume-down"></i></button> 
                         <button   name="chevron-up"   ><i class="fa  fa-chevron-down"></i></button>
                         <button   name="forward" ><i class="fa  fa-forward"></i></button>
                        <button   name="stop" ><i class="fa  fa-stop"></i></button>
                                                      
                    </div>
                    <div class="verticalAlign" style="text-align:center;" >
                    	
                    	<button   name="chevron-up"   ><i class="fa  fa-volume-off"></i></button>
                        <button   name="volume"  style="color:blue;" ><i class="fa  fa-info"></i></button>
                        <button   name="backward" ><i class="fa  fa-backward"></i></button>
                    	<button   name="registered"   style="color:red;" ><i class="fa  fa-registered"></i></button>
                    </div>
                    <br/>  
                </div>
                <div id="universelle" class="telco" style="text-align:center;">
                	<br/>
                    <div class="verticalAlign">
                        <center>
                            <button  name="poweroff" style="color:red;" ><i class="fa  fa-power-off"></i></button>
                            <button style="color:#0099ff;"  name="television" ><i class="fa  fa-television"></i></button>
                            <button style="color:#0099ff;"  name="video" ><i class="fa  fa-video-camera"></i></button>
                        </center>
                    </div>
                    <div class="verticalAlign">
                        <center>
                            <button  name="un" >1</button>
                            <button  name="deux" >2</button>
                            <button  name="trois" >3</button>
                        </center>
                    </div>
                    <div class="verticalAlign">
                        <center>
                            <button  name="quatre" >4</button>
                            <button  name="cinq" >5</button>
                            <button  name="six" >6</button>
                        </center>
                    </div>    
                    <div class="verticalAlign">
                        <center>
                            <button  name="sept" >7</button>
                            <button  name="huit" >8</button>
                            <button  name="neuf" >9</button>
                        </center>
                    </div>  
                    <div class="verticalAlign">
                        <center>
                            <button style="color:#0099ff;"  name="volume-up" ><i class="fa  fa-volume-up"></i></button>
                            <button  name="zero" >0</button>
                            <button style="color:#0099ff;"  name="ch+" >CH+</button>
                        </center>
                    </div> 
                    <div class="verticalAlign">
                        <center>
                            <button style="color:#0099ff;"  name="volume-down" ><i class="fa  fa-volume-down"></i></button>
                            <button style="color:#3399ff;"  name="volume-off" ><i class="fa  fa-volume-off"></i></button>
                            <button style="color:#0099ff;"  name="ch-" >CH-</button>
                        </center>
                    </div>      
                    <div class="verticalAlign">
                        <center>
                            <button  name="menu" ><i class="fa  fa-bars"></i></button>
                            <button  name="up" ><i class="fa  fa-arrow-up"></i></button>
                            <button  name="info" style="color:blue;"><i class="fa  fa-info"></i></button>
                        </center>
                    </div>  
                    <div class="verticalAlign">
                        <center>
                            <button  name="left" ><i class="fa  fa-arrow-left"></i></button>
                            <button  name="share" ><i class="fa  fa-share"></i></button>
                            <button  name="right" ><i class="fa  fa-arrow-right"></i></button>
                        </center>
                    </div> 
                    <div class="verticalAlign">
                        <center>
                            <button  name="exit" >exit</button>
                            <button  name="down" ><i class="fa  fa-arrow-down"></i></button>
                            <button  name="return" ><i class="fa  fa-reply"></i></button>
                        </center>
                    </div>  
                    <div class="verticalAlign">
                        <center>
                            <button  name="backward" ><i class="fa  fa-backward"></i></button>
                            <button  name="pause" ><i class="fa  fa-pause"></i></button>
                            <button  name="forward" ><i class="fa  fa-forward"></i></button>
                        </center>
                    </div>  
                    <div class="verticalAlign">
                        <center>
                            <button style="color:red;"  name="registered" ><i class="fa  fa-registered"></i></button>
                            <button style="color:#00cc99;"  name="play" ><i class="fa  fa-play"></i></button>
                            <button  name="stop" ><i class="fa  fa-stop"></i></button>
                        </center>
                    </div>  
                    <br/>                               
                </div> 
            </div> 
        </div>    
        
        
      </fieldset>
    </form>   
    </div>
    <div role="tabpanel" class="tab-pane" id="infocmd"> 
    
    <table id="cmds" class="table table-bordered table-condensed telco">
        <thead>
            <tr>
                <th>{{Nom}}</th><th>{{Action}}</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>    
   <br/>
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
    <br/>
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
    

    </div>    
   </div>
  </div>
 </div>
  

<?php include_file('desktop', 'Telejee', 'js', 'Telejee'); ?>
<?php include_file('core', 'plugin.template', 'js'); ?>
<?php include_file('desktop', 'style', 'css', 'Telejee'); ?>
