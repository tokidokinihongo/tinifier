const container = document.querySelector('.container');
const submit_button = document.querySelector('.submit-button');
const link_input = document.querySelector('#link-input');
const link_field = document.querySelector('.link-field');
const link_generate = document.querySelector('.link-generate-form');
const theme_change = document.querySelector('.theme-changer');
const header = document.querySelector('header');
const body = document.querySelector('body');
const inpcell = document.querySelector('.inpcell');

submit_button.addEventListener('click', (e) => {
    if (link_input.value === "") {
        e.preventDefault();
        link_input.style.border = "2px solid red";
        link_field.textContent = "You didn't enter anything!";
    } else {
        link_generate.submit();
    }
})
