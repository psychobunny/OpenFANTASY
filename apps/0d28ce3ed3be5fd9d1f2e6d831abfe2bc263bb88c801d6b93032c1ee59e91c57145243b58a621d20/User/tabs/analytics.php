<?PHP
	use Database as DB;

	$settings = json_decode(file_get_contents('../core/Modules/User/settings/analytics.json'), true);


	$db = DB::instance();
	$data = $db->select('analytics', array('handle'=>'user', 'metric'=>'registered'), null, null, array('hourstamp'=>'ASC'));
	$registered = array();
	foreach ($data as $d) {
		$time = $d['hourstamp'] * 3600000;
		array_push($registered, array($time, $d['value']));
	}

	$data = $db->select('analytics', array('handle'=>'user', 'metric'=>'times_logged_in'));
	$loggedin = array();
	foreach ($data as $d) {
		$time = $d['hourstamp'] * 3600000;
		array_push($loggedin, array($time, $d['value']));
	}


	

	
	//print_r($registered);
	$registered = json_encode($registered);
	$loggedin = json_encode($loggedin);
?>
   <h2 style="margin-left: 10px">Users Registered</h2>   
   <div id="users-registered" style=" width : 90%; height: 384px; margin: 8px;"></div>
   <h2 style="margin-left: 10px">Users Logged In</h2>
   <div id="users-loggedin" style=" width : 90%; height: 384px; margin: 8px;"></div>

    <script type="text/javascript" src="../resources/flotr2/flotr2.js"></script>    
    <script type="text/javascript">
      (function () {

        var
          registered = document.getElementById('users-registered'),
          loggedin = document.getElementById('users-loggedin'),
          data = [];
          var data = <?PHP echo $registered ?>;

          // Draw Graph
          graph = Flotr.draw(registered, [ data ], {
            HtmlText: true,
            xaxis: {
              mode: "time",
              timeFormat: "%m/%d %Hh",
              timeMode: 'local'

            },
            yaxis : {
              max : 100,
              min : 0
            }
          });
          var loggedin_data = <?PHP echo $loggedin ?>;
          console.log(loggedin_data);

          graph = Flotr.draw(loggedin, [ loggedin_data ], {
            xaxis: {
                mode: "time",
                timeFormat: "%m/%d %Hh",
                timeMode: 'local'
            },
            yaxis : {
              max : 100,
              min : 0
            }
          });
        
      })();
    </script>