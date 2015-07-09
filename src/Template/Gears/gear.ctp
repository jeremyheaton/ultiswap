<div class="container-fluid">

<div class="col-sm-3 search">
<form method="post" action="/ultitrade/gears/gear">
  <div class="input-group">
  <input id="search_input" name ="search" data-toggle="dropdown" type="text" class="form-control" placeholder="Search" autofocus="autofocus" autocomplete="off"" />
            <div class="input-group-btn">
                <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
            </div>
            
        </div>  
           <select id="demo" class="form-control" name="type[]" multiple>
                <option value="jersey">Jerseys</option>
                <option value="disc">Discs</option>
                <option value="shorts">Shorts</option>
            </select>
</div>
    
<div class="col-sm-12">
<ul class="pagination">
<?php
  echo $this->Paginator->prev('&laquo;', array('tag' => 'li', 'escape' => false), '<a href="#">&laquo;</a>', array('class' => 'prev disabled', 'tag' => 'li', 'escape' => false));
  echo $this->Paginator->numbers(array('separator' => '', 'tag' => 'li', 'currentLink' => true, 'currentClass' => 'active', 'currentTag' => 'a'));
  echo $this->Paginator->next('&raquo;', array('tag' => 'li', 'escape' => false), '<a href="#">&raquo;</a>', array('class' => 'prev disabled', 'tag' => 'li', 'escape' => false));
?>
</ul>


<div id="page">
 <?php  $i=1; ?>
  <?php foreach ($gear as $gear): ?>

 <?php  if($i%4==1){  ?>
   <div id ="test" "class="row">
  <?php }  ?>
 
    <div class="col-lg-3"> <?=  $this->Html->image('/webroot/uploads/'.$gear['imagelocation1'], ['fullBase' => true, 'class' => 'img-responsive', 'url' => ['controller' => 'Gears', 'action' => 'view', $gear['id']]]); ?> </div>

  <?php if($i%4==0){ ?>
   </div>
  <?php } ?>
  <?php $i++; ?>
   <?php endforeach; ?>
   <?php if($i%4!=0){ ?>
   </div>
  <?php } ?>
  </div>
  </div
  </div>
</div>

 <script>

 
 
  $(function(){
    var $container = $('#page');
 
    $container.infinitescroll({
      navSelector  : '.next',    // selector for the paged navigation 
      nextSelector : '.next a',  // selector for the NEXT link (to page 2)
      itemSelector : '#test',     // selector for all items you'll retrieve
      debug         : true,
      dataType      : 'html',
      loading: {
        
          img: '../webroot/img/spinner.gif'
        }
      }
    );
  });
 
</script>
