<?php
/**
 * @category Symfony_Bundle
 * @package  Jb\Bundle\SimpleRestBundle\DependencyInjection
 * @author   Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 * @license  MIT <https://github.com/jbouzekri/SimpleRestBundle/blob/master/LICENSE>
 * @link     https://github.com/jbouzekri/SimpleRestBundle
 */

namespace Jb\Bundle\SimpleRestBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Reference;

/**
 * class JbSimpleRestExtension
 *
 * Load into DI container the configuration for this bundle
 */
class JbSimpleRestExtension extends Extension
{
    /**
     * @param array $configs
     * @param ContainerBuilder $container
     *
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );
        $loader->load('services.yaml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        if (count($config['zones']) > 0) {
            $this->configureZoneMatcherListener($config['zones'], $container);
        }
    }

    /**
     * Configure the zone matcher listener service
     *
     * Inspired from methods `loadZoneMatcherListener` and `createZoneRequestMatcher` in:
     * https://github.com/FriendsOfSymfony/FOSRestBundle/blob/master/DependencyInjection/FOSRestExtension.php
     * License: https://github.com/FriendsOfSymfony/FOSRestBundle/blob/master/LICENSE
     *
     * @param array $zoneConfig
     *
     * @param ContainerBuilder $container
     */
    protected function configureZoneMatcherListener(array $zoneConfig, ContainerBuilder $container)
    {
        $zoneMatcherListenerClass = 'Jb\\Bundle\\SimpleRestBundle\\EventListener\\ZoneMatcherListener';
        $zoneMatcherListener = $container->getDefinition($zoneMatcherListenerClass);

        foreach ($zoneConfig as $zone) {
            $id = 'jb_simple_rest.zone_request_matcher.'.md5($zone).sha1($zone);

            $childDefinitionClass = class_exists(ChildDefinition::class) ? ChildDefinition::class : DefinitionDecorator::class;

            $container
                ->setDefinition($id, new $childDefinitionClass('jb_simple_rest.zone_request_matcher'))
                ->setArguments([$zone])
            ;

            $zoneMatcherListener->addMethodCall('addRequestMatcher', array(new Reference($id)));
        }
    }
}