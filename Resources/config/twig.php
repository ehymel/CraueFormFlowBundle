<?php
/**
    Author: Christian Raue <christian.raue@gmail.com>
    Copyright: 2011-2025 Christian Raue
        License: http://opensource.org/licenses/mit-license.php MIT License
 **/

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (ContainerConfigurator $container): void {
    // --- PARAMETERS ---
    $parameters = $container->parameters();

    $parameters->set(
        'craue_twig_extensions.formflow.class',
        'Craue\FormFlowBundle\Twig\Extension\FormFlowExtension'
    );

    // --- SERVICES ---
    $services = $container->services();

    $services
        ->set('twig.extension.craue_formflow', '%craue_twig_extensions.formflow.class%')
        ->tag('twig.extension')
        ->call('setFormFlowUtil', [
            service('craue_formflow_util'),
        ]);
};