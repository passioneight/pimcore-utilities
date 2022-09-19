<?php

namespace Passioneight\Bundle\PimcoreUtilitiesBundle\Traits;

/**
 * Only use this trait in a configuration service of a Pimcore bundle.
 * You can use the bundle's extension to populate the service with the config afterwards. This allows you to inject
 * your custom service to access the bundle's configuration.
 *
 * Example code for your extension file:
 *
 * $serviceDefinition = $container->getDefinition(BundleNameConfiguration::class);
 * $serviceDefinition->addMethodCall(MethodUtility::createSetter("configuration"), [$config]);
 *
 */
trait BundleConfigurationAwareTrait
{
    private array $configuration;

    public function getConfiguration(): array
    {
        return $this->configuration;
    }

    /**
     * This is called via the extension.
     */
    public function setConfiguration(array $configuration): void
    {
        $this->configuration = $configuration;
    }
}
