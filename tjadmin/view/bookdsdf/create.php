<?php include_once($_SERVER['DOCUMENT_ROOT'].'/ciu/bootstrap.php');
use Ciu\Utility\Message;

?>
<?php include_once(ADMINELEMENT.'head.php');?> <!-- include header section -->
<?php include_once(ADMINELEMENT.'navigation.php');?> <!-- include navigation section -->
        <!-- Page Link start -->
        <div class="page-link wrapper">
          <a href="javascript:void(0)"><i class="fas fa-book"></i> Book </a> <span>-</span>
          <a href="index.php">Books</a> <span>-</span>
          <a href="create.php">Add new</a>
        </div>

        <!-- Page Link End -->

        <!-- Student Register form section start -->
        <div class="wrapper">
          <div class="single-section">
            <div class="page-heading">
              <h2> Add New Book</h2>
            </div>
            <div class="form-style">
              <form id="newBookAddedForm" method="post" enctype="multipart/form-data">
                <div class="input-row">
                  <div class="input-group">
                    <label for="bookName">Book Name</label>
                    <input type="text" id="bookName" name="bookName" placeholder="Enter book name">
                    <div class="error-msg errmsgTw" id="errmsgBookName"></div>
                  </div>
                  <div class="input-group">
                    <label for="writerName">Writter Name</label>
                    <input type="text" id="writerName" name="writerName" placeholder="Book Writter Name.">
                    <div class="error-msg errmsgTw" id="errmsgWriterName"></div>
                  </div>
                </div>
                <div class="input-row">
                  <div class="input-group">
                    <label for="category">Select Category</label>
                    <select name="category" id="category">
                      <option selected disabled>Select Category</option>
                      <option>CSE</option>
                      <option>EEE</option>
                      <option>BBA</option>
                      <option>LAW</option>
                      <option>JOURNALISM</option>
                      <option>ENGLISH</option>
                    </select>
                    <div class="error-msg errmsgTw" id="errmsgBookCategory"></div>
                  </div>
                  <div class="input-group">
                    <label for="totalStock">Total Stock</label>
                    <input type="text" id="totalStock" name="totalStock" placeholder="Enter Total Stock.">
                    <div class="error-msg errmsgTw" id="errmsgTotalStock"></div>
                  </div>
                </div>
                
                <div class="input-row">
                  <div class="input-group">
                    <label for="bookDescription">Description</label>
                    <textarea name="bookDescription" id="bookDescription" rows="10" placeholder="Write about this Book" ></textarea>                    
                    <div class="error-msg errmsgTw" id="errmsgBookDes"></div>
                  </div>                  
                  <div class="input-group">
                    <label for="bookImage">Insert Picture (width:750, Height:900)</label>
                    <input type="file" id="bookImage" name="bookImage">
                    <div class="error-msg errmsgTw" id="errmsgBookImg"></div>
                  </div>
                </div>
                <div class="newBookSubmitLoading"></div>
                <button name="newBookSubmit" id="newBookSubmit">Submit</button>
              </form>
            </div>
          </div>
        </div>
        <!-- Student Register form section End -->

   	  </div><!-- body content End -->  
  </div> <!-- Full body wrap ENd-->
    

<?php include_once(ADMINELEMENT.'footer.php');?> 