<?php
namespace extas\interfaces\registry;

use extas\interfaces\IHasDescription;
use extas\interfaces\IHasName;
use extas\interfaces\IItem;
use extas\interfaces\samples\parameters\IHasSampleParameters;

/**
 * Interface IRegistryPackage
 *
 * @package extas\interfaces\registry
 * @author jeyroik <jeyroik@gmail.com>
 */
interface IRegistryPackage extends IItem, IHasDescription, IHasName, IHasSampleParameters
{
    public const SUBJECT = 'extas.registry.package';
}
