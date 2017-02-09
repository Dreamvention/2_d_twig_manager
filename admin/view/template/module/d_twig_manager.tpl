<?php
/*
 *	location: admin/view
 */
?>
<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="form-inline pull-right">
				
				<a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
			</div>
			<h1><?php echo $heading_title; ?> <?php echo $version; ?></h1>
			<ul class="breadcrumb">
				<?php foreach ($breadcrumbs as $breadcrumb) { ?>
				<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
				<?php } ?>
			</ul>
		</div>
	</div>
	<div class="container-fluid">
		<?php if (!empty($error['warning'])) { ?>
		<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error['warning']; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<?php } ?>
		<?php if (!empty($success)) { ?>
		<div class="alert alert-success"><i class="fa fa-exclamation-circle"></i> <?php echo $success; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<?php } ?>
		
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
			</div>
			<div class="panel-body">
				
					 <ul class="nav nav-tabs">
						<li class="active"><a href="#tab_event" data-toggle="tab">
							<span class="fa fa-pencil"></span> 
							<?php echo $tab_editor; ?>
						</a></li>

						<li><a href="#tab_setting" data-toggle="tab">
							<span class="fa fa-cog"></span> 
							<?php echo $tab_setting; ?>
						</a></li>
						<!-- 
						
						<li><a href="#tab_instruction" data-toggle="tab">
							<span class="fa fa-graduation-cap"></span> 
							<?php echo $tab_instruction; ?>
						</a></li>  -->
					</ul>

					<div class="tab-content">
						<div class="tab-pane active" id="tab_event" >
							<div class="tab-body">
								<div class="row">
								  <div class="col-lg-3 col-md-3 col-sm-12">
								    <div class="list-group">
								      <div class="list-group-item">
								        <h4 class="list-group-item-heading"><?php echo $text_store; ?></h4>
								      </div>
								      <div class="list-group-item">
								        <select name="store_id" class="form-control">
								          <option value="0"><?php echo $text_default; ?></option>
								          <?php foreach ($stores as $store) { ?>
								          <option value="<?php echo $store['store_id']; ?>"><?php echo $store['name']; ?></option>
								          <?php } ?>
								        </select>
								      </div>
								    </div>
								    <div class="list-group">
								      <div class="list-group-item">
								        <h4 class="list-group-item-heading"><?php echo $text_template; ?></h4>
								      </div>
								      <div id="path"></div>
								    </div>
								  </div>
								  <div class="col-lg-9 col-md-9 col-sm-12">
									<div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $text_begin; ?></div>
										<div id="recent">
										  <fieldset>
										    <legend><?php echo $text_history; ?></legend>
										    <div id="history"></div>
										  </fieldset>
										</div>            
										<div id="code" style="display: none;">
										  <ul class="nav nav-tabs file-tabs">
										  </ul>
										  <div class="tab-content file-content"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="tab-pane" id="tab_setting" >
							<div class="tab-body">
								<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form" class="form-horizontal">
								
								<?php if(VERSION < '3.0.0.0') { ?>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="input_compatibility"><?php echo $entry_compatibility; ?></label>
									<div class="col-sm-10">										
										<input type="hidden" name="compatibility" value="0" />
										<input type="checkbox" name="compatibility" class="switcher" data-label-text="<?php echo $text_enabled; ?>"id="input_compatibility" <?php echo ($compatibility) ? 'checked="checked"':'';?> value="1" />
										
										<div class="bs-callout bs-callout-info m-t"><?php echo $help_compatibility; ?></div>
									</div>


								</div><!-- //compatibility -->
								<?php } ?>
								
								</form>
							</div>
						</div>
						<div class="tab-pane" id="tab_instruction" >
							<div class="tab-body"><?php echo $text_instruction; ?></div>
						</div>
					</div>
				</div>
			</div>
	</div>
</div>

  <style>
.CodeMirror {
  border: 1px solid #eee;
  height: auto;
}
.CodeMirror-scroll {
  overflow-y: hidden;
  overflow-x: auto;
}
</style>

  <script type="text/javascript"><!--

