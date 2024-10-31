<?php
/*
Plugin Name: RSS Scroller
Plugin URI: http://www.vonrueden-design.de/blog/wordpress/rss-feed-sidebar-scroller-widget.html
Description: RSS Feed Sidebar Scroller Widget by <a href="www.vonrueden-design.de">VON RUEDEN DESIGN</a> - Ben&ouml;tigt <a href="http://jquery.com/" target="_blank">jQuery</a>.
Author: Richard von Rueden
Version: 1.1
Author URI: http://www.vonrueden-design.de/blog
*/
add_action('rss_scroller_style',  wp_enqueue_style( 'rss_scroller_style',  get_bloginfo('wpurl')."/wp-content/plugins/rss-feed-scroller-widget/rss_scroller_style.css", array(), '1.0', 'all' ), 0 );
add_action('rss_scroller_script',  wp_enqueue_script( 'rss_scroller_script',  get_bloginfo('wpurl')."/wp-content/plugins/rss-feed-scroller-widget/script.js", false, false, false ), 0 );  

class RssScroller extends WP_Widget {

function RssScroller() {
  parent::WP_Widget(false, $name = 'RSS Scroller');	
}

function widget($args, $instance) {		

  extract( $args );  
  $title = apply_filters('widget_title', $instance['title']);
  $url = apply_filters('widget_url', $instance['url']);
  $count = apply_filters('widget_count', $instance['count']);
  $width = apply_filters('widget_width', $instance['width']);
  $height = apply_filters('widget_height', $instance['height']);

  echo $before_widget;
  
  if ( $title ) echo $before_title . $title . $after_title;
               
    $source = @file($url); 
    $ticker = implode ("", $source);
    preg_match_all("|<item>(.*)</item>|Uism",$ticker, $items, PREG_PATTERN_ORDER);
      if (count($items[1])==0) {
      preg_match_all("|<item .*>(.*)</item>|Uism",$ticker, $items, PREG_PATTERN_ORDER);
    }    
    echo "<dl id=\"ticker\" style=\"width:".$width."px; height:".$height."px;\">";    
    
    if($count==0 || $count==""){
    for ($i=0; $i<count($items[1]); $i++) {
      preg_match_all("|<title>(.*)</title>(.*)<link>(.*)</link>|Uism",$items[1][$i], $regs, PREG_PATTERN_ORDER);
      echo "<dt></dt>
      <dd><a href=\"".$regs[3][0]."\" title=\"".$regs[1][0]."\">".$regs[1][0]."</a></dd>";
    }
    }

    else{
    for ($i=0; $i<$count; $i++) {
      preg_match_all("|<title>(.*)</title>(.*)<link>(.*)</link>|Uism",$items[1][$i], $regs, PREG_PATTERN_ORDER);
      echo "<dt></dt>
      <dd><a href=\"".$regs[3][0]."\" target=\"_blank\">".$regs[1][0]."</a></dd>";
    }        
    }     
    
    echo "</dl>";
    echo $after_widget;
    
  }

    function update($new_instance, $old_instance) {				
    	 $instance = $old_instance;
	     $instance['title'] = strip_tags($new_instance['title']);
	     $instance['url'] = strip_tags($new_instance['url']);
	     $instance['count'] = strip_tags($new_instance['count']);
       $instance['width'] = strip_tags($new_instance['width']);	
       $instance['height'] = strip_tags($new_instance['height']);		     
       return $instance;
    }

    function form($instance) {				
        $title = esc_attr($instance['title']);
        $url= esc_attr($instance['url']);
        $count = esc_attr($instance['count']);
        $width = esc_attr($instance['width']); 
        $height = esc_attr($instance['height']);         
?>

<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Titel:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
<p><label for="<?php echo $this->get_field_id('url'); ?>"><?php _e('Feed URL:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('url'); ?>" type="text" value="<?php echo $url; ?>" /></label></p>
<p><label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Anzahl Feeds:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo $count; ?>" /></label>
<span style="color:#ff0000;">0 = Alle anzeigen</span></p>
<p><label for="<?php echo $this->get_field_id('width'); ?>"><?php _e('Breite:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text" value="<?php echo $width; ?>" /></label></p>
<p><label for="<?php echo $this->get_field_id('height'); ?>"><?php _e('H&ouml;he:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" type="text" value="<?php echo $height; ?>" /></label></p>
<?php 
}
} 
add_action('widgets_init', create_function('', 'return register_widget("RssScroller");'));
?>