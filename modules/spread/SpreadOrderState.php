<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of OrderState
 *
 * @author Aurélien
 */
class SpreadOrderState {

    static $order_states = array(
        999 => '- Do not send order -',
        50 => 'Complete',
        20 => 'Processing',
        0 => 'Cancel',
        10 => 'New'
    );

    const SPREAD_UNDEFINED_ORDER_STATE = 999;

    public static function getOrderStates() {
        return self::$order_states;
    }

    public static function save($id_order_state, $spread_order_state) {
        if ($spread_order_state == self::SPREAD_UNDEFINED_ORDER_STATE) {
            return Db::getInstance()
                    ->execute('DELETE FROM '._DB_PREFIX_.'spread_order_state WHERE id_order_state='.$id_order_state);
        } else {
            return Db::getInstance()
                            ->execute('INSERT INTO ' . _DB_PREFIX_ . 'spread_order_state (id_order_state, spread_order_state) VALUES (' . $id_order_state . ', ' . $spread_order_state . ') ON DUPLICATE KEY UPDATE spread_order_state=' . $spread_order_state);
        }
    }

    public static function getSpreadOrderStateByIdOrderState($id_order_state) {
        $value = Db::getInstance()
                ->getValue('SELECT spread_order_state FROM ' . _DB_PREFIX_ . 'spread_order_state WHERE id_order_state=' . $id_order_state);
        return $value;
    }

    public static function getSpreadOrderStateAvailable()
    {
        return array(0,10,20,50);
    }

}
