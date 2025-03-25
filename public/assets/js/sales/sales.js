
$(document).ready(function () {

    $("#add-row").DataTable({
      pageLength: 5,
    });

    var action =
      '<td> <div class="form-button-action"> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';
  });


  function confirmDelete(deleteSaleId) {

if (confirm("Are you sure you want to delete this Sale?")) {

window.location.href = baseUrl + `/deleteSale/${deleteSaleId}`;
}
}



function showSaleDetails(saleId) {
    $.ajax({
        url: baseUrl + '/getSaleDetails/' + saleId,
        method: 'GET',
        success: function(response) {
            var saleDetails = JSON.parse(response);
            var tableBody = $('#saleDetailsTableBody');
            tableBody.empty();

            saleDetails.forEach(function(detail) {
                var medicamentName = (detail.medicament_id === null) ? 'Deleted Medicament' : detail.medicament_name;

                var row = '<tr>' +
                    '<td>' + medicamentName + '</td>' +
                    '<td>' + detail.quantity + '</td>' +
                    '<td>' + detail.price + '</td>' +
                    '<td>' + detail.prescription + '</td>' +
                    '<td>' + detail.total + '</td>' +
                  '<td>' +  
                    '<a href="#" class="btn btn-sm btn-danger" onclick="deleteSaleItem(' + detail.item_id + ',' + detail.sale_id  + ')">' +
                        '<i class="fa fa-trash"></i>' +
                    '</a>' +
                '</td>' +
            '</tr>';         
                tableBody.append(row);
            });

            $('#saleDetailsModal').modal('show');
        },
        error: function() {
            alert('Erreur lors du chargement des détails de la vente.');
        }
    });
}

function deleteSaleItem(itemId,saleId) {
if (confirm('Are you sure you want to remove this item?')) {
    $.ajax({
      url: baseUrl + '/deleteSaleItem/'+ itemId + '/' + saleId,
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                alert('Item deleted successfully.');
                showSaleDetails(saleId);
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

function generateInvoice(saleId){
if (saleId) {
      window.location.href = baseUrl + "/generateSaleInvoice/" + saleId;
    } else {
        alert("Error :sale ID not found !");
    }
}