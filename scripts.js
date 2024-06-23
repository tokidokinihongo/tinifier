const container = document.querySelector('.container');
const submit_button = document.querySelector('.submit-button');
const link_input = document.querySelector('#link-input');
const link_field = document.querySelector('.link-field');
const link_generate = document.querySelector('.link-generate-form');
const theme_change = document.querySelector('.theme-changer');
const header = document.querySelector('header');
const body = document.querySelector('body');

let light_theme = true;

submit_button.addEventListener('click', (e) => {
    if (link_input.value === "") {
        e.preventDefault();
        link_input.style.border = "2px solid red";
        link_field.textContent = "You didn't enter anything!";
    } else {
        link_generate.submit();
    }
})

theme_change.addEventListener('click', () => {
    if (light_theme) {
        container.style.backgroundColor = "black";
        container.style.color = "white";
        submit_button.style.backgroundColor = "white";
        submit_button.style.color = "black";
        link_input.style.border = "1 px solid white";
        header.style.borderBottom = "1px solid white";
        header.style.color = "white";
        theme_change.textContent = "Light";
        light_theme = false;
    } else {
        container.style.backgroundColor = "gray";
        container.style.color = "white";
        submit_button.style.backgroundColor = "black";
        submit_button.style.color = "white";
        link_input.style.border = "1 px solid blue";
        header.style.borderBottom = "1px solid blue";
        header.style.color = "white";
        theme_change.textContent = "Dark";
        light_theme = true;
    }
})