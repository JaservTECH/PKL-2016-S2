<?php
defined('BASEPATH') OR exit('What Are You Looking For ?');

?>
<div class=col-md-2>
      <div class="block block-drop-shadow">
        <div class="user bg-default bg-light-rtl">
          <div class=info> 
          	<a class="pointer informer informer-three"> 
          		<span>14 / 255</span> Messages </a> 
          	<a class="pointer informer informer-four"> 
          		<span>$549.44</span> Balance </a> 
          	<img src=<?php echo $image;?> class="img-circle img-thumbnail"/> 
          </div>
        </div>
        <div class="content list-group list-group-icons"> 
        	<a href=# class=list-group-item><span class=icon-envelope></span> Pesan<i class="icon-angle-right pull-right"></i></a>  
        	<a href=# class=list-group-item><span class=icon-cogs></span> pengaturan<i class="icon-angle-right pull-right"></i></a> 
        	<a id='keluar-confirm-exe' class='list-group-item pointer'><span class=icon-off></span> keluar</a> 
        </div>
      </div>
      
      <div class="block block-drop-shadow">
        <div class="head bg-dot20">
          <h2>CPU</h2>
          <div class="side pull-right">
            <ul class=buttons>
              <li><a href=#><span class=icon-cogs></span></a></li>
            </ul>
          </div>
          <div class=head-subtitle>Intel Core2 Duo T6670 2.20GHz</div>
          <div class="head-panel nm">
            <div class="hp-info hp-simple pull-left hp-inline"> <span class=hp-main>Core 0 <span class=icon-angle-right></span> 89%</span>
              <div class=hp-sm>
                <div class="progress progress-small">
                  <div class="progress-bar progress-bar-danger" role=progressbar aria-valuenow=89 aria-valuemin=0 aria-valuemax=100 style=width:89%></div>
                </div>
              </div>
            </div>
            <div class="hp-info hp-simple pull-left hp-inline"> <span class=hp-main>Core 1 <span class=icon-angle-right></span> 56%</span>
              <div class=hp-sm>
                <div class="progress progress-small">
                  <div class="progress-bar progress-bar-warning" role=progressbar aria-valuenow=56 aria-valuemin=0 aria-valuemax=100 style=width:56%></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
</div>
    