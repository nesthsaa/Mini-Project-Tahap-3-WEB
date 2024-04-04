// Ambil formulir feedback menggunakan id
var feedbackForm = document.getElementById("feedbackForm");

// Tambahkan event listener untuk form submission
feedbackForm.addEventListener("submit", function(event) {
    // Set timeout untuk membersihkan formulir setelah 3 detik
    setTimeout(function() {
        feedbackForm.reset(); // Membersihkan formulir
    }, 3000); // Waktu dalam milidetik (3000 milidetik = 3 detik)
});

let menu = document.querySelector('.toggle');
let navbar = document.querySelector('.navbar');

menu.onclick = function(){
    menu.classList.toggle('active');
    navbar.classList.toggle('active');
}

let list = document.querySelectorAll('.list');

for(let i=0; i<list.length; i++){
    list[i].onclick = function(){
        let j=0;
        while(j<list.length){
            list[j++].className = 'list'
        }
        list[i].className = 'list active';
    }
}
