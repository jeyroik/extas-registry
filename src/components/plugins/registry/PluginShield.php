<?php
namespace extas\components\plugins\registry;

use extas\components\http\THasHttpIO;
use extas\components\plugins\Plugin;
use extas\interfaces\registry\IRegistryPackage;
use extas\interfaces\samples\parameters\ISampleParameter;
use extas\interfaces\stages\IStageRegistryResponse;
use Psr\Http\Message\ResponseInterface;

/**
 * Class PluginShield
 *
 * @package extas\components\plugins\registry
 * @author jeyroik <jeyroik@gmail.com>
 */
class PluginShield extends Plugin implements IStageRegistryResponse
{
    use THasHttpIO;
    use THasColor;
    use THasState;
    use THasShieldUrl;

    /**
     * @param IRegistryPackage $package
     * @param array $args
     * @param ISampleParameter $parameter
     * @return ResponseInterface
     */
    public function __invoke(IRegistryPackage $package, array $args, ISampleParameter $parameter): ResponseInterface
    {
        $value = $parameter->getValue(false);
        $state = $this->getState($value);
        $color = $this->getColor($value);
        $response = $this->getPsrResponse();
        $response
            ->getBody()
            ->write(
                file_get_contents($this->getUrl(
                    $this->getPsrRequest(), $parameter->getName().'-'.$state.'-' . $color
                ))
            );

        return $response;
    }
}
