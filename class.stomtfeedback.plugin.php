<?php if (!defined('APPLICATION')) exit();

/**
 *  Yandex Metrika plugin.
 *
 * @copyright 2014-2018 Ivan Gurin
 * @license http://www.opensource.org/licenses/gpl-2.0.php GNU GPL v2
 */

$PluginInfo['StomtFeedback'] = 
	array(
		'Name' => 'Stomt Feedback',
		'Description' => 'STOMT makes it easy for anyone to provide instant feedback. This plugin allows you to customize the STOMT feedback button and add it to your wordpress site.Installation is simple and only takes seconds.',
		'License' => 'GNU GPL2',
		'Version' => '1.0',
 		'Date' => 'April 25, 2018',
		'Author' => 'Mariem Bader',
		'AuthorEmail' => 'bader.mariem1@gmail.com',
		'AuthorUrl' => 'https://open.vanillaforums.com/profile/mariem_bader122',
		'SettingsUrl' => 'settings/StomtFeedback',
		'RequiredApplications' => array('Dashboard' => '>=2.0.0'));

/*
$Configuration['Plugins']['StomtFeedback']['TrackerId'] = '00000000';
*/

/**
 * Class StomtFeedbackPlugin
 */
class StomtFeedbackPlugin implements Gdn_IPlugin {
	
	public function SettingsController_StomtFeedback_Create($Sender) {
		$Sender->Permission('Garden.Plugins.Manage');
		$Sender->AddSideMenu();
		$Sender->Title('Stomt Feedback');
		$ConfigurationModule = new ConfigurationModule($Sender);
		$ConfigurationModule->RenderAll = True;

    $items = [
            'left' => 'left',
            'right' => 'right'
        ];
		$Schema =
                  array(
        'Plugins.StomtFeedback.TrackerId' => 
                      array(
                        'LabelCode' => 'App',
                        'Control' => 'TextBox',
                        'Default' => C('Plugins.StomtFeedback.TrackerId', '')

                    ),'Plugins.StomtFeedback.position' => 
                      array(
                        'LabelCode' => 'Position',
                        'Control' => 'radiolist',
                        'Items' => $items,

                        'Default' => C('Plugins.StomtFeedback.position', 'right')

                    ),'Plugins.StomtFeedback.label' => 
                      array(
                        'LabelCode' => 'Label',
                        'Control' => 'TextBox',
                        'Default' => C('Plugins.StomtFeedback.label', 'Feedback')
                    ),'Plugins.StomtFeedback.colortext' => 
                      array(
                        'LabelCode' => 'TextColor',
                        'Control' => 'TextBox',
                        'Default' => C('Plugins.StomtFeedback.colortext', '#FFFFFF')

                    ),'Plugins.StomtFeedback.colorbackg' => 
                      array(
                        'LabelCode' => 'Background-Color',
                        'Control' => 'TextBox',
                        'Default' => C('Plugins.StomtFeedback.colorbackg', '#0091C9')

                    ),'Plugins.StomtFeedback.colorhover' => 
                      array(
                        'LabelCode' => 'Hover-Color',
                        'Control' => 'TextBox',
                        'Default' => C('Plugins.StomtFeedback.colorhover', '#04729E')

                    )

                  );
		$ConfigurationModule->Schema($Schema);
		$ConfigurationModule->Initialize();
		$Sender->View = dirname(__FILE__) . DS . 'views' . DS . 'settings.php';
		$Sender->ConfigurationModule = $ConfigurationModule;
		$Sender->Render();
	}
	
	
	public function Base_AfterBody_Handler($Sender) {

        if ($Sender->MasterView == 'admin')
            return;

       $appId = C('Plugins.StomtFeedback.TrackerId');
        $position = C('Plugins.StomtFeedback.position');
        $label = C('Plugins.StomtFeedback.label');
        $TextColor = C('Plugins.StomtFeedback.colortext');
        $backgColor = C('Plugins.StomtFeedback.colorbackg');
        $hoverColor = C('Plugins.StomtFeedback.colorhover');
    
 echo "
 <script>
 var options = {
  appId: '".$appId."',
  position: '".$position."',
  label: '".$label."',
  colorText: ' ".$TextColor."',
  colorBackground: ' ".$backgColor."', 
  colorHover: ' ".$hoverColor."' ,
  ShowClose:true
};
  // Include the STOMT JavaScript SDK
  (function(w, d, n, r, t, s){
    w.Stomt = w.Stomt||[];
    t = d.createElement(n);
    s = d.getElementsByTagName(n)[0];
    t.async=1;
    t.src=r;
    s.parentNode.insertBefore(t,s);
  })(window, document, 'script', 'https://www.stomt.com/widget.js');
  
  // Adjust the 'APP_ID' to your application id 
  // you can find it here: https://www.stomt.com/YOUR_PAGE/apps
  Stomt.push(['addTab', options]);
  Stomt.push(['addCreate', options]);
  
</script>";

	}
	
	public function Setup() {
	}
}