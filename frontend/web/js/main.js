$(document).ready(function () {

    let $startDate = $('#start-date');
    let $endDate = $('#end-date');
    let $totalPrice = $('#total-price');
    let $rentalPrice = $('#rental-price');
    let $rent = $('#rent');
    let $calculatePrice = $("#calculate-price");

    function changeStartDate() {
        let selected = new Date($startDate.val());
        selected.setHours(selected.getHours() - 4);

        let today = new Date();

        if (selected < today) {
            alert("Минимальное время, через которое можно забронировать автомобиль - 4 часа");
            $startDate.val("");
        } else {
            $endDate.val("");
        }

        $totalPrice.val("");
        $rent.prop("disabled", true);
    }

    $startDate.on("change", changeStartDate);

    function changeEndDate() {
        let startDate = new Date($startDate.val());
        let selected = new Date($endDate.val());
        let today = new Date();

        if (selected < today || selected <= startDate) {
            alert("Дата некорректна!(Выбранная дата уже прошла или она находится раньше начальной даты)");
            $endDate.val("");
        }
        $rent.prop("disabled", true);
    }

    $endDate.on("change", changeEndDate);

    // разница в днях между датами
    function dateDifference(first, second) {
        var timeDiff = Math.abs(second.getTime() - first.getTime());
        return Math.ceil(timeDiff / (1000 * 3600 * 24));
    }

    const DAY_HOURS = 16;

    function calculatePrice() {
        let startDate = new Date($startDate.val());
        let endDate = new Date($endDate.val());
        let rentalPrice = $rentalPrice.val();

        if (startDate < endDate) {
            // аренда в течение одного дня
            if (endDate.getDate() == startDate.getDate() && endDate.getMonth() == startDate.getMonth() && endDate.getFullYear() == startDate.getFullYear()) {
                let hours = endDate.getHours() - startDate.getHours();

                if (startDate.getMinutes() > 0 || endDate.getMinutes() > 0) {
                    hours++;
                }

                if (hours > DAY_HOURS) {
                    $totalPrice.attr('value', rentalPrice * hours);
                    $totalPrice.val(rentalPrice * DAY_HOURS);
                    $rent.prop("disabled", false);
                } else {
                    $rent.prop("disabled", false);
                    $totalPrice.attr('value', rentalPrice * hours);
                    $totalPrice.val(rentalPrice * hours);
                }
                // аренда больше чем на 1 день
            } else {
                let totalPrice = 0;

                let firstDayHours = 24 - startDate.getHours();

                if (firstDayHours > DAY_HOURS) {
                    totalPrice += DAY_HOURS * rentalPrice;
                } else {
                    totalPrice += firstDayHours * rentalPrice;
                }

                let firstDate = new Date(startDate.getFullYear(), startDate.getMonth(), startDate.getDate());
                let secondDate = new Date(endDate.getFullYear(), endDate.getMonth(), endDate.getDate());

                // добавление стоимости полных дней
                if (startDate.getHours() == 0 && startDate.getMinutes() == 0) {
                    totalPrice += Math.abs(DAY_HOURS * rentalPrice * (dateDifference(firstDate, secondDate)));
                } else {
                    totalPrice += Math.abs(DAY_HOURS * rentalPrice * (dateDifference(firstDate, secondDate) - 1));
                }

                let endDayHours = endDate.getHours() + 1;

                if (endDate.getMinutes() > 0) {
                    endDayHours++;
                }

                if (endDayHours > DAY_HOURS) {
                    totalPrice += DAY_HOURS * rentalPrice;
                } else {
                    totalPrice += endDayHours * rentalPrice;
                }

                $totalPrice.attr('value', totalPrice);
                $totalPrice.val(totalPrice);
                $rent.prop("disabled", false);
            }
        } else {
            alert("Даты некорректны!");
        }
    }

    $calculatePrice.on("click", calculatePrice);

});