        <div class="modal fade" id="delete<?php echo $row['id'];?>">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header" style="background-color: #ff4d4d;">
              <h4 class="modal-title" style="color: white">Delete <?php echo $row['book_id'];?> </h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p style="font-style: inherit;">Do You want to Delete this Book  ?..</p>
              <h2 align="center"><?php echo $row['book_title'];?></h2>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-mini btn-default" data-dismiss="modal">Cancel</button>
              <a href="delete_book_process.php?id=<?php echo $row['id'];?>" class="btn btn-mini btn-danger"><i class="fa fa-trash" aria-hidden="true"></i>Delete</a>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->