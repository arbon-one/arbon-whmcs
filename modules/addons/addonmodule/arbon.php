<?php
use WHMCS\Database\Capsule;
use WHMCS\Module\Addon\arbon\Admin\AdminDispatcher;
use WHMCS\Module\Addon\arbon\Client\ClientDispatcher;

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

function arbon_config()
{
    return [
        'name' => 'Arbon',
        'description' => 'This module provides an Arbon integration which allows to offset CO2',
        'author' => 'contact@arbon.one',
        'language' => 'english',
        'version' => '1.0',
        'fields' => [
            'is_production' => [
                'FriendlyName' => 'Is Production?',
                'Type' => 'boolean',
                'Default' => false,
                'Description' => 'Switches between production and dev environments',
            ],

            'access_t' => [
                'FriendlyName' => 'Is Production?',
                'Type' => 'boolean',
                'Default' => false,
                'Description' => 'Switches between production and dev environments',
            ],

            'amount' => [
                'FriendlyName' => 'Amount',
                'Type' => 'integer',
                'Default' => 0,
                'Description' => 'Amount of CO2 in KG to be offset',
            ],

            // IMPORTANT: it should be always "DGCloud"
            'owner' => [
                'FriendlyName' => 'Owner',
                'Type' => 'text',
                'Size' => '25',
                'Default' => 'DGCloud',
                'Description' => 'Company offseting the CO2',
            ],

            'reason' => [
                'FriendlyName' => 'Reason',
                'Size' => '25',
                'Type' => 'text',
                'Description' => 'Reason for offseting CO2',
            ],

            'timestamp' => [
                'FriendlyName' => 'Timestamp',
                'Type' => 'text',
                'Description' => 'Date and time when the CO2 offset happened',
            ],

            // (Not Arbon API related, but rather a suggestion): ID of the user who is making the offset
            'uid' => [
                'FriendlyName' => 'uid',
                'Type' => 'text',
                'Description' => 'ID of the user who is making the offset',
            ],
        ]
    ];
}

function arbon_activate()
{
    try {
        Capsule::schema()
            ->create(
                'mod_arbon',
                function ($table) {
                    /** @var \Illuminate\Database\Schema\Blueprint $table */
                    $table->increments('id');
                    $table->text('amount');
                    $table->text('reason');
                    $table->date('uid');
                    $table->date('timestamp');
                }
            );

        return [
            'status' => 'success',
            'description' => 'TODO: report success',
        ];
    } catch (\Exception $e) {
        return [
            'status' => "error",
            'description' => 'Unable to create mod_arbon: ' . $e->getMessage(),
        ];
    }
}

function arbon_deactivate()
{
    try {
        Capsule::schema()
            ->dropIfExists('mod_arbon');

        return [
            'status' => 'success',
            'description' => 'TODO: report success',
        ];
    } catch (\Exception $e) {
        return [
            "status" => "error",
            "description" => "Unable to drop mod_arbon: {$e->getMessage()}",
        ];
    }
}

/**
 * Admin Area Output.
 *
 * Called when the addon module is accessed via the admin area.
 * Should return HTML output for display to the admin user.
 *
 * This function is optional.
 *
 * @see arbon\Admin\Controller::index()
 *
 * @return string
 */
function arbon_output($vars)
{
    $modulelink = $vars['modulelink'];
    $version = $vars['version'];
    $_lang = $vars['_lang'];

    // $configTextField = $vars['amount'];
    // $configTextField = $vars['reason'];
    // $configTextField = $vars['owner'];
    // $configTextField = $vars['uid'];
    // $configTextField = $vars['timestamp'];

    $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

    $dispatcher = new AdminDispatcher();
    $response = $dispatcher->dispatch($action, $vars);
    echo $response;
}

/**
 * Client Area Output.
 *
 * Called when the addon module is accessed via the client area.
 * Should return an array of output parameters.
 *
 * This function is optional.
 *
 * @see arbon\Client\Controller::index()
 *
 * @return array
 */
function arbon_clientarea($vars)
{
    $modulelink = $vars['modulelink'];
    $version = $vars['version'];
    $_lang = $vars['_lang'];

    // $configTextField = $vars['amount'];
    // $configTextField = $vars['reason'];
    // $configTextField = $vars['owner'];
    // $configTextField = $vars['uid'];
    // $configTextField = $vars['timestamp'];

    $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

    $dispatcher = new ClientDispatcher();
    return $dispatcher->dispatch($action, $vars);
}
