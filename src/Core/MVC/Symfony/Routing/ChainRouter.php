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
namespace Innomatic\Core\MVC\Symfony\Routing;

use Symfony\Cmf\Component\Routing\ChainRouter as BaseChainRouter;

class ChainRouter extends BaseChainRouter
{
    public function generate($name, $parameters = array(), $absolute = false)
    {
        if ($name instanceof RouteReference) {
            $parameters += $name->getParams();
            $name = $name->getRoute();
        }

        return parent::generate($name, $parameters, $absolute);
    }
}
