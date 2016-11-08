{capture name=path}{l s='Newsletter' mod='blocknewsletter'}{/capture}
<h2 class="blf-title">{l s='Newsletter' mod='blocknewsletter'}</h2>
<div class="container">
	<div class="row">
		<div class="newsletter_intro">
			{l s='Form intro' mod='blocknewsletter'}
		</div>
	</div>
</div>
<div class="blf-form-container">
	<div class="container">
		<div class="row">
			<form action="{$link->getModuleLink('blocknewsletter', 'form')|escape:'html'}" method="post">
				<input type="hidden" name="action" value="0" />
					
				<div class="form-group">
					<label for="email">{l s='Email' mod='blocknewsletter'} *</label>
					<input class="form-control" id="email" type="email" name="email" value="{$newsletter_email|escape:'html':'UTF-8'}" required="
					required" aria-required="true" />
				</div>
				<div class="form-group">
					<label for="lastname">{l s='Lastname' mod='blocknewsletter'} *</label>
					<input class="form-control" id="lastname" type="text" name="lastname" value="{$newsletter_lastname|escape:'html':'UTF-8'}" required="
					required" aria-required="true" />
				</div>
				<div class="form-group">
					<label for="firstname">{l s='Firstname' mod='blocknewsletter'} *</label>
					<input class="form-control" id="firstname" type="text" name="firstname" value="{$newsletter_firstname|escape:'html':'UTF-8'}" required="
					required" aria-required="true" />
				</div>
				<div class="form-group clearfix">
					<label for="birthday">{l s='Birthday' mod='blocknewsletter'} *</label>
					<div class="date-select">
						<div class="row">							
							<div class="col-sm-4 col-xs-12">
								<select id="days" name="days" class="form-control">
									<option value=""></option>
									{foreach from=$days item=day}
										<option value="{$day}" {if ($newsletter_day == $day)} selected="selected"{/if}>{$day}</option>
									{/foreach}
								</select>
							</div>
							<div class="col-sm-4 col-xs-12">
								<select id="months" name="months" class="form-control">
									<option value=""></option>
									<option value="1">{l s='January' mod='blocknewsletter'}</option>
									<option value="2">{l s='February' mod='blocknewsletter'}</option>
									<option value="3">{l s='March' mod='blocknewsletter'}</option>
									<option value="4">{l s='April' mod='blocknewsletter'}</option>
									<option value="5">{l s='May' mod='blocknewsletter'}</option>
									<option value="6">{l s='June' mod='blocknewsletter'}</option>
									<option value="7">{l s='July' mod='blocknewsletter'}</option>
									<option value="8">{l s='August' mod='blocknewsletter'}</option>
									<option value="9">{l s='September' mod='blocknewsletter'}</option>
									<option value="10">{l s='October' mod='blocknewsletter'}</option>
									<option value="11">{l s='November' mod='blocknewsletter'}</option>
									<option value="12">{l s='December' mod='blocknewsletter'}</option>
									{*foreach from=$months key=k item=month}
										<option value="{$k}" {if ($newsletter_month == $k)} selected="selected"{/if}>{l s=$month}</option>
									{/foreach*}
								</select>
							</div>
							<div class="col-sm-4 col-xs-12">
								<select id="years" name="years" class="form-control">
									<option value=""></option>
									{foreach from=$years item=year}
										<option value="{$year}" {if ($newsletter_year == $year)} selected="selected"{/if}>{$year}</option>
									{/foreach}
								</select>
							</div>		
						</div>
					</div>
				</div>
				<div class="submit">
					<button type="submit" class="btn-blf white" name="submitNewsletter">{l s='subscribe' mod='blocknewsletter'}</button>
				</div>
			</form>
		</div>
	</div>
</div>