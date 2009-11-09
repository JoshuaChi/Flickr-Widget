<?php
/*
Plugin Name: Flickr Widget
Plugin URI: http://www.freetofeel.com/flickr-widget/
Description: A widget which will display your Flickr photos.
Author: Joshua Chi <joshokn at gmail.com>
Version: 0.1
Author URI: http://www.freetofeel.com/

Installing
1. Make sure you have the Widget plugin available at http://automattic.com/code/widgets/
1. Copy flickr_widget.php to your plugins folder, /wp-content/plugins/widgets/
2. Activate it through the plugin management screen.
3. Go to Themes->Sidebar Widgets and drag and drop the widget to wherever you want to show it.
*/

function widget_flickr($args) {
	extract($args);

	$options = get_option('widget_flickr');
	if( $options == false ) {
		$options[ 'title' ] = 'Flickr Photos';
		$options[ 'bk-color' ] = '#FFFFFF';
	}
	$title = empty($options['title']) ? __('Flickr Photos') : $options['title'];
	$flickr_bk_color = $options[ 'bk-color' ];
	$flickr_rss_id = empty($options['flickr_rss_id']) ? __('40294857@N02') : $options['flickr_rss_id'];
	?>
	<?php echo $before_widget; ?>
	<?php echo $before_title . $title . $after_title; ?>
<!-- Start of Flickr Badge -->
<p>
<script type="text/javascript">
var zg_nsids = "<?php echo $flickr_rss_id ?>";
var zg_bg_color = "<?php echo $flickr_bk_color ?>";
</script>
<script src="http://www.flickr.com/fun/zeitgeist/badge.js.gne" type="text/javascript"></script>
</p>
<!-- End of Flickr Badge -->

		<?php echo $after_widget; ?>
<?php
}

function widget_flickr_control() {
	$options = $newoptions = get_option('widget_flickr');
	if( $options == false ) {
		$newoptions[ 'title' ] = 'Flickr Photos';
	}
	if ( $_POST["flickr-submit"] ) {
		$newoptions['title'] = strip_tags(stripslashes($_POST["flickr-title"]));
		$newoptions['bk-color'] = strip_tags(stripslashes($_POST["flickr-bk-color"]));
		$newoptions['flickr_rss_id'] = strip_tags(stripslashes($_POST["flickr-rss-url"]));
	}
	if ( $options != $newoptions ) {
		$options = $newoptions;
		update_option('widget_flickr', $options);
	}
	$title = wp_specialchars($options['title']);
	$flickr_bk_color = wp_specialchars($options['bk-color']);
	if ( empty($flickr_bk_color) ) $flickr_bk_color = '#FFFFFF';
	$flickr_rss_id = wp_specialchars($options['flickr_rss_id']);

	?>
	<p><label for="flickr-title"><?php _e('Title:'); ?> <input style="width: 250px;" id="flickr-title" name="flickr-title" type="text" value="<?php echo $title; ?>" /></label></p>
	<p><label for="flickr-rss-url"><?php _e('Flickr RSS ID:'); ?> <input style="width: 250px;" id="flickr-rss-url" name="flickr-rss-url" type="text" value="<?php echo $flickr_rss_id; ?>" /></label></p>
	<p><label for="flickr-bk-color"><?php _e('Widget Background Color:'); ?> <input style="width: 100px;" id="flickr-bk-color" name="flickr-bk-color" type="text" value="<?php echo $flickr_bk_color; ?>" /></label></p>
	<p align='left'>
	* Your RSS ID can be found on http://www.flickr.com/fun/zeitgeist/. <br /><em>var zg_nsids = 123456@N05';</em> <br />copy the value '123456@N05' into the box above.<br />
	<br clear='all'></p>
	<p>Leave the Flickr RSS URL blank to display <a href="http://freetofeel.com/">Joshua's</a> Flickr photos.</p>
	<input type="hidden" id="flickr-submit" name="flickr-submit" value="1" />
	<?php
}


function flickr_widgets_init() {
	register_widget_control('Flickr', 'widget_flickr_control', 500, 250);
	register_sidebar_widget('Flickr', 'widget_flickr');
}
add_action( "init", "flickr_widgets_init" );

?>
