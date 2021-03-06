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


$("#table_cmd").sortable({axis: "y", cursor: "move", items: ".cmd", placeholder: "ui-state-highlight", tolerance: "intersect", forcePlaceholderSize: true});

$("body").delegate(".listCmdActionOn", 'click', function() {
    var type = $(this).attr('data-type');
    var el = $(this).closest('.' + type).find('.cmdAttr[data-l1key=configuration][data-l2key=action]');
    jeedom.cmd.getSelectModal({cmd: {type: 'action'}}, function(result) {
        el.value(result.human);
    });
});

 $('body').undelegate('.icone .iconeOn[data-l1key=chooseIcon]', 'click').delegate('.icone .iconeOn[data-l1key=chooseIcon]', 'click', function () {
    var mode = $(this).closest('.icone');
    chooseIcon(function (_icon) {
        mode.find('.iconeAttrOn[data-l2key=iconOn]').empty().append(_icon);
    });
});

 $('body').undelegate('.icone .iconeAttrOn[data-l2key=iconOn]', 'click').delegate('.icone .iconeAttrOn[data-l2key=iconOn]', 'click', function () {
    $(this).empty();
});


$( "#myselect option:selected" ).text()


autoCompleteAction = ['sleep', 'variable', 'scenario', 'stop', 'icon', 'say','wait','return','gotodesign','log','message'];



$('.eqLogicAction[data-action=addTel]').on('click', function () {
    bootbox.prompt("{{Nom de la télécommande?}}", function (result) {
        if (result !== null) {
			$.ajax({// fonction permettant de faire de l'ajax
				type: "POST", // methode de transmission des données au fichier php
				url: "plugins/Telejee/core/ajax/Telejee.ajax.php", // url du fichier php
				data: {
					action: "addTelco",
					name: result
				},
				dataType: 'json',
				error: function(request, status, error) {
					handleAjaxError(request, status, error);
				},
				success: function(data) { // si l'appel a bien fonctionné
					if (data.state != 'ok') {
						$('#div_alert').showAlert({message:  data.result,level: 'danger'});
						return;
					}
					modifyWithoutSave=false;
				   window.location.reload();
				}
			});			
        }
    });
});


$('.eqLogicAction[data-action=editIcon]').on('click', function () {
   bootbox.confirm('Etes-vous sûr de vouloir mettre à jour les icônes?', function (result) {
	 if (result) {
		editIconTele();
	 }
   });
});

$('.eqLogicAction[data-action=chargePlug]').on('click', function () {
   bootbox.confirm('Attention cette action effacera toutes vos données si elles existent!', function (result) {
	 if (result) {
		chargePlug();
	 }
   });
});



$('#addEventLogo').on('click', function() {
    addEventLogo({}, 'action_logo', '{{Action}}');
	setAutocomplete();
});

$('#addEventPlay').on('click', function() {
     addEventPlay({}, 'action_play', '{{Action}}');
	setAutocomplete();
});

$('#addEventSearch').on('click', function() {
    addEventSearch({}, 'action_search', '{{Action}}');
});


 $('.eqLogicAction[data-action=add_chaine]').on('click', function () {
   bootbox.confirm('Etes-vous sûr de vouloir ajouter des chaînes?', function (result) {
	 if (result) {
		addChaine();
	 }
   });
});

function editIconTele() {
	$.ajax({// fonction permettant de faire de l'ajax
        type: "POST", // methode de transmission des données au fichier php
        url: "plugins/Telejee/core/ajax/Telejee.ajax.php", // url du fichier php
        data: {
            action: "editIconTele",
        },
        dataType: 'json',
        error: function(request, status, error) {
            handleAjaxError(request, status, error);
        },
        success: function(data) { // si l'appel a bien fonctionné
            if (data.state != 'ok') {
            	$('#div_alert').showAlert({message:  data.result,level: 'danger'});
                return;
            }
            modifyWithoutSave=false;
             window.location.reload();
        }
    });
}

