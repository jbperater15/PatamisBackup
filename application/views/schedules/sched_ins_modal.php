<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- <form action="<?php echo base_url() ?>Schedules/evaluation_schedule_insert" method="post" role='form'> -->
        <form action="<?php echo base_url() ?>Upload/up_calendar" method="post" role='form'>
            <div class="form-group">
                <label for="p-in" class="col-md-4 label-heading">Title</label>
                <div class="col-md-12 ui-front">
                    <input type="hidden" name="evaluation_id" id="evaluation_id" value="" required="">
                    <input type="text" class="form-control" name="title" id="evaluation_title" value="" required="">
                </div>
            </div>
            <div class="form-group">
                <label for="p-in" class="col-md-4 label-heading">Description</label>
                <div class="col-md-12 ui-front">
                    <input type="text" class="form-control" name="description" id="description" value="" required="">
                </div> 
            </div>
            <div class="form-group">
                <label for="p-in" class="col-md-4 label-heading">Location</label>
                <div class="col-md-12 ui-front">
                    <input type="text" class="form-control" name="location" id="location" value="" required="">
                </div>
            </div>
            <div class="form-group">
                <label for="p-in" class="col-md-4 label-heading">Date</label>
                <div class="col-md-12 ui-front">
                    <input type="date" class="form-control" name="date" data-date="" data-date-format="DD MMMM YYYY" id="sched_date" value="" required="">
                </div>
            </div>
            <div class="form-group">
                <label for="p-in" class="col-md-4 label-heading">Time Start</label>
                <div class="col-md-12">
                    <input type="time" class="form-control" name="time_start" id="time_start" required="">
                </div>
            </div>
            <div class="form-group">
                <label for="p-in" class="col-md-4 label-heading">Time End</label>
                <div class="col-md-12">
                    <input type="time" class="form-control" name="time_end" id="time_end" required="">
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>