$(document).ready(function () {

    let table = $('#ingredientTable').DataTable({
        ajax: {
            url: baseUrl + 'product/getAll',
            dataSrc: function(json){

                // 🔥 CARD COUNTS
                let total = json.data.length;
                let low = 0;
                let out = 0;

                json.data.forEach(item=>{
                    if(item.quantity == 0) out++;
                    else if(item.quantity <= 20) low++;
                });

                $('#totalItems').text(total);
                $('#lowStock').text(low);
                $('#outStock').text(out);

                return json.data;
            }
        },

        columns: [
            { data: 'product_name' },
            { data: 'category' },
            { data: 'quantity' },
            { data: 'unit' },
            { 
                data: 'price',
                render: d => '₱ '+parseFloat(d).toFixed(2)
            },
            {
                data: 'quantity',
                render: d=>{
                    if(d==0) return '<span class="badge bg-danger">Out</span>';
                    if(d<=20) return '<span class="badge bg-warning">Low</span>';
                    return '<span class="badge bg-success">In</span>';
                }
            },
            {
                data:null,
                render: row=>`
                <button class="btn btn-warning btn-sm edit-btn" data-id="${row.product_id}">Edit</button>
                <button class="btn btn-danger btn-sm delete-btn" data-id="${row.product_id}">Delete</button>`
            }
        ]
    });

    $('#addProductForm').submit(function(e){
        e.preventDefault();
        $.post(baseUrl+'product/save', $(this).serialize(), function(){
            $('#AddNewModal').modal('hide');
            table.ajax.reload();
        });
    });

    $(document).on('click','.delete-btn',function(){
        let id=$(this).data('id');
        if(confirm('Delete?')){
            $.post(baseUrl+'product/delete/'+id,function(){
                table.ajax.reload();
            });
        }
    });

});