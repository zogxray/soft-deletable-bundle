<?php
/**
 * Created by PhpStorm.
 * User: Zogxray (Viktor Pavlov)
 * Date: 31.08.18
 * Time: 11:06
 */

namespace Zogxray\SoftDeletableBundle;


use Zogxray\SoftDeletableBundle\DependencyInjection\Compiler\SoftDeletableCompilerPass;
use Zogxray\SoftDeletableBundle\DependencyInjection\SoftDeletableExtension;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class SoftDeletableBundle
 */
class SoftDeletableBundle extends Bundle
{
    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new SoftDeletableCompilerPass(), PassConfig::TYPE_BEFORE_OPTIMIZATION, 1000);
    }

    /**
     * @return SoftDeletableExtension|null|\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
     */
    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new SoftDeletableExtension();
        }
        return $this->extension;
    }
}
