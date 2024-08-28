

 

  document.addEventListener("DOMContentLoaded", function() {
         
         
         
         
         // === Affichage de marquers de la ville de chaque utilisateur

        if( document.querySelector(".map")) {

        let data = document.getElementById('mycities').getAttribute('data-my-var');

             let Coordinates = JSON.parse(data);

            // Initialize the map and set its view to the chosen geographical coordinates and a zoom level.
            let map = L.map('map').setView([46.5, 2], 4.5);

            // Add a tile layer to the map, in this case, it's the OpenStreetMap tile layer.
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <div> <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> romain audemar </div>'
            }).addTo(map);

    // Create a marker cluster group
    let markers = L.markerClusterGroup();

          Coordinates.forEach((element, index) => {
              
            let coords = element[0].split('|');
            

          let marker =  L.marker([coords[0], coords[1]]);
   markers.addLayer(marker);
              
          });

map.addLayer(markers)

            
        }
        
        
        
        
        
        
        
         // ===== Autocomplete de l'input register
         const coordinate = document.getElementById("coordinate");
        if(coordinate)  {
         
         
         
            let autocompleteData = [];

            $("#city").autocomplete({
                source: function(request, response) {
                    let url = `https://nominatim.openstreetmap.org/search?q=${request.term}&format=json&addressdetails=1&limit=5`;
                    fetch(url)
                        .then(res => res.json())
                        .then(data => {
                            autocompleteData = data.map(item => ({
                                label: item.display_name,
                                value: item.display_name,
                                lat: item.lat,
                                lon: item.lon
                            }));
                            response(autocompleteData.map(item => ({
                                label: item.label,
                                value: item.value
                            })));
                        })
                        .catch(error => console.error('Error fetching data:', error));
                },
                minLength: 2,
                select: function(event, ui) {
                    let selected = autocompleteData.find(item => item.value === ui.item.value);
                    if (selected) {

                    coordinate.value = selected.lat + "|" + selected.lon ;

                    }
                }
            });

            $("#city").on('blur', function() {
                let inputVal = $(this).val();
                let match = autocompleteData.find(item => item.value === inputVal);
                if (!match) {
                    $(this).val('');
                }
            });

            $("#city").on('keydown', function(event) {
                if (event.key === 'Enter') {
                    let inputVal = $(this).val();
                    let match = autocompleteData.find(item => item.value === inputVal);
                    if (!match) {
                        $(this).val('');
                        event.preventDefault();
                    }
                }
            });
            
         }
            
        });
        
