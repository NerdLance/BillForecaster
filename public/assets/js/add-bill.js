const recurrance = document.querySelector('#recurrance');
const weeklyDayContainer = document.querySelector('#weekly-day-container');
const weeklyDayInput = document.querySelector('#weekly_day');

if (recurrance.value == 'weekly') {
    weeklyDayContainer.classList.add('show');
}

const handleChange = (event) => {
    if (event.target.value == 'weekly') {
        weeklyDayContainer.classList.add('show');
    } else {
        weeklyDayInput.value = "";
        weeklyDayContainer.classList.remove('show');
    }
}

recurrance.addEventListener('change', handleChange);