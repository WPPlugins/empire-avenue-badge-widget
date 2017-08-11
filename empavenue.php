<?php
/*
Plugin Name: Empire avenue badge widget
Plugin URI: http://blog.yalamber.com/2010/06/08/empire-avenue-badge-widget/ 
Description: This will add empire avenue badge widget to your blog.
Author: Yalamber subba
Version: 1.0
Author URI: http://yalamber.com/
*/
add_action("widgets_init", array('Empire_avenue', 'register'));
register_activation_hook( __FILE__, array('Empire_avenue', 'activate'));
register_deactivation_hook( __FILE__, array('Empire_avenue', 'deactivate'));
class Empire_avenue {
  function activate(){
    $data = array( 'eav_t' => 'DUPS' ,'eav_s' => 2);
    if ( ! get_option('empire_avenue')){
      add_option('empire_avenue' , $data);
    } else {
      update_option('empire_avenue' , $data);
    }
  }
  function deactivate(){
    delete_option('empire_avenue');
  }
  function control(){
	  $data = get_option('empire_avenue');
	  ?>
	  <p><label>eav_t<input name="eav_t" type="text" value="<?php echo $data['eav_t']; ?>" /></label></p>
	  <p><label>eav_s<input name="eav_s" type="text" value="<?php echo $data['eav_s']; ?>" /></label></p>
	  <?php
	   if (isset($_POST['eav_t'],$_POST['eav_s'])){
		$data['eav_t'] = attribute_escape($_POST['eav_t']);
		$data['eav_s'] = attribute_escape($_POST['eav_s']);
		update_option('empire_avenue', $data);
	  }
	}
  function widget($args){
    echo $args['before_widget'];
    echo $args['before_title'] . '' . $args['after_title'];
   	$data = get_option('empire_avenue');
   		?>
		<script type="text/javascript" charset="utf-8">
        //EDIT THE FOLLOWING VARIABLES
        //enter your exact ticker
        var eav_t = "<?php echo $data['eav_t']; ?>";
        //Size 1 is 100x100 and Size 2 is 190x167
        var eav_s = <?php echo $data['eav_s']; ?>;
        //Do not edit the following:
        var eav_is_ssl = ("https:" == document.location.protocol);
        var eav_asset_host = eav_is_ssl ? "https://badge.empireavenue.com/" : "http://badge.empireavenue.com/";
        document.write(unescape("%3Cscript src='" + eav_asset_host + "blog/?t=" + eav_t + "&l=" + escape(window.location) +"&s=" + eav_s + "' type='text/javascript'%3E%3C/script%3E"));
        </script>
        <?php
    echo $args['after_widget'];
  }
  function register(){
    register_sidebar_widget('Empire avenue badge', array('Empire_avenue', 'widget'));
    register_widget_control('Empire avenue badge', array('Empire_avenue', 'control'));
  }
}

?>
