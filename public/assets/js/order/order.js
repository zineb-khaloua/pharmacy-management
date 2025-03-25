$(document).ready(function () {
 
    $("#add-row").DataTable({
      pageLength: 5,
    });

    var action =
      '<td> <div class="form-button-action"> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';
  });


  function confirmDelete(deleteOrderId) {

if (confirm("Are you sure you want to delete this order?")) {

window.location.href = baseUrl + `/deleteOrder/${deleteOrderId}`;
}
}



function showOrderDetails(orderId) {
    $.ajax({
        url: baseUrl + '/getOrderDetails/' + orderId,
        method: 'GET',
        success: function(response) {
            var orderDetails = JSON.parse(response);
            var tableBody = $('#orderDetailsTableBody');
            tableBody.empty();

            orderDetails.forEach(function(detail) {
                var medicamentName = (detail.medicament_id === null) ? 'Deleted Medicament' : detail.medicament_name;

                var row = '<tr>' +
                    '<td>' + medicamentName + '</td>' +
                    '<td>' + detail.quantity + '</td>' +
                    '<td>' + detail.price + '</td>' +
                    '<td>' + detail.total + '</td>' +
                  '<td>' +  
                    '<a href="#" class="btn btn-sm btn-danger" onclick="deleteOrderItem(' + detail.item_id + ',' + detail.order_id + ')">' +
                        '<i class="fa fa-trash"></i>' +
                    '</a>' +
                '</td>' +
            '</tr>';         
                tableBody.append(row);
            });

            $('#orderDetailsModal').modal('show');
        },
        error: function() {
            alert('Erreur lors du chargement des détails de la vente.');
        }
    });
}


function deleteOrderItem(itemId, orderId) {
if (confirm('Are you sure you want to remove this item?')) {
    $.ajax({
      url: baseUrl + '/deleteOrderItem/' + itemId +'/' + orderId,
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                alert('Item deleted successfully.');
                showOrderDetails(orderId);
                location.reload();
            } else {
                alert('Error: ' + response.message);
            }
        },
        error: function(xhr) {
            alert('error: ' + xhr.responseText);
        }
    });
}
}


$(document).ready(function() {
    $('.status-dropdown').on('change', function() {
        var orderId = $(this).data('order-id');
        var newStatus = $(this).val();
        var selectElement = $(this);
        
        $.ajax({
            url: baseUrl + '/updateOrderStatus', 
            type: 'POST',
            dataType: 'json',
            data: {   
                order_id: orderId,
                status: newStatus
            },
            success: function(response) {
              //console.log("Server response:", response);
              if (response.status === 'success')  {
                    alert('Order status updated successfully!');

                    if (newStatus === "completed") {
                    selectElement.prop('disabled', true);
                }
                } else {
                    alert('Failed to update: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
        ///console.error('AJAX Error:', status, error);
        alert('An error occurred while updating the status.');
    }
        });
    });
});



function updateSelectColor(selectElement) {
    selectElement.className = 'status-dropdown ' + selectElement.value;
}
document.querySelectorAll('.status-dropdown').forEach(select => {
    updateSelectColor(select);
    if (select.value === "completed") {
        select.disabled = true;
    }
});


function generateInvoice(orderId){
if (orderId) {
window.location.href = baseUrl + "/generateOrderInvoice/" + orderId;
    } else {
        alert("Error : order ID not found!");
    }
}