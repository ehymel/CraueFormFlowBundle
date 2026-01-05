<?php

/**
	Author: Christian Raue <christian.raue@gmail.com>
	Author: Marcus Stöhr <dafish@soundtrack-board.de>
	Copyright: 2011-2025 Christian Raue
	License: http://opensource.org/licenses/mit-license.php MIT License
 **/

use Craue\FormFlowBundle\Form\FormFlowEvents;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (ContainerConfigurator $container): void {
    // --- PARAMETERS ---
    $parameters = $container->parameters();

    $parameters->set('craue.form.flow.class', 'Craue\FormFlowBundle\Form\FormFlow');
    $parameters->set('craue.form.flow.storage.class', 'Craue\FormFlowBundle\Storage\SessionStorage');

    $parameters->set('craue.form.flow.event_listener.previous_step_invalid.class', 'Craue\FormFlowBundle\EventListener\PreviousStepInvalidEventListener');
    $parameters->set('craue.form.flow.event_listener.previous_step_invalid.event', constant(FormFlowEvents::class . '::PREVIOUS_STEP_INVALID'));

    $parameters->set('craue.form.flow.event_listener.flow_expired.class', 'Craue\FormFlowBundle\EventListener\FlowExpiredEventListener');
    $parameters->set('craue.form.flow.event_listener.flow_expired.event', constant(FormFlowEvents::class . '::FLOW_EXPIRED'));

    // --- SERVICES ---
    $services = $container->services();

    // Storage
    $services
        ->set('craue.form.flow.storage_default', '%craue.form.flow.storage.class%')
        ->public(false)
        ->args([
            service('request_stack'),
        ]);

    $services
        ->alias('craue.form.flow.storage', 'craue.form.flow.storage_default')
        ->public();

    // Data Manager
    $services
        ->set('craue.form.flow.data_manager_default', 'Craue\FormFlowBundle\Storage\DataManager')
        ->public(false)
        ->args([
            service('craue.form.flow.storage'),
        ]);

    $services->alias('craue.form.flow.data_manager', 'craue.form.flow.data_manager_default');

    // Main Flow Service
    $services
        ->set('craue.form.flow', '%craue.form.flow.class%')
        ->call('setDataManager', [service('craue.form.flow.data_manager')])
        ->call('setFormFactory', [service('form.factory')])
        ->call('setRequestStack', [service('request_stack')])
        ->call('setEventDispatcher', [
            service('event_dispatcher')->ignoreOnInvalid(),
        ]);

    // Form Extensions
    $services
        ->set('craue.form.flow.form_extension', 'Craue\FormFlowBundle\Form\Extension\FormFlowFormExtension')
        ->tag('form.type_extension', [
            'extended-type' => 'Symfony\Component\Form\Extension\Core\Type\FormType',
        ]);

    $services
        ->set('craue.form.flow.hidden_field_extension', 'Craue\FormFlowBundle\Form\Extension\FormFlowHiddenFieldExtension')
        ->tag('form.type_extension', [
            'extended-type' => 'Symfony\Component\Form\Extension\Core\Type\HiddenType',
        ]);

    // Event Listeners
    $services
        ->set('craue.form.flow.event_listener.previous_step_invalid', '%craue.form.flow.event_listener.previous_step_invalid.class%')
        ->tag('kernel.event_listener', [
            'event' => '%craue.form.flow.event_listener.previous_step_invalid.event%',
            'method' => 'onPreviousStepInvalid',
        ])
        ->call('setTranslator', [service('translator')]);

    $services
        ->set('craue.form.flow.event_listener.flow_expired', '%craue.form.flow.event_listener.flow_expired.class%')
        ->tag('kernel.event_listener', [
            'event' => '%craue.form.flow.event_listener.flow_expired.event%',
            'method' => 'onFlowExpired',
        ])
        ->call('setTranslator', [service('translator')]);
};