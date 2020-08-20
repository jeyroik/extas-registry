<?php
namespace extas\components\plugins\registry;

use Psr\Http\Message\RequestInterface;

/**
 * Trait THasShieldUrl
 *
 * @package extas\components\plugins\registry
 * @author jeyroik <jeyroik@gmail.com>
 */
trait THasShieldUrl
{
    /**
     * @param RequestInterface $request
     * @param string $baseSuffix
     * @return string
     */
    public function getUrl(RequestInterface $request, string $baseSuffix)
    {
        $query = parse_url($request->getUri()->getQuery());
        $type = $query['path'] ?? 'png';

        return 'https://img.shields.io/badge/' . $baseSuffix . '.' . $type;
    }
}
