<?php if (@$gsExport == "") { ?>
<?php if (@!$gbSkipHeaderFooter) { ?>
				<!-- right column (end) -->
				<?php if (isset($gTimer)) $gTimer->Stop() ?>
			</div>
		</div>
	</div>
	<!-- content (end) -->
	<!-- footer (begin) --><!-- ** Note: Only licensed users are allowed to remove or change the following copyright statement. ** -->
	<div id="ewFooterRow" class="ewFooterRow">	
		<div class="ewFooterText"><?php echo $Language->ProjectPhrase("FooterText") ?></div>
		<!-- Place other links, for example, disclaimer, here -->		
	</div>
	<!-- footer (end) -->	
</div>
<?php } ?>
<!-- modal dialog -->
<div id="ewModalDialog" class="modal" role="dialog" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h4 class="modal-title"></h4></div><div class="modal-body"></div><div class="modal-footer"></div></div></div></div>
<!-- modal lookup dialog -->
<div id="ewModalLookupDialog" class="modal" role="dialog" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h4 class="modal-title"></h4></div><div class="modal-body"></div><div class="modal-footer"></div></div></div></div>
<!-- add option dialog -->
<div id="ewAddOptDialog" class="modal" role="dialog" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h4 class="modal-title"></h4></div><div class="modal-body"></div><div class="modal-footer"><button type="button" class="btn btn-primary ewButton"><?php echo $Language->Phrase("AddBtn") ?></button><button type="button" class="btn btn-default ewButton" data-dismiss="modal"><?php echo $Language->Phrase("CancelBtn") ?></button></div></div></div></div>
<!-- message box -->
<div id="ewMsgBox" class="modal" role="dialog" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-body"></div><div class="modal-footer"><button type="button" class="btn btn-primary ewButton" data-dismiss="modal"><?php echo $Language->Phrase("MessageOK") ?></button></div></div></div></div>
<!-- prompt -->
<div id="ewPrompt" class="modal" role="dialog" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-body"></div><div class="modal-footer"><button type="button" class="btn btn-primary ewButton"><?php echo $Language->Phrase("MessageOK") ?></button><button type="button" class="btn btn-default ewButton" data-dismiss="modal"><?php echo $Language->Phrase("CancelBtn") ?></button></div></div></div></div>
<!-- session timer -->
<div id="ewTimer" class="modal" role="dialog" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-body"></div><div class="modal-footer"><button type="button" class="btn btn-primary ewButton" data-dismiss="modal"><?php echo $Language->Phrase("MessageOK") ?></button></div></div></div></div>
<!-- tooltip -->
<div id="ewTooltip"></div>
<?php } ?>
<?php if (@$gsExport == "") { ?>
<script type="text/javascript" src="<?php echo $EW_RELATIVE_PATH ?>phpjs/userevt13.js"></script>
<script type="text/javascript">

function toggle_menu()
{
	if ($('#ewMenuColumn').attr('class') == "displayNone")
	{
		$.post("toggle_menu.php", { display: "yes" });
		$('#ewMenuColumn').removeClass().addClass('hidden-xs').addClass('ewMenuColumn');
	}
	else
	{
		$.post("toggle_menu.php", { display: "no" });
		$('#ewMenuColumn').removeClass().addClass('displayNone');
	}
}
$(".ewToolbar .breadcrumb").after("<div id=\"navegacionGrupo0\" class=\"btn-group ewButtonGroup\"></div>");
$("#navegacionGrupo0").append("<button onclick=\"toggle_menu();\" class=\"btn btn-default\" type=\"button\" title=\"Menu\" data-caption=\"Menu\" style=\"margin-right: 10px;\"><span class=\"glyphicon glyphicon-menu-hamburger ewIcon\" data-caption=\"Menu\"></span></button>");
$(".ewToolbar .breadcrumb").after("<div id=\"navegacionGrupo1\" class=\"btn-group ewButtonGroup\"></div>");
$("#navegacionGrupo1").append("<button onclick=\"window.history.back();\" class=\"btn btn-default\" type=\"button\" title=\"Retroceder\" data-caption=\"Retroceder\"><span class=\"glyphicon glyphicon-step-backward ewIcon\" data-caption=\"Retroceder\"></span></button>");
$("#navegacionGrupo1").append("<button onclick=\"window.history.forward();\" class=\"btn btn-default\" type=\"button\" title=\"Avanzar\" data-caption=\"Avanzar\" style=\"margin-right: 10px;\"><span class=\"glyphicon glyphicon-step-forward ewIcon\" data-caption=\"Avanzar\"></span></button>");
if ((typeof show_print_email_buttons !== 'undefined') && (show_print_email_buttons))
{
	$(".ewToolbar .breadcrumb").after("<div id=\"navegacionGrupo2\" class=\"btn-group ewButtonGroup\"></div>");
	$("#navegacionGrupo2").append("<button onclick=\"window.print();\" class=\"btn btn-default\" type=\"button\"><span class=\"glyphicon glyphicon-print ewIcon\"></span></button>");
	$("#navegacionGrupo2").append("<button onclick=\"location.href = location.href + \'&email=true\';\" class=\"btn btn-default\" type=\"button\" title=\"EMail\" data-caption=\"EMail\" style=\"margin-right: 10px;\"><span class=\"glyphicon glyphicon-envelope ewIcon\" data-caption=\"EMail\"></span></button>");
}
$(".ewToolbar .breadcrumb").before("<div id=\"barraEstados\" style=\"position: absolute; right: 0px;\"></div>");
<?PHP if (CurrentUserName() != "") { ?>
<?PHP $estado_actualizacion = estadoActualizacion(); ?>
$("#barraEstados").append("<div id=\"estadoPedidos\" data-caption=\"Estado de Pedidos\" data-original-title=\"Estado de Pedidos\" class=\"breadcrumb ewBreadcrumbs ewTooltip\"><?PHP echo(estadoPedidos()); ?></div>");
<?PHP if ($estado_actualizacion[0] != "") { ?>
	$("#barraEstados").append("<div id=\"estadoActualizacion\" data-caption=\"Estado de Actualización (<?PHP echo($estado_actualizacion[1]); ?>)\" data-original-title=\"Estado de Actualización (<?PHP echo($estado_actualizacion[1]); ?>)\" class=\"breadcrumb ewBreadcrumbs ewTooltip\"><?PHP echo($estado_actualizacion[0]); ?></div>");
<?PHP } ?>
<?PHP } ?>
$(".dropdown-menu a[href='#']")
  .on("mouseenter", function() {
	$("[data-menuvisible='true']").attr("data-menuvisible","false");
	$(this).parents(".dropdown-submenu ul").attr("data-menuvisible","true");	  
	$(this).parent(".dropdown-submenu").children("ul").attr("data-menuvisible","true");
	$("[data-menuvisible='true']").css("display","block").css("z-index","999999");
	$("[data-menuvisible='false']").css("display","none");
  });
$(document).click(function() {
  	$("[data-menuvisible='true']").css("display","none");
});
</script>
<?php } ?>
</body>
</html>
