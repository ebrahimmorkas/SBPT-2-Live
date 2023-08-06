// Handling the click event on navbar li's
let li=document.getElementsByClassName("navbar-a-bold")
for(let i=0 ; i<li.length ; i++)
{
    li[i].classList.remove("bold");
    li[i].addEventListener("click" , e => {
        // console.log(li[i]);
        li[i].classList.add("bold");
    });
}