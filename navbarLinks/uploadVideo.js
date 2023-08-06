// Start of script for videoServers.php
let serverABtn=document.getElementById("serverABtn");
let serverBBtn=document.getElementById("serverBBtn");
let serverAInput=document.getElementById("serverA");
let serverBInput=document.getElementById("serverB");

// Initially disabling the buttons
serverABtn.disabled=true;
serverBBtn.disabled=true;

serverAInput.addEventListener("input" , e => {
    if(serverAInput.value.length=="")
    {
        serverABtn.disabled=true;
    }
    else
    {
        serverABtn.disabled=false;
    }
});

serverBInput.addEventListener("input" , e => {
    if(serverBInput.value.length=="")
    {
        serverBBtn.disabled=true;
    }
    else
    {
        serverBBtn.disabled=false;
    }   
});
// End of script for videoServers.php