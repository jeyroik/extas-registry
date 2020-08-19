<?php
namespace extas\components\registry;

use extas\components\Item;
use extas\components\samples\parameters\THasSampleParameters;
use extas\components\THasDescription;
use extas\components\THasName;
use extas\interfaces\registry\IRegistryPackage;

/**
 * Class RegistryPackage
 *
 * @package extas\components\registry
 * @author jeyroik <jeyroik@gmail.com>
 */
class RegistryPackage extends Item implements IRegistryPackage
{
    use THasName;
    use THasDescription;
    use THasSampleParameters;

    /**
     * @return string
     */
    protected function getSubjectForExtension(): string
    {
        return static::SUBJECT;
    }
}