function chargePlug() {
	$.ajax({// fonction permettant de faire de l'ajax
        type: "POST", // methode de transmission des données au fichier php
        url: "plugins/Telejee/core/ajax/Telejee.ajax.php", // url du fichier php
        data: {
            action: "chargePlug",
        },
        dataType: 'json',
        error: function(request, status, error) {
            handleAjaxError(request, status, error);
        },
        success: function(data) { // si l'appel a bien fonctionné
            if (data.state != 'ok') {
            	$('#div_alert').showAlert({message:  data.result,level: 'danger'});
                return;
            }
            modifyWithoutSave=false;
             window.location.reload();
        }
    });
}



$( "#sel_telco" ).change(function() {
		switch($( "#sel_telco option:selected" ).text()) {
			case 'Universelle' :
				$('#universelle').show();
				$('#tv').hide();
			break;
			case 'TV' :

				$('#universelle').hide();
				$('#tv').show();			
			break;			
		}

});



$("#universelle button,#tv button").on('click', function(e) {
	e.preventDefault();
	$.ajax({
		type: 'POST',
		url: 'plugins/Telejee/core/ajax/Telejee.ajax.php',
		data: {
			action: 'LaunchAction',
			id: $('#id_telejee').val(),
			cmd: this.name
		},
		dataType: 'json',
		error: function (request, status, error) {
			handleAjaxError(request, status, error);
		},
		success: function (data) {
			
			if (data.state != 'ok') {
				$('#div_alert').showAlert({message: data.result, level: 'danger'});
				return;
			}	
				
		}
   });
	
});


function printEqLogic(_eqLogic) {
	$('.telco').hide();
	$('.legend_action').hide();
	$('.widget-size').hide();
	$('#universelle').hide();
	$('#tv').hide();
    $('#div_action_logo').empty();
    $('#div_action_play').empty();
	$('#div_action_present').empty();		
	
	if (!isset(_eqLogic)) {
		var _eqLogic = {configuration: {}};
	}
	if (!isset(_eqLogic.configuration)) {
	   _eqLogic.configuration = {};
	}
	
	if (_eqLogic.configuration.type == 'config') {
			$('.legend_action').hide();
			$('.telco').hide();
			$('.widget-size').show();
			return;
		}	
	if (_eqLogic.configuration.type == 'telco') {
		$('.telco').show();
		$('.legend_action').hide();
		$('.widget-size').hide();
		switch($( "#sel_telco option:selected" ).text()) {
			case 'Universelle' :
				$('#universelle').show();
				$('#tv').hide();
			break;
			case 'TV' :
				$('#universelle').hide();
				$('#tv').show();			
			break;			
		}
		return;
	} 
	if (_eqLogic.configuration.type != 'telco' || _eqLogic.configuration.type != 'config') {
		$('.telco').hide();
		$('.legend_action').show();
		$('.widget-size').hide();		
	}
    if (isset(_eqLogic.configuration)) {
        if (isset(_eqLogic.configuration.action_logo)) {
            for (var i in _eqLogic.configuration.action_logo) {
                addEventLogo(_eqLogic.configuration.action_logo[i], 'action_logo', '{{Action}}');
            }
        }
		if (isset(_eqLogic.configuration.action_play)) {
            for (var i in _eqLogic.configuration.action_play) {
                addEventPlay(_eqLogic.configuration.action_play[i], 'action_play', '{{Action}}');
            }
        }

	}
}

$("body").delegate(".listCmdAction", 'click', function() {
    var type = $(this).attr('data-type');
    var el = $(this).closest('.' + type).find('.expressionAttr[data-l1key=cmd]');
    jeedom.cmd.getSelectModal({cmd: {type: 'action'}}, function(result) {
        el.value(result.human);
        jeedom.cmd.displayActionOption(el.value(), '', function(html) {
            el.closest('.' + type).find('.actionOptions').html(html);
        });
    });
});


function saveEqLogic(_eqLogic) {
    if (!isset(_eqLogic.configuration)) {
        _eqLogic.configuration = {};
    }
	
	
	if (_eqLogic.configuration.type != 'telco') {
	_eqLogic.configuration.action_logo = $('#div_action_logo .action_logo').getValues('.expressionAttr');
    _eqLogic.configuration.action_play = $('#div_action_play .action_play').getValues('.expressionAttr');
	_eqLogic.configuration.action_search = $('#div_action_search .action_search').getValues('.expressionAttr');
	return _eqLogic;
	}
}

