<?php
$leftColumn  = false;
$rightColumn = false;
$txtsRight	 = 0;
$txtsLeft	 = 0;
$txtsCenter	 = 3;
$colors 	 = 2;
$cartProducts = '<tr><td>%NAME%</td></tr><tr><td>%IMG%</td></tr>';
$content = '<body style="padding: 0; margin: 0; background-color:#%color_1%"><div align="center" style="background-color:#%color_1%"><center><br /><br />
<table  cellpadding="0" cellspacing="0" border="0" style="font-family: Verdana,sans-serif; font-size: 11px; color: #374953;">
	<tbody>                            
		<!-- entete -->
		<tr class="pagetoplogo">
			<td bgcolor="#%color_2%">
				<table cellpadding="0" cellspacing="0" border="0" bgcolor="#%color_2%">
					<tbody>
						<tr>
							<td  class="w310"  width="310" align="left">
								<div class="pagetoplogo-content">
									%SHOP_LINK_OPEN%<img style="text-decoration: none; display: block; color:#476688; font-size:30px;" src="http://www.bougies-la-francaise.com/img/logo_mail.jpg"/>%SHOP_LINK_CLOSE%
								</div>
							</td> 
                            <td  class="w330"  width="330" align="left"  style="color:#6a6763; font-size: 16px; font-weight: normal; font-style: italic;">
                                bougies-la-francaise.com
                            </td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>

		<!-- separateur horizontal -->
		<tr>
            <td>&nbsp;</td>
        </tr>

		<!-- contenu -->
		<tr class="content">
			<td class="w640" class="w640"  width="640" bgcolor="#%color_3%">
				<table class="w640"  width="640" cellpadding="0" cellspacing="0" border="0">
					<tbody>
						<tr>
							<td  class="w640"  width="640">
								<!-- une zone de contenu -->
								<table class="w640"  width="640" cellpadding="0" cellspacing="0" border="0">
									<tbody>                                                            
										<tr>
											<td class="w640"  width="640" style="font-size: 11px;">
                                                <br/><br/>
												%center_1%
                                                <br/><br/>
											</td>
										</tr>
									</tbody>
								</table>
								<!-- fin zone -->                                                   
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>

		<!--  separateur horizontal-->
		<tr>
            <td>&nbsp;</td>
        </tr>

		<!-- pied de page -->
		<tr class="pagebottom">
			<td class="w640"  width="640" bgcolor="#%color_4%" style="font-size: 10px; border-top: 1px solid #D9DADE;">
				<table class="w640"  width="640" cellpadding="0" cellspacing="0" border="0" bgcolor="#%color_4%">
					<tbody>
						<tr>
							<td class="w640"  width="640" valign="top" style="font-size: 11px; text-align: center;">
								%center_2%
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
	</tbody>
</table></center></div></body>';

$contentEdit1 = '
<div id="color_2_1_1_edit" width="600" align="center" valign="top" style="background-color:#%color_1%;">
	<input id="color_picker_2_1_1_edit" class="color" name="color_picker_2_1_1" 
	onchange="updateColor(\'color_2_1_1_edit\',this.color.toString());" value="%color_1%" />
	<table width="600" border="0" cellspacing="0" cellpadding="0">
		<tbody>
		<tr>
			<td width="166" valign="middle">
				%SHOP_LINK_OPEN%<img style="text-decoration: none; display: block; color:#476688; font-size:30px;display:block;vertical-align:top;" 
				src="%logo%" border="0">
				%SHOP_LINK_CLOSE%
			</td>
		</tr>
		</tbody>
	</table>
	<table width="600" border="0" cellpadding="0" cellspacing="0">
		<tbody>
		<tr>
			<td width="600" height="20px"><hr style="margin-top:20px;margin-bottom:20px;border:0;border-top:1px solid #eee"></td>
		</tr>
	</tbody>
	</table>  

	<table width="600" border="0" cellpadding="0" cellspacing="0">
		<tbody>
		<tr><td id="color_2_2_1_edit" bgcolor="#%color_2%">
			<input id="color_picker_2_2_1_edit" class="color" name="color_picker_2_2_1" onchange="updateColor(\'color_2_2_1_edit\',this.color.toString())" value="%color_2%" />
			<table width="600" border="0" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
					<td width="280" align="left" valign="top">
							<table width="280" border="0" cellpadding="0" cellspacing="0">
								<tbody>
									<tr>
										<td width="280" align="left" valign="top" style="padding: 5px;">
											<textarea name="center_2_1_1" id="tpl2_center_1_1">%center_1%</textarea>
										</td>
									</tr>
								</tbody>
							</table>
						</td>
						<td width="320" align="right" valign="top">
							<table width="320" border="0" cellpadding="0" cellspacing="0">
								<tbody>
									<tr>
										<td width="40" height="35"></td>
										<td width="280" height="35" align="left" style="padding: 5px;">
											<textarea name="center_2_2_1" id="tpl2_center_2_1">%center_2%</textarea>
										</td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
		</td></tr>
		</tbody>
	</table>

	<table width="600" border="0" cellpadding="0" cellspacing="0">
		<tbody>
			<tr>
				<td width="600" height="22">
					<hr style="margin-top:20px;margin-bottom:20px;border:0;border-top:1px solid #eee">
				</td>
			</tr>
			<tr>
				<td width="600" height="32" bgcolor="#%color_1%">
					<table width="600" border="0" cellpadding="0" cellspacing="0"> 
						<tbody>
							<tr>
								<td width="40" height="32" align="center">
									<textarea name="center_2_3_1" id="tpl2_center_3_1_edit">%center_3%</textarea>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
</div>
';

