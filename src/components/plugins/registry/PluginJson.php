<?php
namespace extas\components\plugins\registry;

use extas\components\http\THasHttpIO;
use extas\components\plugins\Plugin;
use extas\interfaces\registry\IRegistryPackage;
use extas\interfaces\stages\IStageRegistryResponse;
use Psr\Http\Message\ResponseInterface;

/**
 * Class PluginJson
 *
 * @package extas\components\plugins\registry
 * @author jeyroik <jeyroik@gmail.com>
 */
class PluginJson extends Plugin implements IStageRegistryResponse
{
    use THasHttpIO;

    public function __invoke(IRegistryPackage $package, array $args = []): ResponseInterface
    {
        $paramName = $args['parameter_name'] ?? '';
        $value = $package->getParameterValue($paramName, false);

        $response = $this->getPsrResponse();
        $response->withHeader('Content-type', 'application/json')->getBody()->write(json_encode([
            'version' => '1.0',
            $paramName => $value
        ]));

        return $response;
    }
}
