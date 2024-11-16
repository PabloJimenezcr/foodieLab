let lessBtns = document.querySelectorAll('.less');
let moreBtns = document.querySelectorAll('.more');

for (let i = 0; i < lessBtns.length; i++) {
    let inputQty = lessBtns[i].nextElementSibling;

    lessBtns[i].addEventListener('click', function () {
        if (inputQty.value > parseInt(inputQty.getAttribute('min'))) {
            inputQty.value = parseInt(inputQty.value) - parseInt(inputQty.getAttribute('step'));
        }
    });

    moreBtns[i].addEventListener('click', function () {
        if (inputQty.value < parseInt(inputQty.getAttribute('max'))) {
            inputQty.value = parseInt(inputQty.value) + parseInt(inputQty.getAttribute('step'));
        }
    });
}