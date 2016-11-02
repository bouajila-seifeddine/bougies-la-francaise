<?php

class CompareController extends CompareControllerCore
{
	public function initContent()
	{
		if (Tools::getValue('ajax'))
			return;
		parent::initContent();

		//Clean compare product table
		CompareProduct::cleanCompareProducts('week');

		$hasProduct = false;

		if (!Configuration::get('PS_COMPARATOR_MAX_ITEM'))
			return Tools::redirect('index.php?controller=404');

		$ids = null;
		if (($product_list = Tools::getValue('compare_product_list')) && ($postProducts = (isset($product_list) ? rtrim($product_list, '|') : '')))
			$ids = array_unique(explode('|', $postProducts));
		elseif (isset($this->context->cookie->id_compare))
		{
			$ids = CompareProduct::getCompareProducts($this->context->cookie->id_compare);
			if (count($ids))
				Tools::redirect($this->context->link->getPageLink('products-comparison', null, $this->context->language->id, array('compare_product_list' => implode('|', $ids))));
		}

		if ($ids)
		{
			if (count($ids) > 0)
			{
				if (count($ids) > Configuration::get('PS_COMPARATOR_MAX_ITEM'))
					$ids = array_slice($ids, 0, Configuration::get('PS_COMPARATOR_MAX_ITEM'));

				$listProducts = array();
				$listFeatures = array();

				foreach ($ids as $k => &$id)
				{
					$curProduct = new Product((int)$id, true, $this->context->language->id);
					if (!Validate::isLoadedObject($curProduct) || !$curProduct->active || !$curProduct->isAssociatedToShop())
					{
						if (isset($this->context->cookie->id_compare))
							CompareProduct::removeCompareProduct($this->context->cookie->id_compare, $id);
						unset($ids[$k]);
						continue;
					}

					foreach ($curProduct->getFrontFeatures($this->context->language->id) as $feature) {
						if(isset($listFeatures[$curProduct->id][$feature['id_feature']]) && $listFeatures[$curProduct->id][$feature['id_feature']])
							$listFeatures[$curProduct->id][$feature['id_feature']] .= ', '.$feature['value'];
						else
							$listFeatures[$curProduct->id][$feature['id_feature']] = $feature['value'];
					}


					$cover = Product::getCover((int)$id);

					$curProduct->id_image = Tools::htmlentitiesUTF8(Product::defineProductImage(array('id_image' => $cover['id_image'], 'id_product' => $id), $this->context->language->id));
					$curProduct->allow_oosp = Product::isAvailableWhenOutOfStock($curProduct->out_of_stock);
					$listProducts[] = $curProduct;
				}

				if (count($listProducts) > 0)
				{
					$width = 80 / count($listProducts);

					$hasProduct = true;
					$ordered_features = Feature::getFeaturesForComparison($ids, $this->context->language->id);
					$this->context->smarty->assign(array(
						'ordered_features' => $ordered_features,
						'product_features' => $listFeatures,
						'products' => $listProducts,
						'width' => $width,
						'HOOK_COMPARE_EXTRA_INFORMATION' => Hook::exec('displayCompareExtraInformation', array('list_ids_product' => $ids)),
						'HOOK_EXTRA_PRODUCT_COMPARISON' => Hook::exec('displayProductComparison', array('list_ids_product' => $ids)),
						'homeSize' => Image::getSize(ImageType::getFormatedName('home'))
					));
				}
				elseif (isset($this->context->cookie->id_compare))
				{
					$object = new CompareProduct((int)$this->context->cookie->id_compare);
					if (Validate::isLoadedObject($object))
					  $object->delete();
				}
			}
		}
		$this->context->smarty->assign('hasProduct', $hasProduct);

		$this->setTemplate(_PS_THEME_DIR_.'products-comparison.tpl');
	}
	
}