<?php
/**
    Author: Christian Raue <christian.raue@gmail.com>
    Copyright: 2011-2025 Christian Raue
	License: http://opensource.org/licenses/mit-license.php MIT License
 **/

use Craue\FormFlowBundle\Util\FormFlowUtil;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $container): void {
    // --- PARAMETERS ---
    $parameters = $container->parameters();

    $parameters->set(
        'craue_formflow.util.class',
        'Craue\FormFlowBundle\Util\FormFlowUtil'
    );

    // --- SERVICES ---
    $services = $container->services();

    // The main utility service
    $services->set('craue_formflow_util', '%craue_formflow.util.class%')
        ->public();

    // Autowiring alias: allows injection via the class name as a type-hint
    $services->alias(FormFlowUtil::class, 'craue_formflow_util')
        ->public(false);
};