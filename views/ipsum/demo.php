<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="Content-Language" content="en-us" />
		<title>Ipsum Module Demo</title>
	</head>
	<body>
		<h1>Ipsum Module Demo</h1>
		<hr />

		<pre>echo Ipsum::h1()</pre>
		<?php echo Ipsum::h1() ?>

		<pre>echo Ipsum::h2()</pre>
		<?php echo Ipsum::h2() ?>

		<pre>echo Ipsum::h3()</pre>
		<?php echo Ipsum::h3() ?>

		<pre>echo Ipsum::h4()</pre>
		<?php echo Ipsum::h4() ?>

		<pre>echo Ipsum::h5()</pre>
		<?php echo Ipsum::h5() ?>

		<pre>echo Ipsum::h6()</pre>
		<?php echo Ipsum::h6() ?>

		<pre>echo Ipsum::words()</pre>
		<?php echo Ipsum::words() ?>

		<pre>echo Ipsum::sentences()</pre>
		<?php echo Ipsum::sentences() ?>

		<pre>echo Ipsum::paragraphs()</pre>
		<?php echo Ipsum::paragraphs() ?>

		<pre>echo Ipsum::blockquote()</pre>
		<?php echo Ipsum::blockquote() ?>

		<pre>echo Ipsum::ul()</pre>
		<?php echo Ipsum::ul() ?>

		<pre>echo Ipsum::ol()</pre>
		<?php echo Ipsum::ol() ?>

		<pre>echo Ipsum::image(rand(300,600), rand(100,300))</pre>
		<?php echo Ipsum::image(rand(300,600), rand(100,300)) ?>
		
		<pre>echo Ipsum::page()</pre>
		<?php echo Ipsum::page() ?>
	</body>
</html>