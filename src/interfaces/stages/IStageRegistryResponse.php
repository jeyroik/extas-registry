<?php
namespace extas\interfaces\stages;

use extas\interfaces\http\IHasHttpIO;
use extas\interfaces\registry\IRegistryPackage;
use Psr\Http\Message\ResponseInterface;

/**
 * Interface IStageRegistryResponse
 *
 * @package extas\interfaces\stages
 * @author jeyroik <jeyroik@gmail.com>
 */
interface IStageRegistryResponse extends IHasHttpIO
{
    public const NAME = 'extas.registry.response.';

    /**
     * @param IRegistryPackage $package
     * @param array $args
     * @return ResponseInterface
     */
    public function __invoke(IRegistryPackage $package, array $args = []): ResponseInterface;
}
