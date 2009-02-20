<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $html->charset(); ?>
	<title>
		<?php __('Jobo Scope:'); ?>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $html->meta('icon');

		echo $html->css('style');
		echo $html->css('layout');
		echo $html->css('typo');


		echo $scripts_for_layout;
	?>
</head>
<body id="page3">
<div class="w">
  	<div class="site_center">
    	<div class="site_center1">
            <div class="head1">
	            <div id="header">
	                <div class="head">
						<div style="height: 85px; padding-bottom: 43px;" class="menu_top">
							<ul>
								<LI><A HREF="/">HOME</A></LI>
								<LI><A HREF="/candidate">INBOX</A></LI>
								<LI><A HREF="/candidate/profile">PROFIL  </A></LI>
								<LI><A HREF="#">FINANTE</A></LI>
							<!-- 	<li><a href="/Contact">FINANTE</a></li>  -->
							</ul>
						</div>
	                   <div class="indent">
							<div style="float: left;">
								<img alt="" src="/images/logo.gif" class="pic"/>
							</div>
							<div style="float: left;">
			                    <div style="background: transparent url(/images/w1.gif) no-repeat left top; width: 337px; height: 27px; font-size: 10px; line-height: 22px;">
									&nbsp; &nbsp; <span style="color: white;">&nbsp; Acum este:
									<?php
										date_default_timezone_set('Europe/Bucharest');
										echo  date('F j, Y, g:i');
									?></span>
								</div> 
			                <div>
									<div style="float: left; width: 183px;">
									</div>
								</div>					
							</div>
	                    </div>
					</div>
	            </div>
            </div>
      		<div id="content">		
          		<div class="col1" style="width:1px; float:left; ">
					 
                </div>
          		<div class="col2" style="width:765px; padding-top:20px; float:right;">
                	<div class="indent_col2">
                   	  <div class="indent" >
			<?php $session->flash(); ?>
			
			<?php echo $content_for_layout; ?>
                            <div class="clear"></div>
                      </div>        
                                    
                    </div>
                </div>
                <div class="clear" style="clear:both"></div>
				
		</div>	 
      		<div id="footer" style="text-align: center;">
                <p>
					<a href="Home" style="text-decoration: none;">Home</a>
					<img src="/images/spacer.gif" width="12" height="1"/>|<img src="/images/spacer.gif" width="12" height="1"/>
					<a href="Candidati" style="text-decoration: none;">Candidati</a>
					<img src="/images/spacer.gif" width="12" height="1"/>|<img src="/images/spacer.gif" width="12" height="1"/>
					<a href="Angajatori" style="text-decoration: none;">Angajatori</a>
					<img src="/images/spacer.gif" width="12" height="1"/>|<img src="/images/spacer.gif" width="12" height="1"/>
					<a href="FAQ" style="text-decoration: none;">FAQ</a>
					<img src="/images/spacer.gif" width="12" height="1"/>|<img src="/images/spacer.gif" width="12" height="1"/>
					<a href="Despre+noi+" style="text-decoration: none;">Despre noi </a>
					<img src="/images/spacer.gif" width="12" height="1"/>|<img src="/images/spacer.gif" width="12" height="1"/>
					<a href="Contact" style="text-decoration: none;">Contact</a>
				</p>
			JoboScope  © 2009 | Powered by <a href="http://www.sveatoslav.com/" target="_blank">Sveatoslav Art Studio</a><br/>
			</div>
      </div>
  </div>
</div>
		<?php //echo $cakeDebug; ?>
</body>
</html>