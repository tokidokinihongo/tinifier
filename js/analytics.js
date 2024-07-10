// document.addEventListener('DOMContentLoaded', () => {
//     const ajaxDiv = document.querySelector('.ajaxtest');
//     const ajaxButton = document.querySelector('.ajax');
//     function updateField() {
//         let xml = new XMLHttpRequest();
//         xml.onreadystatechange = function () {
//             if (this.readyState == 4 && this.status == 200) {
//                 ajaxDiv.innerHTML = this.responseText;
//             }
//         };
//         xml.open("GET", "helloworld.php", true);
//         xml.send();
//     }
//     ajaxButton.addEventListener('click', updateField);
// })