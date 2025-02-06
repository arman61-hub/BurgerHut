function toggleMenu() {
    const navLinks = document.getElementById('nav-links');
    const hamburger = document.querySelector('.hamburger');
    navLinks.classList.toggle('active');
    hamburger.classList.toggle('active');
}

function change() {
    document.getElementById('btn').style.backgroundColor = '#cc0000';
}

function retrieve() {
    document.getElementById('btn').style.backgroundColor = '#ff0000';
}
