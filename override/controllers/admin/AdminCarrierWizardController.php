<?php

class AdminCarrierWizardController extends AdminCarrierWizardControllerCore 
{
	public function processRanges($id_carrier)
    {
        if (!$this->tabAccess['edit'] || !$this->tabAccess['add']) {
            $this->errors[] = Tools::displayError('You do not have permission to use this wizard.');
            return;
        }

        $carrier = new Carrier((int)$id_carrier);
        if (!Validate::isLoadedObject($carrier)) {
            return false;
        }

        $range_inf = Tools::getValue('range_inf');
        $range_sup = Tools::getValue('range_sup');
        $range_type = Tools::getValue('shipping_method');

        $fees = Tools::getValue('fees');

        $carrier->deleteDeliveryPrice($carrier->getRangeTable());
        if ($range_type != Carrier::SHIPPING_METHOD_FREE) {
            foreach ($range_inf as $key => $delimiter1) {
                if (!isset($range_sup[$key])) {
                    continue;
                }
                $add_range = true;
                if ($range_type == Carrier::SHIPPING_METHOD_WEIGHT) {
                    if (!RangeWeight::rangeExist((int)$carrier->id, (float)$delimiter1, (float)$range_sup[$key])) {
                        $range = new RangeWeight();
                    } else {
                        $range = new RangeWeight((int)$key);
                        $add_range = false;
                    }
                }

                if ($range_type == Carrier::SHIPPING_METHOD_PRICE) {
                    if (!RangePrice::rangeExist((int)$carrier->id, (float)$delimiter1, (float)$range_sup[$key])) {
                        $range = new RangePrice();
                    } else {
                        $range = new RangePrice((int)$key);
                        $add_range = false;
                    }
                }
                if ($add_range) {
                    $range->id_carrier = (int)$carrier->id;
                    $range->delimiter1 = (float)$delimiter1;
                    $range->delimiter2 = (float)$range_sup[$key];
                    $range->save();
                }

                if (!Validate::isLoadedObject($range)) {
                    return false;
                }
                $price_list = array();
                if (is_array($fees) && count($fees)) {
                    foreach ($fees as $id_zone => $fee) {
                        $price_list[] = array(
                            'id_range_price' => ($range_type == Carrier::SHIPPING_METHOD_PRICE ? (int)$range->id : null),
                            'id_range_weight' => ($range_type == Carrier::SHIPPING_METHOD_WEIGHT ? (int)$range->id : null),
                            'id_carrier' => (int)$carrier->id,
                            'id_zone' => (int)$id_zone,
                            'price' => isset($fee[$key]) ? (float)$fee[$key] : 0,
                        );
                    }
                }

                if (count($price_list) && !$carrier->addDeliveryPrice($price_list, true)) {
                    return false;
                }
            }
        }
        return true;
    }
}