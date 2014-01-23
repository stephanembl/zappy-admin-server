<?php
$cmd = "";
if (isset($_POST['cmd']))
{
	if ($_POST['cmd'] == 'stop' || $_POST['cmd'] == 'ban' || $_POST['cmd'] == 'unban'
		|| $_POST['cmd'] == 'ban2' || $_POST['cmd'] == 'unban2')
		{
			$cmd = $_POST['cmd'];
		}
}
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="iso-8859-1">
    <title>Zappy Server Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet" />
	<link href="style.css" rel="stylesheet" />
    <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
    <!--[if lt IE 9]>
		<script src="bootstrap/js/html5shiv.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="container">
      <form class="form-signin" method="post" action="">
		<h2 class="form-signin-heading">ZAPPY SERVER</h2><br />
		<?php
		if (!isset($_POST['ip'], $_POST['port']) || (empty($_POST['ip']) || empty($_POST['port'])))
		{
			?>
			<input type="text" name="ip" class="input-block-level" placeholder="Address">
			<input type="text" name="port" class="input-block-level" placeholder="Port">
			<button class="btn btn-large btn-primary btn-custom" type="submit">Administrate</button>
			<?php
		} else {
			error_reporting(0);
			$port = intval($_POST['port']);
			$address = $_POST['ip'];
			$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
			$team = "ADMIN\n";
			$pass = "totototo\n"; // quite insecure :D
			if ($socket !== false)
			{
				if (socket_connect($socket, $address, $port) !== false)
				{
					if ($cmd != "")
					{
						switch ($cmd) {
							case 'stop':
							socket_write($socket, $team, strlen($team));
							socket_write($socket, $pass, strlen($pass));
							socket_write($socket, "QUIT\n", strlen("QUIT\n"));
							echo 'Stop request sent.<br /><br />';
							break;
							
							case 'ban':
							?>
							<input type="text" name="ipban" class="input-block-level" placeholder="IP">
							<input type="hidden" name="ip" value="<?php echo $address; ?>" />
							<input type="hidden" name="port" value="<?php echo $port; ?>" />
							<button class="btn btn-large btn-primary btn-custom" name="cmd" value="ban2" type="submit">Ban</button>
							<?php
							break;
							
							case 'ban2':
							if (isset($_POST['ipban']) && !empty($_POST['ipban']))
							{
								$msg = "BAN ".$_POST['ipban']."\n";
								socket_write($socket, $team, strlen($team));
								socket_write($socket, $pass, strlen($pass));
								socket_write($socket, $msg, strlen($msg));
								echo 'Ban request for IP '.$_POST['ipban'].' sent.<br /><br />'.$msg.'<br />';
							} else {
							  echo 'Error.<br /><br />';
							}
							break;
							
							case 'unban':
							?>
							<input type="text" name="ipban" class="input-block-level" placeholder="IP">
							<input type="hidden" name="ip" value="<?php echo $address; ?>" />
							<input type="hidden" name="port" value="<?php echo $port; ?>" />
							<button class="btn btn-large btn-primary btn-custom" name="cmd" value="unban2" type="submit">Unban</button>
							<?php
							break;

							case 'unban2':
							if (isset($_POST['ipban']) && !empty($_POST['ipban']))
							{
								$msg = "UNBAN ".$_POST['ipban']."\n";
								socket_write($socket, $team, strlen($team));
								socket_write($socket, $pass, strlen($pass));
								socket_write($socket, $msg, strlen($msg));
								echo 'Unban request for IP '.$_POST['ipban'].' sent.<br /><br />';
							} else {
							  echo 'Error.<br /><br />';
							}
							break;
							
							default:
							break;
						}
						?>
						<button class="btn btn-large btn-primary btn-custom" type="submit">Back</button>
						<input type="hidden" name="ip" value="<?php echo $address; ?>" />
						<input type="hidden" name="port" value="<?php echo $port; ?>" />
						<?php
					} else {
						?>
						<button class="btn btn-large btn-primary btn-custom" name="cmd" value="stop" type="submit">Stop server</button><br /><br />
						<button class="btn btn-large btn-primary btn-custom" name="cmd" value="ban" type="submit">Ban IP</button><br /><br />
						<button class="btn btn-large btn-primary btn-custom" name="cmd" value="unban" type="submit">Unban IP</button>
						<input type="hidden" name="ip" value="<?php echo $address; ?>" />
						<input type="hidden" name="port" value="<?php echo $port; ?>" />
						<?php
					}
				} else {
					echo "Server offline.<br /><br />";
					?>
					<button class="btn btn-large btn-primary btn-custom" type="submit">Reload</button>
					<input type="hidden" name="ip" value="<?php echo $address; ?>" />
					<input type="hidden" name="port" value="<?php echo $port; ?>" />
					<?php
				}
			}
		}
		?>
      </form>
    </div>
    <script src="bootstrap/js/jquery.js"></script>
    <script src="bootstrap/js/bootstrap-transition.js"></script>
    <script src="bootstrap/js/bootstrap-alert.js"></script>
    <script src="bootstrap/js/bootstrap-modal.js"></script>
    <script src="bootstrap/js/bootstrap-dropdown.js"></script>
    <script src="bootstrap/js/bootstrap-scrollspy.js"></script>
    <script src="bootstrap/js/bootstrap-tab.js"></script>
    <script src="bootstrap/js/bootstrap-tooltip.js"></script>
    <script src="bootstrap/js/bootstrap-popover.js"></script>
    <script src="bootstrap/js/bootstrap-button.js"></script>
    <script src="bootstrap/js/bootstrap-collapse.js"></script>
    <script src="bootstrap/js/bootstrap-carousel.js"></script>
    <script src="bootstrap/js/bootstrap-typeahead.js"></script>
  </body>
</html>