$(function () {

	//checkbox
	$(".switcher[type='checkbox']").bootstrapSwitch({
		'onColor': 'success',
		'onText': '<?php echo $text_yes; ?>',
		'offText': '<?php echo $text_no; ?>',
		onSwitchChange: function(event, state){
			if(state){
				window.location.href = '<?php echo $install_compatibility; ?>'
			}else{
				window.location.href = '<?php echo $uninstall_compatibility; ?>'
			}
		}
		
	})

});

$('select[name="store_id"]').on('change', function(e) {
	$.ajax({
		url: 'index.php?route=<?php echo $route; ?>/path&token=<?php echo $token; ?>&store_id=' + $('select[name="store_id"]').val(),
		dataType: 'json',
		beforeSend: function() {
			$('select[name="store_id"]').prop('disabled', true);
		},
		complete: function() {
			$('select[name="store_id"]').prop('disabled', false);
		},
		success: function(json) {
			html = '';

			if (json['directory']) {
				for (i = 0; i < json['directory'].length; i++) {
					html += '<a href="' + json['directory'][i]['path'] + '" class="list-group-item directory">' + json['directory'][i]['name'] + ' <i class="fa fa-arrow-right fa-fw pull-right"></i></a>';
				}
			}

			if (json['file']) {
				for (i = 0; i < json['file'].length; i++) {
					html += '<a href="' + json['file'][i]['path'] + '" class="list-group-item file">' + json['file'][i]['name'] + ' <i class="fa fa-arrow-right fa-fw pull-right"></i></a>';
				}
			}

			$('#path').html(html);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('select[name="store_id"]').trigger('change');

$('#path').on('click', 'a.directory', function(e) {
	e.preventDefault();

	var node = this;

	$.ajax({
		url: 'index.php?route=<?php echo $route; ?>/path&token=<?php echo $token; ?>&store_id=' + $('select[name="store_id"]').val() + '&path=' + $(node).attr('href'),
		dataType: 'json',
		beforeSend: function() {
			$(node).find('i').removeClass('fa-arrow-right');
			$(node).find('i').addClass('fa-circle-o-notch fa-spin');
		},
		complete: function() {
			$(node).find('i').removeClass('fa-circle-o-notch fa-spin');
			$(node).find('i').addClass('fa-arrow-right');
		},
		success: function(json) {
			html = '';

			if (json['directory']) {
				for (i = 0; i < json['directory'].length; i++) {
					html += '<a href="' + json['directory'][i]['path'] + '" class="list-group-item directory">' + json['directory'][i]['name'] + ' <i class="fa fa-arrow-right fa-fw pull-right"></i></a>';
				}
			}

			if (json['file']) {
				for (i = 0; i < json['file'].length; i++) {
					html += '<a href="' + json['file'][i]['path'] + '" class="list-group-item file">' + json['file'][i]['name'] + ' <i class="fa fa-arrow-right fa-fw pull-right"></i></a>';
				}
			}

			if (json['back']) {
				html += '<a href="' + json['back']['path'] + '" class="list-group-item directory">' + json['back']['name'] + ' <i class="fa fa-arrow-left fa-fw pull-right"></i></a>';
			}

			$('#path').html(html);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('#path').on('click', 'a.file',function(e) {
	e.preventDefault();

	var node = this;
	
	// Check if the file has an extension
	var pos = $(node).attr('href').lastIndexOf('.');

	if (pos != -1) {
		var tab_id = $('select[name="store_id"]').val() + '-' + $(node).attr('href').slice(0, pos).replace('/', '-').replace('_', '-');
	} else {
		var tab_id = $('select[name="store_id"]').val() + '-' + $(node).attr('href').replace('/', '-').replace('_', '-');
	}
	
	if (!$('#tab-' + tab_id).length) {
		$.ajax({
			url: 'index.php?route=<?php echo $route; ?>/template&token=<?php echo $token; ?>&store_id=' + $('select[name="store_id"]').val() + '&path=' + $(node).attr('href'),
			dataType: 'json',
			beforeSend: function() {
				$(node).find('i').removeClass('fa-arrow-right');
				$(node).find('i').addClass('fa-circle-o-notch fa-spin');
			},
			complete: function() {
				$(node).find('i').removeClass('fa-circle-o-notch fa-spin');
				$(node).find('i').addClass('fa-arrow-right');
			},
			success: function(json) {
				if (json['code']) {
					$('#code').show();
					$('#recent').hide();

					$('.file-tabs').append('<li><a href="#tab-' + tab_id + '" data-toggle="tab">' + $(node).attr('href').split('/').join(' / ') + '&nbsp;&nbsp;<i class="fa fa-minus-circle"></i></a></li>');

					html  = '<div class="tab-pane" id="tab-' + tab_id + '">';
					html += '  <textarea name="code" rows="10"></textarea>';
					html += '  <input type="hidden" name="store_id" value="' + $('select[name="store_id"]').val() + '" />';
					html += '  <input type="hidden" name="path" value="' + $(node).attr('href') + '" />';
					html += '  <br />';
					html += '  <div class="pull-right">';
					html += '    <button type="button" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><i class="fa fa-floppy-o"></i> <?php echo $button_save; ?></button>';
					html += '    <button type="button" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-danger"><i class="fa fa-recycle"></i> <?php echo $button_reset; ?></button>';
					html += '  </div>';
					html += '</div>';

					$('.file-content').append(html);

					$('.file-tabs a[href=\'#tab-' + tab_id + '\']').tab('show');
					
					// Initialize codemirrror
					var editor = CodeMirror.fromTextArea(document.querySelector('.file-content .active textarea'), {
						mode: 'text/html',
						height: '500px',
						lineNumbers: true,
						autofocus: true,
						theme: 'monokai'
					});

					editor.setValue(json['code']);
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	} else {
		$('.file-tabs a[href=\'#tab-' + tab_id + '\']').tab('show');
	}
});

$('.file-tabs').on('click', 'i.fa-minus-circle', function(e) {
	e.preventDefault();

	if ($(this).parent().parent().is('li.active')) {
		index = $(this).parent().parent().index();

		if (index == 0) {
			$(this).parent().parent().parent().find('li').eq(index + 1).find('a').tab('show');
		} else {
			$(this).parent().parent().parent().find('li').eq(index - 1).find('a').tab('show');
		}
	}

	$(this).parent().parent().remove();

	$($(this).parent().attr('href')).remove();

	if (!$('#code > ul > li').length) {
		$('#code').hide();
		$('#recent').show();
	}
});

$('.file-content').on('click', '.btn-primary', function(e) {
	var node = this;

	var editor = $('.file-content .active .CodeMirror')[0].CodeMirror;
				
	$.ajax({
		url: 'index.php?route=<?php echo $route; ?>/save&token=<?php echo $token; ?>&store_id=' + $('.file-content .active input[name="store_id"]').val() + '&path=' + $('.file-content .active input[name="path"]').val(),
		type: 'post',
		data: 'code=' + encodeURIComponent(editor.getValue()),
		dataType: 'json',
		beforeSend: function() {
			$(node).button('loading');
		},
		complete: function() {
			$(node).button('reset');
		},
		success: function(json) {
			$('.alert').remove();
			
			if (json['error']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '  <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
			}

			if (json['success']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-success"><i class="fa fa-exclamation-circle"></i> ' + json['success'] + '  <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
				$('#history').load('index.php?route=<?php echo $route; ?>/history&token=<?php echo $token; ?>');
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('.file-content').on('click', '.btn-danger', function(e) {
	if (confirm('<?php echo $text_confirm; ?>')) {
		var node = this;

		$.ajax({
			url: 'index.php?route=<?php echo $route; ?>/reset&token=<?php echo $token; ?>&store_id=' + $('.file-content .active input[name="store_id"]').val() + '&path=' + $('.file-content .active input[name="path"]').val(),
			dataType: 'json',
			beforeSend: function() {
				$(node).button('loading');
			},
			complete: function() {
				$(node).button('reset');
			},
			success: function(json) {
				$('.alert').remove();
				
				if (json['error']) {
					$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '  <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
				}

				if (json['success']) {
					$('#content > .container-fluid').prepend('<div class="alert alert-success"><i class="fa fa-exclamation-circle"></i> ' + json['success'] + '  <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
				}
				
				var editor = $('.file-content .active .CodeMirror')[0].CodeMirror;
				
				editor.setValue(json['code']);
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	}
});


$('#history').delegate('.pagination a', 'click', function(e) {
	e.preventDefault();

	$('#history').load(this.href);
});

$('#history').load('index.php?route=<?php echo $route; ?>/history&token=<?php echo $token; ?>');

$('#history').on('click', '.btn-primary', function(e) {
	e.preventDefault();

	var node = this;
	
	// Check if the file has an extension
	var tab_id = $(node).parent().parent().find('input[name="store_id"]').val() + '-' + $(node).parent().parent().find('input[name="path"]').val().replace(/\//g, '-').replace(/_/g, '-');

	if (!$('#tab-' + tab_id).length) {
		$.ajax({
			url: 'index.php?route=module/d_twig_manager/template&token=<?php echo $token; ?>&store_id=' + $(node).parent().parent().find('input[name="store_id"]').val() + '&path=' + $(node).parent().parent().find('input[name="path"]').val(),
			dataType: 'json',
			beforeSend: function() {
				$(node).button('loading');
			},
			complete: function() {
				$(node).button('reset');
			},
			success: function(json) {
				if (json['code']) {
					$('#code').show();
					$('#recent').hide();

					$('.file-tabs').append('<li><a href="#tab-' + tab_id + '" data-toggle="tab">' + $(node).parent().parent().find('input[name="path"]').val().split('/').join(' / ') + '&nbsp;&nbsp;<i class="fa fa-minus-circle"></i></a></li>');

					html  = '<div class="tab-pane" id="tab-' + tab_id + '">';
					html += '  <textarea name="code" rows="10"></textarea>';
					html += '  <input type="hidden" name="store_id" value="' + $(node).parent().parent().find('input[name="store_id"]').val() + '" />';
					html += '  <input type="hidden" name="path" value="' + $(node).parent().parent().find('input[name="path"]').val() + '.twig" />';
					html += '  <br />';
					html += '  <div class="pull-right">';
					html += '    <button type="button" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><i class="fa fa-floppy-o"></i> <?php echo $button_save; ?></button>';
					html += '    <button data-loading-text="<?php echo $text_loading; ?>" class="btn btn-danger"><i class="fa fa-recycle"></i> <?php echo $button_reset; ?></button>';
					html += '  </div>';
					html += '</div>';

					$('.file-content').append(html);

					$('.file-tabs a[href=\'#tab-' + tab_id + '\']').tab('show');
					
					// Initialize codemirrror
					var codemirror = CodeMirror.fromTextArea(document.querySelector('.file-content .active textarea'), {
						mode: 'text/html',
						height: '500px',
						lineNumbers: true,
						autofocus: true,
						theme: 'monokai'
					});

					codemirror.setValue(json['code']);
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	} else {
		$('.file-tabs a[href=\'#tab-' + tab_id + '\']').tab('show');
	}
});

$('#history').on('click', '.btn-danger', function(e) {
	e.preventDefault();
	
	if (confirm('<?php echo $text_confirm; ?>')) {
		var node = this;

		$.ajax({
			url: $(node).attr('href'),
			dataType: 'json',
			beforeSend: function() {
				$(node).button('loading');
			},
			complete: function() {
				$(node).button('reset');
			},
			success: function(json) {
				$('.alert').remove();
				
				if (json['error']) {
					$('#history').before('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
				}

				if (json['success']) {
					$('#history').before('<div class="alert alert-success"><i class="fa fa-exclamation-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
				
					$('#history').load('index.php?route=<?php echo $route; ?>/history&token=<?php echo $token; ?>');
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	}
});


//--></script> 
<?php echo $footer; ?>