<?php
if (!defined('APPLICATION')) exit();

/**
 * Stomt Feedback module
 *
 * @package StomtFeedback
 * @author <a href="https://github.com/mariembader123">Mariem Bader</a>
 * @copyright 2018 STOMT Gmbh.
 * @license GPL2
 * @since 1.0
 */

/**
 * Renders the Stomt Feedback. Built for use in a side panel.
 */
class StomtFeedbackModule extends Gdn_Module {
   
    public function AssetTarget() {
        return 'Panel';
    }

    public function ToString() {  

        $id = c( 'Plugin.StomtFeedback.id' );
        $position = c( 'Plugin.StomtFeedback.position' );
        $label = c( 'Plugin.StomtFeedback.label' );
        $textColor = c( 'Plugin.StomtFeedback.textColor' );
        $backgroundColor = c( 'Plugin.StomtFeedback.backgroundColor' );
        $HoverColor = c( 'Plugin.StomtFeedback.HoverColor' );

              echo "string";    


               echo "<script>
               var options = {
                    appId: '".$id."',
                    position: '".$position."', 
                    label: '".$label."', 
                    colorText: '".$textColor."',
                    colorBackground: '".$backgroundColor."', 

                    colorHover: '".$HoverColor."',
                    showClose: true
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
  Stomt.push(['addFeed', options]);
  Stomt.push(['addCreate', options]);
</script>";

    }
}

?>
