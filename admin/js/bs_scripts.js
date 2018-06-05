$('.delete_btn').on('click', function(){
  var id = $(this).attr('data-delete');
  var title = $(this).attr('data-title');
  $('li#li_id').html('ID: '+id);
  $('li#li_title').html('ID: '+title);

  $('#delete_post_btn').attr('href', '//' + location.host + location.pathname+'?delete_id='+id);
});

$( ".datepicker" ).datepicker({
  dateFormat: "yy-mm-dd"
});

var button = $('button[data-media_btn=save]');

button.on('click', function(){
  var selected = $('.media_input:checked');
  var file_name = selected.attr('data-name');
  console.log(file_name);
  $('.featured-img').attr('src', '../upload/'+file_name);
});
