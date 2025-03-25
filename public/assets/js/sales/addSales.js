
let generalTotal = 0;

document.getElementById('saveModalData').addEventListener('click', function() {
           
  var medicamentSelect = document.getElementById('modal_medicament_id');
            var medicamentId = medicamentSelect.value;
            var medicamentName = medicamentSelect.options[medicamentSelect.selectedIndex].text;
           
            var quantity = document.getElementById('modal_quantity').value;
            var prescription = document.querySelector('input[name="prescription"]:checked').value;
             var price = document.getElementById('modal_price').value;
            var total = document.getElementById('modal_total').value;
            

        
            var tableBody = document.getElementById('selectedItemsTable').getElementsByTagName('tbody')[0];
            var newRow = tableBody.insertRow();
            var cell1 = newRow.insertCell(0);
            var cell2 = newRow.insertCell(1);
            var cell3 = newRow.insertCell(2);
            var cell4 = newRow.insertCell(3);
            var cell5 = newRow.insertCell(4);
            var cell6 = newRow.insertCell(5);
            cell1.innerHTML = medicamentName;
            cell2.innerHTML = quantity;
            cell3.innerHTML = price;
            cell4.innerHTML = prescription;
            cell5.innerHTML = '<input type="hidden" class="item-total" value="' + total + '">' + total;
            cell6.innerHTML = '<a href="#" class="btn btn-sm btn-danger" onclick="deleteRow(this)"> <i class="fa fa-trash"></i> </a>';
               
            
              generalTotal += parseFloat(total);

              updateGeneralTotal(); 

            var medicamentData = JSON.parse(document.getElementById('medicament_data').value || '[]');
           
            
             medicamentData.push({medicament_id: medicamentId ,quantity: quantity,prescription: prescription ,price: price ,total: total });
      
             document.getElementById('medicament_data').value = JSON.stringify(medicamentData);

         
            $('#addMedicamentModal').modal('hide');

            


        });

        

function deleteRow(button) {
  if(confirm("Are you sure want to delete this medicament ?")){
       var row = button.closest('tr');
    var total = parseFloat(row.cells[4].innerText) || 0;
    generalTotal -= total;
    updateGeneralTotal();
    row.remove();

    var medicamentId = row.getAttribute('data-medicament-id');
    var medicamentData = JSON.parse(document.getElementById('medicament_data').value || '[]');
    medicamentData = medicamentData.filter(item => item.medicament_id !== medicamentId);
    document.getElementById('medicament_data').value = JSON.stringify(medicamentData);
  }
 
}


 document.getElementById('modal_medicament_id').addEventListener('change', function() {
    
    var selectedOption = this.options[this.selectedIndex];
    var price = selectedOption.getAttribute('data-price');
    document.getElementById('modal_price').value = price;
    calculateTotal();
 });


document.getElementById('modal_quantity').addEventListener('input', function() {
    calculateTotal();
});



function calculateTotal() {
    var price = parseFloat(document.getElementById('modal_price').value) || 0;
    var quantity = parseInt(document.getElementById('modal_quantity').value) || 0;
    var total = price * quantity;
    document.getElementById('modal_total').value = total.toFixed(2);
}


function updateGeneralTotal() {
    var totalGeneral = 0;

    var rows = document.getElementById('selectedItemsTable').getElementsByTagName('tbody')[0].rows;

    for (var i = 0; i < rows.length; i++) {
        var row = rows[i];
        var totalCell = row.cells[4];  
        var total = parseFloat(totalCell.innerText) || 0; 
        totalGeneral += total;
    }

    document.getElementById('totalGeneral').innerText = totalGeneral.toFixed(2);

    document.getElementById('generalTotal').value = totalGeneral.toFixed(2);


}
$(document).ready(function () {
    $("#mainForm").on("submit", function (event) {
        event.preventDefault(); 

        $.ajax({
            url: baseUrl + "/addSale",
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function (response) {
                console.log('Response:', response); 

                $(".error-message").text("").hide(); 

                if (response.status === "success") {
                    $("#modalMessage").text(response.message);
                    $("#confirmationModal").modal("show");
                    $("#generateInvoiceBtn").data("saleId", response.saleId);
                    
                } else if (response.status === "error") {
                   
                    console.log("Errors detected :", response.errors);

                    if (response.errors && typeof response.errors === "object") {

                        $.each(response.errors, function (field, messages) {
                            let errorField = $("#error-" + field); 
                            if (errorField.length) {
                                errorField.text(messages[0]).show();
                            }
                        });
                    } else {
                        alert(response.message || "An error occurred.");
                    }
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error: ", status, error);
                console.log("Server Response: ", xhr.responseText); 
                alert("Error while submitting the form.");
            }
        });
    });



  $("#generateInvoiceBtn").on("click", function () {
        let saleId = $(this).data("saleId");
        if (saleId) {
          window.location.href = baseUrl + "/generateSaleInvoice/" + saleId;
        } else {
            alert("Erreur : Order ID non trouvé !");
        }
    });
});


document.getElementById("cancel-btn").addEventListener("click", function() {
window.location.href = baseUrl + "/sale";
});