// console.log("Hello this is JS file for Login page");
let timeInput=document.getElementById("time");

let date=new Date();
timeInput.value=`${date.getHours()}:${date.getMinutes()}:${date.getSeconds()}`;

// Hiding the time input
timeInput.style.display="none";

// // Getting the its password and button
// let loginBtn=document.getElementById("loginBtn");
// let ITSInput=document.getElementById("its");
// let password=document.getElementById("password");

// // Initially disabling the login button
// loginBtn.disabled=true;

// // Adding event listener on ITS input
// ITSInput.addEventListener("input" , () => {
//     if(ITSInput.value.length==8 && password.value!="")
//     {
//         loginBtn.disabled=false;
//     }
// });

// // Adding event listener on password input
// password.addEventListener("input" , () => {
//     if(ITSInput.value.length==8 && password.value!="")
//     {
//         loginBtn.disabled=false;
//     }
// });