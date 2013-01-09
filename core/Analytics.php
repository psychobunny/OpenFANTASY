<?php
use Database as DB;

class Analytics
{
	/**
	* @param metric str The name of the value being tracked, ex. register_user
	* @param handleID double Optional. ex. UserID, default is anonymous (0)
	* @param handle str Optional. By default pulls the calling class's defined analytics handle
	* @param value str Optional. By default increases metric by 1
	*/
	public static function track($metric, $handle, $handleID=0, $value=1)
	{

		if ($metric == null || $handle == null)
		{
			throw new Exception('No Metric Defined');
		}
		$hourstamp = floor(time() / 3600);

		$db = DB::instance();
        $db->insert('analytics_warehouse', array(
            'metric' => $metric,
            'handle' => $handle,
            'handleID' => $handleID,
            'value' => $value,
            'hourstamp' => $hourstamp
        ));

        // todo: integrate on duplicate into db wrapper
        $db->execute(
        	"INSERT INTO analytics (metric, handle, value, hourstamp)
                VALUES (
	                :metric,
	                :handle,
                	:value,
                	:hourstamp
                )
		    	ON DUPLICATE KEY UPDATE value = value + :increment",
		    array(
		    	'metric' => $metric,
		    	'handle' => $handle,		    	
		    	'value' => $value,
		    	'hourstamp' => $hourstamp,
		    	'increment' => $value,
		    )
		);
		
	}
}
?>