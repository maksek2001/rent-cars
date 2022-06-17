let filter = document.getElementById('filter');
let rents = document.querySelector('#rents');

function renderAll() {
    for (let i = 0; i < rents.children.length; i++) {
        rents.children[i].classList.remove('hide');
    }
}

function renderByStatus(status) {
    for (let i = 0; i < rents.children.length; i++) {
        let tmpElem = rents.children[i];
        if (tmpElem.getAttribute('data-status') != status) {
            tmpElem.classList.add('hide')
        }
    }
}

function renderByPrice(startPrice, endPrice) {
    for (let i = 0; i < rents.children.length; i++) {
        let tmpElem = rents.children[i];
        let price = +tmpElem.getAttribute('data-price');

        if (price < startPrice || price > endPrice) {
            tmpElem.classList.add('hide')
        }
    }
}

function renderByDate(startDate, endDate) {
    for (let i = 0; i < rents.children.length; i++) {
        let tmpElem = rents.children[i];
        let dataStartDate = new Date(tmpElem.getAttribute('data-start-date'));
        let dataEndDate = new Date(tmpElem.getAttribute('data-end-date'));

        if (dataStartDate < startDate || dataEndDate > endDate) {
            tmpElem.classList.add('hide')
        }
    }
}

function render() {
    let status = document.getElementById('status-select').value;

    let startPrice = document.getElementById('start-price').value;
    let endPrice = document.getElementById('end-price').value;

    let startDate = document.getElementById('start-date').value;
    let endDate = document.getElementById('end-date').value;

    renderAll();

    if (status != '') {
        renderByStatus(status);
    }

    if (startPrice != '' && endPrice != '') {
        renderByPrice(+startPrice, +endPrice);
    }

    if (startDate != '' && endDate != '') {
        renderByDate(new Date(startDate), new Date(endDate));
    }

}

filter.onclick = render;