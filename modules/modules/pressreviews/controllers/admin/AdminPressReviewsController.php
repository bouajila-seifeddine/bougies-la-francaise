<?php

define('_PS_PR_THUMB_IMG_DIR_', _PS_IMG_DIR_.'pr/thumb/');
define('_PS_PR_BIG_IMG_DIR_', _PS_IMG_DIR_.'pr/big/');


class AdminPressReviewsController extends ModuleAdminController {

	protected $_pressreviews = null;
	protected $position_identifier = 'id_pressreviews';

    public function __construct() {
    

        $this->table 		= 'pressreviews';
        $this->className 	= 'PrReviews';
        $this->lang 		= true;
        $this->explicitSelect = true;
        $this->deleted		= false;
        
        $this->addRowAction('edit');
		$this->addRowAction('delete');

		$this->_defaultOrderBy = 'position';
	
		$this->context = Context::getContext();
        
       	$this->fieldImageSettings = array(
       		array(
				'name' => 'thumb_img',
				'dir'  => 'pr/thumb'
			),
			array(
				'name' => 'big_img',
				'dir'  => 'pr/big'
			)	
		);	
        
        $this->fields_list = array(
			'id_pressreviews' => array(
				'title' 	=> '#',
				'width'		=> 40 
			), 
			'title' => array(
				'title' 	=> $this->l('Name'), 
			), 
			'type' => array(
				'title' 	=> $this->l('Type'),
				'width'		=> 60
			),
			'creation_date' => array(
				'title' 	=> $this->l('Creation date'),
				'width'		=> 120,
				'align' => 'center',
			),
			'position' => array(
				'title' 	=> $this->l('Position'),
				'width'		=> 40,
				'align' => 'center',
				'position' => 'position'
			),
			'active' => array(
				'title' 	=> $this->l('Enabled'),
				'active' 	=> 'status',
				'width'		=> 40,
				'align'		=> 'center',
				'type' => 'bool'
			)
		);

		$this->actions = array('edit', 'delete');

		$this->bulk_actions = array('delete' => array('text' => $this->l('Delete selected')));
		
		parent::__construct();
    }
    
    public function init()
    {
    		parent::init();
    }
    
    
    public function initProcess()
	{
		parent::initProcess();
	}
	
