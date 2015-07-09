<div class="container-fluid">
   <form method="post" accept-charset="utf-8" enctype="multipart/form-data" action="/ultitrade/gears/add">
   <div class="form-group">
      <label for="sel1">Select The Type Of Gear</label>
      <select name="type"  class="form-control type" id="sel1">
         <option value="jersey">Jersey</option>
         <option value="disc">Disc</option>
         <option value="shorts">shorts</option>
      </select>
      <label for="description">Enter in a description:</label>
      <input  name ="tags" type="text" class="form-control" id="tags">
   <label for="tags">Enter in your tags, each seperated by a comma:</label>
  
   <input class="form-control" type="text" id="tags" name ="tags"/>
   </div>
   <input type="file" class="image" id = "fileToUpload" name = "fileToUpload" />
   <img src="" class="preview img-responsive2" />
   
   <input type="file" class="image" id = "fileToUpload2" name = "fileToUpload2" />
   <img src="" class="preview img-responsive2" />
   </div>
   <?= $this->Form->button(__('Submit')); ?>
   <script>
      $('.type').on('change', function() {
      
      if(this.value === "jersey"){
      $("#fileToUpload2").show();
      }
      if(this.value === "disc"){
      $("#fileToUpload2").hide();
      }
      }); 
         $(function(){
           $(".image").change(showPreviewImage_click);
         })
         
         function showPreviewImage_click(e) {
           var $input = $(this);
           var inputFiles = this.files;
           if(inputFiles == undefined || inputFiles.length == 0) return;
           var inputFile = inputFiles[0];
         
           var reader = new FileReader();
           reader.onload = function(event) {
               $input.next().attr("src", event.target.result);
           };
           reader.onerror = function(event) {
               alert("I AM ERROR: " + event.target.error.code);
           };
           reader.readAsDataURL(inputFile);
         }
          
   </script>
</div>