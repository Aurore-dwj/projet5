const weatherIcons = { // objet liste d'icon
    "Rain": "wi wi-day-rain",
    "Clouds": "wi wi-day-cloudy",
    "Clear": "wi wi-day-sunny",
    "Snow": "wi wi-day-snow",
    "Mist": "wi wi-day-fog",
    "Drizzle": "wi wi-day-sleet",
     
}

function capitalize(str) { // capitalise la première lettre du texte
    return str[0].toUpperCase() + str.slice(1); //et on rajoute le reste du tableau à partir de la 2ème lettre
}

async function main(withIp = true) { // fonction par défaut: on affiche la ville de l'user avec son ip

    let ville;

    if (withIp) { // recherche de son ip pour afficher la ville user: API IPSTACK
        ville = await fetch('http://api.ipstack.com/ 176.159.91.31?access_key=91913480e438d4f8cb02499b9389bfe7')
            .then(resultat => resultat.json()) //quand tu as le resultat tu me le donne en json...
            .then(json => json.city) //...et quand tu as le json, va me chercher la ville (city dans json)
    
    } else { // on passe la fonction par défaut et on peut récupérer la ville par le texte tapé dans l'id ville
        ville = document.querySelector('#ville').textContent;
    }
    //récupération de la variable ville dans l'addresse de l'API OPENWEATHERMAP
    const meteo = await fetch(`http://api.openweathermap.org/data/2.5/weather?q=${ville}&appid=2e0e5ede742861192d75ef2771bd649e&lang=fr&units=metric`)

        .then(resultat => resultat.json())
        .then(json => json)

    displayWeatherInfos(meteo)
}

function displayWeatherInfos(data) { // appel des différents items de l'objet...
    const name = data.name;
    const temperature = data.main.temp;
    const conditions = data.weather[0].main;
    const description = data.weather[0].description;
    const vent = data.wind.speed;
    const humidite = data.main.humidity;
    const pression = data.main.pressure;

function Km(){ // fonction de conversion noeud en Km/h
   var x = vent;
   var y = 1.852;
   var z = x*y;
   return z
}
    document.querySelector('#ville').textContent = name; // ...pour pouvoir les afficher
    document.querySelector('#temperature').textContent = Math.round(temperature); // arrondi le chiffre de température
    document.querySelector('#conditions').textContent = capitalize(description); // capitalise la première lettre
    // affiche l'icon selon les conditions grâce à l'ojbet weatherIcon situé en haut du fichier
    document.querySelector('i.wi').className = weatherIcons[conditions];
    document.querySelector('#vent').textContent = Math.round(Km(vent));
    document.querySelector('#humidite').textContent = humidite;
    document.querySelector('#pression').textContent = pression;
}
//initialisation au click du contentEditable pour pouvoir taper le nom de la ville
ville.addEventListener('click', () => {
    ville.contentEditable = true;
});
//pour ne pas sauter de ligne au click de la touche entrée
ville.addEventListener('keydown', (e) => {
    if (e.keyCode === 13) {
        e.preventDefault();
        ville.contentEditable = false;
        // pour ne plus avoir la fonction main par défaut et qu'on puisse taper la ville que l'on veut    
        main(false);
    }
})

main();