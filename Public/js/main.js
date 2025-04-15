const gear = document.getElementById("gear");
const gearBox = document.getElementById("gearBox");

const holder = document.getElementById("holder");
const spinner = document.getElementById("spinner");

const withdrawBtn = document.getElementById("withdrawBtn");
const withdrawContainer = document.getElementById("withdrawContainer");


const alertModal = document.getElementById("alertModal");
const popUp = document.getElementById("popUp")


setInterval(() => {
    popUp.classList.toggle('active');
}, 9000);

setTimeout(() => {
    alertModal.style.display = 'none';
}, 4000);

// const navLinks = document.getElementById('navLinks');
// const navItem = navLinks.querySelectorAll('li');

withdrawBtn.addEventListener('click', ()=> {
    withdrawContainer.classList.toggle('active');
});

gear.addEventListener('click', (e)=> {
    e.preventDefault();
    gearBox.classList.toggle("active");
});

// console.log(navItem);

// navItem.forEach(link => {
//     link.addEventListener('click', (e)=> {
//         // e.preventDefault();
//         link.classList.toggle('active');
//     });
// });


window.addEventListener('load', () => {
    spinner.style.display = "none";
});



