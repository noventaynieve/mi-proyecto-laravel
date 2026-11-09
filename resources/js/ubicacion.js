const mapElement = document.querySelector('[data-google-map]');

if (mapElement instanceof HTMLElement) {
    const statusElement = document.querySelector('[data-map-status]');
    const fallbackMap = document.querySelector('[data-static-map-fallback]');
    const locateButton = document.querySelector('[data-map-locate]');
    const trafficButton = document.querySelector('[data-map-traffic]');
    const autocompleteContainer = document.querySelector('[data-place-autocomplete]');
    const defaultLocation = { lat: 20.3667, lng: -103.8167 };

    const updateStatus = (message) => {
        if (statusElement instanceof HTMLElement) {
            statusElement.textContent = message;
        }
    };

    const showFallbackMap = () => {
        mapElement.hidden = true;

        if (fallbackMap instanceof HTMLIFrameElement) {
            fallbackMap.hidden = false;
        }
    };

    const setControlsDisabled = (disabled) => {
        [locateButton, trafficButton].forEach((button) => {
            if (button instanceof HTMLButtonElement) {
                button.disabled = disabled;
            }
        });
    };

    const apiKey = mapElement.dataset.googleMapsApiKey;

    const loadGoogleMapsApi = () => new Promise((resolve, reject) => {
        const script = document.createElement('script');
        const scriptUrl = new URL('https://maps.googleapis.com/maps/api/js');

        scriptUrl.searchParams.set('key', apiKey);
        scriptUrl.searchParams.set('loading', 'async');
        scriptUrl.searchParams.set('v', 'weekly');
        script.src = scriptUrl.toString();
        script.async = true;
        script.addEventListener('load', resolve, { once: true });
        script.addEventListener('error', () => reject(new Error('No se pudo cargar Google Maps.')), { once: true });
        document.head.append(script);
    });

    const initializeMap = async () => {
        let map;

        window.gm_authFailure = () => {
            updateStatus('Google Maps rechazó la clave. Verifica las APIs habilitadas, la facturación y las restricciones por dominio.');
            setControlsDisabled(true);
            showFallbackMap();
        };

        try {
            await loadGoogleMapsApi();

            if (!window.google?.maps?.importLibrary) {
                throw new Error('Google Maps no está disponible después de cargar el script.');
            }

            const [mapsLibrary, markersLibrary, placesLibrary] = await Promise.all([
                window.google.maps.importLibrary('maps'),
                window.google.maps.importLibrary('marker'),
                window.google.maps.importLibrary('places'),
            ]);

            const { Map, TrafficLayer } = mapsLibrary;
            const { Marker } = markersLibrary;
            const { PlaceAutocompleteElement } = placesLibrary;

            map = new Map(mapElement, {
                center: defaultLocation,
                zoom: 14,
                mapTypeControl: true,
                streetViewControl: true,
            });

            const trafficLayer = new TrafficLayer();
            new Marker({
                map,
                position: defaultLocation,
                title: 'Punto de referencia de la zona centro',
            });
            let searchMarker = null;
            let userMarker = null;

            map.addListener('click', (event) => {
                if (!event.latLng) {
                    return;
                }

                new Marker({ map, position: event.latLng });
                updateStatus(`Marcador creado en Lat: ${event.latLng.lat().toFixed(4)}, Lng: ${event.latLng.lng().toFixed(4)}.`);
            });

            if (autocompleteContainer instanceof HTMLElement) {
                const autocomplete = new PlaceAutocompleteElement();
                autocomplete.placeholder = 'Buscar lugares, ciudades o direcciones...';
                autocomplete.setAttribute('aria-label', 'Buscar lugares, ciudades o direcciones');
                autocomplete.style.width = '100%';
                autocompleteContainer.append(autocomplete);

                autocomplete.addEventListener('gmp-select', async (event) => {
                    try {
                        const place = event.placePrediction.toPlace();
                        await place.fetchFields({
                            fields: ['displayName', 'formattedAddress', 'location', 'viewport'],
                        });

                        if (!place.location) {
                            updateStatus('No se encontraron coordenadas para el lugar seleccionado.');

                            return;
                        }

                        if (place.viewport) {
                            map.fitBounds(place.viewport);
                        } else {
                            map.setCenter(place.location);
                            map.setZoom(17);
                        }

                        if (searchMarker) {
                            searchMarker.setPosition(place.location);
                        } else {
                            searchMarker = new Marker({ map, position: place.location });
                        }

                        updateStatus(`Lugar seleccionado: ${place.displayName || place.formattedAddress || 'Ubicación encontrada'}.`);
                    } catch {
                        updateStatus('No se pudieron cargar los detalles del lugar. Intenta realizar la búsqueda de nuevo.');
                    }
                });
            }

            if (locateButton instanceof HTMLButtonElement) {
                locateButton.addEventListener('click', () => {
                    if (!navigator.geolocation) {
                        updateStatus('Este navegador no permite obtener la ubicación actual.');

                        return;
                    }

                    updateStatus('Solicitando permiso para consultar tu ubicación...');
                    navigator.geolocation.getCurrentPosition(
                        (position) => {
                            const location = {
                                lat: position.coords.latitude,
                                lng: position.coords.longitude,
                            };

                            map.setCenter(location);
                            map.setZoom(15);

                            if (userMarker) {
                                userMarker.setPosition(location);
                            } else {
                                userMarker = new Marker({
                                    map,
                                    position: location,
                                    title: 'Tu ubicación',
                                });
                            }

                            updateStatus('Ubicación actual detectada correctamente.');
                        },
                        (error) => {
                            const message = error.code === error.PERMISSION_DENIED
                                ? 'No se concedió permiso para consultar la ubicación.'
                                : error.code === error.TIMEOUT
                                    ? 'La consulta de ubicación excedió el tiempo de espera.'
                                    : 'No fue posible obtener tu ubicación actual.';

                            updateStatus(message);
                        },
                        { enableHighAccuracy: true, timeout: 10000, maximumAge: 60000 },
                    );
                });
            }

            if (trafficButton instanceof HTMLButtonElement) {
                trafficButton.addEventListener('click', () => {
                    const isTrafficEnabled = trafficButton.getAttribute('aria-pressed') === 'true';
                    trafficLayer.setMap(isTrafficEnabled ? null : map);
                    trafficButton.setAttribute('aria-pressed', String(!isTrafficEnabled));
                    trafficButton.textContent = isTrafficEnabled ? 'Activar tráfico' : 'Desactivar tráfico';
                    updateStatus(isTrafficEnabled ? 'Capa de tráfico desactivada.' : 'Capa de tráfico activada.');
                });
            }

            setControlsDisabled(false);
            updateStatus('Mapa interactivo listo. Haz clic en el mapa para agregar un marcador.');
        } catch (error) {
            setControlsDisabled(true);
            showFallbackMap();
            updateStatus(`${error.message} Se muestra el mapa de consulta; verifica tu clave y la configuración de Google Cloud.`);
        }
    };

    initializeMap();
}
