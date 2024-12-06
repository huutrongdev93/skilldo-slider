<?php
namespace Slider;

class Caption
{
    public string $itemId;

    public array $config;

    public function __construct()
    {
        $this->config = $this->default();
    }

    public function default(): array
    {
        return [];
    }

    public function setConfig($config): void
    {
        if(is_array($config) && have_posts($config))
        {
            foreach($config as $key => $configValue)
            {
                if(!isset($this->config[$key]))
                {
                    continue;
                }

                if(!is_array($this->config[$key]))
                {
                    continue;
                }

                if(is_string($configValue))
                {
                    $this->config[$key] = $configValue;
                    continue;
                }

                if(is_array($configValue))
                {
                    $this->config[$key] = array_merge($this->config[$key], $configValue);
                }
            }
        }
    }

    public function setItemId($itemId): void
    {
        $this->itemId = $itemId;
    }

    public function config(): array
    {
        return $this->config;
    }

    public function itemId(): string
    {
        return $this->itemId;
    }
}