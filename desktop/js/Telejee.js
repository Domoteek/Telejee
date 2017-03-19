
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

autoCompleteAction = ['sleep', 'variable', 'scenario', 'stop', 'icon', 'say','wait','return','gotodesign','log','message'];


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
    addEventLogo({}, '{{Action}}');
	setAutocomplete();
});

$('#addEventPlay').on('click', function() {
    addEventPlay({}, '{{Action}}');
	setAutocomplete();
});

$('#addEventSearch').on('click', function() {
    addEventSearch({}, '{{Action}}');
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



function printEqLogic(_eqLogic) {

	if (isset(_eqLogic.configuration) && _eqLogic.configuration.type != 'config') {
		$('.true_visible').hide();
		$('.category').hide();
		$('.legend_action').show();
		$('.widget-size').hide();
		$('#div_action_logo').empty();
		$('#div_action_play').empty();	
		$('#div_action_search').empty();
		$('.prog_visible').hide();
		$('.object_prog').hide();
		if (isset(_eqLogic.configuration.action_logo)) {
            for (var i in _eqLogic.configuration.action_logo) {
				//console.log(_eqLogic.configuration.action_alarm[i]);
                addEventLogo(_eqLogic.configuration.action_logo[i], '{{Action}}');
            }
         }
		  if (isset(_eqLogic.configuration.action_play)) {
            for (var i in _eqLogic.configuration.action_play) {
				//console.log(_eqLogic.configuration.action_alarm[i]);
                addEventPlay(_eqLogic.configuration.action_play[i], '{{Action}}');
            }
         }
		  if (isset(_eqLogic.configuration.action_search)) {
            for (var i in _eqLogic.configuration.action_search) {
				//console.log(_eqLogic.configuration.action_alarm[i]);
                addEventSearch(_eqLogic.configuration.action_search[i], '{{Action}}');
            }
         }
		 	   
	} else {
		$('.legend_action').hide();
		$('.true_visible').show();
		$('.widget-size').show();
		$('.category').show();
		$('.prog_visible').show();
		$('.object_prog').show();
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
	
	_eqLogic.configuration.action_logo = $('#div_action_logo .action_logo').getValues('.expressionAttr');
    _eqLogic.configuration.action_play = $('#div_action_play .action_play').getValues('.expressionAttr');
	_eqLogic.configuration.action_search = $('#div_action_search .action_search').getValues('.expressionAttr');
	return _eqLogic;
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




function addEventLogo(_action, _name, _el) {
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

function addEventPlay(_action, _name, _el) {
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

function addCmdToTable() {


	
}


