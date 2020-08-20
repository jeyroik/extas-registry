<?php
namespace extas\interfaces\stages;

use extas\interfaces\registry\IRegistryPackage;
use extas\interfaces\samples\parameters\ISampleParameter;

/**
 * Interface IStageRegistryResponseParameter
 *
 * @package extas\interfaces\stages
 * @author jeyroik <jeyroik@gmail.com>
 */
interface IStageRegistryResponseParameter
{
    public const NAME = 'extas.registry.response.parameter';

    /**
     * @param IRegistryPackage $package
     * @param ISampleParameter $parameter
     * @return ISampleParameter
     */
    public function __invoke(IRegistryPackage $package, ISampleParameter $parameter): ISampleParameter;
}
