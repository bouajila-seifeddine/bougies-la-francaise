<?php
$leftColumn  = false;
$rightColumn = false;
$txtsRight	 = 0;
$txtsLeft	 = 0;
$txtsCenter	 = 2;
$colors 	 = 4;
$cartProducts = '<tr><td>%IMG%</td><td>%NAME%<br>%DESC%</td></tr>';
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
									%SHOP_LINK_OPEN%<img style="text-decoration: none; display: block; color:#476688; font-size:30px;" src="http://www.blf-ecommerce.loc/img/logo_mail.jpg"/>%SHOP_LINK_CLOSE%
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

$contentEdit1 = '<div id="color_1_1_1_edit" align="center" style="background-color:#%color_1%"><center>
				<input id="color_picker_1_1_1_edit" class="color" name="color_picker_1_1_1" onchange="updateColorEdit(\'color_1_1_1_edit\', \'color_picker_1_1_1_edit\');" value="%color_1%" />
				<table  cellpadding="0" cellspacing="0" border="0" style="font-family: Verdana,sans-serif; font-size: 11px; color: #374953;">
					<tbody>
						<!-- entete -->
						<tr class="pagetoplogo">
							<td id="color_1_2_1_edit" bgcolor="#%color_2%">
								<table cellpadding="0" cellspacing="0" border="0">
									<tbody>
										<tr><td colspan="2"><input id="color_picker_1_2_1_edit" class="color" name="color_picker_1_2_1" onchange="updateColorEdit(\'color_1_2_1_edit\', \'color_picker_1_2_1_edit\');" value="%color_2%" /></td></tr>
										<tr>
											<td  class="w310"  width="310" align="left">
                                                <div class="pagetoplogo-content">
                                                    %SHOP_LINK_OPEN%<img style="text-decoration: none; display: block; color:#476688; font-size:30px;" src="http://www.bougies-la-francaise.com/img/logo_mail.jpg" alt="Mon Logo"/>%SHOP_LINK_CLOSE%
                                                </div>
                                            </td> 
                                            <td  class="w330"  width="330" align="left">
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
							<td id="color_1_3_1_edit" class="w640" class="w640"  width="640" bgcolor="#%color_3%">
								<input id="color_picker_1_3_1_edit" class="color" name="color_picker_1_3_1" onchange="updateColorEdit(\'color_1_3_1_edit\', \'color_picker_1_3_1_edit\');" value="%color_3%" />
								<table class="w640"  width="640" cellpadding="0" cellspacing="0" border="0">
									<tbody>
										<tr>
											<td  class="w640"  width="640">
												<!-- une zone de contenu -->
												<table class="w640"  width="640" cellpadding="0" cellspacing="0" border="0">
													<tbody>                                                            
														<tr>
															<td class="w640"  width="640" style="font-size: 10px;">
																<textarea name="center_1_1_1" id="tpl1_center_1_1_edit">%center_1%</textarea>
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
							<td id="color_1_4_1_edit" class="w640"  width="640" bgcolor="#%color_4%" style="font-size: 10px; border-top: 1px solid #D9DADE;">
								<table class="w640"  width="640" cellpadding="0" cellspacing="0" border="0" >
									<tbody>
										<tr><td><input id="color_picker_1_4_1_edit" class="color" name="color_picker_1_4_1" onchange="updateColorEdit(\'color_1_4_1_edit\', \'color_picker_1_4_1_edit\');" value="%color_4%" /></td></tr>
										<tr>
											<td class="w640"  width="640" valign="top">
												<textarea name="center_1_2_1" id="tpl1_center_1_2_1_edit">%center_2%</textarea>
											</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
					</tbody>
				</table>
			</center></div>';

