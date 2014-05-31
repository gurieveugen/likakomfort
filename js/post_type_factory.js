jQuery(document).ready(function(){
	// =========================================================
	// Add new item to table
	// =========================================================
	jQuery('.add-table-item').click(function(e){
		var table   = jQuery(this).parent().parent().parent().parent();
		var count   = table.data('columnsCount');
		var last_id = table.data('lastId');
		var columns = {};
		var row     = '';
		var name    = table.attr('id');

		table.find('thead tr th').each(function(index){
			columns[index] = jQuery(this).data('name').toLowerCase();
		});

		last_id++;

		for (var i = 0; i < count; i++) 
		{
			row += '<td><input type="text" class="widefat" name="' + name + '[' + last_id + '][' + columns[i] + ']"></td>';
		}
		row = '<tr>' + row + '</tr>';

		table.find('tbody .footer').before(row);		
		table.data('lastId', last_id);

		e.preventDefault();
	});
	// =========================================================
	// REMOVE TABLE ITEM
	// =========================================================
	jQuery('.remove-btn').click(function(e){
		var row_id = '#' + jQuery(this).data('rowId');
		if(confirm('You realy want remove this item?'))
		{
			jQuery(row_id).remove();
		}
		e.preventDefault();
	});
});