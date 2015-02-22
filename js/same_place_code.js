$(function() {
	var url   = location.href;
    params_a    = url.split("?");
    params_b   = params_a[1].split("&");
    params_c = params_b[1].split("=");
    var new_selected = params_c[1];
	console.log(new_selected);

	//$('#'+new_selected).setAttribute('selected', 'selected');
	var
	$('#'+new_selected).setAttribute('class', 'nannka');
	//$('#'+old_selected).removeAttribute('selected');
	old_selected = new_selected;
	console.log(new_selected);
});

//今のselectedクラス
var old_selected="学校";