$("body").delegate('.bt_removeAction', 'click', function() {
    var type = $(this).attr('data-type');
    $(this).closest('.' + type).remove();
});

function setAutocomplete() {
  $('.action_logo').each(function () {
    if ($(this).find('.expressionAttr[data-l1key=type]').value() == 'action') {
      $(this).find('.expressionAttr[data-l1key=cmd]').autocomplete({
        source: autoCompleteAction,
        close: function (event, ui) {
          $(this).trigger('focusout');
        }
      });
    }
  });
  $('.action_play').each(function () {
    if ($(this).find('.expressionAttr[data-l1key=type]').value() == 'action') {
      $(this).find('.expressionAttr[data-l1key=cmd]').autocomplete({
        source: autoCompleteAction,
        close: function (event, ui) {
          $(this).trigger('focusout');
        }
      });
    }
  });}

$('body').delegate('.action_logo .expressionAttr[data-l1key=cmd]', 'focusout', function (event) {
  var el = $(this);
  if (el.closest('.action_logo').find('.expressionAttr[data-l1key=type]').value() == 'action') {
    var expression = el.closest('.action_logo').getValues('.expressionAttr');
    jeedom.cmd.displayActionOption(el.value(), init(expression[0].options), function (html) {
      el.closest('.action_logo').find('.actionOptions').html(html);
    });
  }
});

$('body').delegate('.action_play .expressionAttr[data-l1key=cmd]', 'focusout', function (event) {
  var el = $(this);
  if (el.closest('.action_play').find('.expressionAttr[data-l1key=type]').value() == 'action') {
    var expression = el.closest('.action_play').getValues('.expressionAttr');
    jeedom.cmd.displayActionOption(el.value(), init(expression[0].options), function (html) {
      el.closest('.action_play').find('.actionOptions').html(html);
    });
  }
});




function addEventLogo(_action, _type, _name, _el) {
	if (!isset(_action)) {
        _action = {};
    }
    if (!isset(_action.options)) {
        _action.options = {};
    }


    var div = '<div class="action_logo">';
	div += '<input class="expressionAttr" data-l1key="type" style="display : none;" value="action"/>';
    div += '<div class="form-group ">';
    div += '<label class="col-lg-1 control-label">' + _name + '</label>';
    div += '<div class="col-lg-1">';
    div += '<a class="btn btn-warning btn-sm listCmdAction" data-type="action_logo"><i class="fa fa-list-alt"></i></a>';
    div += '</div>';
    div += '<div class="col-lg-3 has-warning">';
    div += '<input class="expressionAttr form-control input-sm cmdAction" data-l1key="cmd" data-type="action_logo" />';
    div += '</div>';
    div += '<div class="col-lg-6 actionOptions">';
    div += jeedom.cmd.displayActionOption(init(_action.cmd, ''), _action.options);
    div += '</div>';
    div += '<div class="col-lg-1">';
    div += '<i class="fa fa-minus-circle pull-left cursor bt_removeAction" data-type="action_logo"></i>';
    div += '</div>';
    div += '</div>';
    if (isset(_el)) {
        _el.find('.div_action_logo').append(div);
        _el.find('.action_logo:last').setValues(_action, '.expressionAttr');
    } else {
        $('#div_action_logo').append(div);
        $('#div_action_logo .action_logo:last').setValues(_action, '.expressionAttr');
    }
}

function addEventSearch(_action, _name, _el) {
	if (!isset(_action)) {
        _action = {};
    }
    if (!isset(_action.options)) {
        _action.options = {};
    }


    var div = '<div class="action_search">';
    div += '<div class="form-group ">';
    div += '<label class="col-lg-1 control-label">' + _name + '</label>';
    div += '<div class="col-lg-1">';
    div += '<a class="btn btn-warning btn-sm listCmdAction" data-type="action_search"><i class="fa fa-list-alt"></i></a>';
    div += '</div>';
    div += '<div class="col-lg-3 has-warning">';
    div += '<input class="expressionAttr form-control input-sm cmdAction" data-l1key="cmd" data-type="action_search" />';
    div += '</div>';
    div += '<div class="col-lg-6 actionOptions">';
    div += jeedom.cmd.displayActionOption(init(_action.cmd, ''), _action.options);
    div += '</div>';
    div += '<div class="col-lg-1">';
    div += '<i class="fa fa-minus-circle pull-left cursor bt_removeAction" data-type="action_search"></i>';
    div += '</div>';
    div += '</div>';
    if (isset(_el)) {
        _el.find('.div_action_search').append(div);
        _el.find('.action_search:last').setValues(_action, '.expressionAttr');
    } else {
        $('#div_action_search').append(div);
        $('#div_action_search .action_search:last').setValues(_action, '.expressionAttr');
    }
}


