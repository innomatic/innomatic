<?php
/**
 * Innomatic
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.
 *
 * @copyright  1999-2014 Innomatic Company
 * @license    http://www.innomatic.io/license/ New BSD License
 * @link       http://www.innomatic.io
 */
namespace Innomatic\Core\MVC\Legacy;

/**
 * This class provides an interface to the legacy stack.
 *  
 * @author     Alex Pagnoni <alex.pagnoni@innomatic.io>
 * @copyright  1999-2014 Innomatic Company
 * @since      7.0.0 introduced
 */
class Kernel 
{
    /**
     * Legacy stack callback running state.
     * @var boolean 
     */
    protected $runningCallback = false;

    /**
     * Runs a callback function in the legacy core.
     *
     * @param \Closure $callback
     * @throws \RuntimeException
     * @return mixed Callback result 
     */
    public function runCallback(\Closure $callback)
    {
        // Check if a legacy stack callback is already running.
        if ($this->runningCallback) {
            throw new RuntimeException('Started recursive callback in legacy kernel.');
        }

        // Set the callback as running.
        $this->runningCallback = true;

        // Change current directory to the legacy stack.
        $platformHome = getcwd();
        // @todo Must get innomatic_legacy path from configuration.
        chdir($platformHome . '/innomatic_legacy');

        try {
            // Start the legacy Root Container and the legacy autoloader.
            require_once getcwd().'/innomatic/core/classes/innomatic/core/RootContainer.php';
            $rootContainer = \Innomatic\Core\RootContainer::instance('\Innomatic\Core\RootContainer');

            // Start the legacy Innomatic Container.
            $innomatic = \Innomatic\Core\InnomaticContainer::instance('\Innomatic\Core\InnomaticContainer');

            // Set the Innomatic interface type to console.
            $innomatic->setInterface(\Innomatic\Core\InnomaticContainer::INTERFACE_CONSOLE);
            $home = \Innomatic\Core\RootContainer::instance('\Innomatic\Core\RootContainer')
                ->getHome()
                . 'innomatic/';

            // Start Innomatic.
            $innomatic->bootstrap($home, $home . 'core/conf/innomatic.ini');
            
            // Run the callback in the legacy core.
            $result = $innomatic->runCallback($callback);
        } catch (Exception $e) {
            // Go back to the new platform home.
            chdir($platformHome);
        
            // Clean the callback running state.
            $this->runningCallback = false;
            throw $e;
        }

        // Go back to the new platform home.
        chdir($platformHome);

        // Clean the callback running state.
        $this->runningCallback = false;

        return $result;
    }

    public function run()
    {
        // Change current directory to the legacy stack.
        $platformHome = getcwd();
        // @todo Must get innomatic_legacy path from configuration.
        chdir($platformHome . '/../innomatic_legacy/innomatic');
            
        // Saves webapp home.
        $webAppHome = getcwd() . '/';
        
        // Start the legacy Root Container and the legacy autoloader.
        require_once getcwd() . '/core/classes/innomatic/core/RootContainer.php';
        $rootContainer = \Innomatic\Core\RootContainer::instance('\Innomatic\Core\RootContainer');
        
        // Starts the WebAppContainer.
        $container = \Innomatic\Webapp\WebAppContainer::instance('\Innomatic\Webapp\WebAppContainer');
        
        ob_start();
        // Starts the WebApp. This is where all the real stuff is done.
        $container->startWebApp($webAppHome);
        $result = ob_get_contents();
        ob_end_clean();
        
        // Stops the Root Container so that the instance is marked as cleanly exited.
        $rootContainer->stop();
        chdir($platformHome);
        return $result;
    }
}