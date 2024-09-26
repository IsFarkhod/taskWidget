const btnSearch = document.getElementById("buttonSearch");
const inputModalWindow = document.getElementById("inputModalWindow")

const openModalWindow = document.getElementById("openModalWindow");
const closeModalWindow = document.getElementById("closeModalWindow");
openModalWindow.onclick = function () {
    modalWindow.style.display = "flex";
};

closeModalWindow.onclick = function () {
    modalWindow.style.display = "none";
}
btnSearch.addEventListener('click', function () {
    const productName = document.getElementById("inputModalWindow").value;
    console.log(productName)
    fetch(`index.php?product_name=${encodeURIComponent(productName)}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                document.getElementById('result').textContent = data.message;
            } else {
                document.getElementById('result').textContent = `ИКПУ: ${data.mxikCode} < br > Код упаковки: ${data.packageCode}`;
            }

        })
        .catch(error => {
            console.error('Ошибка: ', error);
            document.getElementById('result').innerText = 'Произошла ошибка при выполнении запроса';
        });
});