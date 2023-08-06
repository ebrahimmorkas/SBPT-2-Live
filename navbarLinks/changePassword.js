let passwordInput=document.getElementById("password");
let changePasswordBtn=document.getElementById("changePasswordBtn");
changePasswordBtn.disabled=true;
passwordInput.addEventListener("input" , () => {
    if(passwordInput.value=="")
    {
        changePasswordBtn.disabled=true;
    }
    else
    {
        changePasswordBtn.disabled=false;   
    }
});