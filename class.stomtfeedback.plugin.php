<?php

$PluginInfo[ 'StomtFeedback' ] = [
    'Name' => 'Stomt-Feedback',
    'Description' => 'Creates a settings page to setup your Stomt-Feedback and adds it to your website.',
    'Version' => '0.1',
    'RequiredApplications' => array( 'Vanilla' => '2.3' ),
    'SettingsUrl' => '/dashboard/settings/StomtFeedback',
    'SettingsPermission' => 'Garden.Settings.Manage',
    'RequiredPlugins' => FALSE,
    'RequiredTheme' => FALSE,
    'MobileFriendly' => TRUE,
    'RegisterPermissions' => array(
        'Plugins.StomtFeedback.Add',
        'Plugins.StomtFeedback.Manage',
        'Plugins.StomtFeedback.Notify',
        'Plugins.StomtFeedback.View'
    ),
    'Author' => '<a href="https://github.com/mariembader123">Mariem Bader</a>',
    'AuthorUrl' => 'https://github.com/mariembader123',
    'License' => 'MIT'
];

/**
 * Stomt Feedback
 *
 * Plugin that creates a settings page to setup your 
 * Stomt Feedback and adds it to your sidebar.
 *
 * @package StomtFeedback
 * @author <a href="https://github.com/mariembader123">Mariem Bader</a>
 * @copyright 2018 STOMT Gmbh.
 * @license MIT
 */
class StomtFeedback extends Gdn_Plugin {

	/**
     * Plugin constructor
     *
     * @package StomtFeedback
     * @since 1.0
     */
    public function __construct() {

    }

    /**
     * Plugin setup
     *
     * @package StomtFeedback
     * @since 1.0
     */
    public function setup() {

        // Set up the plugin's default values
        saveToConfig( 'Plugin.StomtFeedback.id', "" );
        saveToConfig( 'Plugin.StomtFeedback.position', "right" );
        saveToConfig( 'Plugin.StomtFeedback.label', "Feedback" );
        saveToConfig( 'Plugin.StomtFeedback.textColor', "#FFFFFF" );
        saveToConfig( 'Plugin.StomtFeedback.backgroundColor', "#0091C9" );
        saveToConfig( 'Plugin.StomtFeedback.HoverColor', "#04729E" );

        // Trigger database changes
        $this->structure();

    }

    /**
     * Plugin Structure
     *
     * @package StomtFeedback
     * @since 1.0
     */
    public function structure() {

    }

    /**
     * Plugin cleanup
     *
     * @package StomtFeedback
     * @since 1.0
     */
    public function onDisable() {

        removeFromConfig( 'Plugin.StomtFeedback.id', "" );
        removeFromConfig( 'Plugin.StomtFeedback.position', "right" );
        removeFromConfig( 'Plugin.StomtFeedback.label', "Feedback" );
        removeFromConfig( 'Plugin.StomtFeedback.textColor', "#FFFFFF" );
        removeFromConfig( 'Plugin.StomtFeedback.backgroundColor', "#0091C9" );
        removeFromConfig( 'Plugin.StomtFeedback.HoverColor', "#04729E" );


        

        // Never delete from the database OnDisable.
        // Usually, you want re-enabling a plugin to be as if it was never off.

    }

    /**
     * CSS/JS Event Hooks
     *
     * @param $Sender Sending controller instance
     *
     * @package StomtFeedback
     * @since 1.0
     */
   

	/**
	 * Default action on /discussion/poll is not found
	 *
	 * @param $Sender Sending controller instance
	 *
     * @package StomtFeedback
     * @since 1.0
	 */
	public function controller_index( $Sender ) {

		//shift request args for implied method
		array_unshift( $Sender->RequestArgs, NULL );
		$this->Controller_Results( $Sender );

	}

    /**
     * Stomt Feedback Controller
     *
     * @param $Sender Sending controller instance
     *
     * @package StomtFeedback
     * @since 1.0
     */
    public function settingsController_StomtFeedback_create( $Sender ) {

    	// Prevent non-admins from accessing this page
        $Sender->permission( 'Garden.Settings.Manage' );
        $Sender->addCSSFile('settings.css', 'plugins/StomtFeedback');
        $Sender->setData( 'PluginDescription',$this->getPluginKey( 'Description' ) );

        $Sender->Form = new Gdn_Form();

        $Validation = new Gdn_Validation();
        $ConfigurationModel = new Gdn_ConfigurationModel( $Validation );
        $ConfigurationModel->setField( array(
            'Plugin.StomtFeedback.id'	=> '',
            'Plugin.StomtFeedback.position' => 'right',
            'Plugin.StomtFeedback.label' => 'Feedback',
            'Plugin.StomtFeedback.textColor' => '#FFFFFF',
            'Plugin.StomtFeedback.backgroundColor' => '#0091C9',
            'Plugin.StomtFeedback.HoverColor' => '#04729E'
        ) );

        // Set the model on the form.
        $Sender->Form->setModel( $ConfigurationModel );

        // If seeing the form for the first time...
        if( $Sender->Form->authenticatedPostBack() === false ) {
            // Apply the config settings to the form.
            $Sender->Form->setData( $ConfigurationModel->Data );
		}
		else {
            //Validate
            //Save
            $Saved = $Sender->Form->save();
            //if( $Saved ) {
                $Sender->StatusMessage = t( "Your changes have been saved." );
            
                //Sort module position based on setting
                $ModuleSort = c( 'Modules.Vanilla.Panel' );
                $ModuleSort = preg_replace( '/\StomtFeedbackModule\b/', '', $ModuleSort); //Remove module from list
                $ModuleSort = array_filter( $ModuleSort ); //Clear empty slots
               
                SaveToConfig( 'Modules.Vanilla.Panel', $ModuleSort ); //Save the setting
            //}
        }

        $Sender->addSideMenu( '/dashboard/settings/StomtFeedback' );
        $Sender->title( 'Stomt-Feedback' );
        $Sender->render( $this->getView( 'settings.php' ) );

    }

    /**
     * Stomt Feedback Renderer
     *
     * @param $Sender Sending controller instance
     *
     * @package StomtFeedback
     * @since 1.0
     */
    public function Base_Render_Before( $Sender ) {

        $Controller = $Sender->ControllerName;
        $ShowOnController = array(
            'discussioncontroller',
            'categoriescontroller',
            'discussionscontroller',
            'profilecontroller',
            'activitycontroller'
        );

        if( !InArrayI( $Controller, $ShowOnController ) ) return; 


        $StomtFeedbackModule = new StomtFeedbackModule( $Sender );
        $Sender->AddModule( $StomtFeedbackModule );

    }

}

?>