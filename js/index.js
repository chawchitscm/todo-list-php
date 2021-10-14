$(function(){
    $('.editBtn').click(function(){
        var id = $(this).attr('data-id');
        var name = $(this).attr('data-name');
        var desc = $(this).attr('data-desc');
        var due = $(this).attr('data-due');
        var checked = $(this).attr('data-checked');
        var finish = $(this).attr('data-finish');

        $('#todo_modal_id').val(id);
        $('#todo_modal_name').val(name);
        $('#todo_modal_desc').val(desc);
        $('#todo_modal_due').val(due);
        $('#todo_modal_finish').val(finish);
        if(checked == 1) {
            $('#todo_modal_checked').attr('checked', true);
        }
    });
});