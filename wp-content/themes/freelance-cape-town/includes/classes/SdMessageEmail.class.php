<?php
	class SdMessageEmail{

		public $body;

		public function buildSource(){
			return '
				<!Doctype html>
					<html>
					<head>
					<meta charset="UTF-8">
					<title>Freelance Cape Town</title>
					<style type="text/css">
						body{
							padding:50px 0 50px 0;
							padding: 0;
							font-family:Helvetica, Arial, Sans-serif;
							font-size:13px;
							line-height: 17px;
							color:#444;
					        background: #fff;
						}
					    div.container{
					        width:700px;
					        margin:0 auto;
					        background: #fff;
					        border: 1px solid #fff;
					        border-radius: 10px;
					        -moz-border-radius: 10px;
					        -webkit-border-radius: 10px;
					        -ms-border-radius: 10px;
					        -o-border-radius: 10px;
					        overflow:hidden;
					        clear:both;
					        padding:20px;
					    }
						table.container{
							border:none;
							margin: 0 auto;
							padding: 0;
							width: 700px;
					        background: #fff;
					        border:none;
						}
						p{
							margin-bottom:20px;
						}
						td.cellPadding{
							padding: 0 50px;
						}
						a.btnLink{
							text-decoration: none;
						}
					</style>
					</head>

					<body style="padding:25px 0 25px 0;font-family:Helvetica, Arial, Sans-serif;font-size:12px;line-height: 16px;color:#444;background: #fff;">
						<div class="container" style="width:650px;margin:0 auto;background: #fff;border: 1px solid #fff;border-radius: 10px;-moz-border-radius: 10px;-webkit-border-radius: 10px;-ms-border-radius: 10px;-o-border-radius: 10px;overflow:hidden;clear:both;padding:20px;">
					        <table align="center" cellpadding="0" cellspacing="0" border="0" class="container" width="650" style="width:650px;">
					            <tr>
					        		<td width="250" valign="top" align="left" style="width:250px;text-align:left;">
					        			<img src="' . get_stylesheet_directory_uri() . '/assets/img/email/logo_email.png' . '" width="250" alt="Freelance Cape Town" />
					        		</td>
					                <td valign="top" align="right" style="valign:top;text-align:right;">
					                    <!--<h3 style="margin:0 0 5px 0;color:#222;font-size:1em;">FREELANCE CAPE TOWN</h3>-->
					                    <h4 style="margin:0 0 15px 0;color:#666;font-size:.8em;font-weight:normal;">CAPE TOWN\'S PREMIUM LISTING FOR FREELANCERS</h3><br>
					                    <a href="http://www.facebook.com/freelancecapetown"><img src="' . get_stylesheet_directory_uri() . '/assets/img/email/email_icon_facebook.png' . '" width="25" height="25" alt="Facebook" /></a>
					                    <a href="http://www.twitter.com/capefreelance"><img src="' . get_stylesheet_directory_uri() . '/assets/img/email/email_icon_twitter.png' . '" width="25" height="25" alt="Twitter" /></a>
					                    <a href="http://www.instagram.com/freelancecapetown"><img src="' . get_stylesheet_directory_uri() . '/assets/img/email/email_icon_instagram.png' . '" width="25" height="25" alt="Instagram" /></a>
					                </td>
					        	</tr>
					        	<tr>
					        		<td colspan="2" height="30" style="height:30px;">&nbsp;</td>
					        	</tr>
					        	<tr>
					        		<td colspan="2">
					        			' . $this->body . '
					        		</td>
					        	</tr>
					        </table>
					    </div>
					    <div>
					        <p style="text-align:center;color:#fff;">
					            <a style="font-size:11px;color:#fff;" href="http://freelancecapetown.com/legal/terms-of-service">Terms of Service</a> | <a style="font-size:11px;color:#fff;" href="http://freelancecapetown.com/legal/privacy-policy">Privacy Policy</a> | <a style="font-size:11px;color:#fff;" href="http://freelancecapetown.com/legal/refund-policy">Refund Policy</a> | <a style="font-size:11px;color:#fff;" href="http://freelancecapetown.com/contact">Contact Us</a>
					        </p> 
					        <p style="text-align:center;color:#eee;">
					            Freelance Culture (Pty) Ltd
					        </p>    
					    </div>
					</body>
					</html>
			';
		}

	}
?>
