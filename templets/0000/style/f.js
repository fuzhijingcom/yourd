	$(function(){

		$("dl.tbox_bar dt span.label a[_for]").mouseover(function(){


			$(this).parents("span.label").children("a[_for]").removeClass("bar_bg_style").parents("dl.tbox_bar").children("dd").hide();


			$(this).addClass("bar_bg_style").blur();


			$("#"+$(this).attr("_for")).show();


		});


		$("a[_for=uc_jqjj]").mouseover();

	});	