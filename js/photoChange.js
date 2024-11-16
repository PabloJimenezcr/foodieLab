const fotoInput = document.getElementById('foto');
const chosenImage = document.getElementById('chosen-image');
const fileName = document.getElementById('file-name');

fotoInput.addEventListener('change', function (e) {
    const file = e.target.files[0];

    if (file) {
        const reader = new FileReader();

        reader.onload = function (e) {
            chosenImage.setAttribute('src', e.target.result);
            fileName.textContent = file.name;
        };

        reader.readAsDataURL(file);
    } else {
        chosenImage.setAttribute('src', 'img/user.png');
        fileName.textContent = '';
    }
});