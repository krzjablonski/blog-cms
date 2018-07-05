$('.delete_btn').on('click', function(){
  var id = $(this).attr('data-delete');
  var title = $(this).attr('data-title');
  $('li#li_id').html('ID: '+id);
  $('li#li_title').html('Title: '+title);

  $('#delete_post_btn').attr('href', '//' + location.host + location.pathname+'?delete_id='+id);
});

$( ".datepicker" ).datepicker({
  dateFormat: "yy-mm-dd"
});

var button = $('button[data-media_btn=save]');

button.on('click', function(){
  var selected = $('.media_input:checked');
  var file_name = selected.attr('data-name');
  $('.featured-img').attr('src', '../upload/'+file_name);
});


$('#add_image_field').on('change', function(e){
  var imageName = e.target.files[0].name
  $('.imageName').html(imageName);
  $('.image-select i').show();
  console.log(imageName);
});

$('.image-select i').on('click', function(e){
  e.preventDefault();
  $('form').trigger('reset');
  $('.imageName').html('Choose Image...');
  $(this).hide();
});
