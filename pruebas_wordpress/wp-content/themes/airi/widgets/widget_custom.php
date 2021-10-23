<?php
class custom_widget extends WP_Widget{
    
    function __construct()
    {
        parent::__construct("custom_widget",__("Simple Custom Widget","custom_widget",array("description"=>__("Widget personalizado para Aiudo","custom_widget"))));
    }
    public function widget($args,$instance){
        $title= apply_filters("widget_title",$instance['title']);
        echo $args['before_widget'];
        if(!empty($title)) echo $args['before_title'].$title.$args['after_title'];
        echo __("Widget presonalizado para Aiudo","custom_widget");
        echo $args['after_widget'];
    }

    
}