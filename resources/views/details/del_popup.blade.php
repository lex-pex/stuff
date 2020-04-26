<!-- Delete Confirmation Pop-Up Modal -->
<div class="container">
    <div class="modal fade in" id="modal-default" style="display: none; padding-right: 15px;">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header text-center">
                    <span id="del_modal_title" class="modal-title"> Delete </span>
                    <a class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"> × </span>
                    </a>
                </div>

                <div class="modal-body text-center text-bold">
                    <p>Are you sure you want</p>
                    <p>to erase the <i id="item">Item</i> :</p>
                    <p id="item_name"> </p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-outline-dark" data-dismiss="modal">Cancel</button>
                    <form id="del_form" method="post" action="404" style="display: inline-block">
                        @csrf
                        <input type="hidden" name="_method" value="delete">
                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
