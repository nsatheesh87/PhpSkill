/**
* TIME: 30 mins
* TYPE: IDE, Whiteboard
* QUESTION: We have a situation where paths to template assets are constructed using user input in 
* our template editor. We have recently moved these assets off local disk to remote object storage 
* accessed via http. You are required to write a function which takes a file path as input and return 
* the absolute path as output.
* EXAMPLE INPUT: '/bigcommerce/./main/../../image.jpg'
* EXAMPLE OUTPUT: '/bigcommerce/image.jpg'
* EXAMPLE INTPUT: '/root/home/test/.././'
* EXAMPLE OUTPUT: '/root/home/'
*/

<?php 

function absolute_path($relativePath) {
	// Strip all parent and this folder dots (.. and .)
	$relParts = explode("/", $relativePath);
		foreach($relParts as $i => $part) {
			if ($part == '.') {
				$relParts[$i] = null;
			}

			if ($part == '..') {
				$relParts[$i - 1] = null;
				$relParts[$i] = null;
			}
		}
		// Remove empty values
		$relParts = array_filter($relParts);
		// Reassemble string
		return '/'.implode("/", $relParts);
		// Strip all parent and this folder dots (.. and .)		
}
echo absolute_path('/root/home/test/.././');
?>