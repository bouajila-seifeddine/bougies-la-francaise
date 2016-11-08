<h3><i class="icon-book"></i> {l s='Configurez vos relances de paniers abandonnés' mod='cartabandonmentpro'}</h3>
{if $edit eq 1 and $cronOK eq ''}
	<div id="alertSave" class="alert alert-success">
		{l s='Sauvegarde réussie' mod='cartabandonmentpro'}
		<button type="button" class="close" data-dismiss="alert">×</button>
	</div>
{/if}
{$cronOK}
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-credit-card"></i>
				1 - {l s='Language' mod='cartabandonmentpro'}
			</div>
			<div class="panel-body">
				{include file="../conf/lang.tpl"}
				<h4>{l s='Templates list' mod='cartabandonmentpro'}</h4>
				{include file="../conf/templates_list.tpl"}
			</div>
		</div>
	</div>
</div>
<div class="row" style="margin-top: 25px;">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-cogs"></i>
				2 - {l s='Reminders frequencies' mod='cartabandonmentpro'}
			</div>
			<div class="panel-body">
				{include file="../conf/reminders.tpl"}
			</div>
		</div>
	</div>
</div>
<div class="row" style="margin-top: 25px;">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-cogs"></i>
				3 - {l s='Personalize your templates' mod='cartabandonmentpro'}
			</div>
			<div class="panel-body">
				{include file="../conf/template.tpl"}
			</div>
		</div>
	</div>
</div>