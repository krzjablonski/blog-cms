<?php

$page_title = "Media";

include 'inc/admin_header.inc.php';

if(isset($_GET['pg'])){
  $current_page = filter_input(INPUT_GET, "pg", FILTER_SANITIZE_NUMBER_INT);
}else{
  $current_page = 1;
}

if(isset($_GET['delete_item'])){
  $delete_item = filter_input(INPUT_GET, "delete_item", FILTER_SANITIZE_NUMBER_INT);
  $file_name = filter_input(INPUT_GET, "file_name", FILTER_SANITIZE_STRING);

  if(Media::delete_media($delete_item, $file_name) == 'success'){
    $status = true;
  }else{
    $status = false;
  }

}

$pagination = new Pagination($current_page, 3, 'media', null);

$media = new Media($pagination->get_limit(), $pagination->get_offset());
$media_items = $media->get_all_media();

?>
<div class="col-md-9">
  <div class="row">
    <div class="col">
      <?php if(isset($status) && $status === true):?>
        <div class="alert alert-success" role="alert">
          Post deleted successfully
        </div>
      <?php elseif(isset($status) && $status === false): ?>
        <div class="alert alert-danger" role="alert">
          Error: Couldn't remove post
        </div>
      <?php endif ?>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <h3 class="mb-5">Media Items</h3>
    </div>
  </div>
  <div id="images-list" class="row mb-5">
    <?php foreach($media_items as $media_item): ?>
      <div class="col-md-4">
        <div class="media-image-container shadow-sm">
          <img class="media-image" src="../upload/<?php echo $media_item['file_name'] ?>" alt="<?php echo $media_item['alt_tag'] ?>">
          <div class="delete_image">
            <a href="media.php?delete_item=<?php echo $media_item['id']; ?>&file_name=<?php echo $media_item['file_name']; ?>"><i style="color: white;" class="fas fa-trash-alt"></i></a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
  <div class="row">
    <div class="col">
      <ul class="pagination justify-content-end">
        <?php echo $pagination->show_pagination_back(); ?>
      </ul>
    </div>
  </div>
</div>
<div class="col-md-3">
  <form id="add_image_form" class="form-group">
    <h5 class="mb-3">Add New Image</h5>
    <label for="add_image_field" class="image-select mb-3 d-flex justify-content-between align-items-center" style="cursor:pointer;">
      <span class="imageName">Choose image...</span><i style="display:none;" class="far fa-trash-alt"></i>
    </label>
    <div id="add_image_field_progress_container" class="progress mb-3">
      <div id="add_image_field_progress" class="progress-bar progress-bar-striped" role="progressbar" style="width: 0;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <input hidden class="form-control" type="file" name="image" id="add_image_field">
    <label style="font-size: .8em" for="alt_tag">Enter alt tag for this image</label>
    <input class="form-control mb-3" type="text" name="alt_tag" id="alt_tag">
    <input type="submit" class="btn btn-primary btn-block" value="Upload">
  </form>
</div>


<?php include 'inc/admin_footer.inc.php'; ?>
