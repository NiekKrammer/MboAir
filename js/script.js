document.addEventListener("DOMContentLoaded", function () {
 
 // Toon verberg cargo of passagiers DIV
  function updatePassengerCargoFields() {
    let vliegtuigType = document.getElementById("vliegtuig_type").value;
    let passagiersDiv = document.querySelector(".passagiers");
    let cargoDiv = document.querySelector(".cargo");

    if (vliegtuigType === "Boeing 737-700") {
        passagiersDiv.style.display = "none";
        cargoDiv.style.display = "flex";
    } else {
        passagiersDiv.style.display = "flex";
        cargoDiv.style.display = "none";
    }
}

document.getElementById("vliegtuig_type").addEventListener("change", updatePassengerCargoFields);

updatePassengerCargoFields();

  // Vertrek tijd (moet tussen 06:00 en 16:00 uur zijn)
  const vertrekTijd = document.querySelector(".vertrek_tijd");

  vertrekTijd.addEventListener("input", function () {
    let selectedTime = vertrekTijd.value;

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

// Zoek functionaliteit
function searchTable() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.querySelector(".search_field");
  filter = input.value.toUpperCase();
  table = document.querySelector(".vluchten_tabel");
  tr = table.getElementsByTagName("tr");

  // Loop door alle rijen, verberg degene die niet overeenkomen met de zoekopdracht
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td");
    for (var j = 0; j < td.length; j++) {
      if (td[j]) {
        txtValue = td[j].textContent || td[j].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
          break; // Laat de rij zien als er een match is gevonden en ga naar de volgende rij
        } else {
          tr[i].style.display = "none"; // Verberg de rij als er geen match is gevonden
        }
      }
    }
  }
}

// Vertrek en aankomst luchthaven, piloot en copiloot mogen niet hetzelfde zijn
document.querySelector(".flightForm").addEventListener("submit", function(event) {
  const vertrekLuchthaven = document.getElementById("vertrek_luchthaven").value;
  const aankomstLuchthaven = document.getElementById("aankomst_luchthaven").value;

  const piloot1 = document.getElementById("piloot1").value;
  const piloot2 = document.getElementById("piloot2").value;

  // Controleer of vertrek- en aankomstluchthaven hetzelfde zijn
  if (vertrekLuchthaven === aankomstLuchthaven) {
    alert("Vertrek en aankomst luchthavens mogen niet hetzelfde zijn.");
    event.preventDefault();
    return;
  }

  // Controleer of piloot1 en piloot2 hetzelfde zijn
  if (piloot1 === piloot2) {
    alert("Piloot en Copiloot mogen niet hetzelfde zijn.");
    event.preventDefault();
    return;
  }
});


// Maximaal aantal passagiers per vliegtuig
function updatePassengerLimit() {
  const vliegtuigTypeSelect = document.getElementById("vliegtuig_type");
  const selectedOption =
    vliegtuigTypeSelect.options[vliegtuigTypeSelect.selectedIndex];
  const maxPassengers = selectedOption.getAttribute("data-max-passengers");
  const aantalPassagiersInput = document.getElementById("aantal_passagiers");

  if (maxPassengers) {
    aantalPassagiersInput.max = maxPassengers;
    if (aantalPassagiersInput.value > maxPassengers) {
      aantalPassagiersInput.value = maxPassengers;
    }
  } else {
    aantalPassagiersInput.removeAttribute("max");
  }
}
