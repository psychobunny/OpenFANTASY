
<script type="text/javascript">
var OF_PATH = '<?php echo OF_PATH; ?>';
</script>
<?PHP
if (isset($_POST['method']) && $_POST['method'] == 'save') {
	echo '<div class="alert alert-success">	
    	Successfully Saved!
    	<a href="#" class="close" data-dismiss="alert">&times;</a>
    </div>';
}
?>


<legend>Settings</legend>
<form method="POST" action = "index.php?module=User&tab=settings">
<?PHP

$settings = json_decode(file_get_contents('../core/Modules/User/settings/settings.json'), true);

foreach ($settings as $name => $setting)
{
	$type = $setting['type'];
	$value = $setting['value'];
	$settingName = $setting['name'];
	$settingDescription = $setting['description'];

	echo "<p>";
	if ($type == 'text' || $type == 'checkbox')
	{
		echo "<label class='$type'>";
		echo "<b>$settingName</b> ";
		if ($type !== 'checkbox') echo "<br />";
		echo "<small>$settingDescription</small>";
		if ($type !== 'checkbox') echo "<br />";
		echo "<input name='$name' type='$type' value='$value' />";
		echo "</label>";
	}
	else if ($type == 'textarea')
	{
		
		echo "<label><b>$settingName</b><br /><small>$settingDescription</small><br /><textarea name='$name' class='span5' rows='5'>" . $value . "</textarea></label>";
		
	}
	echo "</p>";

	
}
?>
<input class='btn btn-primary' style="height: 40px" type='submit' value='Save Changes'/>
<input type="hidden" name="method" value="save" />
</form>