document.addEventListener('DOMContentLoaded', function() {
    const airports = [
        {"name": "Amsterdam, Netherlands"},
        {"name": "Athens, Greece"},
        {"name": "Barcelona, Spain"},
        {"name": "Berlin, Germany"},
        {"name": "Budapest, Hungary"},
        {"name": "Copenhagen, Denmark"},
        {"name": "Dublin, Ireland"},
        {"name": "Rome, Italy"},
        {"name": "Helsinki, Finland"},
        {"name": "Istanbul, Turkey"},
        {"name": "Lisbon, Portugal"},
        {"name": "London, United Kingdom"},
        {"name": "Madrid, Spain"},
        {"name": "Moscow, Russia"},
        {"name": "Munich, Germany"},
        {"name": "Oslo, Norway"},
        {"name": "Paris, France"},
        {"name": "Prague, Czech Republic"},
        {"name": "Riga, Latvia"},
        {"name": "Stockholm, Sweden"},
        {"name": "Vienna, Austria"},
        {"name": "Warsaw, Poland"},
        {"name": "Zurich, Switzerland"}
    ];

    // Functie om opties toe te voegen aan een select element
    function populateSelect(selectElement, airportList) {
        airportList.forEach(function(airport) {
            let option = document.createElement('option');
            option.value = airport.name;
            option.textContent = airport.name;
            selectElement.appendChild(option);
        });
    }

    // Selecteer alle vertrek_luchthaven_select elementen
    let selectElements = document.querySelectorAll('.luchthavens_select');

    // Vul alle vertrek_luchthaven_select elementen met opties
    selectElements.forEach(function(selectElement) {
        populateSelect(selectElement, airports);
    });
});