function addChaine() {
			$.showLoading();
			$('#md_modal').dialog({
				width : 1000,
				height: 600,
				autoOpen: false,
				modal: true,
				
				title: "Création des chaînes"
			});
			var _name = "";
            $('#md_modal').load('index.php?v=d&plugin=Telejee&modal=createChaine');
			$('#md_modal').dialog('open');

}

function addEventPlay(_action, _type, _name, _el) {
	if (!isset(_action)) {
        _action = {};
    }
    if (!isset(_action.options)) {
        _action.options = {};
    }


    var div = '<div class="action_play">';
	div += '<input class="expressionAttr" data-l1key="type" style="display : none;" value="action"/>';
    div += '<div class="form-group ">';
    div += '<label class="col-lg-1 control-label">' + _name + '</label>';
    div += '<div class="col-lg-1">';
    div += '<a class="btn btn-warning btn-sm listCmdAction" data-type="action_play"><i class="fa fa-list-alt"></i></a>';
    div += '</div>';
    div += '<div class="col-lg-3 has-warning">';
    div += '<input class="expressionAttr form-control input-sm cmdAction" data-l1key="cmd" data-type="action_play" />';
    div += '</div>';
    div += '<div class="col-lg-6 actionOptions">';
    div += jeedom.cmd.displayActionOption(init(_action.cmd, ''), _action.options);
    div += '</div>';
    div += '<div class="col-lg-1">';
    div += '<i class="fa fa-minus-circle pull-left cursor bt_removeAction" data-type="action_play"></i>';
    div += '</div>';
    div += '</div>';
    if (isset(_el)) {
        _el.find('.div_action_play').append(div);
        _el.find('.action_play:last').setValues(_action, '.expressionAttr');
    } else {
        $('#div_action_play').append(div);
        $('#div_action_play .action_play:last').setValues(_action, '.expressionAttr');
    }
}

function addCmdToTable(_cmd) {

    if (!isset(_cmd)) {
        var _cmd = {configuration: {}};
    }
    if (!isset(_cmd.configuration)) {
        _cmd.configuration = {};
    }
	
	if(_cmd.isVisible == 1) {
		var tr = '<tr class="cmd" data-cmd_id="' + init(_cmd.id) + '">';
		tr += '<td>';
		tr += '<span class="cmdAttr" data-l1key="id" style="display:none;"></span>';
		tr += '<input class="cmdAttr form-control input-sm" data-l1key="name" style="width : 140px;" placeholder="{{Nom}}">';
		tr += '</td>';
		tr += '<td class="action">';
		tr += '<input class="cmdAttr form-control input-sm" data-l1key="configuration" data-type="' + _cmd.type + '" data-l2key="action"  style="margin-bottom : 5px;width : 80%; display : inline-block;">';
		tr += '<a class="btn btn-default btn-sm cursor listCmdActionOn" data-type="' + _cmd.type + '" data-input="action" style="margin-left : 5px;"><i class="fa fa-list-alt "></i></a>';
		tr += '</td>';	
		
		
		tr += '<td>';
		tr += '<i class="fa fa-minus-circle pull-right cmdAction cursor" data-action="remove"></i>';
		tr += '</td>';
		tr += '</tr>';
		$('#cmds tbody').append(tr);
		$('#cmds tbody tr:last').setValues(_cmd, '.cmdAttr');
		if (isset(_cmd.type)) {
			$('#cmds tbody tr:last .cmdAttr[data-l1key=type]').value(init(_cmd.type));
		}
		jeedom.cmd.changeType($('#cmds tbody tr:last'), init(_cmd.subType));
	}
}
