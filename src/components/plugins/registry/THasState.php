<?php
namespace extas\components\plugins\registry;

/**
 * Trait THasState
 *
 * @package extas\components\plugins\registry
 * @author jeyroik <jeyroik@gmail.com>
 */
trait THasState
{
    /**
     * @param $value
     * @return string
     */
    public function getState($value): string
    {
        return $value ? 'yes' : 'no';
    }
}
