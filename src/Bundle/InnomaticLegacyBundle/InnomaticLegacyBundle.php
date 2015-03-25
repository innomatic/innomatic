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
namespace Innomatic\Bundle\InnomaticLegacyBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Innomatic\Bundle\InnomaticLegacyBundle\DependencyInjection\InnomaticLegacyExtension;

class InnomaticLegacyBundle extends Bundle
{
    public function getContainerExtension()
    {
        if (!isset($this->extension)) {
            $this->extension = new InnomaticLegacyExtension(
                array()
            );
        }

        return $this->extension;
    }
}
