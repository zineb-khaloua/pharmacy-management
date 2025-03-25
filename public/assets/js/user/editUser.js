
document.getElementById("cancel-btn").addEventListener("click", function() {
    window.location.href = baseUrl +"/authenInfo";
    });
    
 
    function loadProfileImage(event) {
        const image = document.getElementById('profileImage');
        image.src = URL.createObjectURL(event.target.files[0]);
}