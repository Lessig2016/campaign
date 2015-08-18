<?php
extract( shortcode_atts( array(
			'height' => '400',
			'map_height' => 'custom',

			'latitude' => '',
			'longitude' => '',
			'address' => '',

			'latitude_2' => '',
			'longitude_2' => '',
			'address_2' => '',

			'latitude_3' => '',
			'longitude_3' => '',
			'address_3' => '',

			'map_type' => 'ROADMAP',
			'zoom' => '14',
			'draggable' => 'true',
			'pan_control' => 'true',
			'zoom_control' => 'true',
			'map_type_control' => 'true',
			'scale_control' => 'true',
			'pin_icon' => '',
			'modify_json' => 'false',
			'map_json' => '',
			'modify_coloring' => 'false',
			'hue' => '#ccc',
			'saturation' => '',
			'lightness' => ''			
		), $atts ) );

// Define mutable variables
$style = $map_height_class = '';


// Quit if no lat / lang 
if( $longitude == '' && $latitude == '') { return null; }
// Zoom cannot be less than one
if( $zoom < 1 ) $zoom = 1;
// Disable coloring options when full JSON customization is passed
if( $modify_json == 'true' ) $modify_coloring = 'false';
// Apply full height class if not custom height
if( $map_height != 'custom' ) $map_height_class = 'dc__full-height';


// Unique Module ID
$id = 'google-map-' . uniqid();


////////////////////////////////////////////////////////////////
//
// Collect JSON config for JS
//
////////////////////////////////////////////////////////////////

//
// data-places
//
$place1 = '{
	"address"   : "'.$address.'",
	"latitude"  : '.$latitude.', 
	"longitude" : '.$longitude.'
}';

$place2 = ( !empty($latitude_2) && !empty($longitude_2) ) ? ',{
	"address"   : "'.$address_2.'",
	"latitude"  : '.$latitude_2.', 
	"longitude" : '.$longitude_2.'
}' : '';

$place3 = ( !empty($latitude_3) && !empty($longitude_3) ) ? ',{
	"address"   : "'.$address_3.'",
	"latitude"  : '.$latitude_3.', 
	"longitude" : '.$longitude_3.'
}' : '';

$places = '['.$place1.$place2.$place3.']';
// places

//
// data-options
//
$options = '{
	"zoom"      : '.$zoom.',
	"draggable" : '.$draggable.',
	"panControl": '.$pan_control.',
	"zoomControl": '.$zoom_control.',
	"scaleControl": '.$scale_control.',
	"mapTypeControl" : '.$map_type_control.',
    "mapTypeId": "'.$map_type.'"
}';
// options

// 
// data-style
//
if( $modify_coloring != 'false' ) {
	$style = '[{
	    "stylers": [{
	        "hue": "'.$hue.'"
	    }, {
	        "saturation": '.$saturation.'
	    }, {
	        "lightness": '.$lightness.'
	    }, {
	        "featureType": "landscape.man_made",
	        "stylers": [{
	            "visibility": "on"
	        }]
	    }]
	}]';
}
else if( $modify_json != 'false' ) {
	$style = urldecode(base64_decode($map_json));
}
// style


////////////////////////////////////////////////////////////////
//
// HTML Output
//
////////////////////////////////////////////////////////////////


$output .= '<div id="'. $id .'" class="mk-advanced-gmaps '. $map_height_class .'" 
				data-options=\''. $options .'\' 
				data-places=\''. $places .'\' 
				data-style=\''. $style .'\'
				data-icon=\''. $pin_icon .'\'
			></div>';  

$output .= '<script src="http'. ( is_ssl() ? 's' : '' ) .'://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>';

echo $output;



////////////////////////////////////////////////////////////////
//
// Custom CSS Output
//
////////////////////////////////////////////////////////////////

if( $map_height == 'custom' ) {

	addCSS('
		#'.$id.' { height: '.$height.'px; }
	');
}

?>