<?php
/**
 * This file defines default configuration values for Repoman packages.
 *
 * DO NOT EDIT THIS FILE! Instead, place a (partial) copy of it into your repository root and 
 * name it config.php.  Any values you define in your repository's config.php will override 
 * the values in this file. Usually you only need to copy and fill-in the first block of 
 * config options.  Many of the others are obscure and technical. See 
 * https://github.com/craftsmancoding/repoman/wiki/config.php for full documentation.
 *
 *
 * modX and xPDOTransport constants are in context when this file is included,
 * as well as the $pkg_root_dir (abs. path to the repository's base path with no trailing slash).
 *
 * @package repoman 
 * @return array
 */
// xPDOTransport::PRESERVE_KEYS => preserve_keys
// xPDOTransport::UPDATE_OBJECT => update_object
// xPDOTransport::UNIQUE_KEY => unique_key
// xPDOTransport::RELATED_OBJECTS => related_objects
// xPDOTransport::RELATED_OBJECT_ATTRIBUTES => related_object_attributes
return array(
    'package_name' => basename($pkg_root_dir),
    'namespace' => strtolower(basename($pkg_root_dir)),
    'description' => 'This package was built with Repoman (https://github.com/craftsmancoding/repoman)',
    'version' => '0.0.0',
    'release' => 'dev',
    'copyright' => date('Y'),
    'category' => basename($pkg_root_dir), // Default category for elements
    
    'require_docblocks' => false, // if true, your elements *must* define docblocks in order to be imported
    'build_docs' => '*', // you may include an array specifying basenames of specific files in the build
    'overwrite' => false, // if true, will overwrite repo files during extract operations
    'log_level' => modX::LOG_LEVEL_INFO,
    
    // Author stuff (better when the mgr is used)...
    'author_name' => '', 
    'author_email' => '',
    'author_homepage' => MODX_SITE_URL,
    
    // Paths
    'core_path' => '',
    'assets_path' => 'assets/',
    'docs_path' => 'docs/',
    
    // Dirs relative to core_path/
    'chunks_path' => 'elements/chunks/',
    'plugins_path' => 'elements/plugins/',
    'snippets_path' => 'elements/snippets/',
    'templates_path' => 'elements/templates/',
    'tvs_path' => 'elements/tvs/',
    
    // Relative to core/components/<namespace>/  (do not start these with a slash!)
    'orm_path' => 'model/', // <-- xPDO's ORM classes here. MODX convention is "model/"
    'migrations_path' => 'model/migrations/',
    'seeds_path' => array(),
    'validators_path' => 'tests/',
    'controllers_path' => '', // Default is blank.  MODX hard-codes this pattern: {$controllers_path}controllers/{$action}.class.php

    // Directories or files omit from packaging to core/components/$namespace/
    'omit' => array('assets','screenshots','tests','composer.json','composer.lock','phpunit.xml','.git'),
    
    // When exporting, this determines how many records are packed into each seed file
    'limit' => 50,
    
    // For import/install (dev), force elements to reference static file for easier editing
    'force_static' => true,
    'move' => false, // used when exporting elements: if true, the original element will be updated to the new location.
    'dry_run' => false, // use runtime setting: --dry_run to see which objects will be created.
    'dir_mode' => 0777, // mask used when creating new directories
    
    'target' => 'model/seeds', // dir relative to package root where where export op should save data. Usually corresponds with one of the seeds_path entries

    'abort_install_on_fail' => true, // if true, your validation tests can halt pkg install by returning "false"

    // for schema operations
    'overwrite' => false,
    'restrict_prefix' => true,
    
    /**
     * Define any packages to be loaded during various operations (graph, export)
     * This lets you easily see the format your objects need to be in.
     * Syntax of :
     * 'packages = array(
     *      array( 'pkg'=> <model_name>, 'path'=> 'model/', 'table_prefix' => <table_prefix>)
     *  ),
     * translates to:
     * 'packages = array(
     *      array( 'pkg'=> <model_name>, 'path'=> $pkg_root_dir.'/core/components/<namespace>/model/', 'table_prefix' => <table_prefix>)
     *  ),
     */
    'packages' => array(),
    
    'support' => array(
        'email' => '',
        'issues' => '',
        'forum' => '',
        'wiki' => 'http://xkcd.com/293/',
        'source' => '',
    ),
    'authors' => array(),
    /**
     * Used when building packages and for running install/import because we need to know 
     * which fields identify an object and how to handle them if they already exist.
     */
    'build_attributes' => array(
         'modCategory' => array(
                xPDOTransport::PRESERVE_KEYS => true,
                xPDOTransport::UPDATE_OBJECT => false, // <-- moot point when we only have a single column
                xPDOTransport::UNIQUE_KEY => array('category'),
                xPDOTransport::RELATED_OBJECTS => true,
                xPDOTransport::RELATED_OBJECT_ATTRIBUTES => array (
                    'Snippets' => array(
                        xPDOTransport::PRESERVE_KEYS => false,
                        xPDOTransport::UPDATE_OBJECT => true,
                        xPDOTransport::UNIQUE_KEY => 'name',
                    ),
                    'Chunks' => array (
                        xPDOTransport::PRESERVE_KEYS => false,
                        xPDOTransport::UPDATE_OBJECT => true,
                        xPDOTransport::UNIQUE_KEY => 'name',
                    ),
                    'Plugins' => array (
                        xPDOTransport::PRESERVE_KEYS => false,
                        xPDOTransport::UPDATE_OBJECT => true,
                        xPDOTransport::UNIQUE_KEY => 'name',
                        xPDOTransport::RELATED_OBJECT_ATTRIBUTES => array (
                            'PluginEvents' => array(
                                 xPDOTransport::PRESERVE_KEYS => true,
                                 xPDOTransport::UPDATE_OBJECT => false,
                                 xPDOTransport::UNIQUE_KEY => array('pluginid','event'),
                             ),
                         ),
                    ),
                    'modTemplate' => array(
                        xPDOTransport::PRESERVE_KEYS => false,
                        xPDOTransport::UPDATE_OBJECT => true,
                        xPDOTransport::UNIQUE_KEY => 'templatename',
                    ),
                    'modTemplateVar' => array(
                        xPDOTransport::PRESERVE_KEYS => false,
                        xPDOTransport::UPDATE_OBJECT => true,
                        xPDOTransport::UNIQUE_KEY => 'name',
                    ),
            )
        ),        
        'modSystemSetting' => array(
        	xPDOTransport::UNIQUE_KEY => 'key',
        	xPDOTransport::PRESERVE_KEYS => true,
        	xPDOTransport::UPDATE_OBJECT => true, // <-- critical! We don't want to overwrite user's values	
        ),
        'modMenu' => array(
            xPDOTransport::PRESERVE_KEYS => true,
            xPDOTransport::UPDATE_OBJECT => true,
            xPDOTransport::UNIQUE_KEY => 'text',
            xPDOTransport::RELATED_OBJECTS => true,
            xPDOTransport::RELATED_OBJECT_ATTRIBUTES => array (
               'Action' => array(
                    xPDOTransport::PRESERVE_KEYS => false,
                    xPDOTransport::UPDATE_OBJECT => true,
                    xPDOTransport::UNIQUE_KEY => array(
                       'namespace',
                       'controller'
                    ),
                ),
            ),
        ),
        // Elements
        'modSnippet' => array(
            xPDOTransport::PRESERVE_KEYS => false,
            xPDOTransport::UPDATE_OBJECT => true,
            xPDOTransport::UNIQUE_KEY => 'name',
        ),
        'modChunk' => array (
            xPDOTransport::PRESERVE_KEYS => false,
            xPDOTransport::UPDATE_OBJECT => true,
            xPDOTransport::UNIQUE_KEY => 'name',
        ),
        'modTemplate' => array(
            xPDOTransport::PRESERVE_KEYS => false,
            xPDOTransport::UPDATE_OBJECT => true,
            xPDOTransport::UNIQUE_KEY => 'templatename',
        ),
        'modTemplateVar' => array(
            xPDOTransport::PRESERVE_KEYS => false,
            xPDOTransport::UPDATE_OBJECT => true,
            xPDOTransport::UNIQUE_KEY => 'name',
        ),        
        'modDocument' => array(
            xPDOTransport::PRESERVE_KEYS => false,
            xPDOTransport::UPDATE_OBJECT => true,
            xPDOTransport::UNIQUE_KEY => array('context_key','uri'),
        ),
        'modResource' => array(
            xPDOTransport::PRESERVE_KEYS => false,
            xPDOTransport::UPDATE_OBJECT => true,
            xPDOTransport::UNIQUE_KEY => array('context_key','uri'),
        ),
        'modPlugin' => array (
            xPDOTransport::PRESERVE_KEYS => false,
            xPDOTransport::UPDATE_OBJECT => true,
            xPDOTransport::UNIQUE_KEY => 'name',
            xPDOTransport::RELATED_OBJECTS => true,
			xPDOTransport::RELATED_OBJECT_ATTRIBUTES => array (
		        'PluginEvents' => array(
		            xPDOTransport::PRESERVE_KEYS => true,
		            xPDOTransport::UPDATE_OBJECT => false,
		            xPDOTransport::UNIQUE_KEY => array('pluginid','event'),
		        ),
    		),
        ),
        'modPluginEvent' => array(
            xPDOTransport::PRESERVE_KEYS => true,
            xPDOTransport::UPDATE_OBJECT => false,
            xPDOTransport::UNIQUE_KEY => array('pluginid','event'),
        ),
       'modAction' => array(
            xPDOTransport::PRESERVE_KEYS => false,
            xPDOTransport::UPDATE_OBJECT => true,
            xPDOTransport::UNIQUE_KEY => array(
               'namespace',
               'controller'
            ),
            xPDOTransport::RELATED_OBJECTS => true,
            xPDOTransport::RELATED_OBJECT_ATTRIBUTES => array (
               'Menus' => array(
                    xPDOTransport::PRESERVE_KEYS => true,
                    xPDOTransport::UPDATE_OBJECT => true,
                    xPDOTransport::UNIQUE_KEY => 'text',           
               ),
            ),
       ),
       'modContentType' => array(
            xPDOTransport::PRESERVE_KEYS => false,
            xPDOTransport::UPDATE_OBJECT => true,
            xPDOTransport::UNIQUE_KEY => 'name',       
       ),
       'modDashboard' => array(
            xPDOTransport::PRESERVE_KEYS => false,
            xPDOTransport::UPDATE_OBJECT => true,
            xPDOTransport::UNIQUE_KEY => 'name',       
       ),
       'modUserGroup' => array(
            xPDOTransport::PRESERVE_KEYS => false,
            xPDOTransport::UPDATE_OBJECT => true,
            xPDOTransport::UNIQUE_KEY => 'name',       
       ),
       'modUserGroupRole' => array(
            xPDOTransport::PRESERVE_KEYS => false,
            xPDOTransport::UPDATE_OBJECT => true,
            xPDOTransport::UNIQUE_KEY => 'name',       
       ),
       'modPropertySet' => array(
            xPDOTransport::PRESERVE_KEYS => false,
            xPDOTransport::UPDATE_OBJECT => true,
            xPDOTransport::UNIQUE_KEY => 'name',       
       ),
       'modUserGroupRole' => array(
            xPDOTransport::PRESERVE_KEYS => false,
            xPDOTransport::UPDATE_OBJECT => true,
            xPDOTransport::UNIQUE_KEY => 'name',       
       ),
       'modNamespace' => array(
            xPDOTransport::PRESERVE_KEYS => false,
            xPDOTransport::UPDATE_OBJECT => true,
            xPDOTransport::UNIQUE_KEY => 'name',       
       ),
       'modUser' => array(
            xPDOTransport::PRESERVE_KEYS => false,
            xPDOTransport::UPDATE_OBJECT => true,
            xPDOTransport::UNIQUE_KEY => 'username',       
       ),
       'modContext' => array(
            xPDOTransport::PRESERVE_KEYS => false,
            xPDOTransport::UPDATE_OBJECT => true,
            xPDOTransport::UNIQUE_KEY => 'key',   
       ),
       'modDashboardWidget' => array(
            xPDOTransport::PRESERVE_KEYS => true,
            xPDOTransport::UPDATE_OBJECT => true,
            xPDOTransport::UNIQUE_KEY => array('name','namespace'),
            xPDOTransport::RELATED_OBJECTS => true,
            xPDOTransport::RELATED_OBJECT_ATTRIBUTES => array (
               'Placements' => array(
                    xPDOTransport::PRESERVE_KEYS => true,
                    xPDOTransport::UPDATE_OBJECT => true,
                    xPDOTransport::UNIQUE_KEY => array('dashboard','widget'),
               ),
            ),
            
       ),
       'modDashboardWidgetPlacement' => array(
            xPDOTransport::PRESERVE_KEYS => false,
            xPDOTransport::UPDATE_OBJECT => true,
            xPDOTransport::UNIQUE_KEY => array('dashboard','widget'),
        )
        
    ), // end build_attributes
);
/*EOF*/