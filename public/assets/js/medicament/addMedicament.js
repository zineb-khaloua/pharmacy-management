document.getElementById('saveModalData').addEventListener('click', function() {

    var medicamentSelect = document.getElementById('modal_medicament_id');
    var medicamentId = medicamentSelect.value;
    var medicamentName = medicamentSelect.options[medicamentSelect.selectedIndex].text;
    //var medicamentId = document.getElementById('modal_medicament_id').value;
    var quantity = document.getElementById('modal_quantity').value;
    var price = document.getElementById('modal_price').value;
    var prescription = document.querySelector('input[name="prescription"]:checked').value;
    var total = document.getElementById('modal_total').value;
  
    var tableBody = document.getElementById('selectedItemsTable').getElementsByTagName('tbody')[0];
    var newRow = tableBody.insertRow();
    var cell1 = newRow.insertCell(0);
    var cell2 = newRow.insertCell(1);
    var cell3 = newRow.insertCell(2);
    var cell4 = newRow.insertCell(3);
    var cell5 = newRow.insertCell(4);
    var cell6 = newRow.insertCell(6);
  
    cell1.innerHTML = medicamentName;
    cell2.innerHTML = quantity;
    cell3.innerHTML = price;
    cell4.innerHTML = prescription;
    cell5.innerHTML = total;
    cell6.innerHTML = '<a href="#" class="btn btn-sm btn-danger" onclick="deleteRow(this)"> <i class="fa fa-trash"></i> </a>';
              
    
  
    var medicamentData = JSON.parse(document.getElementById('medicament_data').value || '[]');
    medicamentData.push({ medicament_id: medicamentId, quantity: quantity,prescription: prescription, price: price ,total: total});
    document.getElementById('medicament_data').value = JSON.stringify(medicamentData);
  
  
    $('#addMedicamentModal').modal('hide');
  });
  
  document.getElementById("cancel-btn").addEventListener("click", function() {
  window.location.href = baseUrl+"/medicament";
  });
  