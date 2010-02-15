<?php
/**
 * Ipsum Controller class
 *
 * The Ipsum Controller allows the user to run the demo and also contains the
 * function for generating an image.
 * @package    Ipsum
 * @version    v2.0
 * @author     Jeremy Lindblom <jeremy@synapsestudios.com>
 * @copyright  Copyright (c) 2009 Synapse Studios
 */
class Controller_Ipsum extends Controller
{
	/**
	 * Rund the demo for the ipsum module
	 */
	public function action_demo()
	{
		echo Ipsum::heading(1);
		echo Ipsum::heading(2);
		echo Ipsum::heading(3);
		echo Ipsum::heading(4);
		echo Ipsum::heading(5);
		echo Ipsum::heading(6);
		echo 'WORD: '.Ipsum::words().'<br />';
		echo 'SENTENCE: '.Ipsum::sentences().'<br />';
		echo Ipsum::paragraphs();
		echo Ipsum::blockquote();
		echo Ipsum::ul();
		echo Ipsum::ol();
		echo Ipsum::image(rand(300,600), rand(100,300));
		echo '<hr />';
		echo Ipsum::page();
	}

	/**
	 * Creates and displays a dummy image based on paramters in $_GET
	 */
	public function action_image()
	{
		// Get image arguments
		extract(arr::extract($_GET, array('width', 'height', 'font_size', 'border')));

		// Make sure server supports GD
		if ( ! function_exists('imagecreatetruecolor')) die('GD not supported on this server.');

		// Sanitize width, height, and border sizes
		$w = $width  = is_numeric($width)     ? (int) $width     : 150;
		$h = $height = is_numeric($height)    ? (int) $height    : $width;
		$b = $border = is_numeric($border)    ? (int) $border    : 4;
		$font_size   = is_numeric($font_size) ? (int) $font_size : 30;

		// Create the image
		$image = @imagecreatetruecolor($width, $height) OR die('Image creation failed.');

		// Create positions matrix
		$pos = array(
			'TL' => array('x' => $b,		'y' => $b),
			'TC' => array('x' => $w/2,		'y' => $b),
			'TR' => array('x' => $w-$b-1,	'y' => $b),
			'ML' => array('x' => $b,		'y' => $h/2),
			'MC' => array('x' => $w/2,		'y' => $h/2),
			'MR' => array('x' => $w-$b-1,	'y' => $h/2),
			'BL' => array('x' => $b,		'y' => $h-$b-1),
			'BC' => array('x' => $w/2,		'y' => $h-$b-1),
			'BR' => array('x' => $w-$b-1,	'y' => $h-$b-1),
		);

		// Create the colors
		$colors = array(
			'black'		=> imagecolorallocate($image, 0, 0, 0),
			'dark_gray'	=> imagecolorallocate($image, 64, 64, 64),
			'lite_gray'	=> imagecolorallocate($image, 224, 224, 224),
			'white'		=> imagecolorallocate($image, 255, 255, 255)
		);

		// Create the border and background
		imagefilledrectangle($image, 0, 0, $width, $height, $colors['black']);
		imagefilledrectangle($image, $border, $border, $w-$b-1, $h-$b-1, $colors['lite_gray']);

		// Create the lines
		imageline($image, $pos['TL']['x'], $pos['TL']['y'], $pos['BR']['x'], $pos['BR']['y'], $colors['white']);
		imageline($image, $pos['TC']['x'], $pos['TC']['y'], $pos['BC']['x'], $pos['BC']['y'], $colors['white']);
		imageline($image, $pos['TR']['x'], $pos['TR']['y'], $pos['BL']['x'], $pos['BL']['y'], $colors['white']);
		imageline($image, $pos['ML']['x'], $pos['ML']['y'], $pos['MR']['x'], $pos['MR']['y'], $colors['white']);

		// Draw image label with an outline
		$font_file = MODPATH.'ipsum/ipsum.ttf';
		$image_text = $width.' x '.$height;
		$bounding_box = imagettfbbox($font_size, 0, $font_file, $image_text);
		$bbw = $bounding_box[2] - $bounding_box[0];
		$bbh = $bounding_box[7] - $bounding_box[1];
		imagefilledrectangle($image, $w/2-$bbw/2-$b, $h/2+$bbh/2-$b, $w/2+$bbw/2+$b, $h/2-$bbh/2+$b, $colors['white']);
		imagettftext($image, $font_size, 0, $w/2-$bbw/2, $h/2-$bbh/2, $colors['dark_gray'], $font_file, $image_text);
		
		// Display the image
		header("Content-type: image/png");
		imagepng($image);
		imagedestroy($image);
		die;
	}
	
}