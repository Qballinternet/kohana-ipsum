<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * The Ipsum helper is used to easily generate random lorem ipsum text in views.
 * It can also create lorem ipsum text inside specific HTML elements including
 * paragraphs, blockquotes, lists, and images.
 *
 * @package    Ipsum
 * @version    v2.0
 * @author     Jeremy Lindblom <jeremy@synapsestudios.com>
 * @copyright  Copyright (c) 2009 Synapse Studios
 */
class Ipsum
{
	/**
	 * Contains an array of lorem ipsum words retrieved from a text file.
	 *
	 * @var	array
	 */
	protected static $lorem_ipsum = array();

	/**
	 * Creates 1 or more random words
	 *
	 * @param	integer	$count
	 * @return	string
	 */
	public static function words($count = NULL)
	{
		if (empty(self::$lorem_ipsum))
		{
			$file = file_get_contents(MODPATH.'ipsum/ipsum.txt');
			self::$lorem_ipsum = array_unique(str_word_count(strtolower($file), 1));
		}

		$count = is_int($count) ? $count : 1;
		$keys = array_flip((array) array_rand(self::$lorem_ipsum, $count));
		$words = array_intersect_key(self::$lorem_ipsum, $keys);

		return implode(' ', $words);
	}

	/**
	 * Creates 1 or more sentences of random length
	 *
	 * @param	integer	$count
	 * @return	string
	 */
	public static function sentences($count = NULL)
	{
		$count = is_int($count) ? $count : 1;
		$sentences = '';
		for ($i = 0; $i < $count; $i++)
			$sentences .= ucfirst(self::words(rand(6, 13))).'. ';
		return trim($sentences);
	}

	/**
	 * Creates 1 or more paragraphs of random length
	 *
	 * @param	integer	$count
	 * @return	string
	 */
	public static function paragraphs($count = NULL)
	{
		$count = is_int($count) ? $count : 1;
		$paragraphs = '';
		for ($i = 0; $i < $count; $i++)
			$paragraphs .= "<p>".self::sentences(rand(4, 9))."</p>\n";
		return trim($paragraphs);
	}

	/**
	 * Creates a page of text with a random number of paragraphs
	 *
	 * @return	string
	 */
	public static function page()
	{
		return "<div>\n".self::paragraphs(rand(2, 5))."</div>\n";
	}

	/**
	 * Creates a blockquote of random length
	 *
	 * @return	type
	 */
	public static function blockquote()
	{
		return "\n<blockquote>".self::sentences(rand(4, 9))."</blockquote>\n";
	}

	/**
	 * Creates a heading with random words
	 *
	 * @param	integer	$level
	 * @return	string
	 */
	public static function heading($level = NULL)
	{
		$level = (is_int($level) AND $level >= 1 AND $level <= 6) ? $level : 1;
		return "<h{$level}>".ucwords(self::words(rand(2, 6)))."</h{$level}>\n";
	}

	/**
	 * Creates a list with 1 or more items
	 *
	 * @param	integer	$items
	 * @param	boolean	$ordered
	 * @return	string
	 */
	public static function ul($items = NULL, $ordered = FALSE)
	{
		$items = is_int($items) ? $items : rand(3, 8);

		$type = $ordered ? 'ol' : 'ul';

		// Get the items
		$list = "<{$type}>\n";
		for ($i = 0; $i < $items; $i++)
			$list .= "<li>".ucfirst(self::words(rand(1,4)))."</li>\n";
		$list .= "</{$type}>\n";

		return $list;
	}

	/**
	 * Creates an ordered list with 1 or more items
	 *
	 * @param	integer	$items
	 * @return	string
	 */
	public static function ol($items = NULL)
	{
		return self::ul($items, TRUE);
	}

	/**
	 * Creates a dummy image of specified width and height.
	 *
	 * @param	integer	$width
	 * @param	integer	$height
	 * @param	integer	$font_size
	 * @param	integer	$border
	 * @return	string
	 */
	public static function image($width = NULL, $height = NULL, $font_size = NULL, $border = NULL)
	{
		// Sanitize width, height, and border sizes
		$width     = is_int($width)     ? $width     : 150;
		$height    = is_int($height)    ? $height    : $width;
		$border    = is_int($border)    ? $border    : 4;
		$font_size = is_int($font_size) ? $font_size : 30;

		// Return the HTML code for the image
		return HTML::image(
			'ipsum/image?'.http_build_query(compact('width', 'height', 'font_size', 'border')),
			array(
				'alt'	 => 'Lorem Ipsum',
				'width'	 => $width,
				'height' => $height
			)
		);
	}

	/**
	 * The __callStatic() has been implemented to allow for Ipsum::hx() where
	 * x is 1-6. This only works in PHP 5.3+
	 *
	 * @param	string	$method
	 * @param	array	$args
	 * @return	mixed
	 */
	public static function __callStatic($method, $args)
	{
		if (strlen($method) == 2 AND $method[0] == 'h' AND is_numeric($method[1]))
		{
			return self::heading(intval($method[1]));
		}

		throw new BadMethodCallException("The static method $method does not exist in the Ipsum module.");
	}

	final private function __construct()
	{
		// Enforce static behavior
	}

} // End Ipsum