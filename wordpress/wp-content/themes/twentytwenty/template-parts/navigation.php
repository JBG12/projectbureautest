<?php
/**
 * Displays the next and previous post navigation in single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

$next_post = get_next_post();
$prev_post = get_previous_post();

if ( $next_post || $prev_post ) {

	$pagination_classes = '';

	if ( ! $next_post ) {
		$pagination_classes = ' only-one only-prev';
	} elseif ( ! $prev_post ) {
		$pagination_classes = ' only-one only-next';
	}
	if(is_user_logged_in()){
		echo '<div class="bar">';
			$post_id = get_the_ID();
			// Get second database connection information from functions.php
			global $db2;
			echo '<form class="actForm single" method="post">';
			// Add the ID of the input (button) to the name of the button to make it "activiteit" specific.
			if ($already = $db2->get_var("SELECT ID FROM `$post_id` WHERE ID = $user_ID")) {
				echo '<input type="submit" name="Uitschrijf'.$post_id.'" value="Uitschrijven" class="Uitschrijf"/>';
			} else {
			echo '<input type="submit" name="ActButton'.$post_id.'" value="Deelnemen" class="ActButton"/>';
			}
			echo '</form>';

			// Get user info
			$user_info  = wp_get_current_user();
			$user_ID    = $user_info->ID;
			$user_name  = $user_info->display_name;
			$user_email = $user_info->user_email;
			// If the "Deelnemen" button is used.
			if(isset($_POST['ActButton'.$post_id.''])) {
				if ($exists = $db2->get_var("SHOW TABLES LIKE '".$post_id."'")) {
					// If the tabel exists, insert the user account values into the tabel from the specific activity.
					$insert = $db2->get_var("INSERT INTO `$post_id` (`ID`, `Naam`, `Email`) VALUES ('$user_ID', '$user_name', '$user_email')");
					// Create setup for mail and send mail to user to verify.
					$to = $user_email;
					$subject = 'Je hebt je ingeschreven voor '.$title;
					$body = ' 
				<html>
				<p><img style="display: block; margin-left: auto; margin-right: auto;" src="https://i.ibb.co/0hGTFcv/Plak-Cirkels-RGB-2.png" alt="" width="182" height="182" /></p>
				<h1 style="text-align: center;">U heeft zich succesvol ingeschreven bij een nieuwe activiteit!</h1>
				<table style="border: 2px dashed; border-color: black; width: 100%; height: 54px;" cellspacing="0">
				<tbody>
				<tr style="height: 18px;">
				<th style="height: 18px; width: 37.9085%;">Activiteit:</th>
				<td style="height: 18px; width: 61.22%;">'.$title.'</td>
				</tr>
				<tr style="background-color: #e0e0e0;">
				<th style="height: 18px; width: 37.9085%;">Datum:</th>
				<td style="height: 18px; width: 61.22%;">'.$pieces[0].'</td>
				</tr>
				<tr style="height: 18px;">
				<th style="height: 18px; width: 37.9085%;">Tijd:</th>
				<td style="height: 18px; width: 61.22%;">'.$pieces[1].'</td>
				</tr>
				<tr style="background-color: #e0e0e0;">
				<th style="height: 18px; width: 37.9085%;">Omschrijving:</th>
				<td style="height: 18px; width: 61.22%;">'.get_the_excerpt().'</td>
				</tr>
				</tbody>
				</table>
				<p>&nbsp;</p>
				<p>Heeft u zich bedacht? Dan kunt u zich uitschrijven door op de knop hieronder te klikken.</p>
				<div>
				<a href="'.get_permalink().'" style="background-color: #e22658; color: #fff; width: 100%; margin: 0 auto; text-align: center; padding: 15px; border-radius: 5px;" border="0" width="100%" >Uitschrijven</a>
				</table>
				</div>
				</html>'; 
					$headers = array('Content-Type: text/html; charset=UTF-8');
					
					wp_mail( $to, $subject, $body, $headers );
					echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL='.$current_URL.'">';
				} else {
				// If tabel doesnt exist yet, create table, then insert user info.
					$createTable = $db2->get_var("CREATE TABLE `$post_id` (
						ID INT(6),
						Naam VARCHAR(30) NOT NULL,
						Email VARCHAR(50)
						)");
					$insert = $db2->get_var("INSERT INTO `$post_id` (`ID`, `Naam`, `Email`) VALUES ('$user_ID', '$user_name', '$user_email')");
					// Also send mail to user here.
					wp_mail( $to, $subject, $body, $headers );
					echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL='.$current_URL.'">';
				}
			}
			// If "Uitschrijven" button is used.
			if(isset($_POST['Uitschrijf'.$post_id.''])) {
				$remove = $db2->get_var("DELETE FROM `$post_id` WHERE ID = $user_ID");
				echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL='.$current_URL.'">';
			}
		echo '</div>';
	} else {
		echo '<p style="text-align:center; margin:10px;">Je moet ingelogd zijn om je in te kunnen schrijven voor een activiteit.</p>';
	}

	?>


	<?php
}
