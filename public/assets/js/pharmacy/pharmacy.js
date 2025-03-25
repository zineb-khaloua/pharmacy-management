document.getElementById("cancel-btn").addEventListener("click", function() {
    window.location.href = basseUrl +"/dashboard";
});
    

function loadLogoImage(event) {
    const image = document.getElementById("profileImage");
    const file = event.target.files[0];

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            image.src = e.target.result; 
        };
        reader.readAsDataURL(file);
    }
}

    

   
