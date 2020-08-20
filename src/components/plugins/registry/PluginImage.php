<?php
namespace extas\components\plugins\registry;

use extas\components\http\THasHttpIO;
use extas\components\plugins\Plugin;
use extas\interfaces\registry\IRegistryPackage;
use extas\interfaces\stages\IStageRegistryResponse;
use Psr\Http\Message\ResponseInterface;

/**
 * Class PluginImage
 *
 * @package extas\components\plugins\registry
 * @author jeyroik <jeyroik@gmail.com>
 */
class PluginImage extends Plugin implements IStageRegistryResponse
{
    use THasHttpIO;

    /**
     * @param IRegistryPackage $package
     * @param array $args
     * @return ResponseInterface
     */
    public function __invoke(IRegistryPackage $package, array $args = []): ResponseInterface
    {
        $paramName = $args['parameter_name'] ?? '';
        $value = $package->getParameterValue($paramName, false);
        $state = $value ? 'yes' : 'no';
        $color = $value ? 'red' : 'green';

        $request = $this->getPsrRequest();
        $query = parse_url($request->getUri()->getQuery());
        $type = $query['path'] ?? 'png';
        $url = 'https://img.shields.io/badge/'.$paramName.'-'.$state.'-' . $color . '.' . $type;
        $response = $this->getPsrResponse();
        $response->withHeader('Content-type', 'image/' . $type)
            ->getBody()
            ->write(file_get_contents($url));

        return $response;
    }
}
