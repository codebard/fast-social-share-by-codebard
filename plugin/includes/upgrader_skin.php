<?php

// This class is used to suppress WP_upgrader output when installing and updating plugins


class Quiet_Skin extends \WP_Upgrader_Skin {
	
	
    public function feedback($string)
    {
		$get_upgrader_strings = new Plugin_Upgrader();
		$get_upgrader_strings->generic_strings();
		$get_upgrader_strings->upgrade_strings();
		$get_upgrader_strings->install_strings();

		$string = trim($string);
		$string = $get_upgrader_strings->strings[$string];
		$string = str_replace('%s','', $string);
		$string = str_replace('(%s)','', $string);
        // just keep it quiet
		echo $string;
		echo '<br>';
		wp_ob_end_flush_all();
    }
}


