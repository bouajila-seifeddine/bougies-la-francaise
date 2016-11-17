<?php

class AdminController extends AdminControllerCore
{
	/**
     * @return string|void
     */
    public function addFiltersToBreadcrumbs()
    {
        if ($this->filter && is_array($this->fields_list)) {
            $filters = array();

            foreach ($this->fields_list as $field => $t) {
                if (isset($t['filter_key'])) {
                    $field = $t['filter_key'];
                }

                if (($val = Tools::getValue($this->table.'Filter_'.$field)) || $val = $this->context->cookie->{$this->getCookieFilterPrefix().$this->table.'Filter_'.$field}) 
                {
                    if (@unserialize($val) !== false)
                        $val = Tools::unSerialize($val);

                    if (!is_array($val)) {
                        $filter_value = '';
                        if (isset($t['type']) && $t['type'] == 'bool') {
                            $filter_value = ((bool)$val) ? $this->l('yes') : $this->l('no');
                        } elseif (is_string($val)) {
                            $filter_value = htmlspecialchars($val, ENT_QUOTES, 'UTF-8');
                        }
                        if (!empty($filter_value)) {
                            $filters[] = sprintf($this->l('%s: %s'), $t['title'], $filter_value);
                        }
                    } else {
                        $filter_value = '';
                        foreach ($val as $v) {
                            if (is_string($v) && !empty($v)) {
                                $filter_value .= ' - '.htmlspecialchars($v, ENT_QUOTES, 'UTF-8');
                            }
                        }
                        $filter_value = ltrim($filter_value, ' -');
                        if (!empty($filter_value)) {
                            $filters[] = sprintf($this->l('%s: %s'), $t['title'], $filter_value);
                        }
                    }
                }
            }

            if (count($filters)) {
                return sprintf($this->l('filter by %s'), implode(', ', $filters));
            }
        }
    }
}