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
namespace Innomatic\Bundle\InnomaticLegacyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;
use Innomatic\Bundle\InnomaticLegacyBundle\LegacyResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

class LegacyKernelController extends BaseController
{
    private $legacyLayout;
    private $request;
    private $router;

    public function __construct(
        RouterInterface $router
    )
    {
        $this->router = $router;
    }
    
    public function setRequest(Request $request = null)
    {
        $this->request = $request;
    }

    public function indexAction()
    {
        $kernel = $this->get('innomatic_legacy.kernel');
        $result = $kernel->run();
        return new LegacyResponse($result);
    }
}
