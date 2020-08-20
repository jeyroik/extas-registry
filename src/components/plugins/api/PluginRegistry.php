<?php
namespace extas\components\plugins\api;

use extas\components\exceptions\MissedOrUnknown;
use extas\components\plugins\Plugin;
use extas\interfaces\http\IHasHttpIO;
use extas\interfaces\registry\IRegistryPackage;
use extas\interfaces\repositories\IRepository;
use extas\interfaces\samples\parameters\ISampleParameter;
use extas\interfaces\stages\IStageApiAppInit;
use extas\interfaces\stages\IStageRegistryResponse;
use extas\interfaces\stages\IStageRegistryResponseParameter;
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

                try {
                    $this->validateRequest($package, $args);
                } catch (MissedOrUnknown $e) {
                    $response->getBody()->write($e->getMessage());

                    return $response;
                }

                $parameter = $this->getPackageParameter($package, $args);

                $config = [
                    IHasHttpIO::FIELD__PSR_REQUEST => $request,
                    IHasHttpIO::FIELD__PSR_RESPONSE => $response
                ];

                $stage = IStageRegistryResponse::NAME . $args['format'];
                foreach ($this->getPluginsByStage($stage, $config) as $plugin) {
                    /**
                     * @var IStageRegistryResponse $plugin
                     */
                    $response = $plugin($package, $args, $parameter);
                }

                return $response;
            }
        );
    }

    /**
     * @param IRegistryPackage $package
     * @param array $args
     * @return bool
     * @throws MissedOrUnknown
     */
    protected function validateRequest(IRegistryPackage $package, array $args): bool
    {
        if (!$package) {
            throw new MissedOrUnknown('package "' . $args['package_name'] . '"');
        }

        if (!$package->hasParameter($args['parameter_name'])) {
            throw new MissedOrUnknown('parameter "' . $args['parameter_name'] . '"');
        }

        return true;
    }

    /**
     * @param IRegistryPackage $package
     * @param array $args
     * @return ISampleParameter
     */
    protected function getPackageParameter(IRegistryPackage $package, array $args): ISampleParameter
    {
        $parameter = $package->getParameter($args['parameter_name']);

        $stage = IStageRegistryResponseParameter::NAME;
        foreach ($this->getPluginsByStage($stage) as $plugin) {
            /**
             * @var IStageRegistryResponseParameter $plugin
             */
            $parameter = $plugin($package, $parameter);
        }

        $stage = IStageRegistryResponseParameter::NAME . '.' . $args['parameter_name'];
        foreach ($this->getPluginsByStage($stage) as $plugin) {
            /**
             * @var IStageRegistryResponseParameter $plugin
             */
            $parameter = $plugin($package, $parameter);
        }

        return $parameter;
    }
}