$contentEdit2 = '
<div id="color_2_1_2_edit" width="600" align="center" valign="top" style="background-color:#%color_1%;">
	<input id="color_picker_2_1_2_edit" class="color" name="color_picker_2_1_2" 
	onchange="updateColor(\'color_2_1_2_edit\',this.color.toString());" value="%color_1%" />
	<table width="600" border="0" cellspacing="0" cellpadding="0">
		<tbody>
		<tr>
			<td width="166" valign="middle">
				%SHOP_LINK_OPEN%<img style="text-decoration: none; display: block; color:#476688; font-size:30px;display:block;vertical-align:top;" 
				src="%logo%" border="0">
				%SHOP_LINK_CLOSE%
			</td>
		</tr>
		</tbody>
	</table>
	<table width="600" border="0" cellpadding="0" cellspacing="0">
		<tbody>
		<tr>
			<td width="600" height="20px"><hr style="margin-top:20px;margin-bottom:20px;border:0;border-top:1px solid #eee"></td>
		</tr>
	</tbody>
	</table>  

	<table width="600" border="0" cellpadding="0" cellspacing="0">
		<tbody>
		<tr><td id="color_2_2_2_edit" bgcolor="#%color_2%">
			<input id="color_picker_2_2_2_edit" class="color" name="color_picker_2_2_2" onchange="updateColor(\'color_2_2_2_edit\',this.color.toString())" value="%color_2%" />
			<table width="600" border="0" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
					<td width="280" align="left" valign="top">
							<table width="280" border="0" cellpadding="0" cellspacing="0">
								<tbody>
									<tr>
										<td width="280" align="left" valign="top" style="padding: 5px;">
											<textarea name="center_2_1_2" id="tpl2_center_1_2">%center_1%</textarea>
										</td>
									</tr>
								</tbody>
							</table>
						</td>
						<td width="320" align="right" valign="top">
							<table width="320" border="0" cellpadding="0" cellspacing="0">
								<tbody>
									<tr>
										<td width="40" height="35"></td>
										<td width="280" height="35" align="left" style="padding: 5px;">
											<textarea name="center_2_2_2" id="tpl2_center_2_2">%center_2%</textarea>
										</td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
		</td></tr>
		</tbody>
	</table>

	<table width="600" border="0" cellpadding="0" cellspacing="0">
		<tbody>
			<tr>
				<td width="600" height="22">
					<hr style="margin-top:20px;margin-bottom:20px;border:0;border-top:1px solid #eee">
				</td>
			</tr>
			<tr>
				<td width="600" height="32" bgcolor="#%color_1%">
					<table width="600" border="0" cellpadding="0" cellspacing="0"> 
						<tbody>
							<tr>
								<td width="40" height="32" align="center">
									<textarea name="center_2_3_2" id="tpl2_center_3_2_edit">%center_3%</textarea>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
</div>
';

$contentEdit3 = '
<div id="color_2_1_3_edit" width="600" align="center" valign="top" style="background-color:#%color_1%;">
	<input id="color_picker_2_1_3_edit" class="color" name="color_picker_2_1_3" 
	onchange="updateColor(\'color_2_1_3_edit\',this.color.toString());" value="%color_1%" />
	<table width="600" border="0" cellspacing="0" cellpadding="0">
		<tbody>
		<tr>
			<td width="166" valign="middle">
				%SHOP_LINK_OPEN%<img style="text-decoration: none; display: block; color:#476688; font-size:30px;display:block;vertical-align:top;" 
				src="%logo%" border="0">
				%SHOP_LINK_CLOSE%
			</td>
		</tr>
		</tbody>
	</table>
	<table width="600" border="0" cellpadding="0" cellspacing="0">
		<tbody>
		<tr>
			<td width="600" height="20px"><hr style="margin-top:20px;margin-bottom:20px;border:0;border-top:1px solid #eee"></td>
		</tr>
	</tbody>
	</table>  

	<table width="600" border="0" cellpadding="0" cellspacing="0">
		<tbody>
		<tr><td id="color_2_2_3_edit" bgcolor="#%color_2%">
			<input id="color_picker_2_2_3_edit" class="color" name="color_picker_2_2_3" onchange="updateColor(\'color_2_2_3_edit\',this.color.toString())" value="%color_2%" />
			<table width="600" border="0" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
					<td width="280" align="left" valign="top">
							<table width="280" border="0" cellpadding="0" cellspacing="0">
								<tbody>
									<tr>
										<td width="280" align="left" valign="top" style="padding: 5px;">
											<textarea name="center_2_1_3" id="tpl2_center_1_3">%center_1%</textarea>
										</td>
									</tr>
								</tbody>
							</table>
						</td>
						<td width="320" align="right" valign="top">
							<table width="320" border="0" cellpadding="0" cellspacing="0">
								<tbody>
									<tr>
										<td width="40" height="35"></td>
										<td width="280" height="35" align="left" style="padding: 5px;">
											<textarea name="center_2_2_3" id="tpl2_center_2_3">%center_2%</textarea>
										</td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
		</td></tr>
		</tbody>
	</table>

	<table width="600" border="0" cellpadding="0" cellspacing="0">
		<tbody>
			<tr>
				<td width="600" height="22">
					<hr style="margin-top:20px;margin-bottom:20px;border:0;border-top:1px solid #eee">
				</td>
			</tr>
			<tr>
				<td width="600" height="32">
					<table width="600" border="0" cellpadding="0" cellspacing="0"> 
						<tbody>
							<tr>
								<td width="40" height="32" align="center">
									<textarea name="center_2_3_3" id="tpl2_center_3_3_edit">%center_3%</textarea>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
</div>
';