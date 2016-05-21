<?php
defined('BASEPATH') OR exit('What Are You Looking For ?');
?>

  </div>
  <div class='row footer-static'>
    <div class='page-footer'>
      <div class='page-footer-wrap' >
        <div class="side pull-left"> Copyirght &copy; 2014-<?php echo DATE('Y');?> Jaserv Studio. All rights reserved. </div>
      </div>
    </div>
  </div>
  <div class="background-page">
      <div class="layer-background-page"></div>
      <div class="image-background-page"></div>
  </div>
</div>
<div style="display: none; bottom: 45px;" class="statusbar" id="statusbar-loading"> 
	<div class="statusbar-icon"><img src="resources/taurus/img/loader.gif"></div> 
	<div class="statusbar-text" id="loading-pesan">Sedang melakukan proses ...</div>
</div>
<?php
	for($i=0;array_key_exists($i,$url_link);$i++)
		echo link_tag($url_link[$i]); 
?>
<?php
	for($i=0;array_key_exists($i,$url_script);$i++)
		echo "<script type='text/javascript' src='".base_url().$url_script[$i]."'></script>";
?>
</body>
</html>