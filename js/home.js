//selectedクラスの変更
function select_change(new_id){
	$('#'+new_id).addClass("selected");
	$('#'+selected_id).removeClass("selected");
	selected_id=new_id;
	console.log(new_id);
}

//今のselectedクラス
var selected_id="all_head";