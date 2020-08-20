<?php
namespace extas\components\plugins\registry;

/**
 * Trait THasColor
 *
 * @package extas\components\plugins\registry
 * @author jeyroik <jeyroik@gmail.com>
 */
trait THasColor
{
    /**
     * @param $value
     * @return string
     */
    public function getColor($value): string
    {
        return $value ? 'red' : 'green';
    }
}
