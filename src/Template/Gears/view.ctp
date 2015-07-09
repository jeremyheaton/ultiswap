
  <h1><?= $user['username']?></h1>
  <h1><?= $user['email']?></h1>
  <div class="row">
    <div class="col-sm-4 gear"> <?=  $this->Html->image('/webroot/uploads/'.$gear['imagelocation1'], ['fullBase' => true, 'class' => 'img-responsive']); ?> </div>
    <?php if(isset($gear['imagelocation2'])){ ?>
    <div class="col-sm-4 gear">  <?=  $this->Html->image('/webroot/uploads/'.$gear['imagelocation2'], ['fullBase' => true,'class' => 'img-responsive']); ?> </div>
		<?php } ?>
  </div>
