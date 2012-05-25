$(document).ready(function(){
	$(".tooltip").tooltip({
        showURL: false,
        delay: 200,
        fade: 250
    });
    
    $(".modal").dialog({
    	autoOpen: false,
		modal: true,
		closeOnEscape: true,
		closeText: 'Cerrar',
		bgiframe: true,
		draggable: true,
		resizable: false,
		position: "top"
    });
    
    $(".modal-sup").dialog({
    	autoOpen: false,
		modal: true,
		closeOnEscape: false,
		closeText: 'Cerrar',
		bgiframe: true,
		draggable: true,
		resizable: false,
		open: function(event, ui) { $(".ui-dialog-titlebar-close").hide(); },
		close: function(event, ui) { $(".ui-dialog-titlebar-close").show(); }
    });
    
    $(".numero").spinner({
    	min: 0,
        max: 9999999,
        step: 1,
        increment: 'fast',
    });
    
    $(".porcentaje").spinner({
    	min: 0,
        max: 100,
        step: 1,
        increment: 'fast',
        showOn: false
    });
    
    $(".moneda").spinner({
    	min: 0,
        max: 999999.99,
        step: .01,
        increment: 'fast',
        showOn: false
    });
    
    $(".calendario").datepicker({
    	dateFormat: 'dd/mm/yy',
		changeMonth: true,
		changeYear: true
    });
});

String.prototype.removerAcentos = function ()
{
	var __r = {
			'À':'A','Á':'A','Â':'A','Ã':'A','Ä':'A','Å':'A','Æ':'E',
			'È':'E','É':'E','Ê':'E','Ë':'E',
			'Ì':'I','Í':'I','Î':'I',
			'Ò':'O','Ó':'O','Ô':'O','Ö':'O',
			'Ù':'U','Ú':'U','Û':'U','Ü':'U',
			'Ñ':'N'};
	
	return this.replace(/[ÀÁÂÃÄÅÆÈÉÊËÌÍÎÒÓÔÖÙÚÛÜÑ]/gi, function(m){
		var ret = __r[m.toUpperCase()];
					
		if (m === m.toLowerCase())
			ret = ret.toLowerCase();
			
		return ret;
	});
};

function formatCurrency(num)
{
	num = num.toString().replace(/\$|\,/g,'');
	
	if (isNaN(num))
		num = '0';
	
	var signo = (num == (num = Math.abs(num)));
	num = Math.floor(num * 100 + 0.50000000001);
	centavos = num % 100;
	num = Math.floor(num / 100).toString();
	
	if (centavos < 10)
		centavos = '0' + centavos;
	
	for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3); i++)
		num = num.substring(0, num.length - (4 * i + 3)) + ',' + num.substring(num.length - (4 * i + 3));
	
	return (((signo) ? '' : '- ') + '$ ' + num + '.' + centavos);
}