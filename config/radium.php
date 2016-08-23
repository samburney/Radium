<?php
return [
    /**
     * Default password type for new users
     */
    'password_attribute' => env("RADIUM_PASSWORD_ATTRIBUTE", ""),

    /**
     * The group that will be assigned or removed when enabling
     * or disabling a user account.
     */
    'disabled_group' => env('RADIUM_DISABLED_GROUP', ''),

    /**
     * The ip address of the radius server for running commands
     */
    'radius_server' => env('RADIUM_RADIUS_SERVER', ''),

    /**
     * The port used to communicate with the radius server
     */
    'radius_port' => env('RADIUM_RADIUS_PORT', ''),

    /**
     * The radius secret used to communicate with the radius server
     * for command line processes.
     */
    'radius_secret' => env('RADIUM_RADIUS_SECRET', ''),

    /**
     * Not really sure what the nas port is used for. Currently
     * daloradius pulls in this value for the test connectivity
     * functionality.
     */
    'nas_port' => env('RADIUM_NAS_PORT', ''),

    /**
     * The system path to the FreeRadius configuration folder.
     */
    'config_folder' => env('RADIUM_CONFIG_FOLDER', ''),

    /**
     * The system path to the FreeRadius dictionary folder.
     */
    'dictionary_folder' => env('RADIUM_DICTIONARY_FOLDER', ''),

    /**
     * A list of dictionaries to be excluded during import. This list should be
     * delimited via pipes.
     */
    'exclude_dictionaries' => env('RADIUM_EXCLUDE_DICTIONARIES', ''),

    /**
     * The proxy configuration file name to automatically generate new proxy
     * entries. This file is automatically generated from Radium. Customizations
     * outside of the app will be overwritten when a new proxy is added or an
     * existing one is updated.
     */
    'proxy_file' => env('RADIUM_PROXY_FILE', ''),

];