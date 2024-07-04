<!-- Modal -->
<div class="modal fade" id="approvalModal" tabindex="-1" aria-labelledby="approvalModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="approvalModalLabel">Approval</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form action="" method="post" id="approval-form">
              @csrf
              <div class="modal-body">
                  <div class="mb-3 form-group row">
                      <label for="reason" class="col-form-label col-sm-2">Catatan</label>
                      <div class="col-sm-10">
                          <textarea class="form-control" id="reason" name="reason" placeholder="Leave a reason here" required id="floatingTextarea"></textarea>
                      </div>
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                  <button type="submit" name="submit" class="btn btn-info">Lanjutkan</button>
              </div>
          </form>
      </div>
  </div>
</div>