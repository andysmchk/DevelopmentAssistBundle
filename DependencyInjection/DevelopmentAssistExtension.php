<?php

namespace Rewsam\DevelopmentAssist\DependencyInjection;

use Rewsam\DevelopmentAssist\Service\Template\Templating;
use Rewsam\DevelopmentAssist\Service\Template\TemplatingConfiguration;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class DevelopmentAssistExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );
        $loader->load('services.yml');

        $this->processTemplating($config, $container);
    }

    private function processTemplating(array $config, ContainerBuilder $container): void
    {
        $container->setParameter('development_assist.template.templates_directory', $config['templates_directory']);
        $this->addRender($config, $container);
        $registry = $container->getDefinition('development_assist.template.templating.registry');

        foreach ($config['templating'] as $templateName => $templateConfig) {
            $this->addTemplate($templateName, $templateConfig, $container, $registry);
        }
    }

    private function addRender(array $config, ContainerBuilder $container): void
    {
        $serviceId = $config['render_service_id'] ?? '';

        if (!$serviceId || !$container->hasDefinition($serviceId)) {
            throw new InvalidConfigurationException('Render service is not valid: ' . $serviceId);
        }

        $container->setAlias('development_assist.template.render.default', $serviceId);
    }

    private function addTemplate(string $templateName, array $templateConfig, ContainerBuilder $container, Definition $registry): void
    {
        $builderServiceId = $templateConfig['builder_service_id'];

        if (!$builderServiceId || !$container->hasDefinition($builderServiceId)) {
            throw new InvalidConfigurationException('Builder service is not valid: ' . $builderServiceId);
        }

        $templatingConfDefinition = new Definition(TemplatingConfiguration::class, [
            $templateConfig,
        ]);
        $templatingConfId = sprintf('development_assist.template.configuration_%s_%s', $templateName, time());
        $container->setDefinition($templatingConfId, $templatingConfDefinition);

        $templatingDefinition = new Definition(Templating::class, [
            new Reference($templatingConfId),
            new Reference($builderServiceId),
            new Reference('development_assist.template.factory'),
        ]);
        $serviceName = 'development_assist.template.' . $templateName;
        $container->setDefinition($serviceName, $templatingDefinition);

        $registry->addMethodCall('add', [$templateName, new Reference($serviceName)]);
    }
}