	public function renderList() {
		$base = ((Configuration::get('PS_SSL_ENABLED') == 1) ? _PS_BASE_URL_SSL_ : _PS_BASE_URL_);
		$metas = new Meta();
		$seo_url = $metas->getMetaByPage('module-pressreviews-default', $this->context->language->id);

		$this->displayInformation(
		'<b>'.$this->l('Informations').'</b>
			<br />
			<ul>
				<li>&nbsp;</li>
				<li>'.$this->l('The gallery is available here:').' '.$base.__PS_BASE_URI__.$this->context->language->iso_code.'/'.$seo_url['url_rewrite'].'</li>
				<li>&nbsp;</li>
				<li>
					<a href="'.(($this->context->language->iso_code == 'fr') ? __PS_BASE_URI__.'modules/pressreviews/docs/readme_fr.pdf' : __PS_BASE_URI__.'modules/pressreviews/docs/readme_en.pdf').'" target="_blank">'.$this->l('Click here to see the documentation').'</a>
				</li>
			</ul>');
		
		return parent::renderList();
	}
    
    public function renderForm()
	{
		$this->fields_form = array(
			'legend' => array(
				'title' => $this->l('Add an item'),
				'image' => '../modules/pressreviews/img/add.png',
			),
			'input' => array(
					array(
					  'type'       => 'text',
					  'label'    	=> $this->l('Title'),
					  'name'       => 'title',
					  'size'       => 100,
					  'required' 	=> true,
					  'hint'       => $this->l('Invalid characters:').' <>;=#{}',
					  'desc'       => $this->l('Title of the item'),
					  'lang'		=> true,
					),
				    array(
				        'type' => 'select',
				        'label' => $this->l('Type of the element'),
				        'name' => 'type',
				        'options' => array(
				        	'query' => array(
				        				array(
				        					'id' => 'lightbox', 
				        					'name' => $this->l('Lightbox effect')
				        				),
				        				array(
				        					'id' => 'link', 
				        					'name' => $this->l('Link')
				        				)
				        			),
				        	'id' => 'id',
				        	'name' => 'name'
				        ),
				        'onchange'	=> "showInputs();"
				    ),
				    array(
				        'type' => 'thumb_img',
				        'label' => $this->l('Thumbnail image'),
				        'name' => 'thumb_img',
				        'required' => false,
				        'display_image' => true,
				        'desc' => $this->l('Upload an image from your computer').' (.gif, .jpg, .jpeg '.$this->l('or').' .png)',
				    ),
				    array(
				      'type'       => 'text',
				      'label'    	=> $this->l('Thumbnail description'),
				      'name'       => 'thumb_txt',
				      'size'       => 100,
				      'required' 	=> false,
				      'hint'       => $this->l('Invalid characters:').' <>;=#{}',
				      'desc'       => $this->l('Thumbnail description'),
				      'lang'		=> true,
				    ),
				    array(
				        'type' => 'big_img',
				        'label' => $this->l('Full size image'),
				        'name' => 'big_img',
				        'classTop' => 'big_img',
				        'display_image' => true,
				        'desc' => $this->l('Upload an image from your computer').' (.gif, .jpg, .jpeg '.$this->l('or').' .png)',
				        'required' => false,
				    ),
				    array(
				      'type'       => 'text',
				      'label'    	=> $this->l('Big image description'),
				      'name'       => 'big_txt',
				      'classTop'	=> 'big_txt',
				      'size'       => 100,
				      'required' 	=> false,
				      'hint'       => $this->l('Invalid characters:').' <>;=#{}"',
				      'desc'       => $this->l('Big image description'),
				      'lang'		=> true,
				    ),
				    array(
				      'type'       => 'text',
				      'label'    	=> $this->l('Link'),
				      'name'       => 'link',
				      'classTop'		=> 'link',
				      'size'       => 100,
				      'required' 	=> false,
				      'desc'       => $this->l('Link to the article.'),
				      'lang'		=> true,
				    ),
				    array(
				      'type'       => 'date',
				      'label'    	=> $this->l('Creation date'),
				      'name'       => 'creation_date',
				      'class'		=> 'datetime',
				      'size'       => 50,
				      'required' 	=> false,
				      'desc'       => $this->l('Creation date.'),
				      'empty_message'	=> 'Ok',
				      'lang'		=> false,
				    ),
				    array(
				      'type'       => 'radio',
				      'label'    	=> $this->l('Active'),
				      'name'       => 'active',
				      'required'	=> false,
				      'class' => 't',
				      'is_bool' => true,
				      'desc'       => $this->l('Link to the article.'),
				      'values' => array(   
				              array(
				                'id' => 'active_on',
				                'value' => 1,
				                'label' => $this->l('Enabled'),
				              ),
				              array(
				                'id' => 'active_off',
				                'value' => 0,
				                'label' => $this->l('Disabled')
				              )
				         )
				    )
				)
		);
		
		$this->fields_form['submit'] = array(
			'title' => $this->l('   Save   '),
			'class' => 'button'
		);
		
		if (!($obj = $this->loadObject(true)))
					return;

		$this->getFieldsValues($obj);
		return parent::renderForm();
	}
	
	public function postProcess()
	{
		$context = Context::getContext();
		
		$d = str_replace(array("/", "."), "-", Tools::getValue('creation_date'));
		$dt = str_replace(array("/", "."), "-", $context->language->date_format_lite); 
		$da = explode(" ", $d);
		$daa = explode("-", $da[0]);
		$db = explode("-", $dt);
		$dc = array($db[0] => $daa[0], $db[1] => $daa[1], $db[2] => $daa[2]);
		$_POST['creation_date'] = $dc['Y'].'-'.$dc['m'].'-'.$dc['d'].' '.$da[1];
		parent::postProcess();
	}
	
	/**
	* Retrieve field values when edit an object
	**/
	public function getFieldsValues($obj)
	{
		$this->context->controller->getLanguages();
		foreach ($this->context->controller->_languages as $language)
		{
			$this->fields_value['title'][$language['id_lang']] = $obj->title[$language['id_lang']];
			
			$this->fields_value['thumb_txt'][$language['id_lang']] = $obj->thumb_txt[$language['id_lang']];
				
			$this->fields_value['big_txt'][$language['id_lang']] = $obj->big_txt[$language['id_lang']];
				
			$this->fields_value['link'][$language['id_lang']] = $obj->link[$language['id_lang']];
		}
		
		$this->fields_value['id_pressreviews'] = $obj->id;

		$this->fields_value['element_type'] = $obj->type;
		
		$image_big = ImageManager::thumbnail(_PS_PR_BIG_IMG_DIR_.$obj->id_pressreviews.'.jpg', $this->table.'_'.(int)$obj->id_pressreviews.'-big.'.$this->imageType, 150, $this->imageType, true);
		$image_thumb = ImageManager::thumbnail(_PS_PR_THUMB_IMG_DIR_.$obj->id_pressreviews.'.jpg', $this->table.'_'.(int)$obj->id_pressreviews.'-thumb.'.$this->imageType, 150, $this->imageType, true);
		
		$this->fields_value = array(
			'big_img' => $image_big ? $image_big : false,
			'big_img_size' => $image_big ? filesize(_PS_PR_BIG_IMG_DIR_.'/'.$obj->id.'.jpg') / 1000 : false,
			'thumb_img' => $image_thumb ? $image_thumb : false,
			'thumb_img_size' => $image_thumb ? filesize(_PS_PR_THUMB_IMG_DIR_.'/'.$obj->id.'.jpg') / 1000 : false
		);
		
		$this->fields_value['active'] = $obj->active;
		
		if (is_null($obj->creation_date) || $obj->creation_date == '0000-00-00 00:00:00') {
			$this->fields_value['creation_date'] = Tools::dateFormat(array('date' => date('Y-m-d H:i:s'), 'full' => true));	
		} else {
			$this->fields_value['creation_date'] = Tools::dateFormat(array('date' => $obj->creation_date, 'full' => true));
		}
	}	
	
	public function processAdd()
	{
		if (Tools::getValue('type') == 'link') {
			$this->context->controller->getLanguages();
			foreach ($this->context->controller->_languages as $language) {
				if (Tools::getValue('link_'.$language['id_lang'])) {
						Tools::strtolower(Tools::getValue('link_'.$language['id_lang']));
					
						if (strpos(Tools::getValue('link_'.$language['id_lang']), 'http://') === FALSE)
							$_POST['link_'.$language['id_lang']] = 'http://'.$_POST['link_'.$language['id_lang']];
					}
				}
		}
		
		$_POST['creation_date'] = date('Y-m-d H:i:s', strtotime(Tools::getValue('creation_date')));
		
		if(!PressReviews::setOnTop())
		{
			$object = parent::processAdd();
			$this->errors[] = Tools::displayError($this->l('Error on the new article position'));
		}
		else {
			$object = parent::processAdd();
		}
		
		if ($object)
			Tools::redirectAdmin(self::$currentIndex.'&conf=3&token='.$this->token);
		return $object;
	}
	
	public function processUpdate()
	{
		if (Tools::getValue('type') == 'link') {
			$this->context->controller->getLanguages();
			foreach ($this->context->controller->_languages as $language) {
				if (Tools::getValue('link_'.$language['id_lang'])) {
						Tools::strtolower(Tools::getValue('link_'.$language['id_lang']));
					
						if (strpos(Tools::getValue('link_'.$language['id_lang']), 'http://') === FALSE)
							$_POST['link_'.$language['id_lang']] = 'http://'.$_POST['link_'.$language['id_lang']];
					}
				}
		}
		
		$_POST['creation_date'] = date('Y-m-d H:i:s', strtotime($_POST['creation_date']));
		
		PrReviews::deleteTmpImages(Tools::getValue('id_'.$this->table));
		$object = parent::processUpdate();
		
		return $object;
	}
	
	public function processDelete()
	{
		$pressreviews = $this->loadObject();
		if ($this->tabAccess['delete'] === '1')
		{
			if (parent::processDelete())
			{
				PrReviews::cleanPositions();
				$pressreviews->deleteImages($pressreviews->id);
				Tools::redirectAdmin(self::$currentIndex.'&conf=7&token='.$this->token);
				return true;
			}
			else
				return false;
		}
		else
			$this->errors[] = Tools::displayError('You do not have permission to delete here.');
	}
	
	protected function processBulkDelete()
	{
		if ($this->tabAccess['delete'] === '1')
		{
			$pr_ids = array();
			foreach (Tools::getValue($this->table.'Box') as $id_pr)
			{
				PrReviews::deleteImages($id_pr);
			}
	
			if (parent::processBulkDelete())
			{
					return true;
			}
			else
				return false;
		}
		else
			$this->errors[] = Tools::displayError('You do not have permission to delete here.');
	}
	
	public function processDeleteImage()
	{			
		$id = (int)Tools::getValue('id_'.$this->table);
		if(Tools::getValue('img') == 'thumb_img')
		{
			$dir = _PS_PR_THUMB_IMG_DIR_;
			$imgType = 'thumb';
		}
		else if (Tools::getValue('img') == 'big_img')
		{
			$dir = _PS_PR_BIG_IMG_DIR_;
			$imgType = 'big';
		}
		
		if (!file_exists($dir.$id.'.jpg')) {
			$this->errors[] = Tools::displayError('Can\'t find the image.');
		}
		else
		{
			unlink($dir.$id.'.jpg');
			unlink(_PS_TMP_IMG_DIR_.$this->table.'_'.$id.'-'.$imgType.'.jpg');
			Tools::redirectAdmin(self::$currentIndex.'&id_'.$this->table.'='.$id.'&update'.$this->table.'&conf=7&token='.$this->token);
		}
	}
	
	protected function postImage($id)
	{
		$ret = parent::postImage($id);

		if (($id_pressreviews = (int)$id) &&
			isset($_FILES) && count($_FILES) && $_FILES['thumb_img']['name'] != null &&
			file_exists(_PS_PR_THUMB_IMG_DIR_.$id_pressreviews.'.jpg'))
		{
			if(!ImageManager::resize(
				_PS_PR_THUMB_IMG_DIR_.$id_pressreviews.'.jpg',
				_PS_PR_THUMB_IMG_DIR_.$id_pressreviews.'.jpg',
				(int)Configuration::get('PR_THUMB_WIDTH'), (int)Configuration::get('PR_THUMB_HEIGHT')
			))
			return false;
		}

		return $ret;
	}
	
	public function ajaxProcessUpdatePositions()
	{
		$way = (int)(Tools::getValue('way'));
		$id_pressreviews = (int)(Tools::getValue('id'));
		$positions = Tools::getValue($this->table);

		if (is_array($positions)) 
		{
			foreach ($positions as $position => $value)
			{
				$pos = explode('_', $value);

				if (isset($pos[2]) && (int)$pos[2] === $id_pressreviews)
				{
					if ($pressreviews = new PrReviews((int)$pos[2]))
						if (isset($position) && $pressreviews->updatePosition($way, $position))
							echo 'ok position '.(int)$position.' for carrier '.(int)$pos[1].'\r\n';
						else
							echo '{"hasError" : true, "errors" : "Can not update carrier '.(int)$id_pressreviews.' to position '.(int)$position.' "}';
					else
						echo '{"hasError" : true, "errors" : "This carrier ('.(int)$id_pressreviews.') can t be loaded"}';
	
					break;
				}
			}
		}
		else {
			$this->errors[] = $this->l('position not an array');	
		}
	}
	
	public function processPosition()
	{
		if ($this->tabAccess['edit'] !== '1')
			$this->errors[] = Tools::displayError('You do not have permission to edit here.');
		else if (!Validate::isLoadedObject($object = new PrReviews((int)Tools::getValue($this->identifier))))
			$this->errors[] = Tools::displayError('An error occurred while updating status for object.').' <b>'.
				$this->table.'</b> '.Tools::displayError('(cannot load object)');
		if (!$object->updatePosition((int)Tools::getValue('way'), (int)Tools::getValue('position')))
			$this->errors[] = Tools::displayError('Failed to update the position.');
		else
		{
			Tools::redirectAdmin(self::$currentIndex.'&'.$this->table.'Orderby=position&'.$this->table.'Orderway=asc&conf=5'.(($id_category = (int)Tools::getValue($this->identifier, Tools::getValue('id_category_parent', 1))) ? ('&'.$this->identifier.'='.$id_category) : '').'&token='.$this->token);
		}
	}
}

?>