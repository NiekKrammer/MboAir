// Toon/verberg cargo lading (kg) veld
const vliegtuigTypes = document.querySelector('.vliegtuigTypes');
const cargo_lading_input = document.querySelectorAll('.cargo_lading');

vliegtuigTypes.addEventListener('change', function handleChange(event) {
    const selectedValue = event.target.value;
    cargo_lading_input.forEach(function(field) {
        if (selectedValue === 'Boeing 737-700') {
            field.style.display = 'block';
        } else {
            field.style.display = 'none';
        }
    });
});

// Vertrek moet tussen 06:00 uur en 16:00 uur zijn
const vertrekTijd = document.querySelector(".vertrek_tijd");

vertrekTijd.addEventListener("input", function() {
    let selectedTime = vertrekTijd.value;
    let minTime = "06:00";
    let maxTime = "16:00";

    if (selectedTime < minTime || selectedTime > maxTime) {
        vertrekTijd.setCustomValidity("Tijd moet tussen 06:00 en 16:00 liggen.");
    } else {
        vertrekTijd.setCustomValidity("");
    }
});