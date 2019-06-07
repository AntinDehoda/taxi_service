<?php


namespace App\DBAL;


class EnumOrderStatus extends EnumType
{
    protected $name = 'orderstatus';
    protected $values = array('created', 'executed', 'completed', 'cancelled', 'updated');

    public static $static_name = 'orderStatus';
    public static $static_values = array('created', 'executed', 'completed', 'cancelled', 'updated');

    public function getValues()
    {
        return $this->values;
    }

}