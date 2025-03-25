
      $(document).ready(function () {
       
 
        $("#add-row").DataTable({
          pageLength: 5,
        });

        var action =
          '<td> <div class="form-button-action"> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';
      });

     

   function confirmDelete(deletePatientId) {
  
  if (confirm("Are you sure you want to delete this patient?")) {
    
    window.location.href = baseUrl + `/deletePatient/${deletePatientId}`;
  }
}




