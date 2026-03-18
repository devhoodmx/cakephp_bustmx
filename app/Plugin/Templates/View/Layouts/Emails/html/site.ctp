<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title><?php echo $this->fetch('title'); ?></title>

		<style type="text/css">
			@media only screen and (max-width: 480px){
				/* /\/\/\/\/\/\/ CLIENT-SPECIFIC MOBILE STYLES /\/\/\/\/\/\/ */
				body, table, td, p, a, li, blockquote{-webkit-text-size-adjust:none !important;} /* Prevent Webkit platforms from changing default text sizes */
				body{width:100% !important; min-width:100% !important;} /* Prevent iOS Mail from adding padding to the body */

				/* /\/\/\/\/\/\/ MOBILE RESET STYLES /\/\/\/\/\/\/ */
				#bodyCell{padding:10px !important;}

				/* /\/\/\/\/\/\/ MOBILE TEMPLATE STYLES /\/\/\/\/\/\/ */

				/* ======== Page Styles ======== */

				/**
				* @tab Mobile Styles
				* @section template width
				* @tip Make the template fluid for portrait or landscape view adaptability. If a fluid layout doesn't work for you, set the width to 300px instead.
				*/
				#templateContainer{
					max-width:600px !important;
					/*@editable*/ width:100% !important;
				}

				/**
				* @tab Mobile Styles
				* @section heading 1
				* @tip Make the first-level headings larger in size for better readability on small screens.
				*/
				h1{
					/*@editable*/ font-size:24px !important;
					/*@editable*/ line-height:100% !important;
				}

				/**
				* @tab Mobile Styles
				* @section heading 2
				* @tip Make the second-level headings larger in size for better readability on small screens.
				*/
				h2{
					/*@editable*/ font-size:20px !important;
					/*@editable*/ line-height:100% !important;
				}

				/**
				* @tab Mobile Styles
				* @section heading 3
				* @tip Make the third-level headings larger in size for better readability on small screens.
				*/
				h3{
					/*@editable*/ font-size:18px !important;
					/*@editable*/ line-height:100% !important;
				}

				/**
				* @tab Mobile Styles
				* @section heading 4
				* @tip Make the fourth-level headings larger in size for better readability on small screens.
				*/
				h4{
					/*@editable*/ font-size:16px !important;
					/*@editable*/ line-height:100% !important;
				}

				/* ======== Header Styles ======== */

				#templatePreheader{display:none !important;} /* Hide the template preheader to save space */

				/**
				* @tab Mobile Styles
				* @section header image
				* @tip Make the main header image fluid for portrait or landscape view adaptability, and set the image's original width as the max-width. If a fluid setting doesn't work, set the image width to half its original size instead.
				*/
				#headerImage{
					height:auto !important;
					/*@editable*/ max-width:600px !important;
					/*@editable*/ width:100% !important;
				}

				/**
				* @tab Mobile Styles
				* @section header text
				* @tip Make the header content text larger in size for better readability on small screens. We recommend a font size of at least 16px.
				*/
				.headerContent{
					/*@editable*/ font-size:20px !important;
					/*@editable*/ line-height:125% !important;
				}

				/* ======== Body Styles ======== */

				/**
				* @tab Mobile Styles
				* @section body text
				* @tip Make the body content text larger in size for better readability on small screens. We recommend a font size of at least 16px.
				*/
				.bodyContent{
					/*@editable*/ font-size:18px !important;
					/*@editable*/ line-height:125% !important;
				}

				/* ======== Footer Styles ======== */

				/**
				* @tab Mobile Styles
				* @section footer text
				* @tip Make the body content text larger in size for better readability on small screens.
				*/
				.footerContent{
					/*@editable*/ font-size:14px !important;
					/*@editable*/ line-height:115% !important;
				}

				.footerContent a{display:block !important;} /* Place footer social and utility links on their own lines, for easier access */
			}
		</style>
	</head>
	<body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0" style="-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;margin: 0;padding: 0;background-color: #F5F5F5;height: 100%;width: 100%;">
		<center>
			<table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable" style="-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;margin: 0;padding: 0;background-color: #F5F5F5;border-collapse: collapse;height: 100%;width: 100%;">
				<tr>
					<td align="center" valign="top" id="bodyCell" style="-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;margin: 0;padding: 20px;height: 100%;width: 100%;">
						<!-- BEGIN TEMPLATE // -->
						<table border="0" cellpadding="0" cellspacing="0" id="templateContainer" style="-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;width: 600px;border: 1px solid #BBBBBB;border-collapse: collapse;">
							<?php /* ?>
							<tr>
								<td align="center" valign="top" style="-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;">
									<!-- BEGIN PREHEADER // -->
									<table border="0" cellpadding="0" cellspacing="0" width="100%" id="templatePreheader" style="-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;background-color: #F9F9F9;border-bottom: 1px solid #CCCCCC;border-collapse: collapse;">
										<tr>
											<td valign="top" class="preheaderContent" style="padding-top: 10px;padding-right: 20px;padding-bottom: 10px;padding-left: 20px;-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;color: #808080;font-family: Helvetica;font-size: 10px;line-height: 125%;text-align: left;">
												Use this area to offer a short teaser of your email's content. Text here will show in the preview area of some email clients.
											</td>
										</tr>
									</table>
									<!-- // END PREHEADER -->
								</td>
							</tr>
							<?php */ ?>
							<tr>
								<td align="center" valign="top" style="-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;">
									<!-- BEGIN HEADER // -->
									<table border="0" cellpadding="0" cellspacing="0" width="100%" id="templateHeader" style="-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;background-color: #F9F9F9;border-top: 0px solid #FFFFFF;border-bottom: 1px solid #CCCCCC;border-collapse: collapse;">
										<tr>
											<td valign="top" class="headerContent" style="-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;color: #505050;font-family: Helvetica;font-size: 20px;font-weight: bold;line-height: 100%;padding-top: 0;padding-right: 0;padding-bottom: 0;padding-left: 0;text-align: left;vertical-align: middle;">
												<?php
												echo $this->Html->image('site/email-header.png', array(
													'id' => 'headerImage',
													'style' => '-ms-interpolation-mode: bicubic;border: 0;height: auto;line-height: 100%;outline: none;text-decoration: none;max-width: 600px;',
													'fullBase' => true
												));
												?>
											</td>
										</tr>
									</table>
									<!-- // END HEADER -->
								</td>
							</tr>

							<tr>
								<td align="center" valign="top" style="-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;">
									<!-- BEGIN BODY // -->
									<table border="0" cellpadding="0" cellspacing="0" width="100%" id="templateBody" style="-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;background-color: #FFFFFF;border-top: 1px solid #FFFFFF;border-bottom: 1px solid #CCCCCC;border-collapse: collapse;">
										<tr>
											<td valign="top" class="bodyContent" style="-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;color: #505050;font-family: Helvetica;font-size: 14px;line-height: 150%;padding-top: 20px;padding-right: 20px;padding-bottom: 20px;padding-left: 20px;text-align: left;">
												<?php echo $this->fetch('content'); ?>
											</td>
										</tr>
									</table>
									<!-- // END BODY -->
								</td>
							</tr>

							<tr>
								<td align="center" valign="top" style="-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;">
									<!-- BEGIN FOOTER // -->
									<table border="0" cellpadding="0" cellspacing="0" width="100%" id="templateFooter" style="-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;background-color: #F9F9F9;border-top: 1px solid #FFFFFF;border-collapse: collapse;">
										<?php /* ?>
										<tr>
											<td valign="top" class="footerContent" style="-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;color: #808080;font-family: Helvetica;font-size: 10px;line-height: 150%;padding-top: 20px;padding-right: 20px;padding-bottom: 20px;padding-left: 20px;text-align: left;">
												<a href="*|TWITTER:PROFILEURL|*" style="-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;color: #606060;font-weight: normal;text-decoration: underline;">Follow on Twitter</a>&nbsp;&nbsp;&nbsp;<a href="*|FACEBOOK:PROFILEURL|*" style="-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;color: #606060;font-weight: normal;text-decoration: underline;">Friend on Facebook</a>&nbsp;&nbsp;&nbsp;<a href="*|FORWARD|*" style="-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;color: #606060;font-weight: normal;text-decoration: underline;">Forward to Friend</a>&nbsp;
											</td>
										</tr>
										<?php */ ?>
										<tr>
											<td valign="top" class="footerContent" style="-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;color: #808080;font-family: Helvetica;font-size: 10px;line-height: 150%;padding-top: 20px;padding-right: 20px;padding-bottom: 20px;padding-left: 20px;text-align: left;">
												<em>Copyright &copy; <?php echo date('Y'); ?> Organization name.</em>
											</td>
										</tr>
									</table>
									<!-- // END FOOTER -->
								</td>
							</tr>
						</table>
						<!-- // END TEMPLATE -->
					</td>
				</tr>
			</table>
		</center>
	</body>
</html>
