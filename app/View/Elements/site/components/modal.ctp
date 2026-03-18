<!-- Modal -->
<div class="modal fade" id="menuModal" tabindex="-1" aria-labelledby="menuModalLabel" aria-hidden="true">
    <div class="modal-dialog vw-100 vh-100 m-0 p-0">
        <div class="modal-content vw-100 h-100 border-0 position-relative">
            <button type="button" class="close close-menu-modal" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal-body d-flex justify-content-center align-items-center">
                <?php
                echo $this->element('site/components/menu');
                ?>
            </div>
            <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
        </div>
    </div>
</div>