<?php
include ("includes/header_teacher.php");
require ("includes/function.php");
require ("language/language.php");
require_once ("thumbnail_images.class.php");


?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>

<div class="row">

    <div class="col-md-12">

        <div class="card">

            <div class="page_title_block">

                <div class="col-md-5 col-xs-12">

                    <div class="page_title">Cbmepill</div>

                </div>

            </div>

            <div class="clearfix"></div>

            <div class="row mrg-top">

                <div class="col-md-12">



                    <div class="col-md-12 col-sm-12">

                        <?php if (isset($_SESSION['msg'])) { ?> 

                            <div class="alert alert-success alert-dismissible" role="alert"> 
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>

                                <?php echo $_SESSION['msg']; ?></a> </div>

                            <?php unset($_SESSION['msg']);
                          }
                          ?> 

                    </div>

                </div>

            </div>

            <div class="card-body mrg_bottom"> 
                
                <img src="images/no_image_selected.png" id="img" style="width:200px!important;margin: 0 0 20px;">
                 <form>
               
                            <div class="row">

                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <label>Select Image</label>
                                    <select class="form-control" name="image_id" onchange="show_img(this.value)">
                                    <option value="">Select</option>
                                    <?php
                                        $sql = "SELECT id,image FROM `think_higher_images`";
                                        $query = mysqli_query($mysqli, $sql);
                                        while ($row = mysqli_fetch_assoc($query)) {
                                    ?>
                                        <option value="<?=$row['id'] ?>"><?=$row['image'] ?></option>
                                    <?php
                                    }
                                    ?>
                                    </select>

                                </div>
                                
                                   <div class="col-lg-12 col-md-12 col-sm-12">
                                     <label for="text">Enter Text:</label>
                                     <input class="form-control" type="text" id="text"  required>
                                </div>
                                 <div class="col-lg-12 col-md-12 col-sm-12">
                                    <!--<label for="backgroundImageURL">Choose Background Image:</label>-->
                                     <input class="form-control" type="hidden" id="backgroundImageURL"  required>
                                </div>
                                 <div class="col-lg-12 col-md-12 col-sm-12">
                                     <label for="fontSize">Font Size:</label>
                                        <input class="form-control" value="22" type="number" id="fontSize" required>
                                </div>
                                 <div class="col-lg-12 col-md-12 col-sm-12">
                                     <label for="fontWeight">Font Weight:</label>
                                    <select id="fontWeight">
                                        <option value="normal">Normal</option>
                                        <option value="bold">Bold</option>
                                    </select>
                                </div>
                                 <div class="col-lg-12 col-md-12 col-sm-12">
                                     <label for="fontColor">Font Color:</label>
                                      <input class="form-control" type="color" id="fontColor" value="#000000">
                                </div>
                                 <div class="col-lg-12 col-md-12 col-sm-12">
                                    <label for="textX">X-axis Direction:</label>
                                    <input class="form-control" type="number" id="textX" value="80" required>
                                </div>
                                 <div class="col-lg-12 col-md-12 col-sm-12">
                                    <label for="textY">Y-axis Direction:</label>
                                    <input class="form-control" type="number" id="textY" value="110" required>
                                </div>
                                 <div class="col-lg-12 col-md-12 col-sm-12">
                                     <label for="lineHeight">Line Height:</label>
                                   <input class="form-control" type="number" id="lineHeight" value="20" required>
                                </div>
                                 <div class="col-lg-12 col-md-12 col-sm-12">
                                     <label for="wordLimit">Word Limit (in single line):</label>
                                          <input class="form-control" type="number" id="wordLimit" value="380" required>
                                </div>
                                 <div class="col-lg-12 col-md-12 col-sm-12">
                                       <input class="form-control" type="button" value="Create Image" onclick="createImage()">
                                 </div>
                                   </form>
                                   <div id="canvasContainer">
                                    <canvas id="canvas" width="500" height="500"></canvas>
                                </div>
                                <br>
                                <a id="downloadLink" style="display: none;">Download Image</a>
                               
                            </div>
                        </div>
                    </div>
            </div>
        </div>
        
          
      
  
       
  
  

    </div>

</div>

<script>
     $(".chosen-select").chosen({no_results_text: "Oops, nothing found!"});
</script>

<script>
    
    const show_img = async (t) => {
        try {
            let val = t;
            let url = `get_high_think_img_src.php?id=${val}`;
            let response = await fetch(url);
            let data = await response.text();
              console.log(data);
            if(data.indexOf(".che") > -1){
                document.querySelector('#img').src = "images/no_image_selected.png";
            }else{
                document.querySelector('#img').src = data;
                 document.querySelector('#backgroundImageURL').value = data;
            }
        } catch (error) {
            console.log(`The Error is ${error}`);
        }
    }
    
    
    
</script>

  <script>
        function createImage() {
            // Get user inputs
            var text = document.getElementById("text").value;
            var backgroundImageURL = document.getElementById("backgroundImageURL").value;
            var fontSize = document.getElementById("fontSize").value;
            var fontWeight = document.getElementById("fontWeight").value;
            var fontColor = document.getElementById("fontColor").value;
            var textX = parseInt(document.getElementById("textX").value);
            var textY = parseInt(document.getElementById("textY").value);
            var lineHeight = parseInt(document.getElementById("lineHeight").value);
            var wordLimit = parseInt(document.getElementById("wordLimit").value);

            // Create a canvas element and get its context
            var canvas = document.getElementById("canvas");
            var context = canvas.getContext("2d");

            // Load the background image
            var backgroundImg = new Image();
            backgroundImg.src = backgroundImageURL;

            // Draw the background image on the canvas
            backgroundImg.onload = function() {
                context.drawImage(backgroundImg, 0, 0, canvas.width, canvas.height);

                // Set the text style
                context.fillStyle = fontColor;
                context.font = fontWeight + " " + fontSize + "px Arial";

                // Adjust the text position based on user inputs
                var x = (textX >= 0) ? textX : canvas.width + textX;
                var y = (textY >= 0) ? textY : canvas.height + textY;

                // Split the text into multiple lines based on the word limit
                var words = text.split(" ");
                var lines = [];
                var currentLine = "";
                for (var i = 0; i < words.length; i++) {
                    var word = words[i];
                    var currentWidth = context.measureText(currentLine + word).width;
                    if (currentWidth <= wordLimit) {
                        currentLine += word + " ";
                    } else {
                        lines.push(currentLine.trim());
                        currentLine = word + " ";
                    }
                }
                lines.push(currentLine.trim());

                // Draw each line of text on the canvas with the specified line height
                for (var i = 0; i < lines.length; i++) {
                    context.fillText(lines[i], x, y + (i * lineHeight));
                }

                // Show the download link
                var downloadLink = document.getElementById("downloadLink");
                downloadLink.style.display = "block";
                // Set the download link to the canvas image data
                downloadLink.href = canvas.toDataURL("image/png");
                // Set the download link to download the image with a custom filename
                downloadLink.download = "generated_image.png";
            };
        }
    </script>

<?php include ("includes/footer.php"); ?>       