$contentEdit2 = '<div id="color_1_1_2_edit" align="center" style="background-color:#%color_1%;"><center>
				<input id="color_picker_1_1_2_edit" class="color" name="color_picker_1_1_2" onchange="updateColorEdit(\'color_1_1_2_edit\', \'color_picker_1_1_2_edit\');" value="%color_1%" />
				<table  cellpadding="0" cellspacing="0" border="0" style="font-family: Verdana,sans-serif; font-size: 11px; color: #374953;">
					<tbody>
						<!-- entete -->
						<tr class="pagetoplogo">
							<td id="color_1_2_2_edit" bgcolor="#%color_2%">
								<table cellpadding="0" cellspacing="0" border="0">
									<tbody>
										<tr><td colspan="2"><input id="color_picker_1_2_2_edit" class="color" name="color_picker_1_2_2" onchange="updateColorEdit(\'color_1_2_2_edit\', \'color_picker_1_2_2_edit\');" value="%color_2%" /></td></tr>
										<tr>
											<td  class="w310"  width="310" align="left">
                                                <div class="pagetoplogo-content">
                                                    %SHOP_LINK_OPEN%<img style="text-decoration: none; display: block; color:#476688; font-size:30px;" src="http://www.bougies-la-francaise.com/img/logo_mail.jpg" alt="Mon Logo"/>%SHOP_LINK_CLOSE%
                                                </div>
                                            </td> 
                                            <td  class="w330"  width="330" align="left">
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
							<td id="color_1_3_2_edit" class="w640" class="w640"  width="640" bgcolor="#%color_3%">
								<input id="color_picker_1_3_2_edit" class="color" name="color_picker_1_3_2" onchange="updateColorEdit(\'color_1_3_2_edit\', \'color_picker_1_3_2_edit\');" value="%color_3%" />
								<table class="w640"  width="640" cellpadding="0" cellspacing="0" border="0">
									<tbody>
										<tr>
											<td  class="w640"  width="640">
												<!-- une zone de contenu -->
												<table class="w640"  width="640" cellpadding="0" cellspacing="0" border="0">
													<tbody>                                                            
														<tr>
															<td class="w640"  width="640">
																<textarea name="center_1_1_2" id="tpl1_center_1_2_edit">%center_1%</textarea>
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

						<!--  separateur horizontal de 15px de  haut-->
						<tr>
                            <td>&nbsp;</td>
                        </tr>

						<!-- pied de page -->
						<tr class="pagebottom">
							<td id="color_1_4_2_edit" class="w640"  width="640" bgcolor="#%color_4%" style="font-size: 10px; border-top: 1px solid #D9DADE;">
								<table class="w640"  width="640" cellpadding="0" cellspacing="0" border="0" >
									<tbody>
										<tr><td><input id="color_picker_1_4_2_edit" class="color" name="color_picker_1_4_2" onchange="updateColorEdit(\'color_1_4_2_edit\', \'color_picker_1_4_2_edit\');" value="%color_4%" /></td></tr>
										<tr>
											<td class="w640"  width="640" valign="top">
												<textarea name="center_1_2_2" id="tpl1_center_2_2_edit">%center_2%</textarea>
											</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
					</tbody>
				</table>
			</center></div><br /><br />';

$contentEdit3 = '<div id="color_1_1_3_edit" align="center" style="background-colo:#%color_1%">
				<input id="color_picker_1_1_3_edit" class="color" name="color_picker_1_1_3" onchange="updateColorEdit(\'color_1_1_3_edit\', \'color_picker_1_1_3_edit\');" value="%color_1%" />
				<table  cellpadding="0" cellspacing="0" border="0" style="font-family: Verdana,sans-serif; font-size: 11px; color: #374953;">
					<tbody>
						<!-- entete -->
						<tr class="pagetoplogo">
							<td id="color_1_2_3_edit" bgcolor="#%color_2%">
								<table cellpadding="0" cellspacing="0" border="0">
									<tbody>
										<tr><td colspan="2"><input id="color_picker_1_2_3_edit" class="color" name="color_picker_1_2_3" onchange="updateColorEdit(\'color_1_2_3_edit\', \'color_picker_1_2_3_edit\');" value="%color_2%" /></td></tr>
										<tr>
											<td  class="w310"  width="310" align="left">
                                                <div class="pagetoplogo-content">
                                                    %SHOP_LINK_OPEN%<img style="text-decoration: none; display: block; color:#476688; font-size:30px;" src="http://www.bougies-la-francaise.com/img/logo_mail.jpg" alt="Mon Logo"/>%SHOP_LINK_CLOSE%
                                                </div>
                                            </td> 
                                            <td  class="w330"  width="330" align="left">
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
							<td id="color_1_3_3_edit" class="w640" class="w640"  width="640" bgcolor="#%color_3%">
								<input id="color_picker_1_3_3_edit" class="color" name="color_picker_1_3_3" onchange="updateColorEdit(\'color_1_3_3_edit\', \'color_picker_1_3_3_edit\');" value="%color_3%" />
								<table class="w640"  width="640" cellpadding="0" cellspacing="0" border="0">
									<tbody>
										<tr>
											<td  class="w640"  width="640">
												<!-- une zone de contenu -->
												<table class="w640"  width="640" cellpadding="0" cellspacing="0" border="0">
													<tbody>                                                            
														<tr>
															<td class="w640"  width="640">
																<textarea name="center_1_1_3" id="tpl1_center_1_3_edit">%center_1%</textarea>
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

						<!--  separateur horizontal de 15px de  haut-->
						<tr>
                            <td>&nbsp;</td>
                        </tr>

						<!-- pied de page -->
						<tr class="pagebottom">
							<td id="color_1_4_3_edit" class="w640"  width="640" bgcolor="#%color_4%" style="font-size: 10px; border-top: 1px solid #D9DADE;">
								<table class="w640"  width="640" cellpadding="0" cellspacing="0" border="0" >
									<tbody>
										<tr><td><input id="color_picker_1_4_3_edit" class="color" name="color_picker_1_4_3" onchange="updateColorEdit(\'color_1_4_3_edit\', \'color_picker_1_4_3_edit\');" value="%color_4%" /></td></tr>
										<tr>
											<td class="w640"  width="640" valign="top">
												<textarea name="center_1_2_3" id="tpl1_center_2_3_edit">%center_2%</textarea>
											</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
					</tbody>
				</table>
			</center></div><br /><br />';