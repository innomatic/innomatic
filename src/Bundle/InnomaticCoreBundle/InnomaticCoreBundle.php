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
namespace Innomatic\Bundle\InnomaticCoreBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Innomatic\Bundle\InnomaticCoreBundle\DependencyInjection\Compiler\ChainRoutingPass;
use Innomatic\Bundle\InnomaticCoreBundle\DependencyInjection\Compiler\ChainConfigResolverPass;
use Innomatic\Bundle\InnomaticCoreBundle\DependencyInjection\InnomaticCoreExtension;

class InnomaticCoreBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new ChainRoutingPass);
        $container->addCompilerPass(new ChainConfigResolverPass);
    }

    public function getContainerExtension()
    {
        if ( !isset( $this->extension ) )
        {
            $this->extension = new InnomaticCoreExtension(
                array(
                )
            );
        }

        return $this->extension;
    }
}
