
function calculateItemTotal(itemId) {
    let quantity = parseFloat(document.getElementById(`quantity_${itemId}`).value) || 0;
    let price = parseFloat(document.getElementById(`price_${itemId}`).value) || 0;
    let total = quantity * price;
    document.getElementById(`total_${itemId}`).value = total.toFixed(2);
    calculateGeneralTotal();
  }

  function calculateGeneralTotal() {
    let totalSum = 0;
    document.querySelectorAll('[id^="total_"]').forEach(input => {
      totalSum += parseFloat(input.value) || 0;
    });
    document.getElementById('generalTotal').value = totalSum.toFixed(2);
  }


  document.querySelectorAll('[id^="quantity_"], [id^="price_"]').forEach(input => {
    input.addEventListener('input', () => {
      let itemId = input.id.split('_')[1];
      calculateItemTotal(itemId);
    });
  });

  document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[id^="quantity_"]').forEach(input => {
      let itemId = input.id.split('_')[1];
      calculateItemTotal(itemId);
    });
  });



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
            cell1.innerHTML = medicamentName;
            cell2.innerHTML = quantity;
            cell3.innerHTML = price;
            cell4.innerHTML = prescription;
            cell5.innerHTML = '<input type="hidden" class="item-total" value="' + total + '">' + total;


              generalTotal += parseFloat(total);

              updateGeneralTotal(); 

            var medicamentData = JSON.parse(document.getElementById('medicament_data').value || '[]');
           
             medicamentData.push({medicament_id: medicamentId ,quantity: quantity,prescription: prescription ,price: price ,total: total });
      
             document.getElementById('medicament_data').value = JSON.stringify(medicamentData);

         
            $('#addMedicamentModal').modal('hide');

            
        });


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
      
  var currentGeneralTotal = parseFloat(document.getElementById('generalTotal').value) || 0;
  
  totalGeneral += currentGeneralTotal;

  document.getElementById('generalTotal').value = totalGeneral.toFixed(2);

}

    document.getElementById("cancel-btn").addEventListener("click", function() {
    window.location.href = baseUrl + "/sale";
});