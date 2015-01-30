<?php
/**
 * Created by PhpStorm.
 * User: decebal
 * Date: 28.01.2015
 * Time: 23:02
 */

namespace app\Models;


class Vendor extends \ArrayObject
{
    private $data = array();

    public function __construct($initialData = array()) {
        $this->data = $initialData;
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value) {
        if (is_null($offset)) {
            $this->data[] = $value;
        } else {
            $this->data[$offset] = $value;
        }
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset) {
        return isset($this->data[$offset]);
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset) {
        unset($this->data[$offset]);
    }

    /**
     * @param mixed $offset
     * @return null
     */
    public function offsetGet($offset) {
        return isset($this->data[$offset]) ? $this->data[$offset] : null;
    }

    /**
     *
     */
    public function getById()
    {

    }
}