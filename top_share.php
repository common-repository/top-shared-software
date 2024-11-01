<?php
/**
 * Plugin Name: Top shared Freeware
 
 * Plugin URI: http://www.logicielsgratuits.org
 
 * Description: Top of most shared freeware on social network 
 
 * Author: Hilflo
 
 * Version: 1.0
 
 * Author URI: http://www.logicielsgratuits.org
 
 * License: GPLv2 or later 
 */

class top_share_freeware_widget extends WP_Widget {

	// Constructor //

		function top_share_freeware_widget() {
			$widget_ops = array( 'classname' => 'top_share_widget_widget', 'description' => 'Top freeware shared on social network' ); // Widget Settings
			$control_ops = array( 'id_base' => 'top_share_freeware_widget' ); // Widget Control Settings
			$this->WP_Widget( 'top_share_freeware_widget', 'Top shared Freeware', $widget_ops, $control_ops ); // Create the widget
		}

	// Extract Args //

		function widget($args, $instance) {
			extract( $args );
			$title 		= apply_filters('widget_title', $instance['title']); // the widget title
			$r_c_number	= $instance['r_c_number']; // choix de la region

			echo $before_widget;
		

	// Title of widget //

			if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;

	// Widget output //
			
			$rss = 'http://www.logicielsgratuits.org/top_share_feed.php?limit='.$r_c_number;
			if(!$xml=simplexml_load_file($rss)){
			trigger_error('Error reading XML file',E_USER_ERROR);
			}
		?>

<ul class="top_share_list">
    <?php 
    foreach ( $xml as $item ) : 
	?>
    <li class="share_li">	
        <a href='<?php echo esc_url( $item->link ); ?>'
        title='<?php echo esc_html( $item->description ); ?>'>
        <?php echo esc_html( $item->title ); ?></a><br />
		Partag&eacute;s : <?php echo $item->fan; ?> fois<br />
    </li>
    <?php endforeach; ?>
	<li style="float:right"><a href="http://www.logicielsgratuits.org/popular/" title="Voir le classement complet">Voir plus</a></li>
</ul>
			
			<?php
			

	// After widget //

			echo $after_widget;
		}

	// Update Settings //

		function update($new_instance, $old_instance) {
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['r_c_number'] = strip_tags($new_instance['r_c_number']);
			return $instance;
		}

	// Widget Control Panel //
		

		function form($instance) {
		$defaults = array( 'title' => 'Top shared Freeware', 'r_c_number' => 5);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>'" type="text" value="<?php echo $instance['title']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('r_c_number'); ?>">Nombre:</label>
			<select id="<?php echo $this->get_field_id('r_c_number'); ?>" name="<?php echo $this->get_field_name('r_c_number'); ?>'">
			<option value="<?php echo $instance['r_c_number']; ?>"><?php echo $instance['r_c_number']; ?></option>
			<option value="5">5</option>
			<option value="10">10</option>
			<option value="15">15</option>
			<option value="20">20</option>
			</select>
		</p>
	     <?php }

}

add_action('widgets_init', create_function('', 'return register_widget("top_share_freeware_widget");'));

?>