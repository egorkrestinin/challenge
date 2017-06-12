<?php

namespace AppBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class CharacterPrototypePass
 * @package AppBundle\DependencyInjection\CompilerPass
 */
class CharacterPrototypePass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('app.service.character.registry')) {
            return;
        }
        $definition = $container->getDefinition('app.service.character.registry');
        $types = $container->findTaggedServiceIds('app.character_prototype');

        foreach ($types as $id => $tags) {
            foreach ($tags as $tag) {
                if (!isset($tag['alias'])) {
                    continue;
                }

                $definition->addMethodCall(
                    'addPrototype',
                    [
                        $tag['alias'],
                        new Reference($id),
                    ]
                );
            }
        }
    }
}
