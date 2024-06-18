document.addEventListener('DOMContentLoaded', function() {
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

        // Parse de tijd in een Date object voor vergelijking
        let selectedDate = new Date(selectedTime);
        let minTime = new Date(selectedDate);
        let maxTime = new Date(selectedDate);

        minTime.setHours(6, 0); // Stel minimum tijd in op 06:00 uur
        maxTime.setHours(16, 0); // Stel maximum tijd in op 16:00 uur

        // Vergelijk de tijd
        if (selectedDate < minTime || selectedDate > maxTime) {
            vertrekTijd.setCustomValidity("Tijd moet tussen 06:00 en 16:00 liggen.");
        } else {
            vertrekTijd.setCustomValidity("");
        }
    });
});
