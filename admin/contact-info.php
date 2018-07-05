<?php
$page_title = 'Contact Info';

include 'inc/admin_header.inc.php';

$contact = new Contact;

if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
  $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_STRING);
  $phone = filter_input(INPUT_POST, "phone", FILTER_SANITIZE_STRING);

  $status = $contact->update_contact($name, $phone, $email);

}

$contact_info = $contact->get_contact();

?>

<div class="col-md-12">
  <h1 class="mb-3"><?php echo $page_title; ?></h1>
  <form class="" action="" html" method="post">
    <div class="form-group">
      <?php if(isset($status) && $status == 'success'):?>
        <div class="alert alert-success" role="alert">
          Contact data updated successfully.
        </div>
      <?php elseif(isset($status) && $status != 'success'): ?>
        <div class="alert alert-danger" role="alert">
          <?php echo "Database error ".$status; ?>
        </div>
      <?php endif; ?>
      <label for="name">Enter Name</label>
      <input type="text" name="name" class="form-control mb-5" value="<?php if(isset($contact_info['name'])) echo $contact_info['name']; ?>">
      <label for="phone">Enter Phone Number</label>
      <input type="text" name="phone" class="form-control mb-5" value="<?php if(isset($contact_info['phone'])) echo $contact_info['phone']; ?>">
      <label for="email">Enter Email Address</label>
      <input type="text" name="email" class="form-control mb-5" value="<?php if(isset($contact_info['email'])) echo $contact_info['email']; ?>">
      <button type="submit" class="btn btn-primary btn-block">Save changes</button>
    </div>
  </form>
</div>
