<?php

class Purchase extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $user_id;

    /**
     *
     * @var integer
     */
    public $products;

    /**
     *
     * @var string
     */
    public $time;

    /**
     *
     * @var integer
     */
    public $price;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSource("'Purchase'");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'Purchase';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Purchase[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Purchase
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
