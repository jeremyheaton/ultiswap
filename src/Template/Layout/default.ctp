<?php
$cakeDescription = 'UltiSwap: the place to trade gear';
?>
<!DOCTYPE html>
<html>
<head>  
 <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://localhost/ultitrade/webroot/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
   <script src="http://localhost/ultitrade/webroot/js/jquery.infinitescroll.js"></script>
 <script src="http://gregpike.net/demos/bootstrap-file-input/bootstrap.file-input.js"></script>
 <link rel="stylesheet" href="http://localhost/ultitrade/webroot/css/bootstrap-multiselect.css" type="text/css">
<script type="text/javascript" src="http://localhost/ultitrade/webroot/js/bootstrap-multiselect.js"></script>
 <script>
 $('input[type=file]').bootstrapFileInput();
$('.file-inputs').bootstrapFileInput();
 $(document).ready(function() {
$('#demo').multiselect();
});
 </script>
  
  
   
  
    <?= $this->Html->charset() ?>
    <?= $this->Html->meta('icon') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
<html lang="en">
    <style>
    
.image{
  height: 100%;
  }
  
.pagination{
  display: none;
  }
.img-responsive{
  height: 200px;
  width: 200px;
  float: right;
  margin-right: 10px;
  display: block;
  margin-bottom: 20px;
  line-height: 1.42857143;
  background-color: #fff;
  border: 1px solid #ddd;
  border-radius: 4px;
  -webkit-transition: border .2s ease-in-out;
  -o-transition: border .2s ease-in-out;
  transition: border .2s ease-in-out;
}
.img-responsive2{
  max-height: 200px;
  max-width: 200px;
  float: right;
  margin-right: 10px;
  display: block;
  padding: 4px;
  margin-bottom: 20px;
  line-height: 1.42857143;
  background-color: #fff;
  border: 1px solid #ddd;
  border-radius: 4px;
  -webkit-transition: border .2s ease-in-out;
  -o-transition: border .2s ease-in-out;
  transition: border .2s ease-in-out;
}
#test {
  
 
}
.col-lg-3{

 padding-right: 0px; 
}
.col-sm-2.search {
  margin-top: 1.5%;
 float:left;
}

  
</style>



 
</head>


<?php $user = "";

$loguser = $this->request->session()->read('Auth.User.username');
if(!empty($loguser)){
    $user = $loguser;
} ?>
<body>

      <nav class="navbar navbar-inverse">
  <div class="container">
    <div class="navbar-header">
    <a class="navbar-brand" rel="home" href="/ultitrade/gears/gear" title="Buy Trade Sell">
        <img style="max-width:100px;"
             src="http://localhost/ultitrade/webroot/img/Ultiswap-red.png">
    </a>
    </div>
    <div>
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Home</a></li>
      <?php  if(!empty($loguser)){ ?>
       <li><a href="/ultitrade/gears/gear">Add Gear</a></li>
	  <?php	} ?>
      <?php  if(!empty($loguser)){ ?>
       <li><a href="/ultitrade/users/logout">Log Out</a></li>
	  <?php	} ?>
        <li><a href="#">Hi, <?php echo $user ?> 
        </a></li> 
      </ul>
    </div>
  </div>
</nav>
 
   

       
            <?= $this->Flash->render() ?>

            
                <?= $this->fetch('content') ?>
           
     
        <footer>
        </footer>

</body>
</html>
