<?php
namespace extas\components\plugins\registry\parameters;

use extas\components\plugins\Plugin;
use extas\interfaces\registry\IRegistryPackage;
use extas\interfaces\samples\parameters\ISampleParameter;
use extas\interfaces\stages\IStageRegistryResponseParameter;

/**
 * Class PluginProvides
 *
 * @package extas\components\plugins\registry\parameters
 * @author jeyroik <jeyroik@gmail.com>
 */
class PluginProvides extends Plugin implements IStageRegistryResponseParameter
{
    /**
     * @param IRegistryPackage $package
     * @param ISampleParameter $parameter
     * @return ISampleParameter
     */
    public function __invoke(IRegistryPackage $package, ISampleParameter $parameter): ISampleParameter
    {
        $author = $package->getParameterValue('author', '');
        $extasPath = 'https://raw.githubusercontent.com/' . $author . '/' . $package->getName() . '/master/extas.json';
        $extas = file_get_contents($extasPath);

        if (!$extas) {
            return $parameter;
        }

        $decoded = json_decode($extas, true);
        $allowed = $parameter->getValue([]);

        $result = [];

        foreach ($allowed as $sectionName) {
            if (isset($decoded[$sectionName])) {
                $result[$sectionName] = $decoded[$sectionName];
            }
        }

        $parameter->setValue($result);

        return $parameter;
    }
}
