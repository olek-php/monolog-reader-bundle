<?php

namespace OlekPhp\Bundle\MonologBundle;

use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use OlekPhp\Bundle\MonologBundle\DependencyInjection\MonologReaderExtension;

class MonologReaderBundle extends Bundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        if($this->extension === null) {
            $this->extension = new MonologReaderExtension();
        }

        return $this->extension;
    }
}