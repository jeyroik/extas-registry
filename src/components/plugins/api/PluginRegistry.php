<?php
namespace extas\components\plugins\api;

use extas\components\plugins\Plugin;
use extas\interfaces\http\IHasHttpIO;
use extas\interfaces\repositories\IRepository;
use extas\interfaces\stages\IStageApiAppInit;
use extas\interfaces\stages\IStageRegistryResponse;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\App;

/**
 * Class PluginRegistry
 *
 * @method IRepository extasPackages()
 *
 * @package extas\components\plugins\api
 * @author jeyroik <jeyroik@gmail.com>
 */
class PluginRegistry extends Plugin implements IStageApiAppInit
{
    /**
     * @param App $app
     */
    public function __invoke(App &$app): void
    {
        $app->get(
            '/registry/{package_name}/{parameter_name}/{format}',
            function (RequestInterface $request, ResponseInterface $response, array $args) {
                $package = $this->extasPackages()->one(['name' => $args['package_name']]);

                if (!$package) {
                    $response->getBody()->write('Unknown package "' . $args['package_name'] . '"');

                    return $response;
                }

                if (!$package->hasParameter($args['parameter_name'])) {
                    $response->getBody()->write('Unknown parameter "' . $args['parameter_name'] . '"');

                    return $response;
                }

                $config = [
                    IHasHttpIO::FIELD__PSR_REQUEST => $request,
                    IHasHttpIO::FIELD__PSR_RESPONSE => $response
                ];
                $stage = IStageRegistryResponse::NAME . $args['format'];

                foreach ($this->getPluginsByStage($stage, $config) as $plugin) {
                    $response = $plugin($package, $args);
                }

                return $response;
            }
        );
    }
}
