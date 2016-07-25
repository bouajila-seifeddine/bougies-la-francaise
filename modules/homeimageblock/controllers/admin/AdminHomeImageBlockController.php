<?php

/**
 * Description of HomeImageBlock
 *
 * @author olivier
 */
class AdminHomeImageBlockController extends ModuleAdminController {
    
    /**
	 * AdminController::__construct() override
	 * @see AdminController::__construct()
	 */
    public function __construct() {
 
        $this->table = 'home_image_block';
        $this->lang = true;
        $this->className = 'HomeImageBlockObject';
        $this->identifier = 'id_home_image_block';
        $this->context = Context::getContext();
        //$this->multishop_context = Shop::CONTEXT_ALL;
        
        $this->_defaultOrderBy = 'position';
        $this->position_identifier = 'id_home_image_block';
        
        $this->fields_list = array(
			'id_home_image_block' => array(
				'title'   => $this->l('Ref image'),
                'width' => 50,
			), 
            'image' => array(
                'title' => $this->l('Image'), 
                'width' => 150, 
                'align' => 'center', 
                'image' => 'home_image_block', 
                'orderby' => false, 
                'search' => false,
                'value' => true
            ),
			'title' => array(
				'title' 	=> $this->l('Title'),
			), 
            'url' => array(
				'title' 	=> $this->l('Url'),
			), 
            'position' => array(
                'title' => $this->l('Position'),
                'width' => 40,
                'filter_key' => 'a!position',
                'position' => 'position'
            ),
			'active' => array(
				'title' 	=> $this->l('Status'),
				'active' 	=> 'status',
                'width' => 50,
			)
		);
 
        // This adds a multiple deletion button
        $this->bulk_actions = array(
            'delete' => array(
                'text' => $this->l('Delete selected'),
                'confirm' => $this->l('Delete selected items?')
            ),
            'enableSelection' => array('text' => $this->l('Enable selection')),
			'disableSelection' => array('text' => $this->l('Disable selection')),
        );
        
        $this->fieldImageSettings = array('name' => 'image', 'dir' => 'home_image_block');
        
        /*$this->fields_options = array(
            'general' => array(
                'title' => $this->l('General option'), 
                'image' => _MODULE_DIR_.'homeimageblock/img/admin/logo.png',
                'fields' => array(
                    'IMAGE_BLOCK_LEFT_MARGIN' => array(
                        'title' => $this->l('Left Margin'),
                        'desc' => $this->l('Define the left margin between image'),
                        'type' => 'text',
                        'cast' => 'intval',
                        'suffix' => 'px',
                    ),
                    'IMAGE_BLOCK_BOTTOM_MARGIN' => array(
                        'title' => $this->l('Bottom Margin'),
                        'desc' => $this->l('Define the bottom margin between image'),
                        'type' => 'text',
                        'cast' => 'intval',
                        'suffix' => 'px',
                    ),
                    'IMAGE_BLOCK_ANIMATE' => array(
                        'title' => $this->l('Animation on hover'),
                        'desc' => $this->l('Define an animation on image hover'),
                        'validation' => 'isBool',
						'cast' => 'intval',
						'type' => 'bool'
                    ),
                    'IMAGE_BLOCK_ANIMATE_PX' => array(
                        'title' => $this->l('Animation px on hover'),
                        'desc' => $this->l('Define the number of pixel when animation on hover is activated'),
                        'suffix' => 'px',
						'cast' => 'intval',
						'type' => 'text'
                    )
                ),
                'submit' => array()
            )
        );*/
        
        parent:: __construct();
    }

    
    /*
     *  This method generates the list of results for ImageBlock Object
     */
    public function renderList()
    {
        Shop::addTableAssociation($this->table, array('type' => 'shop'));       //Add this line to display only content associated to selected shop in admin
        
        // Adds an Edit button for each result
        $this->addRowAction('edit');
  
        // Adds a Delete button for each result
        $this->addRowAction('delete');

        return parent::renderList();
    }
    
    /* 
     * This method generates the Add/Edit form for ImageBlock Object
     */
    public function renderForm()
    {
        // Building the Add/Edit form
        $this->fields_form = array(
            'legend' => array(
                'title' => $this->l('Image Block'),
                'image' => _MODULE_DIR_.'homeimageblock/img/admin/logo.png'
            ),
            'input' => array(
                array(
                    'type' => 'text',
                    'label' => $this->l('Title'),
                    'name' => 'title',
                    'required' => true,
                    'lang' => true,
                    'size' => 33,
                    'desc' => $this->l("This field will never display. It's only a field to retrieve the image in back office"),
                    'empty_message' => $this->l('This field is required'),
                ),
                array(
                    'type' => 'textarea',
                    'label' => $this->l('Description'),
                    'name' => 'description',
                    'required' => false,
                    'lang' => true,
                    'rows' => 3,
                    'cols' => 75,
                    'desc' => $this->l("This field will never display. It's only a field to describe the image in back office"),
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Url'),
                    'name' => 'url',
                    'required' => false,
                    'lang' => true,
                    'size' => 33,
                    'desc' => $this->l("This field isn't required. If set, the image click redirect to this link"),
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Legend'),
                    'name' => 'legend',
                    'required' => true,
                    'lang' => true,
                    'size' => 33,
                    'desc' => $this->l("This field display in link title attribute"),
                    'empty_message' => $this->l('This field is required'),
                ),
                array(
					'type' => 'file',
					'label' => $this->l('Image'),
					'name' => 'image',
                    'required' => true,
					'display_image' => true,
                    'lang' => true,
					'desc' => $this->l('Upload an image'),
                    'empty_message' => $this->l('This field is required'),
				),
                array(
                    'type' => 'radio',
                    'label' => $this->l('Status'),
                    'name' => 'active',
                    'class' => 't',
                    'required' => true,
                    'empty_message' => $this->l('This field is required'),
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
                    ),
                    'is_bool'   => true
                )
            ),
            'submit' => array(
                'title' => $this->l('Save'),
                'class' => 'button',
            )
        );
        
        if (Shop::isFeatureActive())
		{
			$this->fields_form['input'][] = array(
				'type' => 'shop',
				'label' => $this->l('Shop association:'),
				'name' => 'checkBoxShopAsso',
			);
		}
        
        return parent::renderForm();
    }
    
    
    protected function uploadImage($id, $name, $dir, $ext = false, $width = null, $height = null)
	{
        $languages = Language::getLanguages(false);
        $res = true;
        
        foreach($languages as $language) {
            $newName = $name."_".$language['id_lang'];
            $newId = $id.'_'.$language['id_lang'];
            
            if (file_exists(_PS_TMP_IMG_DIR_.$this->table.'_'.$id."_".$language['id_lang'].'.'.$this->imageType)
				&& !unlink(_PS_TMP_IMG_DIR_.$this->table.'_'.$id."_".$language['id_lang'].'.'.$this->imageType))
				return false;
			if (file_exists(_PS_TMP_IMG_DIR_.$this->table.'_mini_'.$id."_".$language['id_lang'].'.'.$this->imageType)
				&& !unlink(_PS_TMP_IMG_DIR_.$this->table.'_mini_'.$id."_".$language['id_lang'].'.'.$this->imageType))
				return false;
            
            $res = parent::uploadImage($newId, $newName, $dir, $ext, $width, $height);
        }
        $res .= copy(_PS_IMG_DIR_.$dir.$id."_".$languages[0]['id_lang'].'.'.$this->imageType, _PS_IMG_DIR_.$dir.$id.'.'.$this->imageType);

        return $res;
	}
}
