<?php if( !defined( 'APPLICATION' ) ) exit(); ?>

<?php
/**
 * Settings
 *
 * Setup settings page HTML
 *
 * @package StomtFeedback
 * @author <a href="https://github.com/mariembader123">Mariem Bader</a>
 * @copyright 2018 STOMT Gmbh.
 * @license GPL2
 * @since 1.0
 */
?>

<h1><?php echo T( $this->Data[ 'Title' ] ); ?></h1>

<?php
    echo $this->Form->open();
    echo $this->Form->errors();
?>
<p class="StomtFeedback__info">
    <strong>Your APP ID (can be found in your Stomt Settings page)</strong>
</p>

<ul>
    <li><?php 
        echo $this->Form->label( 'App-ID?', 'Plugin.StomtFeedback.id' );
        echo $this->Form->input( 'Plugin.StomtFeedback.id' );
    ?></li>
    <li><?php
        echo $this->Form->label( 'Position', 'Plugin.StomtFeedback.position' );
        echo $this->Form->dropDown( 'Plugin.StomtFeedback.position', array(
            'right' => 'right',
            'left' => 'left'
        ) );
    ?></li>
    <li><?php 
        echo $this->Form->label( 'label', 'Plugin.StomtFeedback.label' );
        echo $this->Form->input( 'Plugin.StomtFeedback.label' );
    ?></li>
    <li><?php 
        echo $this->Form->label( 'textColor', 'Plugin.StomtFeedback.textColor' );
        echo $this->Form->color( 'Plugin.StomtFeedback.textColor' );
    ?></li>
     <li><?php 
        echo $this->Form->label( 'backgroundColor', 'Plugin.StomtFeedback.backgroundColor' );
        echo $this->Form->color( 'Plugin.StomtFeedback.backgroundColor' );
    ?></li>


    <li><?php 
        echo $this->Form->label( 'HoverColor', 'Plugin.StomtFeedback.HoverColor' );
        echo $this->Form->color( 'Plugin.StomtFeedback.HoverColor' );
    ?></li>

    
</ul>
<br>
<?php
    echo $this->Form->close( 'Save' );
?>

