$(document).ready(function(){
	
	/*  Xóa nhiều */
	$('.gcheckAction').click(function(){
		var modules = $(this).attr('data-module');
		var id_checked = []; // Lấy id bản ghi
		$('.checkbox-item:checked').each(function() {
		   id_checked.push($(this).val());
		});
		var formURL = modules + '/ajax/'+modules+'/delete';
		$.post(formURL, {
			post: id_checked,},
			function(data){
				$('#alertModal').modal('toggle');
				var json = JSON.parse(data);
				if(json.error == false){
					$('.message-alert').html(json.message);
					
				}else{
					$('.message-alert').html(json.message);
				}
				window.setTimeout('location.reload()', 2000); //Reloads after three seconds
			});
		return false;
	});
	
	$(document).ready(function() {
		$('input.filter').click(function() {
			var id = $(this).prop('id');
			var name = $(this).prop('name');
			$('input[name="'+name+'"]:not(#'+id+')').prop('checked',false);
			
		})
	});
	function changeBackground() {
		$('.checkbox-item').each(function() {
			if($(this).is(':checked')) {
				$(this).parents('tr').addClass('bg-active');
			}else {
				$(this).parents('tr').removeClass('bg-active');
			}
		});
	}
	function showActionButton() {
		if($('.checkbox-item:checked').length) {
			$('.gcheckAction').show();
			$('.gcheckAction1').show();
		}else {
			$('.gcheckAction').hide();
			$('.gcheckAction1').hide();
		}
	}

	function changeChecked() {
		$('.checkbox-item').each(function() {
			if($(this).is(':checked')) {
				$(this).parent().find('.label-checkboxitem').addClass('checked');
			}else {
				$(this).parent().find('.label-checkboxitem').removeClass('checked');
			}
		});
	}
	function userGroupChecked() {
		$('.tpInputCheckbox').each(function() {
			if($(this).is(':checked')) {
				$(this).parent().addClass('checked');
			}else {
				$(this).parent().removeClass('checked');
			}
		});
	}
	userGroupChecked();

	if($('#checkbox-all').length){
		$('#checkbox-all').click(function(){
			if($(this).prop('checked')){
				$('#number_ve').attr('data-count', 0);
				$('.checkbox-item').prop('checked', true);
			}
			else{
				$('#number_ve').attr('data-count', 0);
				$('#fcFrom .error').hide();
				$('.checkbox-item').prop('checked', false);
			}
		});
	}
	if($('.checkbox-item').length) {
		$('.checkbox-item').click(function(){
			if($('.checkbox-item:checked').length == $('.checkbox-item').length) {
				$('#checkbox-all').prop('checked', true);
			}
			else{
				$('#number_ve').attr('data-count', 0);
				$('#fcFrom .error').hide();
				$('#checkbox-all').prop('checked', false);
			}
		});
	}
	$( ".gcheck .check" ).click(function(e) {
	  e.stopImmediatePropagation();
	   $('.gcheckDropdown').hide();
	});
	$(".gcheck").click(function (e) {
 		e.stopPropagation(); 
	    $('.gcheckDropdown').show();
	});
	$(document).click(function(e) {
		$('.gcheckDropdown').hide();
	});
	$('.gcheck-item').click(function() {
		var dataCheck = $(this).attr('data-check');
		if(dataCheck === 'checkall') {
			$('.checkbox-item').prop('checked', true);
			$('#checkbox-all').prop('checked', true)
		}else if(dataCheck === 'uncheckall'){ 
			$('.checkbox-item').prop('checked', false);
			$('#checkbox-all').prop('checked', false);
		}
		changeBackground();
		showActionButton();
		changeChecked();
	});
	$('.label-checkboxitem').click(function() {
		$('#number_ve').attr('data-count', 0);
		$(this).parent().find('.checkbox-item').trigger('click');
	});
	
	$('.tpInputLabel').on('click', function() {
		if($(this).find('.tpInputCheckbox').is(':checked')) {
			$(this).addClass('checked');
		}else {
			$(this).removeClass('checked');
		}
	});

	$('form').change(function() {
		changeBackground();
		showActionButton();
		changeChecked();
		show_number_ve();
	});
	function show_number_ve(){
		$('.checkbox-item:checked').each(function() {
			var t = parseInt($('#number_ve').attr('data-count'));
			var c =parseInt( $(this).attr('data-number'));
			var total = parseInt($('#number_ve').attr('data-count', (t + c)));
			$('#number_ve').html('').html('Tổng số vé cần thao tác là <b>'+$('#number_ve').attr('data-count')+'</b> vé. Bạn có chắc chắn thao tác với số bản ghi đã chọn. Vùi lòng kiểm tra lại.');
			$('#fcFrom .error').show();
		});
	}
});