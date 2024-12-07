<?php
namespace Slider\Update;

use Option;
use Plugin;

class Updater
{
    protected string $version;

    protected ?string $currentVersion;

    protected array $timeline;

    protected $update;

    public function __construct()
    {

        $this->version = Plugin::getInfo('slider')['version'];

        $this->currentVersion = Option::get('slider_version');

        if(empty($this->currentVersion))
        {
            $this->currentVersion = '3.2.6';
        }

        $this->timeline = ['4.0.0'];
    }

    public function setUpdate($version): void
    {
        $this->update = null;

        $className = 'UpdateVersion'.str_replace('.', '', $version);

        if(!class_exists('Slider\\Update\\'.$className))
        {
            if(file_exists(__DIR__.'/'. $version.'/'.$className.'.php'))
            {
                require_once __DIR__ .'/'. $version.'/'.$className.'.php';
            }
        }

        if(class_exists('Slider\\Update\\'.$className))
        {
            $className = 'Slider\\Update\\'.$className;

            $this->update = new $className();
        }
    }

    public function checkForUpdates(): void
    {
        if (version_compare($this->version, $this->currentVersion, '>'))
        {
            foreach ($this->timeline as $version)
            {
                if(version_compare($version, $this->currentVersion) == 1)
                {
                    $this->setUpdate($version);

                    if(!empty($this->update))
                    {
                        $this->update->run();

                        Option::update('slider_version', $version);
                    }
                }
            }
        }
        else
        {
            Plugin::setCheckUpdate('slider', $this->version);
        }
    }
}