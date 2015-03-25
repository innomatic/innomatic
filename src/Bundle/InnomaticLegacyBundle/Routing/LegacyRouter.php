<?php
/**
 * Innomatic
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.
 *
 * @copyright  2014-2015 Innomatic Company
 * @license    http://www.innomatic.io/license/ New BSD License
 * @link       http://www.innomatic.io
 */
namespace Innomatic\Bundle\InnomaticLegacyBundle\Routing;

use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Psr\Log\LoggerInterface;

class LegacyRouter implements RouterInterface
{
    const ROUTE_NAME = 'innomatic_legacy';
    private $context;
    private $logger;

    public function __construct(RequestContext $context = null, LoggerInterface $logger = null)
    {
        $this->context = $context = $context ?: new RequestContext;
        $this->logger  = $logger;
    }

    public function setContext(RequestContext $context)
    {
        $this->context = $context;
    }

    public function getContext()
    {
        return $this->context;
    }

    public function getRouteCollection()
    {
        // Forward requests to the legacy stack
        return new RouteCollection();
    }

    public function generate($name, $parameters = array(), $absolute = false)
    {
        if ($name === self::ROUTE_NAME) {
            return 'test_legacy_route';
        }

        throw new RouteNotFoundException();
    }

    public function match($pathinfo)
    {
        return array(
            "_route" => self::ROUTE_NAME,
            "_controller" => "innomatic_legacy.controller:indexAction",
        );
    }
}
