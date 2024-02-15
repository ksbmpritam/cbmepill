var avatar;

var input;

var cropper;

var imghidden;

var image = document.getElementById('image');

var $image = $("#image");

var $modal = $('#modal');

var height,width;

var type;



// $('[data-toggle="tooltip"]').tooltip();



$(document).on('change', '.inputfile', function(e){

  input = this;
  type = input.files[0].type;
  //console.log(input.files[0].type);
  width = $(input).data('width');

  height = $(input).data('height');

  avatar = $(input).closest('.labeled').children('.avatar');      

  imghidden = $(input).closest('.labeled').children('.imghidden');

  //console.log(avatar);

  var files = e.target.files;

  var done = function (url) {
    //console.log(url);
    input.value = '';

    image.src = url;

    $modal.modal('show');

  };



  if (files && files.length > 0) {

    file = files[0];

    if (URL) {

      done(URL.createObjectURL(file));

    } else if (FileReader) {

      reader = new FileReader();

      reader.onload = function (e) {

        done(reader.result);

      };

      reader.readAsDataURL(file);

    }

  }

});



$modal.on('shown.bs.modal', function () {

  //console.log(calculate_ratio());
  if(width != ''){
    cropper = $image.cropper({

      aspectRatio: calculate_ratio().a / calculate_ratio().b,

      crop: function(e) {

      }

    });
  }else{
      cropper = $image.cropper({

        crop: function(e) {

        }

      });
  }



}).on('hidden.bs.modal', function () {

  $image.cropper('destroy');

  cropper = null;

});



$(document).on('click', '#crop', function () {

  var initialAvatarURL;

  var canvas;

  //console.log(cropper);
  if (cropper) {

    canvas = $image.cropper('getCroppedCanvas', {width: width, height: height});
    // console.log(canvas);
    // var imie = base64MimeType(canvas.toDataURL());
    $(avatar).attr('src', canvas.toDataURL(type, 1));

    $(imghidden).val(canvas.toDataURL(type, 1));

  }

  $modal.modal('hide');
});

// function base64MimeType(encoded) {
//   var result = null;

//   if (typeof encoded !== 'string') {
//     return result;
//   }

//   var mime = encoded.match(/data:([a-zA-Z0-9]+\/[a-zA-Z0-9-.+]+).*,.*/);

//   if (mime && mime.length) {
//     result = mime[1];
//   }

//   return result;
// }







  

var calculate_ratio = function(){



  var gcd = function(a,b){

    return (b == 0) ? a : gcd(b,a%b);

  };



  var gcd = gcd(width,height);

  //console.log(gcd);

  return {a:(width/gcd), b:(height/gcd)};



};