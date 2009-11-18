<?php


	function render($filename, $context=NULL){
		
		$filestr = file_get_contents($filename);
		
		if( isset($context) ){
			
			$out = vsprintf( $filestr, $context );
			
		}
		else{
			$out = $filestr;
		}
		
		echo $out;		
	}

?>
