<?php

namespace Innomatic\Legacy;

class Core
{
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
        if ($this->runningCallback) {
            throw new RuntimeException('Started recursive callback in legacy kernel.');
        }

        $this->runningCallback = true;

        $platformHome = getcwd();
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

            // Start Innomatic
            $innomatic->bootstrap($home, $home . 'core/conf/innomatic.ini');
            $result = $innomatic->runCallback($callback);
        } catch (Exception $e) {
            chdir($platformHome);
            $this->runningCallback = false;
            throw $e;
        }

        chdir($platformHome);
        $this->runningCallback = false;
        return $result;
    }
}