<?php 

if (!defined('_PS_VERSION_'))
  exit;
		
	class ProCategory extends Module
	{
		
		 public function __construct()
		  {
			$this->name = 'procategory';
			$this->tab = 'front_office_features';
			$this->version = '0.2';
			$this->author = 'Webtet';
			$this->bootstrap = true;
			$this->display = 'view';
			$this->need_instance = 0;
			$this->ps_versions_compliancy = array('min' => '1.5', 'max' => '1.6'); 
			parent::__construct();
			$this->displayName = $this->l('Category carousel');
			$this->description = $this->l('Display responsive Category carousel.');
			$this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
			if (!Configuration::get('procategory'));
			 
		}

		public function install()
		{
			
	
		  	return parent::install() &&
			$this->registerHook('displayHome') &&
			$this->registerHook('displayHeader') &&
			$this->registerHook('customSliderCollections') &&
			Configuration::updateValue('configcategory_input1', '1') &&
			Configuration::updateValue('configcategory_input2', '2') &&
			Configuration::updateValue('configcategory_input3', '2') &&
			Configuration::updateValue('configcategory_input4', '1') &&
			Configuration::updateValue('configcategory_input5', '1') &&
			Configuration::updateValue('configcategory_input6', '200') &&
			Configuration::updateValue('configcategory_input7', '800') &&
			Configuration::updateValue('configcategory_input8', '1000') &&
			Configuration::updateValue('configcategory_radio1', 1) &&
			Configuration::updateValue('configcategory_radio2', 1) &&
			Configuration::updateValue('configcategory_radio3', 1) &&
			Configuration::updateValue('configcategory_radio4', 1) &&
			Configuration::updateValue('configcategory_radio5', 1) &&
			Configuration::updateValue('configcategory_radio6', 1) &&
			Configuration::updateValue('configcategory_radio7', 1) &&
			Configuration::updateValue('configcategory_radio8', 1) &&
			Configuration::updateValue('configcategory_radio9', 1) &&
			Configuration::updateValue('configcategory_radio10', 1) &&
			Configuration::updateValue('configcategory_radio11', 1) &&
			Configuration::updateValue('configcategory_radio12', 1) &&
			Configuration::updateValue('configcategory_radio13', 1) &&
			Configuration::updateValue('configcategory_radio14', 1) &&
			Configuration::updateValue('configcategory_radio15', 1) &&
			Configuration::updateValue('configcategory_radio16', 1) &&
			Configuration::updateValue('configcategory_radio17', 1) &&
			Configuration::updateValue('configcategory_radio18', 1) &&
			Configuration::updateValue('configcategory_color1', '#f1f1f1') &&
			Configuration::updateValue('configcategory_color2', '#ffffff') &&
			Configuration::updateValue('configcategory_color3', '#3a3a3a') &&
			Configuration::updateValue('configcategory_color4', '#d12222') &&
			Configuration::updateValue('configcategory_color5', '#f13340') &&
			Configuration::updateValue('configcategory_color6', '#3a3a3a') &&
			Configuration::updateValue('configcategory_color7', '#00ac19') &&
			Configuration::updateValue('configcategory_color8', '#d0c45b') &&
			Configuration::updateValue('configcategory_color9', '#de880e') &&
			Configuration::updateValue('configcategory_color10', '#f6f6f6');

		  }

		public function uninstall()
		{
		  if (!parent::uninstall() ||
		 	!Configuration::deleteByName('configcategory_input1')||
			!Configuration::deleteByName('configcategory_input2')||
			!Configuration::deleteByName('configcategory_input3')||
			!Configuration::deleteByName('configcategory_input4')||
			!Configuration::deleteByName('configcategory_input5')||
			!Configuration::deleteByName('configcategory_input6')||
			!Configuration::deleteByName('configcategory_input7')||
			!Configuration::deleteByName('configcategory_input8')||
			!Configuration::deleteByName('configcategory_radio1')||
			!Configuration::deleteByName('configcategory_radio2')||
			!Configuration::deleteByName('configcategory_radio3')||
			!Configuration::deleteByName('configcategory_radio4')||
			!Configuration::deleteByName('configcategory_radio5')||
			!Configuration::deleteByName('configcategory_radio6')||
			!Configuration::deleteByName('configcategory_radio7')||
			!Configuration::deleteByName('configcategory_radio8')||
			!Configuration::deleteByName('configcategory_radio9')||
			!Configuration::deleteByName('configcategory_radio10')||
			!Configuration::deleteByName('configcategory_radio11')||
			!Configuration::deleteByName('configcategory_radio12')||
			!Configuration::deleteByName('configcategory_radio13')||
			!Configuration::deleteByName('configcategory_radio14')||
			!Configuration::deleteByName('configcategory_radio15')||
			!Configuration::deleteByName('configcategory_radio16')||
			!Configuration::deleteByName('configcategory_radio17')||
			!Configuration::deleteByName('configcategory_radio18')||
			!Configuration::deleteByName('configcategory_color1')||
			!Configuration::deleteByName('configcategory_color2')||
			!Configuration::deleteByName('configcategory_color3')||
			!Configuration::deleteByName('configcategory_color4')||
			!Configuration::deleteByName('configcategory_color5')||
			!Configuration::deleteByName('configcategory_color6')||
			!Configuration::deleteByName('configcategory_color7')||
			!Configuration::deleteByName('configcategory_color8')||
			!Configuration::deleteByName('configcategory_color9')||
			!Configuration::deleteByName('configcategory_color10'))
			return false;
		    return true;
		}
	
		public function getContent()
		{
			$output = null;
			if (Tools::isSubmit('submit'.$this->name))
			{
				
				$proconfigcategoryinput1 = Tools::getValue('configcategory_input1');
				$proconfigcategoryinput2 = Tools::getValue('configcategory_input2');
				$proconfigcategoryinput3 = Tools::getValue('configcategory_input3');
				$proconfigcategoryinput4 = Tools::getValue('configcategory_input4');
				$proconfigcategoryinput5 = Tools::getValue('configcategory_input5');
				$proconfigcategoryinput6 = Tools::getValue('configcategory_input6');
				$proconfigcategoryinput7 = Tools::getValue('configcategory_input7');
				$proconfigcategoryinput8 = Tools::getValue('configcategory_input8');
				$proconfigcategoryradio1 = Tools::getValue('configcategory_radio1');
				$proconfigcategoryradio2 = Tools::getValue('configcategory_radio2');
				$proconfigcategoryradio3 = Tools::getValue('configcategory_radio3');
				$proconfigcategoryradio4 = Tools::getValue('configcategory_radio4');
				$proconfigcategoryradio5 = Tools::getValue('configcategory_radio5');
				$proconfigcategoryradio6 = Tools::getValue('configcategory_radio6');
				$proconfigcategoryradio7 = Tools::getValue('configcategory_radio7');
				$proconfigcategoryradio8 = Tools::getValue('configcategory_radio8');
				$proconfigcategoryradio9 = Tools::getValue('configcategory_radio9');
				$proconfigcategoryradio10 = Tools::getValue('configcategory_radio10');
				$proconfigcategoryradio11 = Tools::getValue('configcategory_radio11');
				$proconfigcategoryradio12 = Tools::getValue('configcategory_radio12');
				$proconfigcategoryradio13 = Tools::getValue('configcategory_radio13');
				$proconfigcategoryradio14 = Tools::getValue('configcategory_radio14');
				$proconfigcategoryradio15 = Tools::getValue('configcategory_radio15');
				$proconfigcategoryradio16 = Tools::getValue('configcategory_radio16');
				$proconfigcategoryradio17 = Tools::getValue('configcategory_radio17');
				$proconfigcategoryradio18 = Tools::getValue('configcategory_radio18');
				$proconfigcategorycolor1 = Tools::getValue('configcategory_color1');
				$proconfigcategorycolor2 = Tools::getValue('configcategory_color2');
				$proconfigcategorycolor3 = Tools::getValue('configcategory_color3');
				$proconfigcategorycolor4 = Tools::getValue('configcategory_color4');
				$proconfigcategorycolor5 = Tools::getValue('configcategory_color5');
				$proconfigcategorycolor6 = Tools::getValue('configcategory_color6');
				$proconfigcategorycolor7 = Tools::getValue('configcategory_color7');
				$proconfigcategorycolor8 = Tools::getValue('configcategory_color8');
				$proconfigcategorycolor9 = Tools::getValue('configcategory_color9');
				$proconfigcategorycolor10 = Tools::getValue('configcategory_color10');
					Configuration::updateValue('configcategory_input1', $proconfigcategoryinput1);
					Configuration::updateValue('configcategory_input2', $proconfigcategoryinput2);
					Configuration::updateValue('configcategory_input3', $proconfigcategoryinput3);
					Configuration::updateValue('configcategory_input4', $proconfigcategoryinput4);
					Configuration::updateValue('configcategory_input5', $proconfigcategoryinput5);
					Configuration::updateValue('configcategory_input6', $proconfigcategoryinput6);
					Configuration::updateValue('configcategory_input7', $proconfigcategoryinput7);
					Configuration::updateValue('configcategory_input8', $proconfigcategoryinput8);
					Configuration::updateValue('configcategory_radio1', $proconfigcategoryradio1);
					Configuration::updateValue('configcategory_radio2', $proconfigcategoryradio2);
					Configuration::updateValue('configcategory_radio3', $proconfigcategoryradio3);
					Configuration::updateValue('configcategory_radio4', $proconfigcategoryradio4);
					Configuration::updateValue('configcategory_radio5', $proconfigcategoryradio5);
					Configuration::updateValue('configcategory_radio6', $proconfigcategoryradio6);
					Configuration::updateValue('configcategory_radio7', $proconfigcategoryradio7);
					Configuration::updateValue('configcategory_radio8', $proconfigcategoryradio8);
					Configuration::updateValue('configcategory_radio9', $proconfigcategoryradio9);
					Configuration::updateValue('configcategory_radio10', $proconfigcategoryradio10);
					Configuration::updateValue('configcategory_radio11', $proconfigcategoryradio11);
					Configuration::updateValue('configcategory_radio12', $proconfigcategoryradio12);
					Configuration::updateValue('configcategory_radio13', $proconfigcategoryradio13);
					Configuration::updateValue('configcategory_radio14', $proconfigcategoryradio14);
					Configuration::updateValue('configcategory_radio15', $proconfigcategoryradio15);
					Configuration::updateValue('configcategory_radio16', $proconfigcategoryradio16);
					Configuration::updateValue('configcategory_radio17', $proconfigcategoryradio17);
					Configuration::updateValue('configcategory_radio18', $proconfigcategoryradio18);
					Configuration::updateValue('configcategory_color1', $proconfigcategorycolor1);
					Configuration::updateValue('configcategory_color2', $proconfigcategorycolor2);
					Configuration::updateValue('configcategory_color3', $proconfigcategorycolor3);
					Configuration::updateValue('configcategory_color4', $proconfigcategorycolor4);
					Configuration::updateValue('configcategory_color5', $proconfigcategorycolor5);
					Configuration::updateValue('configcategory_color6', $proconfigcategorycolor6);
					Configuration::updateValue('configcategory_color7', $proconfigcategorycolor7);
					Configuration::updateValue('configcategory_color8', $proconfigcategorycolor8);
					Configuration::updateValue('configcategory_color9', $proconfigcategorycolor9);
					Configuration::updateValue('configcategory_color10', $proconfigcategorycolor10);
				$output .= $this->displayConfirmation($this->l('Settings updated'));
		}
			return $output.$this->displayForm();
		}
	
		public function displayForm()
		{
			// Init Fields form array
			$fields_form = array(
			'form' => array(
				'legend' => array(
					'title' => $this->l('Settings display the number of products in five different screen resolutions (desktop, tablet and mobile)'),
				),
				'input' => array(
					array(
						'type' => 'text',
						'label' => $this->l('Maximum of items displayed Desktop:'),
						'name' => 'configcategory_input2',
						'size' => 40,
						'desc' => 'This variable allows you to set the maximum amount of items displayed at a time with the widest browser width.'
					),
					array(
						'type' => 'text',
						'label' => $this->l('Maximum of items Desktop-Tablet (window <= 1199px):'),
						'name' => 'configcategory_input3',
						'desc' => 'This allows you to preset the number of slides visible with a particular browser width. if(window <= 1199){ show number slides per page}.'
					),
					array(
						'type' => 'text',
						'label' => $this->l('Maximum of items Tablet Small (window <= 979px):'),
						'name' => 'configcategory_input1',
						'desc' => 'This allows you to preset the number of slides visible with a particular browser width. if(window <= 979px){ show number slides per page}.'
					),
					array(
						'type' => 'text',
						'label' => $this->l('Maximum of items Mobile (window <= 768px):'),
						'name' => 'configcategory_input4',
						'desc' => 'This allows you to preset the number of slides visible with a particular browser width. if(window <= 768px){ show number slides per page}.'
					),
					array(
						'type' => 'text',
						'label' => $this->l('Maximum of items Mobile Small (window <= 479px):'),
						'name' => 'configcategory_input5',
						'desc' => 'This allows you to preset the number of slides visible with a particular browser width. if(window <= 479px){ show number slides per page}.'
					)
				),
				'submit' => array(
					'title' => $this->l('Save'),
					'class' => 'button'
				)
				
				),
				
				
		);
				// Init Fields form array
			$fields_form3 = array(
			'form' => array(
				'legend' => array(
					'title' => $this->l('Animation speed carousel - slide, pagination, rewind '),
				),
				'input' => array(
					array(
						'type' => 'text',
						'label' => $this->l('Slide speed:'),
						'name' => 'configcategory_input6',
						'desc' => 'Slide speed in milliseconds.'
					),
					array(
						'type' => 'text',
						'label' => $this->l('Pagination speed:'),
						'name' => 'configcategory_input7',
						'desc' => 'Pagination speed in milliseconds.'
					),
					array(
						'type' => 'text',
						'label' => $this->l('Rewind speed:'),
						'name' => 'configcategory_input8',
						'desc' => 'Rewind speed in milliseconds.'
					),
	  			array(
                    'type' => 'switch',
                    'label' => $this->l('Auto Play:'),
                    'name' => 'configcategory_radio16',
					'desc' => 'Enable Auto Play.',
                    'class' => 't',	
                    'values' => array(
                        array(
                            'id' => 'active_on',
                            'value' => 1,
                            'label' => $this->l('Enabled')
                        ),
                        array(
                            'id' => 'active_off',
                            'value' => 0,
                            'label' => $this->l('Disabled')
                        )
                    )
                ),
	  			array(
                    'type' => 'switch',
                    'label' => $this->l('Stop on hover:'),
                    'name' => 'configcategory_radio17',
					'desc' => 'Enable stop on hover.',
                    'class' => 't',	
                    'values' => array(
                        array(
                            'id' => 'active_on',
                            'value' => 1,
                            'label' => $this->l('Enabled')
                        ),
                        array(
                            'id' => 'active_off',
                            'value' => 0,
                            'label' => $this->l('Disabled')
                        )
                    )
                ),
	  			array(
                    'type' => 'switch',
                    'label' => $this->l('Mouse Drag:'),
                    'name' => 'configcategory_radio18',
					'desc' => 'Turn off/on mouse events..',
                    'class' => 't',	
                    'values' => array(
                        array(
                            'id' => 'active_on',
                            'value' => 1,
                            'label' => $this->l('Enabled')
                        ),
                        array(
                            'id' => 'active_off',
                            'value' => 0,
                            'label' => $this->l('Disabled')
                        )
                    )
                )
				),
				'submit' => array(
					'title' => $this->l('Save'),
					'class' => 'button'
				)
				
				),
				
				
		);
	// Init Fields form array
			$fields_form2 = array(
			'form' => array(
				'legend' => array(
					'title' => $this->l('Settings Display element "Category Сarousel".'),
				),
				'input' => array(
					 array(
                   'type' => 'switch',
                    'label' => $this->l('Category name:'),
                    'name' => 'configcategory_radio4',
                    'class' => 't',
					'desc' => 'Display category name.',
                    'values' => array(
                        array(
                            'id' => 'active_on',
                            'value' => 1,
                            'label' => $this->l('Enabled')
                        ),
                        array(
                            'id' => 'active_off',
                            'value' => 0,
                            'label' => $this->l('Disabled')
                        )
                    )
                ),
	  			array(
                   'type' => 'switch',
                    'label' => $this->l('Category description:'),
                    'name' => 'configcategory_radio6',
					'desc' => 'Display category description.',
                    'class' => 't',
                    'values' => array(
                        array(
                            'id' => 'active_on',
                            'value' => 1,
                            'label' => $this->l('Enabled')
                        ),
                        array(
                            'id' => 'active_off',
                            'value' => 0,
                            'label' => $this->l('Disabled')
                        )
                    )
                ),
                array(
                   'type' => 'switch',
                    'label' => $this->l('Category images:'),
                    'name' => 'configcategory_radio1',
					'desc' => 'Display category images.',
                    'class' => 't',
                    'values' => array(
                        array(
                            'id' => 'active_on',
                            'value' => 1,
                            'label' => $this->l('Enabled')
                        ),
                        array(
                            'id' => 'active_off',
                            'value' => 0,
                            'label' => $this->l('Disabled')
                        )
                    )
                ),
                array(
                   'type' => 'switch',
                    'label' => $this->l('Title category block:'),
                    'name' => 'configcategory_radio7',
					'desc' => 'Display title category block.',
                    'class' => 't',
                    'values' => array(
                        array(
                            'id' => 'active_on',
                            'value' => 1,
                            'label' => $this->l('Enabled')
                        ),
                        array(
                            'id' => 'active_off',
                            'value' => 0,
                            'label' => $this->l('Disabled')
                        )
                    )
                ),

	  			array(
                    'type' => 'switch',
                    'label' => $this->l('Navigation:'),
                    'name' => 'configcategory_radio14',
					'desc' => 'Display "next" and "prev" buttons.',
                    'class' => 't',	
                    'values' => array(
                        array(
                            'id' => 'active_on',
                            'value' => 1,
                            'label' => $this->l('Enabled')
                        ),
                        array(
                            'id' => 'active_off',
                            'value' => 0,
                            'label' => $this->l('Disabled')
                        )
                    )
                ),
	  			array(
                    'type' => 'switch',
                    'label' => $this->l('Pagination:'),
                    'name' => 'configcategory_radio15',
					'desc' => 'Show pagination.',
                    'class' => 't',	
                    'values' => array(
                        array(
                            'id' => 'active_on',
                            'value' => 1,
                            'label' => $this->l('Enabled')
                        ),
                        array(
                            'id' => 'active_off',
                            'value' => 0,
                            'label' => $this->l('Disabled')
                        )
                    )
                )
				),
				'submit' => array(
					'title' => $this->l('Save'),
					'class' => 'button'
				)
				
				),
				
				
		);
						// Init Fields form array
			$fields_form4 = array(
			'form' => array(
				'legend' => array(
					'title' => $this->l('Desing amd Style element "Category carousel"'),
				),
				'input' => array(
					array(
						'type' => 'color',
						'label' => $this->l('Color "name category":'),
						'name' => 'configcategory_color1',
                     	'class' => 'color mColorPickerInput',
                   		'size' => 20,
                  		'desc' => $this->l('Change color style for name category".')
		    		 ),
					 array(
						'type' => 'color',
						'label' => $this->l('Color "description category":'),
						'name' => 'configcategory_color2',
                     	'class' => 'color mColorPickerInput',
                   		'size' => 20,
                  		'desc' => $this->l('Change color style for description category".')
		    		 ),
					 array(
						'type' => 'color',
						'label' => $this->l('Color "title category":'),
						'name' => 'configcategory_color3',
                     	'class' => 'color mColorPickerInput',
                   		'size' => 20,
                  		'desc' => $this->l('Change color style for title category".')
		    		 ),
					
					 array(
						'type' => 'color',
						'label' => $this->l('Background "Title block":'),
						'name' => 'configcategory_color10',
                     	'class' => 'color mColorPickerInput',
                   		'size' => 20,
                  		'desc' => $this->l('Change background style for "Title block".')
		    		 )
				),
			'submit' => array(
					'title' => $this->l('Save'),
					'class' => 'button'
				)	
					),
		);

		$helper = new HelperForm();
		$helper->show_toolbar = false;
		$helper->table =  $this->table;
		$lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
		$helper->default_form_language = $lang->id;
		$helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
		$this->fields_form = array();
		$this->fields_form2 = array();
		$this->fields_form3 = array();
		$this->fields_form4 = array();
		$helper->identifier = $this->identifier;
		$helper->submit_action = 'submit'.$this->name;
		$helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		$helper->tpl_vars = array(
			'fields_value' => $this->getConfigFieldsValues(),
			'languages' => $this->context->controller->getLanguages(),
			'id_language' => $this->context->language->id
		);
				 
				// Load current value
				$helper->fields_value['configcategory_input1'] = Configuration::get('configcategory_input1');
				$helper->fields_value['configcategory_input2'] = Configuration::get('configcategory_input2');
				$helper->fields_value['configcategory_input3'] = Configuration::get('configcategory_input3');
				$helper->fields_value['configcategory_input4'] = Configuration::get('configcategory_input4');
				$helper->fields_value['configcategory_input5'] = Configuration::get('configcategory_input5');
				$helper->fields_value['configcategory_input6'] = Configuration::get('configcategory_input6');
				$helper->fields_value['configcategory_input7'] = Configuration::get('configcategory_input7');
				$helper->fields_value['configcategory_input8'] = Configuration::get('configcategory_input8');
				$helper->fields_value['configcategory_radio1'] = Configuration::get('configcategory_radio1');
				$helper->fields_value['configcategory_radio2'] = Configuration::get('configcategory_radio2');
				$helper->fields_value['configcategory_radio3'] = Configuration::get('configcategory_radio3');
				$helper->fields_value['configcategory_radio4'] = Configuration::get('configcategory_radio4');
				$helper->fields_value['configcategory_radio5'] = Configuration::get('configcategory_radio5');
				$helper->fields_value['configcategory_radio6'] = Configuration::get('configcategory_radio6');
				$helper->fields_value['configcategory_radio7'] = Configuration::get('configcategory_radio7');
				$helper->fields_value['configcategory_radio8'] = Configuration::get('configcategory_radio8');
				$helper->fields_value['configcategory_radio9'] = Configuration::get('configcategory_radio9');
				$helper->fields_value['configcategory_radio10'] = Configuration::get('configcategory_radio10');
				$helper->fields_value['configcategory_radio11'] = Configuration::get('configcategory_radio11');
				$helper->fields_value['configcategory_radio12'] = Configuration::get('configcategory_radio12');
				$helper->fields_value['configcategory_radio13'] = Configuration::get('configcategory_radio13');
				$helper->fields_value['configcategory_radio14'] = Configuration::get('configcategory_radio14');
				$helper->fields_value['configcategory_radio15'] = Configuration::get('configcategory_radio15');
				$helper->fields_value['configcategory_radio16'] = Configuration::get('configcategory_radio16');
				$helper->fields_value['configcategory_radio17'] = Configuration::get('configcategory_radio17');
				$helper->fields_value['configcategory_radio18'] = Configuration::get('configcategory_radio18');
				$helper->fields_value['configcategory_color1'] = Configuration::get('configcategory_color1');
				$helper->fields_value['configcategory_color2'] = Configuration::get('configcategory_color2'); 
				$helper->fields_value['configcategory_color3'] = Configuration::get('configcategory_color3'); 
				$helper->fields_value['configcategory_color4'] = Configuration::get('configcategory_color4'); 
				$helper->fields_value['configcategory_color5'] = Configuration::get('configcategory_color5'); 
				$helper->fields_value['configcategory_color6'] = Configuration::get('configcategory_color6'); 
				$helper->fields_value['configcategory_color7'] = Configuration::get('configcategory_color7'); 
				$helper->fields_value['configcategory_color8'] = Configuration::get('configcategory_color8'); 
				$helper->fields_value['configcategory_color9'] = Configuration::get('configcategory_color9'); 
				$helper->fields_value['configcategory_color10'] = Configuration::get('configcategory_color10');  
				   
				return  $helper->generateForm(array($fields_form, $fields_form3, $fields_form2, $fields_form4 ));
	}
			
					public function getConfigFieldsValues()
	{
		return array(
			'configcategory_input1' => Tools::getValue('configcategory_input1', Configuration::get('configcategory_input1')),
			'configcategory_input2' => Tools::getValue('configcategory_input2', Configuration::get('configcategory_input2')),
			'configcategory_input3' => Tools::getValue('configcategory_input3', Configuration::get('configcategory_input3')),
			'configcategory_input4' => Tools::getValue('configcategory_input4', Configuration::get('configcategory_input4')),
			'configcategory_input5' => Tools::getValue('configcategory_input5', Configuration::get('configcategory_input5')),
			'configcategory_input6' => Tools::getValue('configcategory_input6', Configuration::get('configcategory_input6')),
			'configcategory_input7' => Tools::getValue('configcategory_input7', Configuration::get('configcategory_input7')),
			'configcategory_input8' => Tools::getValue('configcategory_input8', Configuration::get('configcategory_input8')),
			'configcategory_radio1' => Tools::getValue('configcategory_radio1', Configuration::get('configcategory_radio1')),
			'configcategory_radio2' => Tools::getValue('configcategory_radio2', Configuration::get('configcategory_radio2')),
			'configcategory_radio3' => Tools::getValue('configcategory_radio3', Configuration::get('configcategory_radio3')),
			'configcategory_radio4' => Tools::getValue('configcategory_radio4', Configuration::get('configcategory_radio4')),
			'configcategory_radio5' => Tools::getValue('configcategory_radio5', Configuration::get('configcategory_radio5')),
			'configcategory_radio6' => Tools::getValue('configcategory_radio6', Configuration::get('configcategory_radio6')),
			'configcategory_radio7' => Tools::getValue('configcategory_radio7', Configuration::get('configcategory_radio7')),
			'configcategory_radio8' => Tools::getValue('configcategory_radio8', Configuration::get('configcategory_radio8')),
			'configcategory_radio9' => Tools::getValue('configcategory_radio9', Configuration::get('configcategory_radio9')),
			'configcategory_radio10' => Tools::getValue('configcategory_radio10', Configuration::get('configcategory_radio10')),
			'configcategory_radio11' => Tools::getValue('configcategory_radio11', Configuration::get('configcategory_radio11')),
			'configcategory_radio12' => Tools::getValue('configcategory_radio12', Configuration::get('configcategory_radio12')),
			'configcategory_radio13' => Tools::getValue('configcategory_radio13', Configuration::get('configcategory_radio13')),
			'configcategory_radio14' => Tools::getValue('configcategory_radio14', Configuration::get('configcategory_radio14')),
			'configcategory_radio15' => Tools::getValue('configcategory_radio15', Configuration::get('configcategory_radio15')),
			'configcategory_radio16' => Tools::getValue('configcategory_radio16', Configuration::get('configcategory_radio16')),
			'configcategory_radio17' => Tools::getValue('configcategory_radio17', Configuration::get('configcategory_radio17')),
			'configcategory_radio18' => Tools::getValue('configcategory_radio18', Configuration::get('configcategory_radio18')),
			'configcategory_color1' => Tools::getValue('configcategory_color1', Configuration::get('configcategory_color1')),
			'configcategory_color2' => Tools::getValue('configcategory_color2', Configuration::get('configcategory_color2')),
			'configcategory_color3' => Tools::getValue('configcategory_color3', Configuration::get('configcategory_color3')),
			'configcategory_color4' => Tools::getValue('configcategory_color4', Configuration::get('configcategory_color4')),
			'configcategory_color5' => Tools::getValue('configcategory_color5', Configuration::get('configcategory_color5')),
			'configcategory_color6' => Tools::getValue('configcategory_color6', Configuration::get('configcategory_color6')),
			'configcategory_color7' => Tools::getValue('configcategory_color7', Configuration::get('configcategory_color7')),
			'configcategory_color8' => Tools::getValue('configcategory_color8', Configuration::get('configcategory_color8')),
			'configcategory_color9' => Tools::getValue('configcategory_color9', Configuration::get('configcategory_color9')),
			'configcategory_color10' => Tools::getValue('configcategory_color10', Configuration::get('configcategory_color10'))
		);
	}
			
			// Display module
			public function hookDisplayHome($params)
				{			
				  $shop_id = (int)$this->context->shop->id;
				  $id_customer = (int)$params['cookie']->id_customer;
				  $id_group = $id_customer ? Customer::getDefaultGroupId($id_customer) : _PS_DEFAULT_CUSTOMER_GROUP_;
				  $id_lang = (int)$params['cookie']->id_lang;

				  /*** OLD clause where
					WHERE level_depth > 1 And level_depth < 3
					ADD INNER JOIN `'._DB_PREFIX_.'category` cc
				  ***/

				  $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('
				  SELECT DISTINCT c.*, cl.*
				  FROM `'._DB_PREFIX_.'category` c
				  LEFT JOIN `'._DB_PREFIX_.'category_lang` cl ON (c.`id_category` = cl.`id_category` AND `id_lang` = '.$id_lang.')
				  LEFT JOIN `'._DB_PREFIX_.'category_group` cg ON (cg.`id_category` = c.`id_category`)
				  LEFT JOIN `'._DB_PREFIX_.'category_shop` cs ON (cs.`id_category` = c.`id_category`)
				  INNER JOIN `'._DB_PREFIX_.'category` cc ON (cc.`id_category` = c.`id_parent` AND cc.`id_parent` = 3)
				  WHERE c.`level_depth` = 4
				  AND c.`active` = 1
				  AND cg.`id_group` = '.$id_group.'
				  GROUP BY c.`id_category` 
				  ORDER BY `level_depth` ASC, cs.`position` ASC');
				  $category = new Category(1);
				  $res = array();
				  
				  foreach ($result as $key => $value) 
				  	$res[$value['id_category']] = $value;

                    $this->context->smarty->assign(array(
						  'category' => $category,
						  'categories' => $result, Category::getRootCategories(intval($params['cookie']->id_lang), true)));

						   $this->context->smarty->assign(array(
						   'lang' => Language::getIsoById(intval($params['cookie']->id_lang)),
				 		  'proconfigcategoryinput1' => Configuration::get('configcategory_input1'),
						  'proconfigcategoryinput2' => Configuration::get('configcategory_input2'),
						  'proconfigcategoryinput3' => Configuration::get('configcategory_input3'),
						  'proconfigcategoryinput4' => Configuration::get('configcategory_input4'),
						  'proconfigcategoryinput5' => Configuration::get('configcategory_input5'),
						  'proconfigcategoryinput6' => Configuration::get('configcategory_input6'),
						  'proconfigcategoryinput7' => Configuration::get('configcategory_input7'),
						  'proconfigcategoryinput8' => Configuration::get('configcategory_input8'),
						  'proconfigcategoryradio1' => Configuration::get('configcategory_radio1'),
						  'proconfigcategoryradio2' => Configuration::get('configcategory_radio2'),
						  'proconfigcategoryradio3' => Configuration::get('configcategory_radio3'),
						  'proconfigcategoryradio4' => Configuration::get('configcategory_radio4'),
						  'proconfigcategoryradio5' => Configuration::get('configcategory_radio5'),
						  'proconfigcategoryradio6' => Configuration::get('configcategory_radio6'),
						  'proconfigcategoryradio7' => Configuration::get('configcategory_radio7'),
						  'proconfigcategoryradio8' => Configuration::get('configcategory_radio8'),
						  'proconfigcategoryradio9' => Configuration::get('configcategory_radio9'),
						  'proconfigcategoryradio10' => Configuration::get('configcategory_radio10'),
						  'proconfigcategoryradio11' => Configuration::get('configcategory_radio11'),
						  'proconfigcategoryradio12' => Configuration::get('configcategory_radio12'),
						  'proconfigcategoryradio13' => Configuration::get('configcategory_radio13'),
						  'proconfigcategoryradio14' => Configuration::get('configcategory_radio14'),
						  'proconfigcategoryradio15' => Configuration::get('configcategory_radio15'),
						  'proconfigcategoryradio16' => Configuration::get('configcategory_radio16'),
						  'proconfigcategoryradio17' => Configuration::get('configcategory_radio17'),
						  'proconfigcategoryradio18' => Configuration::get('configcategory_radio18'),
						  'proconfigcategorycolor1' => Configuration::get('configcategory_color1'),
						  'proconfigcategorycolor2' => Configuration::get('configcategory_color2'),
						  'proconfigcategorycolor3' => Configuration::get('configcategory_color3'),
						  'proconfigcategorycolor4' => Configuration::get('configcategory_color4'),
						  'proconfigcategorycolor5' => Configuration::get('configcategory_color5'),
						  'proconfigcategorycolor6' => Configuration::get('configcategory_color6'),
						  'proconfigcategorycolor7' => Configuration::get('configcategory_color7'),
						  'proconfigcategorycolor8' => Configuration::get('configcategory_color8'),
						  'proconfigcategorycolor9' => Configuration::get('configcategory_color9'),
						  'proconfigcategorycolor10' => Configuration::get('configcategory_color10')
 					  ));
				  	 return $this->display(__FILE__, 'procategory.tpl');
					 
				}
				public function hookCustomSliderCollections($params)
				{
				  return $this->hookDisplayHome($params);
				}
				
				public function hookDisplayRightColumn($params)
				{
				  return $this->hookDisplayHome($params);
				}
				public function hookDisplayLeftColumn($params)
				{
				  return $this->hookDisplayHome($params);
				}
				public function hookdisplayHomeTabContent($params)
		{
			return $this->hookDisplayHome($params);
		}
		public function hookDisplayFooter($params)
					{
						return $this->hookDisplayHome($params);
					}
					
				public function hookProductFooter($params)
					{
						return $this->hookDisplayHome($params);
					}
				public function hookDisplayHeader()
					{
					  $this->context->controller->addCSS($this->_path.'css/procategory.css', 'all');
					  $this->context->controller->addJS(($this->_path).'js/procategory-script.js');
					}  
}
?>