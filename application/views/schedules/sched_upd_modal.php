<!-- Update Modal -->
<div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?php echo base_url() ?>main_controller/update_event" method="post" role='form'>
            <div class="form-group">
                <label for="p-in" class="col-md-4 label-heading">Title</label>
                <div class="col-md-12 ui-front">
                    <input type="hidden" name="evaluation_id" id="evaluation_id1" value="" required="">
                    <input type="text" class="form-control" name="evaluation_title" id="evaluation_title1" value="" required="">
                </div>
            </div>
            <div class="form-group">
                <label for="p-in" class="col-md-4 label-heading">Date</label>
                <div class="col-md-12 ui-front">
                    <input type="date" class="form-control" name="date" id="sched_date1" value="" required="">
                </div>
            </div>
            <div class="form-group">
                <label for="p-in" class="col-md-4 label-heading">Time Start</label>
                <div class="col-md-12">
                    <input type="time" class="form-control" name="time_start" id="time_start1" required="">
                </div>
            </div>
            <div class="form-group">
                <label for="p-in" class="col-md-4 label-heading">Time End</label>
                <div class="col-md-12">
                    <input type="time" class="form-control" name="time_end" id="time_end1" required="">
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-danger" id="deleteButton" data-toggle="modal" data-target="#myModal">Delete</button>
        <button type="submit" class="btn btn-info" id="updateButton">Update changes</button>
      </div>
      </form>
    </div>
  </div>
</div>