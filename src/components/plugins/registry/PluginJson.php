<?php
namespace extas\components\plugins\registry;

use extas\components\http\THasHttpIO;
use extas\components\plugins\Plugin;
use extas\interfaces\registry\IRegistryPackage;
use extas\interfaces\samples\parameters\ISampleParameter;
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

    /**
     * @param IRegistryPackage $package
     * @param array $arg
     * @param ISampleParameter $parameter
     * @return ResponseInterface
     */
    public function __invoke(IRegistryPackage $package, array $arg, ISampleParameter $parameter): ResponseInterface
    {
        $value = $parameter->getValue(false);
        $response = $this->getPsrResponse();
        $response->withHeader('Content-type', 'application/json')->getBody()->write(json_encode([
            'version' => '1.0',
            $parameter->getName() => $this->isDetailed() ? $parameter->__toArray() : $value
        ]));

        return $response;
    }

    /**
     * @return bool
     */
    protected function isDetailed(): bool
    {
        $query = parse_url($this->getPsrRequest()->getUri()->getQuery());
        return $query['path'] ? true : false;
    }
}
