<?php

namespace Rewsam\DevelopmentAssist\DependencyInjection;

use Rewsam\DevelopmentAssist\Service\Template\TemplateDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('development_assist');

        $rootNode
            ->children()
            ->scalarNode('templates_directory')
            ->defaultValue('')
            ->end()
            ->scalarNode('render_service_id')
            ->defaultValue('development_assist.template.render.mustache')
            ->end()
            ->append($this->getTemplating())
            ->end();

        return $treeBuilder;
    }

    private function getTemplating(): NodeDefinition
    {
        $treeBuilder = new TreeBuilder();
        $node = $treeBuilder->root('templating');

        $node
            ->useAttributeAsKey('name')
            ->arrayPrototype()
            ->children()
            ->scalarNode('builder_service_id')
            ->defaultValue('development_assist.template.parameter.default_builder')
            ->end()
            ->arrayNode('parameters')
            ->arrayPrototype()
            ->children()
            ->scalarNode('name')->isRequired()->end()
            ->scalarNode('key')->isRequired()->end()
            ->end()
            ->end()
            ->end()
            ->append($this->getDestinations())
            ->end()
            ->end();

        return $node;
    }

    private function getDestinations(): NodeDefinition
    {
        $treeBuilder = new TreeBuilder();
        $node = $treeBuilder->root('destinations');

        $node
            ->useAttributeAsKey('name')
            ->arrayPrototype()
            ->children()
            ->scalarNode('files_source_path')->defaultValue('')->end()
            ->scalarNode('destination_path')->defaultValue('')->end()
            ->enumNode('write_mode')
            ->values(TemplateDefinition::SAVE_MODES)
            ->defaultValue(TemplateDefinition::SAVE_MODE_DUMP)
            ->end()
            ->arrayNode('files')
            ->useAttributeAsKey('name')
            ->beforeNormalization()
            ->always(function ($v) {
                $normalized = [];

                foreach ($v as $key => $value) {
                    if (is_numeric($key)) {
                        $key = $value;
                        $value = '';
                    }

                    $normalized[$key] = $value;
                }

                return $normalized;
            })
            ->end()
            ->scalarPrototype()->end()
            ->end()
            ->end()
            ->end();

        return $node;
    }
}
